<?php

namespace App\Models;

use App\Traits\DownloadFile;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\File;

/**
 * @property integer $document_id
 * @property string $name
 * @property string $file
 * @property double $size
 * @property Document $document
 */
class Attachment extends Model
{
    use HasFactory, DownloadFile;

    protected $fillable = ['document_id', 'name', 'file', 'size'];

    public function fileName(): string
    {
        return $this->name;
    }

    public function filePath(): string
    {
        return $this->file;
    }

    public function getExtensionAttribute(): string
    {
        return File::extension(public_path('storage/' . $this->file));
    }

    public function document(): BelongsTo
    {
        return $this->belongsTo(Document::class);
    }

    protected function serializeDate(DateTimeInterface $date): string
    {
        return $date->format('Y-m-d H:i:s');
    }
}
