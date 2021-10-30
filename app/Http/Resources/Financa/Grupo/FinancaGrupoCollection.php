<?php

namespace App\Http\Resources\Financa\Grupo;

use Illuminate\Http\Resources\Json\ResourceCollection;

class FinancaGrupoCollection extends ResourceCollection
{
  public $collects = 'App\Http\Resources\Financa\Grupo\FinancaGrupoResource';

  public function toArray($request)
  {
    return $this->resource;
  }
}
