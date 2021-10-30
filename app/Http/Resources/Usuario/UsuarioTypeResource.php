<?php

namespace App\Http\Resources\Usuario;

use Illuminate\Http\Resources\Json\JsonResource;

class UsuarioTypeResource extends JsonResource
{
  public function toArray($request)
  {
    return [
      'usut_id' => $this->usut_id,
      'usut_name' => $this->usut_name,
    ];
  }
}