<?php

namespace App\Scanners;

use Exception;
use thiagoalessio\TesseractOCR\TesseractOCR;

class JpgScanner extends BaseScanner implements ScannerInterface
{
    public function getText(string $filePath): string
    {
        $text = '';

        try {
            $text = (new TesseractOCR($filePath))->lang('rus', 'eng')->run();
        } catch (Exception $e) {
        }

        return $this->handleText($text);
    }
}
