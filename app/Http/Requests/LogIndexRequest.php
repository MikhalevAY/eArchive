<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LogIndexRequest extends FormRequest
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

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'page' => 'nullable|integer',
            'per_page' => 'nullable|integer|min:10',
            'q' => 'nullable',
            'sort' => 'nullable|string|in:created_at,surname,action,text',
            'order' => 'nullable|in:asc,desc',
        ];
    }
}
