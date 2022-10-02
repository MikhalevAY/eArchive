<?php

namespace App\Services;

use App\Models\Document;
use App\RepositoryInterfaces\DocumentRepositoryInterface;
use Illuminate\Support\Collection;

class DocumentService
{
    public function __construct(
        public DocumentRepositoryInterface $repository,
        public AttachmentService           $attachmentService
    )
    {
    }

    public function getAll(array $params): Collection
    {
        return $this->repository->getAll($params);
    }

    public function getOrderBy(array $params): array
    {
        return $this->repository->getOrderBy($params);
    }

    public function store(array $data): array
    {
        // Сохраняем документ
        $data['file_name'] = $data['file']->getClientOriginalName();
        $data['file_size'] = round(($data['file']->getSize() / 1024 / 1024), 1);
        $file = $data['file']->store('documents', 'public');
        $data['file'] = $file;
        $document = $this->repository->store($data);

        // Сохраняем вложения
        $this->storeAttachments($data['attachments'], $document);

        // TODO Права для документов
        // TODO скан файла

        return [
            'message' => __('messages.' . ($data['is_draft'] == 1 ? 'document_stored' : 'document_registered')),
        ];
    }

    public function update(array $data, Document $document): array
    {
        return [];
    }

    public function delete(Document $document): array
    {
        return $this->repository->delete($document);
    }

    private function storeAttachments(array $attachments, Document $document): void
    {
        if (!empty($attachments)) {
            foreach ($attachments as $attachment) {
                $this->attachmentService->store($attachment, $document);
            }
        }
    }
}
