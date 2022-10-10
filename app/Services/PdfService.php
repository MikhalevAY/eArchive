<?php

namespace App\Services;

use App\Models\Document;
use Illuminate\Support\Collection;
use PDF;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use ZipArchive;

class PdfService
{
    public function print(Document $document)
    {
        $pdf = $this->generate($document);
        $filename = $this->getFileName($document);
        $pdf->getMpdf()->SetTitle($filename);

        return $pdf->getMpdf()->output($filename, 'I');
    }

    public function exportSelected(Collection $documents): BinaryFileResponse
    {
        $zipFile = 'documents.zip';
        $zip = new ZipArchive;
        if ($zip->open(public_path() . '/' . $zipFile, ZipArchive::CREATE) === TRUE) {
            foreach ($documents as $document) {
                $pdf = $this->generate($document);
                $filename = $this->getFileName($document);
                $pdf->getMpdf()->SetTitle($filename);
                $fileContent = $pdf->getMpdf()->output('filename.pdf', 'S');
                $zip->addFromString(basename($filename), $fileContent);
            }
            $zip->close();
        }

        return response()->download(public_path($zipFile))->deleteFileAfterSend();
    }

    private function generate(Document $document)
    {
        return PDF::loadView('pdf.document', compact('document'));
    }

    private function getFileName(Document $document): string
    {
        return 'Документ #' . $document->id . '.pdf';
    }
}
