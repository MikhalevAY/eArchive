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
            'q' => 'nullable',
            'sort' => 'nullable|string|in:id,type,case_nomenclature,registration_date,question,surname',
            'order' => 'nullable|in:asc,desc',
        ];
    }
}