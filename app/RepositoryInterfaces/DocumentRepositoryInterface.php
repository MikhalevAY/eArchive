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

    public function store(array $data) : Document;

    public function update(array $data, Document $document): array;

    public function delete(Document $document): array;
}
