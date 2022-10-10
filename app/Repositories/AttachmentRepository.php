<?php

namespace App\Repositories;

use App\Models\Attachment;
use App\RepositoryInterfaces\AttachmentRepositoryInterface;

class AttachmentRepository extends BaseRepository implements AttachmentRepositoryInterface
{
    public function get(int $id): Attachment
    {
        return Attachment::find($id);
    }

    public function store(array $data): void
    {
        Attachment::create($data);
    }

    public function delete(Attachment $attachment): void
    {
        $attachment->delete();
    }
}
