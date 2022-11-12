<?php

namespace App\Traits;

trait DownloadFile
{
    abstract public function fileName(): string;

    abstract public function filePath(): string;

    public function downloadLink(): string
    {
        return route('document.downloadFile', [
            'file' => $this->filePath(),
            'name' => $this->fileName(),
        ]);
    }
}
