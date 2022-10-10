<?php

namespace App\RepositoryInterfaces;

use App\Models\Document;
use App\Repositories\DocumentRepository;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

/**
 * @see DocumentRepository
 **/
interface DocumentRepositoryInterface
{
    public function getPaginated(array $params): LengthAwarePaginator;

    public function getAll(array $params): Collection;

    public function findByIds(array $documentIds): Collection;

    public function store(array $data): Document;

    public function update(array $data, Document $document): Document;

    public function delete(array $documentIds): void;

    public function getNeeded(array $ids): Collection;

    public function getActionsForDocument(int $documentId): array;

    public function getAvailableForAction(array $ids, string $action): array;
}
