<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AccessRequestStoreRequest extends FormRequest
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
            'documents' => json_decode($this->documents, true),
            'status' => 'new',
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
            'documents.*' => 'required|integer|exists:documents,id',
            'comment' => 'required',
            'status' => 'required',
            'view.*' => 'nullable|integer',
            'edit.*' => 'nullable|integer',
            'download.*' => 'nullable|integer',
            'delete.*' => 'nullable|integer',
        ];
    }
}
