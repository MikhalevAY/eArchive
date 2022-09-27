<?php

namespace App\Services;

use App\Models\Document;
use App\RepositoryInterfaces\DocumentRepositoryInterface;
use Illuminate\Support\Collection;

class DocumentService
{
    public function __construct(public DocumentRepositoryInterface $repository)
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
        $file = $data['file']->store('documents', 'public');
        $data['file'] = $file;
        $data = $this->repository->store($data);

        return $data;
    }

    public function update(array $data, Document $document): array
    {
        return [];
    }

    private function storeAttachments($attachments, $documentId): string
    {
        return '';
    }

    public function delete(Document $document): array
    {
        return $this->repository->delete($document);
    }
}
