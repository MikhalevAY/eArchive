<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AccountUpdateRequest extends FormRequest
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
            'surname' => 'required|string:255',
            'name' => 'required|string:255',
            'patronymic' => 'nullable|string:255',
            'email' => 'required|email:strict|unique:users,email,' . auth()->id(),
        ];
    }
}
