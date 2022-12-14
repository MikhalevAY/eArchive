<?php

namespace App\Scanners;

abstract class BaseScanner
{
    public function __construct()
    {
    }

    public function handleText(string $text): string
    {
        return trim(strip_tags($text));
    }
}
