<?php

namespace App\Services;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\File;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use ZipArchive;

class ZipArchiveService
{
    public function download(string $zipFile, Collection $documents): BinaryFileResponse
    {
        $zip = new ZipArchive;
        if ($zip->open(public_path() . '/' . $zipFile, ZipArchive::CREATE) === true) {
            foreach ($documents as $document) {
                $documentDirectory = 'Document #' . $document->id . '/';
                $attachmentsDirectory = $documentDirectory . 'attachments/';

                if (File::exists(public_path('storage/' . $document->file))) {
                    $zip->addFile(
                        public_path('storage/' . $document->file),
                        $documentDirectory . basename($document->file_name)
                    );
                }

                foreach ($document->attachments as $attachment) {
                    if (File::exists(public_path('storage/' . $attachment->file))) {
                        $zip->addFile(
                            public_path('storage/' . $attachment->file),
                            $attachmentsDirectory . basename($attachment->name)
                        );
                    }
                }
            }
            $zip->close();
        }

        return response()->download(public_path($zipFile))->deleteFileAfterSend();
    }
}
