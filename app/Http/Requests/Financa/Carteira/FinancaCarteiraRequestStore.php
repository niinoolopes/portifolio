<?php

namespace App\Http\Requests\Financa\Carteira;

use Illuminate\Foundation\Http\FormRequest;

class FinancaCarteiraRequestStore extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'fnct_description' => 'required|max:50',
        ];
    }

    public function messages()
    {
        return [
            'fnct_description.required' => 'field is required',
        ];
    }
}
