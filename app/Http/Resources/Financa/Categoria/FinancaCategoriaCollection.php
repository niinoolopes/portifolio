<?php

namespace App\Http\Resources\Financa\Categoria;

use Illuminate\Http\Resources\Json\ResourceCollection;

class FinancaCategoriaCollection extends ResourceCollection
{
  public $collects = 'App\Http\Resources\Financa\Categoria\FinancaCategoriaResource';

  public function toArray($request)
  {
    return $this->resource;
  }
}
