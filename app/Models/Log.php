<?php

namespace App\Models;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * @property integer $user_id
 * @property string $action
 * @property string $model
 * @property integer $model_id
 * @property string $device_ip
 * @property string $text
 */
class Log extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'action', 'model', 'model_id', 'device_ip', 'text'];

    public const ACTION_DELETE = 'Удаление';
    public const ACTION_CREATE = 'Создание';
    public const ACTION_UPDATE = 'Обновление';
    public const ACTION_AUTH = 'Авторизация';
    public const ACTION_PASSWORD_RESET = 'Сброс пароля';

    protected $with = ['user'];

    public static array $tHeads = [
        ['title' => 'Дата и время', 'field' => 'created_at', 'class' => ''],
        ['title' => 'Автор', 'field' => 'surname', 'class' => ''],
        ['title' => 'IP адрес', 'field' => 'device_ip', 'class' => ''],
        ['title' => 'Объект', 'field' => 'text', 'class' => ''],
        ['title' => 'Действие', 'field' => 'action', 'class' => ''],
    ];

    public function user(): HasOne
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    protected function serializeDate(DateTimeInterface $date): string
    {
        return $date->format('Y-m-d H:i:s');
    }
}
