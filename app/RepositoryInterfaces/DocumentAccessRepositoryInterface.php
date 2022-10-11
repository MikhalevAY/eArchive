<?php

namespace App\RepositoryInterfaces;

use App\Models\DocumentAccess;
use App\Repositories\DocumentAccessRepository;

/**
 * @see DocumentAccessRepository
 **/
interface DocumentAccessRepositoryInterface
{
    public function store(array $data): void;

    public function update(array $data, DocumentAccess $documentAccess): void;
}
