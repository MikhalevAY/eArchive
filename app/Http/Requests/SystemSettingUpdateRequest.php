<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SystemSettingUpdateRequest extends FormRequest
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
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,svg|max:8192',
            'color' => 'required|max:7|starts_with:#'
        ];
    }

    public function attributes(): array
    {
        return [
            'logo' => 'Логотип',
            'color' => 'Цвет'
        ];
    }
}
