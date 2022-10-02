<?php

namespace App\Models;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property integer $id
 */
class Document extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'document_type_id', 'case_nomenclature_id', 'income_number', 'registration_date', 'registration_time',
        'author_email', 'outgoing_number', 'outgoing_date', 'sender_id', 'receiver_id', 'addressee', 'question',
        'delivery_type_id', 'number_of_sheets', 'language_id', 'summary', 'shelf_life', 'note', 'answer_to_number',
        'gr_document', 'performer', 'document_text', 'history', 'file', 'file_name', 'is_draft', 'answer_to_date',
        'file_size'
    ];

    protected $dates = ['registration_date', 'registration_time', 'outgoing_date', 'answer_to_date'];

    public static array $tHeads = [
        ['title' => 'Рег. номер', 'field' => 'income_number', 'class' => ''],
        ['title' => 'Тип документа', 'field' => 'document_type', 'class' => ''],
        ['title' => 'Номенклатура дел', 'field' => 'case_nomenclature', 'class' => ''],
        ['title' => 'Характер вопроса', 'field' => 'question', 'class' => ''],
        ['title' => 'Автор', 'field' => 'author', 'class' => ''],
        ['title' => 'Дата', 'field' => 'registration_date', 'class' => ''],
    ];

    public static array $draftTHeads = [
        ['title' => 'Редактирование', 'field' => 'updated_at', 'class' => ''],
        ['title' => 'Тип документа', 'field' => 'document_type', 'class' => ''],
        ['title' => 'Номенклатура дел', 'field' => 'case_nomenclature', 'class' => ''],
        ['title' => 'Характер вопроса', 'field' => 'question', 'class' => ''],
    ];

    public static array $shelfLife = [
        1 => '1 год',
        3 => '3 года',
        5 => '5 лет',
        10 => '10 лет',
        9999 => 'Без срока',
    ];

    public function scopeNotDeleted($query)
    {
        return $query->whereNull('deleted_at');
    }

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'author_email', 'email');
    }

    public function type(): BelongsTo
    {
        return $this->belongsTo(Dictionary::class, 'document_type_id', 'id');
    }

    public function caseNomenclature(): BelongsTo
    {
        return $this->belongsTo(Dictionary::class, 'case_nomenclature_id', 'id');
    }

    public function attachments(): HasMany
    {
        return $this->hasMany(Attachment::class);
    }

    protected function serializeDate(DateTimeInterface $date): string
    {
        return $date->format('Y-m-d H:i:s');
    }
}
