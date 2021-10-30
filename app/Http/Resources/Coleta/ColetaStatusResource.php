<?php

namespace App\Http\Resources\Coleta;

use Illuminate\Http\Resources\Json\JsonResource;

class ColetaStatusResource extends JsonResource
{
  public function toArray($request)
  {
    return [
      'cols_id' => $this->cols_id,
      'cols_name' => $this->cols_name,
    ];
  }
}
