<?php

namespace App\Services;

use App\Models\DocumentAccess;
use App\RepositoryInterfaces\DocumentAccessRepositoryInterface;

class DocumentAccessService
{
    public function __construct(public DocumentAccessRepositoryInterface $documentAccessRepository)
    {
    }

    public function store(array $data): void
    {
        $this->documentAccessRepository->store($data);
    }

    public function update(array $data, DocumentAccess $documentAccess): void
    {
        $this->documentAccessRepository->update($data, $documentAccess);
    }
}
