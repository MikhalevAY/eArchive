<?php

namespace App\Scanners;

use Illuminate\Support\Facades\File;

class JpgScanner extends BaseScanner implements ScannerInterface
{
    public function getText(string $filePath): string
    {
        if (!File::exists($filePath)) {
            return '';
        }

        $text = '';

        return $text;
    }
}
