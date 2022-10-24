<?php

namespace App\Services;

use App\Models\DocumentAccess;
use App\RepositoryInterfaces\DocumentAccessRepositoryInterface;
use Illuminate\Support\Collection;

class DocumentAccessService
{
    public function __construct(
        public DocumentAccessRepositoryInterface $documentAccessRepository,
        public AdministrationService $administrationService
    ) {
    }

    public function store(array $data): void
    {
        $this->documentAccessRepository->store($data);
    }

    public function update(array $data, DocumentAccess $documentAccess): void
    {
        $this->documentAccessRepository->update($data, $documentAccess);
    }

    public function setAvailableForAll(int $documentId): void
    {
        $users = $this->administrationService->getAll(['role' => ['reader', 'guest']]);
        $this->documentAccessRepository->storeMany($this->prepareData($documentId, $users));
    }

    private function prepareData(int $documentId, Collection $users): array
    {
        $data = [];

        foreach ($users as $user) {
            $data[] = [
                'user_id' => $user->id,
                'document_id' => $documentId,
                'view' => true,
                'edit' => false,
                'download' => false,
                'delete' => false,
                'is_allowed' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        return $data;
    }
}
