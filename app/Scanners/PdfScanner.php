<?php

namespace App\Scanners;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Imagick;
use ImagickException;

class PdfScanner extends BaseScanner implements ScannerInterface
{
    public const RESOLUTION = 300;

    /**
     * @throws ImagickException
     */
    public function getText(string $filePath): string
    {
        $tempDir = 'tmp_' . Str::random(8);

        if (!Storage::exists($tempDir)) {
            Storage::makeDirectory($tempDir);
        }

        $imagePath = public_path("storage/$tempDir/image.jpg");

        $image = $this->createImage($filePath, $imagePath);

        $text = '';

        if ($image->getNumberImages() == 1) {
            $text = (new JpgScanner())->getText($imagePath);
        } else {
            for ($number = 0; $number < $image->getNumberImages(); $number++) {
                $text .= (new JpgScanner())->getText(
                    str_replace("image.jpg", "image-$number.jpg", $imagePath)
                );
            }
        }

        Storage::deleteDirectory($tempDir);

        return $text;
    }

    /**
     * @throws ImagickException
     */
    private function createImage(string $filePath, string $imagePath): Imagick
    {
        $image = new Imagick();
        $image->setResolution(self::RESOLUTION, self::RESOLUTION);
        $image->setBackgroundColor('white');
        $image->readImage($filePath);
        $image->mergeImageLayers(Imagick::LAYERMETHOD_FLATTEN);
        $image->setImageAlphaChannel(Imagick::ALPHACHANNEL_REMOVE);
        $image->writeImages($imagePath, true);

        return $image;
    }
}
