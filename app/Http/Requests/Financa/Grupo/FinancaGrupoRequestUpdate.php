<?php

namespace App\Http\Requests\Financa\Grupo;

use Illuminate\Foundation\Http\FormRequest;

class FinancaGrupoRequestUpdate extends FormRequest
{
    public function authorize()
    {
        return true;
    }
    
    public function rules()
    {
        return [
            'fngp_description' => 'required',
            'fngp_enable'      => 'required',
            'fngp_fechamento'  => 'required',
            'fntp_id'          => 'required',
            'fnct_id'          => 'required',
        ];
    }

    public function messages()
    {
        return [
            'fngp_description.required' => 'field is required',
            'fngp_enable.required'      => 'field is required',
            'fngp_fechamento.required'  => 'field is required',
            'fntp_id.required'          => 'field is required',
            'fnct_id.required'          => 'field is required',
        ];
    }
}
