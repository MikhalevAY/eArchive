<?php

namespace App\Repositories;

use App\Models\DocumentAccess;
use App\RepositoryInterfaces\DocumentAccessRepositoryInterface;

class DocumentAccessRepository extends BaseRepository implements DocumentAccessRepositoryInterface
{
    public function store(array $data): void
    {
        DocumentAccess::query()->create($data);
    }

    public function storeMany(array $data): void
    {
        DocumentAccess::query()->insert($data);
    }

    public function update(array $data, DocumentAccess $documentAccess): void
    {
        $documentAccess->update($data);
    }
}
