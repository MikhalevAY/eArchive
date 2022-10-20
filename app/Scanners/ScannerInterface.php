<?php

namespace App\Scanners;

interface ScannerInterface
{
    public function getText(string $filePath): string;
}
