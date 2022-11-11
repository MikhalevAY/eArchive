<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;

class LoginRequest extends FormRequest
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
            'is_active' => 1,
            'email' => Str::lower($this->email),
        ]);
    }

    public function rules(): array
    {
        return [
            'is_active' => 'required|int',
            'email' => 'required|email:strict',
            'password' => 'required',
        ];
    }

    public function messages(): array
    {
        return [
            '*.required' => 'Укажите данные для входа',
        ];
    }
}
