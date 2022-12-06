<?php

namespace App\Http\Requests\Api\v1;

use App\Rules\CheckBase64String;
use App\Rules\CheckFileExtension;
use Illuminate\Foundation\Http\FormRequest;

class DocumentStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'author_email' => 'required|email:strict|exists:users,email',
            'type_id' => 'required|exists:dictionaries,id',
            'case_nomenclature_id' => 'required|exists:dictionaries,id',
            'sender_id' => 'nullable|exists:dictionaries,id',
            'outgoing_number' => 'nullable|max:255',
            'outgoing_date' => 'nullable|date_format:Y-m-d',
            'receiver_id' => 'nullable|exists:dictionaries,id',
            'income_number' => 'nullable|max:255',
            'registration_date' => 'required|date_format:Y-m-d',
            'registration_time' => 'required|date_format:H:i',
            'addressee' => 'nullable|max:255',
            'question' => 'required',
            'delivery_type_id' => 'nullable|exists:dictionaries,id',
            'number_of_sheets' => 'nullable|integer',
            'language_id' => 'nullable|exists:dictionaries,id',
            'summary' => 'required',
            'shelf_life' => 'required',
            'note' => 'nullable',
            'answer_to_number' => 'nullable|max:255',
            'answer_to_date' => 'nullable|date_format:Y-m-d',
            'performer' => 'nullable|max:255',
            'gr_document' => 'nullable',
            'file_base64' => ['required', 'string', new CheckBase64String],
            'history' => 'nullable',
            'available_for_all' => 'nullable',
            'is_draft' => 'nullable',
            'attachments.*' => ['nullable', 'max:51200', new CheckFileExtension],
        ];
    }

    public function attributes(): array
    {
        return [
            'registration_time' => 'Время регистрации',
            'registration_date' => 'Дата регистрации',
            'outgoing_date' => 'Исходящая дата',
            'number_of_sheets' => 'Кол-во листов/экземпляров',
            'performer' => 'Исполнитель',
            'outgoing_number' => 'Исходящий номер',
            'file_base64' => 'Основной документ',
        ];
    }
}
