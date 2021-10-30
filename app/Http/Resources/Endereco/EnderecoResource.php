<?php

namespace App\Http\Resources\Endereco;

use Illuminate\Http\Resources\Json\JsonResource;

class EnderecoResource extends JsonResource
{
  public function toArray($request)
  {
    return [
      'end_id' => $this->end_id,
      'end_complement' => $this->end_complement,
      'end_address' => $this->end_address,
      'end_number' => $this->end_number,
      'end_zipcode' => $this->end_zipcode,
      'end_district' => $this->end_district,
      'end_city' => $this->end_city,
    ];
  }
}
