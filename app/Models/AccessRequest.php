<?php

namespace App\Models;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property integer $id
 * @property integer $user_id
 * @property string $comment
 * @property string $status
 * @property HasMany $documentAccesses
 * @property User $user
 */
class AccessRequest extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'comment', 'status'];

    public static array $tHeads = [
        ['title' => 'Дата', 'field' => 'created_at', 'class' => ''],
        ['title' => 'Автор', 'field' => 'full_name', 'class' => ''],
    ];

    public static array $statusTitle = [
        'new' => 'Новый',
        'active' => 'Активный',
        'closed' => 'Закрытый',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id')->withTrashed();
    }

    public function getAuthorAttribute(): string
    {
        return $this->user->surname . ' ' . $this->user->name;
    }

    public function documentAccesses(): HasMany
    {
        return $this->hasMany(DocumentAccess::class, 'access_request_id', 'id');
    }

    protected function serializeDate(DateTimeInterface $date): string
    {
        return $date->format('Y-m-d H:i:s');
    }
}
