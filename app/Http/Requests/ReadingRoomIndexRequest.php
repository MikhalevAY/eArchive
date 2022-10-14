<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ReadingRoomIndexRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    public function prepareForValidation()
    {
        $this->merge([
            'available' => 1
        ]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
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
