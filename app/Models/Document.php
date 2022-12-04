<?php

namespace App\Models;

use App\Traits\DownloadFile;
use DateTimeInterface;
use Illuminate\Database\Eloquent\{Builder, Model};
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\{BelongsTo, HasMany};
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

/**
 * @property integer $id
 * @property integer $type_id
 * @property string $file
 * @property string $file_name
 * @method static Builder|Document query()
 * @method Builder|Document documentAccessJoin()
 */
class Document extends Model
{
    use HasFactory, SoftDeletes, DownloadFile;

    protected $fillable = [
        'type_id',
        'case_nomenclature_id',
        'income_number',
        'registration_date',
        'registration_time',
        'author_email',
        'outgoing_number',
        'outgoing_date',
        'sender_id',
        'receiver_id',
        'addressee',
        'question',
        'delivery_type_id',
        'number_of_sheets',
        'language_id',
        'summary',
        'shelf_life',
        'note',
        'answer_to_number',
        'gr_document',
        'performer',
        'text',
        'history',
        'file',
        'file_name',
        'is_draft',
        'answer_to_date',
        'file_size',
    ];

    protected $dates = ['registration_date', 'registration_time', 'outgoing_date', 'answer_to_date'];

    public static array $tHeads = [
        ['title' => 'Рег. номер', 'field' => 'id', 'class' => ''],
        ['title' => 'Тип документа', 'field' => 'type', 'class' => ''],
        ['title' => 'Номенклатура дел', 'field' => 'case_nomenclature', 'class' => ''],
        ['title' => 'Характер вопроса', 'field' => 'question', 'class' => ''],
        ['title' => 'Автор', 'field' => 'surname', 'class' => ''],
        ['title' => 'Дата', 'field' => 'registration_date', 'class' => ''],
    ];

    public static array $draftTHeads = [
        ['title' => 'Редактирование', 'field' => 'updated_at', 'class' => ''],
        ['title' => 'Тип документа', 'field' => 'type', 'class' => ''],
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

    public function fileName(): string
    {
        return $this->file_name;
    }

    public function filePath(): string
    {
        return $this->file;
    }

    public function scopeDocumentAccessJoin($query)
    {
        return $query->leftJoin(
            DB::raw(
                '(
                SELECT *
                FROM document_accesses
                WHERE id in (
                    SELECT MAX(id) FROM document_accesses WHERE user_id = ' . auth()->id() . ' GROUP BY document_id
                )
            ) AS da'
            ),
            function ($join) {
                $join->on('da.document_id', '=', 'documents.id');
            }
        );
    }

    public function scopeNotDeleted($query)
    {
        return $query->whereNull('deleted_at');
    }

    public function getFileExtensionAttribute(): string
    {
        return File::extension(public_path('storage/' . $this->file));
    }

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'author_email', 'email')->withTrashed();
    }

    public function authorId(): int
    {
        return $this->author()->pluck('id')->first();
    }

    public function type(): BelongsTo
    {
        return $this->belongsTo(Dictionary::class, 'type_id', 'id');
    }

    public function caseNomenclature(): BelongsTo
    {
        return $this->belongsTo(Dictionary::class, 'case_nomenclature_id', 'id');
    }

    public function language(): BelongsTo
    {
        return $this->belongsTo(Dictionary::class, 'language_id', 'id');
    }

    public function deliveryType(): BelongsTo
    {
        return $this->belongsTo(Dictionary::class, 'delivery_type_id', 'id');
    }

    public function sender(): BelongsTo
    {
        return $this->belongsTo(Dictionary::class, 'sender_id', 'id');
    }

    public function receiver(): BelongsTo
    {
        return $this->belongsTo(Dictionary::class, 'receiver_id', 'id');
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
