<?php

namespace App\Http\Requests\Financa\Carteira;

use Illuminate\Foundation\Http\FormRequest;

class FinancaCarteiraRequestUpdate extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'fnct_description' => 'required|max:50',
            'fnct_json'        => 'required',
            'fnct_enable'      => 'required',
            'fnct_panel'       => 'required',
        ];
    }

    public function messages()
    {
        return [
            'fnct_description.required' => 'field is required',
            'fnct_json.required' => 'field is required',
            'fnct_enable.required' => 'field is required',
            'fnct_panel.required' => 'field is required',
        ];
    }
}
