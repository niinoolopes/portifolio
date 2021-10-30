<?php

namespace App\Http\Resources\Coleta;

use Illuminate\Http\Resources\Json\JsonResource;

class ColetaHistoricoResource extends JsonResource
{
  public function toArray($request)
  {
    return [
      'colh_id'   => $this->colh_id,
      'colh_date' => $this->colh_date,
      'cole_id'   => $this->cole_id,
      'cols_id'   => $this->cols_id,
      'cols'      => $this->cols,
      'usua_id'   => $this->usua_id,
      'usua'      => $this->usua,
    ];
  }
}
