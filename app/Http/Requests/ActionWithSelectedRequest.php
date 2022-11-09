<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ActionWithSelectedRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'documents' => 'nullable',
            'type' => 'required|in:view,download',
        ];
    }
}
