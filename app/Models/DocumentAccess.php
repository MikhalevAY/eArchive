<?php

namespace App\Models;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


/**
 * @property integer $id
 * @property integer $user_id
 * @property integer $document_id
 * @property integer|null $access_request_id
 * @property boolean $view
 * @property boolean $edit
 * @property boolean $download
 * @property boolean $delete
 * @property integer|null $is_allowed
 */
class DocumentAccess extends Model
{
    protected $fillable = [
        'user_id',
        'document_id',
        'access_request_id',
        'view',
        'edit',
        'download',
        'delete',
        'is_allowed',
    ];

    protected $dates = ['created_at'];

    protected function serializeDate(DateTimeInterface $date): string
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function accessRequest(): BelongsTo
    {
        return $this->belongsTo(AccessRequest::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function document(): BelongsTo
    {
        return $this->belongsTo(Document::class)->withTrashed();
    }
}
