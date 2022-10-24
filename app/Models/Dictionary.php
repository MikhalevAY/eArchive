<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property string $title
 * @property string $type
 * @method static Builder|Dictionary query()
 */
class Dictionary extends Model
{
    use HasFactory;

    public const TITLES = [
        'document_type' => 'Тип документа',
        'case_nomenclature' => 'Номенклатура дел',
        'counterparty' => 'Отправитель/Получатель',
        'delivery_type' => 'Способ доставки',
        'language' => 'Язык обращения',
    ];

    public $timestamps = false;

    protected $fillable = ['title', 'type'];
}
