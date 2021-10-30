<?php

namespace App\Http\Resources\Produto;

use Illuminate\Http\Resources\Json\JsonResource;

class ProdutoResource extends JsonResource
{
  public function toArray($request)
  {
    return [
      "copt_id" => $this->copt_id,
      "copt_type" => $this->copt_type,
      "copt_price" => $this->copt_price,
      "copt_status" => $this->copt_status,
    ];
  }
}
