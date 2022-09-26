<?php

namespace App\Models;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

/**
 * @property integer $id
 * @property string $email
 * @property string $name
 * @property string $surname
 * @property string $patronymic
 * @property string $role
 * @property string $photo
 * @property integer $is_active
 */
class User extends Authenticatable
{
    use HasFactory, Notifiable, SoftDeletes;

    protected $fillable = [
        'is_active',
        'name',
        'surname',
        'patronymic',
        'email',
        'role',
        'photo',
        'password',
    ];

    protected $hidden = [
        'password',
    ];

    protected $appends = [
        'photo_url'
    ];

    public const ROLE_TITLES = [
        'admin' => 'Администратор',
        'archivist' => 'Архивариус',
        'reader' => 'Читатель',
        'guest' => 'Гость',
    ];

    public static array $tHeads = [
        ['title' => 'ID', 'field' => 'id', 'class' => ''],
        ['title' => 'Фамилия', 'field' => 'surname', 'class' => ''],
        ['title' => 'Имя Отчество', 'field' => 'name', 'class' => ''],
        ['title' => 'Роль', 'field' => 'role', 'class' => ''],
        ['title' => 'Дата регистрации', 'field' => 'created_at', 'class' => 'text-center']
    ];

    public function scopeNotDeleted($query)
    {
        return $query->whereNull('deleted_at');
    }

    public function getPhotoUrlAttribute(): string
    {
        return is_null($this->photo) ? '/images/default-photo.png' : '/storage/' . $this->photo;
    }

    public function logs(): HasMany
    {
        return $this->hasMany(Log::class);
    }

    protected function serializeDate(DateTimeInterface $date): string
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function drafts(): HasMany
    {
        return $this->hasMany(Document::class, 'author_email', 'email')->where('is_draft', true);
    }
}
