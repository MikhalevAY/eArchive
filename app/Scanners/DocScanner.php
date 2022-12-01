<?php

namespace App\Scanners;

use Illuminate\Support\Str;
use PhpOffice\PhpWord\Exception\Exception;
use PhpOffice\PhpWord\IOFactory;

class DocScanner extends BaseScanner implements ScannerInterface
{
    public function getText(string $filePath): string
    {
        $text = '';

        try {
            if (Str::contains($filePath, '.docx')) {
                $docFile = IOFactory::createReader()->load($filePath);
            } else {
                $docFile = IOFactory::createReader('MsDoc')->load($filePath);
            }

            foreach ($docFile->getSections() as $section) {
                foreach ($section->getElements() as $element) {
                    if (method_exists($element, 'getElements')) {
                        foreach ($element->getElements() as $childElement) {
                            if (method_exists($childElement, 'getText')) {
                                $text .= $childElement->getText() . ' ';
                            } else {
                                if (method_exists($childElement, 'getContent')) {
                                    $text .= $childElement->getContent() . ' ';
                                }
                            }
                        }
                    } else {
                        if (method_exists($element, 'getText')) {
                            $text .= $element->getText() . ' ';
                        }
                    }
                }
            }
        } catch (Exception $e) {
        }

        return $this->handleText($text);
    }
}
