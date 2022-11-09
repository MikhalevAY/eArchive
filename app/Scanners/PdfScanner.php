<?php

namespace App\Scanners;

use Illuminate\Support\Facades\Storage;
use Imagick;
use ImagickException;

class PdfScanner extends BaseScanner implements ScannerInterface
{
    public const RESOLUTION = 300;
    public const TMPDIR = 'tmp';

    /**
     * @throws ImagickException
     */
    public function getText(string $filePath): string
    {
        if (!Storage::exists(self::TMPDIR)) {
            Storage::makeDirectory(self::TMPDIR);
        }

        $imagePath = public_path('storage/' . self::TMPDIR . '/image.jpg');

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

        Storage::deleteDirectory(self::TMPDIR);

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
