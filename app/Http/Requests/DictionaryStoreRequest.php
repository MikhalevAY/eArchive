<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DictionaryStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => 'required|string',
            'type' => 'required|in:document_type,case_nomenclature,counterparty,delivery_type,language'
        ];
    }

    public function attributes(): array
    {
        return [
            'type' => 'Тип справочника',
        ];
    }
}
