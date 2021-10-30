<?php

namespace App\Http\Resources\Usuario;

use Illuminate\Http\Resources\Json\JsonResource;

class UsuarioResource extends JsonResource
{
  public function toArray($request)
  {
    return [
      'usua_id' => $this->usua_id,
      'usua_login' => $this->usua_login,
      // 'usua_password' => $this->usua_password,
      'usua_name' => $this->usua_name,
      'usua_email' => $this->usua_email,
      'usua_cnpj' => $this->usua_cnpj,
      'usua_pix' => $this->usua_pix,
      'usua_whatsapp' => $this->usua_whatsapp,
      'usua_banco' => $this->usua_banco,
      'usua_agencia' => $this->usua_agencia,
      'usua_conta' => $this->usua_conta,
      'usua_status' => $this->usua_status,
      'usut_id' => $this->usut_id,
      'end' => $this->end,
      'usut' => $this->usut,
    ];
  }
}