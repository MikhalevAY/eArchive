<?php

namespace App\Models;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * @property integer $user_id
 * @property string $comment
 * @property string $status
 * @property BelongsToMany $documents
 */
class AccessRequest extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'comment', 'status'];

    public static array $tHeads = [
        ['title' => 'Дата', 'field' => 'created_at', 'class' => ''],
        ['title' => 'Автор', 'field' => 'surname', 'class' => ''],
    ];

    public static array $statusTitle = [
        'new' => 'Новый',
        'active' => 'Активный',
        'closed' => 'Закрытый'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function getAuthorAttribute(): string
    {
        return $this->user->surname . ' ' . $this->user->name;
    }

    public function documents(): BelongsToMany
    {
        return $this->belongsToMany(Document::class)->with('type')->withPivot([
            'view',
            'edit',
            'download',
            'delete',
            'is_allowed',
            'user_id'
        ]);
    }

    protected function serializeDate(DateTimeInterface $date): string
    {
        return $date->format('Y-m-d H:i:s');
    }
}
