<?php

namespace App\Http\Requests;

use App\Rules\MatchOldPassword;
use Illuminate\Foundation\Http\FormRequest;

class AccountUpdatePasswordRequest extends FormRequest
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

    protected function passedValidation()
    {
        $this->merge([
            'password' => bcrypt($this->new_password)
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
            'password' => ['required', new MatchOldPassword],
            'new_password' => 'same:repeat_password|min:6',
            'repeat_password' => 'min:6',
        ];
    }

    public function attributes(): array
    {
        return [
            'password' => 'Старый пароль',
            'new_password' => 'Новый пароль',
            'repeat_password' => 'Повторите новый пароль'
        ];
    }
}
