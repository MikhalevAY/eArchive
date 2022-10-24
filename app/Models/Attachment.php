<?php

namespace App\Models;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property integer $document_id
 * @property string $name
 * @property string $file
 * @property double $size
 * @property BelongsTo $document
 */
class Attachment extends Model
{
    use HasFactory;

    protected $fillable = ['document_id', 'name', 'file', 'size'];

    public function document(): BelongsTo
    {
        return $this->belongsTo(Document::class);
    }

    protected function serializeDate(DateTimeInterface $date): string
    {
        return $date->format('Y-m-d H:i:s');
    }
}
