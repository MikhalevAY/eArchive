<?php

namespace App\Services;

use App\Models\Document;
use App\RepositoryInterfaces\AttachmentRepositoryInterface;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class AttachmentService
{
    private const FILENAME_LENGTH = 16;

    public function __construct(public AttachmentRepositoryInterface $repository)
    {
    }

    public function store(UploadedFile $attachment, Document $document): void
    {
        $folder = 'attachments/' . $document->id;

        $this->createStorage($folder);

        $newName = Str::random(self::FILENAME_LENGTH) . '.' . $attachment->getClientOriginalExtension();
        $file = $attachment->storeAs($folder, $newName, 'public');

        $this->repository->store([
            'document_id' => $document->id,
            'name' => $attachment->getClientOriginalName(),
            'file' => $file,
            'size' => round(($attachment->getSize() / 1024 / 1024), 3)
        ]);
    }

    public function delete(int $attachment): void
    {
        $attachment = $this->repository->get($attachment);
        @unlink(public_path('storage/' . $attachment->file));
        $this->repository->delete($attachment);
    }

    public function storeMany(array $attachments, Document $document): void
    {
        if (!empty($attachments)) {
            foreach ($attachments as $attachment) {
                $this->store($attachment, $document);
            }
        }
    }

    public function deleteMany(array $attachments): void
    {
        if (!empty($attachments)) {
            foreach ($attachments as $attachment) {
                $this->delete($attachment);
            }
        }
    }

    private function createStorage(string $folder): void
    {
        if (!File::exists('storage/' . $folder)) {
            Storage::disk('public')->makeDirectory($folder);
        }
    }
}
