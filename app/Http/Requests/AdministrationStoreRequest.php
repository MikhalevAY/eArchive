<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;

class AdministrationStoreRequest extends FormRequest
{
    private const PASSWORD_LENGTH = 8;

    public function authorize(): bool
    {
        return true;
    }

    public function prepareForValidation()
    {
        $this->merge([
            'is_active' => 1,
            'password' => Str::random(self::PASSWORD_LENGTH),
            'email' => Str::lower($this->email),
        ]);
    }

    public function rules(): array
    {
        return [
            'is_active' => 'required|integer',
            'surname' => 'required|string:255',
            'name' => 'required|string:255',
            'patronymic' => 'nullable|string:255',
            'role' => 'required|in:admin,archivist,reader,guest',
            'email' => 'required|email:strict|unique:users,email',
            'password' => 'required',
        ];
    }

    public function attributes(): array
    {
        return [
            'email' => 'E-mail',
        ];
    }
}
