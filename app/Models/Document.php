<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Document extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'document_type_id', 'case_nomenclature_id', 'income_number', 'registration_date', 'registration_time',
        'author_email', 'outgoing_number', 'outgoing_date', 'sender_id', 'receiver_id', 'addressee', 'question',
        'delivery_type_id', 'number_of_sheets', 'language_id', 'summary', 'shelf_life', 'note', 'answer_to_number',
        'gr_document', 'performer', 'document_text', 'history', 'file', 'is_draft', 'answer_to_date'
    ];

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
}
