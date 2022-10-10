<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DraftDocumentsIndexRequest extends FormRequest
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
            'author_email' => auth()->user()->email,
            'is_draft' => true
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
            'author_email' => 'required',
            'is_draft' => 'required',
            'sort' => 'nullable|string|in:updated_at,question,type,case_nomenclature',
            'order' => 'nullable|in:asc,desc',
        ];
    }
}
