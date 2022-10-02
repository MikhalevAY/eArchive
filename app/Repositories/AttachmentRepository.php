<?php

namespace App\Repositories;

use App\Models\Attachment;
use App\RepositoryInterfaces\AttachmentRepositoryInterface;

class AttachmentRepository extends BaseRepository implements AttachmentRepositoryInterface
{

    public function store(array $data): void
    {
        Attachment::create($data);
    }
}
