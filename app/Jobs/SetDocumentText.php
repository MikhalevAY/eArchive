<?php

namespace App\Jobs;

use App\Models\Document;
use App\Scanners\DocScanner;
use App\Scanners\JpgScanner;
use App\Scanners\PdfScanner;
use App\Scanners\TxtScanner;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\File;
use ImagickException;

class SetDocumentText implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(public Document $document, public string $file)
    {
    }

    /**
     * @throws ImagickException
     */
    public function handle(): void
    {
        $filePath = public_path('storage/' . $this->file);

        $text = '';

        if (File::exists($filePath)) {
            $text = match (File::extension($filePath)) {
                'pdf' => (new PdfScanner())->getText($filePath),
                'txt' => (new TxtScanner())->getText($filePath),
                'doc', 'docx' => (new DocScanner())->getText($filePath),
                'jpg', 'png', 'jpeg' => (new JpgScanner())->getText($filePath),
            };
        }

        $this->document->updateQuietly([
            'text' => $text,
        ]);
    }
}
