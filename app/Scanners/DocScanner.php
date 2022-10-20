<?php

namespace App\Scanners;

use Illuminate\Support\Facades\File;
use PhpOffice\PhpWord\Exception\Exception;
use PhpOffice\PhpWord\IOFactory;

class DocScanner extends BaseScanner implements ScannerInterface
{
    public function getText(string $filePath): string
    {
        if (!File::exists($filePath)) {
            return '';
        }

        $text = '';

        try {
            $docFile = IOFactory::createReader()->load($filePath);
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
