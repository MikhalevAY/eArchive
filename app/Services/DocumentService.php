<?php

namespace App\Services;

use App\Models\Document;
use App\RepositoryInterfaces\DocumentRepositoryInterface;
use App\Scanners\{DocScanner, JpgScanner, PdfScanner, TxtScanner};
use Illuminate\Http\RedirectResponse;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\File;
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
        $data['text'] = $this->getTextFromFile($data['file']);

        $document = $this->repository->store($data);

        // Сохраняем вложения
        if (isset($data['attachments'])) {
            $this->attachmentService->storeMany($data['attachments'], $document);
        }

        // Права для документа
        if (isset($data['available_for_all'])) {
            $this->documentAccessService->setAvailableForAll($document->id);
        }

        return [
            'message' => __('messages.' . ($data['is_draft'] == 1 ? 'document_stored' : 'document_registered')),
        ];
    }

    public function update(array $data, Document $document): array
    {
        if (isset($data['file'])) {
            $data = $this->uploadDocumentFile($data);
            $data['text'] = $this->getTextFromFile($data['file']);
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
            'closeWindow' => true,
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

    public function downloadSelected(array $documentIds): BinaryFileResponse|RedirectResponse
    {
        $documents = $this->getAvailableForAction($documentIds, 'download');

        if ($documents->isEmpty()) {
            return redirect()->back();
        }

        return $this->zipArchiveService->download('documents.zip', $documents);
    }

    public function print(Document $document)
    {
        return $this->pdfService->print($document);
    }

    public function exportSelected(array $documentIds): BinaryFileResponse|RedirectResponse
    {
        $documents = $this->getAvailableForAction($documentIds, 'view');

        if ($documents->isEmpty()) {
            return redirect()->back();
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
        $data['file_name'] = $data['file']->getClientOriginalName();
        $data['file_size'] = round(($data['file']->getSize() / 1024 / 1024), 3);
        $data['file'] = $data['file']->store('documents', 'public');

        return $data;
    }

    private function getTextFromFile(string $fileName): string
    {
        $filePath = public_path('storage/' . $fileName);
        $extension = File::extension($filePath);

        return match ($extension) {
            'pdf' => (new PdfScanner())->getText($filePath),
            'txt' => (new TxtScanner())->getText($filePath),
            'jpg' => (new JpgScanner())->getText($filePath),
            'doc', 'docx' => (new DocScanner())->getText($filePath),
        };
    }
}
