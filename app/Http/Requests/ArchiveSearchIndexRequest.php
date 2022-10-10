<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ArchiveSearchIndexRequest extends FormRequest
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
            'all_documents' => 1
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
            'all_documents' => 'required',
            'page' => 'nullable|integer',
            'per_page' => 'nullable|integer',
            'id' => 'nullable|integer',
            'gr_document' => 'nullable|in:on',
            'sort' => 'nullable|string|in:id,type,case_nomenclature,registration_date,question,surname',
            'order' => 'nullable|in:asc,desc',
        ];
    }
}
