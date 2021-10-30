<?php

namespace App\Http\Resources\Financa\Carteira;

use Illuminate\Http\Resources\Json\ResourceCollection;

class FinancaCarteiraCollection extends ResourceCollection
{
  public $collects = 'App\Http\Resources\Financa\Carteira\FinancaCarteiraResource';

  public function toArray($request)
  {
    return $this->resource;
  }
}
