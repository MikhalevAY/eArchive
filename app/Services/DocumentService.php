<?php

namespace App\Services;

use App\Jobs\SetDocumentText;
use App\Models\Document;
use App\RepositoryInterfaces\DocumentRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class DocumentService
{
    public function __construct(
        public DocumentRepositoryInterface $repository,
        public AttachmentService $attachmentService,
        public PdfService $pdfService,
        public ZipArchiveService $zipArchiveService,
        public DocumentAccessService $documentAccessService
    ) {
    }

    public function getAll(array $params): Collection
    {
        return $this->repository->getAll($params);
    }

    public function getPaginated(array $params): LengthAwarePaginator
    {
        return $this->repository->getPaginated($params);
    }

    public function getOrderBy(array $params, string $defaultSort): array
    {
        return $this->repository->getOrderBy($params, $defaultSort);
    }

    public function store(array $data): array
    {
        // Сохраняем документ
        $data = $this->uploadDocumentFile($data);
        $document = $this->repository->store($data);

        // Сканируем файл
        dispatch(new SetDocumentText($document, $document->file));

        // Сохраняем вложения
        if (isset($data['attachments'])) {
            $this->attachmentService->storeMany($data['attachments'], $document);
        }

        // Права для документа
        if (isset($data['available_for_all'])) {
            $this->documentAccessService->setAvailableForAll($document->id);
        }

        return [
            'message' => __(
                'messages.' .
                (isset($data['is_draft']) && $data['is_draft'] == 1 ? 'document_stored' : 'document_registered')
            ),
        ];
    }

    public function update(array $data, Document $document): array
    {
        if (isset($data['file'])) {
            $data = $this->uploadDocumentFile($data);
            dispatch(new SetDocumentText($document, $data['file']));
        }

        $document = $this->repository->update($data, $document);

        // Удаляем вложения
        if (isset($data['attachments_deleted'])) {
            $this->attachmentService->deleteMany($data['attachments_deleted']);
        }

        // Сохраняем вложения
        if (isset($data['attachments'])) {
            $this->attachmentService->storeMany($data['attachments'], $document);
        }

        return [
            'message' => __('messages.data_updated'),
        ];
    }

    public function delete(Document $document): array
    {
        $this->repository->delete(collect([$document]));

        return [
            'message' => __('messages.document_deleted'),
            'rowsToDelete' => [$document->id],
        ];
    }

    public function deleteSelected(array $documentIds): array
    {
        $documents = $this->getAvailableForAction($documentIds, 'delete');

        if ($documents->isEmpty()) {
            return [
                'message' => __('messages.no_rights_to_delete'),
                'class' => 'error',
            ];
        }

        $this->repository->delete($documents);

        return [
            'message' => __('messages.documents_deleted'),
            'rowsToDelete' => $documents->pluck('id')->toArray(),
        ];
    }

    public function getAvailableForRequest(array $documentIds): Collection
    {
        return $this->repository->getAvailableForRequest($documentIds);
    }

    public function download(Document $document): BinaryFileResponse
    {
        return $this->zipArchiveService->download('document-' . $document->id . '.zip', collect([$document]));
    }

    public function print(Document $document)
    {
        return $this->pdfService->print($document);
    }

    public function actionWithSelected(array $params): JsonResponse
    {
        if (!isset($params['documents'])) {
            return response()->json(['message' => __('messages.at_least_one_document')], 400);
        }

        $documents = $this->getAvailableForAction(
            $params['documents'],
            $params['type']
        );

        if ($documents->isEmpty()) {
            return response()->json(['message' => __('messages.no_rights_to_documents')], 400);
        }

        if ($params['type'] == 'view') {
            $url = route('document.exportSelected');
        } else {
            $url = route('document.downloadSelected');
        }

        return response()->json(['url' => $url]);
    }

    public function downloadSelected(array $documentIds): BinaryFileResponse|RedirectResponse
    {
        $documents = $this->getAvailableForAction($documentIds, 'download');

        if ($documents->isEmpty()) {
            return redirect()->route('archiveSearch');
        }

        return $this->zipArchiveService->download('documents.zip', $documents);
    }

    public function exportSelected(array $documentIds): BinaryFileResponse|RedirectResponse
    {
        $documents = $this->getAvailableForAction($documentIds, 'view');

        if ($documents->isEmpty()) {
            return redirect()->route('archiveSearch');
        }

        return $this->pdfService->exportSelected($documents);
    }

    public function getAvailableForAction(array $documentIds, string $action): Collection
    {
        return adminOrArchivist() ?
            $this->repository->findByIds($documentIds)
            :
            $this->repository->getAvailableForAction($documentIds, $action);
    }

    private function uploadDocumentFile(array $data): array
    {
        if (isset($data['file'])) {
            $file = $data['file']->store('documents', 'public');

            return array_merge($data, [
                'file_size' => round(($data['file']->getSize() / 1024 / 1024), 3),
                'file_name' => $data['file']->getClientOriginalName(),
                'file' => $file,
                'text' => __('messages.text_is_loading'),
            ]);
        } else {
            $base64String = $data['file_base64'];
            $extension = $this->getMimeExtension($this->base64Mimetype($base64String));
            $fileName = 'documents/' . Str::random() . '.' . $extension;
            Storage::put($fileName, base64_decode($base64String));

            return array_merge($data, [
                'file_size' => round((Storage::size($fileName) / 1024 / 1024), 3),
                'file_name' => 'Archive document',
                'file' => $fileName,
                'text' => __('messages.text_is_loading'),
            ]);
        }
    }

    private function getMimeExtension(string $mimeType): string
    {
        return match ($mimeType) {
            'application/vnd.openxmlformats-officedocument.wordprocessingml.document' => 'docx',
            'application/msword' => 'doc',
            'application/pdf' => 'pdf',
            'image/jpeg' => 'jpg',
            default => 'txt',
        };
    }

    private function base64Mimetype(string $encoded): ?string
    {
        if ($decoded = base64_decode($encoded, true)) {
            $tmpFile = tmpFile();
            $tmpFilename = stream_get_meta_data($tmpFile)['uri'];

            file_put_contents($tmpFilename, $decoded);

            return mime_content_type($tmpFilename) ?: null;
        }

        return null;
    }
}
