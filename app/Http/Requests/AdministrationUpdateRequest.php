<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AdministrationUpdateRequest extends FormRequest
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
            'is_active' => 'nullable|in:0,1',
            'surname' => 'required|string:255',
            'name' => 'required|string:255',
            'patronymic' => 'nullable|string:255',
            'role' => 'required|in:admin,archivist,reader,guest',
            'email' => 'required|email:strict|unique:users,email,' . $this->user->id . ',id,deleted_at,NULL',
        ];
    }

    public function attributes(): array
    {
        return [
            'email' => 'E-mail'
        ];
    }
}
