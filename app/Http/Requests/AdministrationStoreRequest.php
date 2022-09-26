<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;

class AdministrationStoreRequest extends FormRequest
{
    private const PASSWORD_LENGTH = 8;

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
            'password' => Str::random(self::PASSWORD_LENGTH)
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
            'is_active' => 'required|integer',
            'surname' => 'required|string:255',
            'name' => 'required|string:255',
            'patronymic' => 'nullable|string:255',
            'role' => 'required|in:admin,archivist,reader,guest',
            'email' => 'required|email:strict|unique:users,email,NULL,id,deleted_at,NULL',
            'password' => 'required'
        ];
    }

    public function attributes(): array
    {
        return [
            'email' => 'E-mail'
        ];
    }
}
