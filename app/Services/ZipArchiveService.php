<?php

namespace App\Services;

use Illuminate\Support\Collection;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use ZipArchive;

class ZipArchiveService
{
    public function download(string $zipFile, Collection $documents): BinaryFileResponse
    {
        $zip = new ZipArchive;
        if ($zip->open(public_path() . '/' . $zipFile, ZipArchive::CREATE) === TRUE) {
            foreach ($documents as $document) {
                $documentDirectory = 'Document #' . $document->id . '/';
                $attachmentsDirectory = $documentDirectory . 'attachments/';
                $zip->addFile(
                    public_path('storage/' . $document->file),
                    $documentDirectory . basename($document->file_name)
                );
                foreach ($document->attachments as $attachment) {
                    $zip->addFile(
                        public_path(
                            'storage/' . $attachment->file),
                        $attachmentsDirectory . basename($attachment->file)
                    );
                }
            }
            $zip->close();
        }

        return response()->download(public_path($zipFile))->deleteFileAfterSend();
    }
}
