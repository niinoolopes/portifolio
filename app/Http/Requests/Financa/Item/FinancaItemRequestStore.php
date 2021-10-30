<?php

namespace App\Http\Requests\Financa\Item;

use Illuminate\Foundation\Http\FormRequest;

class FinancaItemRequestStore extends FormRequest
{
  public function authorize()
  {
    return true;
  }

  public function rules()
  {
    return [
      'fnit_value'  => 'required',
      'fnit_date'   => 'required',
      'fnit_obs'    => 'required',
      'fnit_enable' => 'required',
      'fnis_id'     => 'required',
      'fntp_id'     => 'required',
      'fngp_id'     => 'required',
      'fncg_id'     => 'required',
    ];
  }

  public function messages()
  {
    return [
      'fnit_value.required'  => 'field is required',
      'fnit_date.required'   => 'field is required',
      'fnit_obs.required'    => 'field is required',
      'fnit_enable.required' => 'field is required',
      'fnis_id.required'     => 'field is required',
      'fntp_id.required'     => 'field is required',
      'fngp_id.required'     => 'field is required',
      'fncg_id.required'     => 'field is required',
    ];
  }
}
