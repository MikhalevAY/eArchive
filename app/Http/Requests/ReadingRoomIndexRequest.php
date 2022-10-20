<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ReadingRoomIndexRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    private function prepareText(string $text): string
    {
        return implode(' or ', explode(' ', $text));
    }

    public function prepareForValidation()
    {
        $this->merge([
            'available' => 1,
            'text' => $this->text != '' ? $this->prepareText($this->text) : null,
        ]);
    }

    public function rules(): array
    {
        return [
            'available' => 'required',
            'page' => 'nullable|integer',
            'per_page' => 'nullable|integer',
            'id' => 'nullable|integer',
            'type_id' => 'nullable|integer',
            'case_nomenclature_id' => 'nullable|integer',
            'sender_id' => 'nullable|integer',
            'receiver_id' => 'nullable|integer',
            'question' => 'nullable|string',
            'addressee' => 'nullable|string',
            'income_number' => 'nullable|string',
            'registration_date_from' => 'nullable|date_format:Y-m-d',
            'registration_date_to' => 'nullable|date_format:Y-m-d',
            'text' => 'nullable|max:500',
            'gr_document' => 'nullable|in:on',
            'sort' => 'nullable|string|in:id,type,case_nomenclature,registration_date,question,surname',
            'order' => 'nullable|in:asc,desc',
        ];
    }
}
