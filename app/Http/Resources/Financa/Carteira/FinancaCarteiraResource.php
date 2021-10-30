<?php

namespace App\Http\Resources\Financa\Carteira;

use Illuminate\Http\Resources\Json\JsonResource;

class FinancaCarteiraResource extends JsonResource
{
  public function toArray($request)
  {
    return [
      "fnct_id"          => $this->fnct_id,
      "fnct_description" => $this->fnct_description,
      "fnct_json"        => json_decode($this->fnct_json),
      "fnct_enable"      => intval($this->fnct_enable),
      "fnct_panel"       => intval($this->fnct_panel),
    ];
  }
}
