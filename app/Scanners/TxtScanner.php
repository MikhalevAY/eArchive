<?php

namespace App\Scanners;

use Illuminate\Support\Facades\File;

class TxtScanner extends BaseScanner implements ScannerInterface
{
    public function getText(string $filePath): string
    {
        if (!File::exists($filePath)) {
            return '';
        }

        $text = File::get($filePath);

        return $this->handleText($text);
    }
}
