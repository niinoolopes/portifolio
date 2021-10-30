<?php

namespace App\Http\Resources\Financa\Item;

use Illuminate\Http\Resources\Json\ResourceCollection;

class FinancaItemCollection extends ResourceCollection
{
  public $collects = 'App\Http\Resources\Financa\Item\FinancaItemResource';

  public function toArray($request)
  {
    return $this->resource;
  }
}
