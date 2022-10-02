<?php

namespace App\RepositoryInterfaces;

use App\Models\Document;
use App\Repositories\AttachmentRepository;

/**
 * @see AttachmentRepository
 **/
interface AttachmentRepositoryInterface
{
    public function store(array $data): void;
}
