<?php

namespace App\Http\Requests\Financa\Categoria;

use Illuminate\Foundation\Http\FormRequest;

class FinancaCategoriaRequestStore extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'fncg_description' => 'required',
            'fncg_enable'      => 'required',
            'fncg_fechamento'  => 'required',
            'fngp_id'          => 'required',
            'fnct_id'          => 'required',
        ];
    }

    public function messages()
    {
        return [
            'fncg_description.required' => 'field is required',
            'fncg_enable.required'      => 'field is required',
            'fncg_fechamento.required'  => 'field is required',
            'fngp_id.required'          => 'field is required',
            'fnct_id.required'          => 'field is required',
        ];
    }
}
