<?php

namespace App;

use App\Http\Resources\Coleta\ColetaStatusResource;
use App\Http\Resources\Usuario\UsuarioPedidoResource;
use Illuminate\Database\Eloquent\Model;
// use Illuminate\Support\Facades\DB;

class ColetaHistorico extends Model
{
    protected $table = 'sc__coleta_historico';

    protected $primaryKey = 'colh_id';

    public function cols()
    {
        $model = $this->hasOne('App\ColetaStatus', 'cols_id', 'cols_id');
        return new ColetaStatusResource($model->first());
    }

    public function usua()
    {
        $model = $this->hasOne('App\Usuario', 'usua_id', 'usua_id');
        return  new UsuarioPedidoResource($model->first());
    }
}
