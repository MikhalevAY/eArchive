<?php

namespace App\RepositoryInterfaces;

use App\Models\Attachment;
use App\Repositories\AttachmentRepository;

/**
 * @see AttachmentRepository
 **/
interface AttachmentRepositoryInterface
{
    public function get(int $id): Attachment;

    public function store(array $data): void;

    public function delete(Attachment $attachment): void;
}
