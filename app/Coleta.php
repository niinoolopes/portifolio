<?php

namespace App;

use App\Http\Resources\Coleta\ColetaHistoricoResource;
use App\Http\Resources\Coleta\ColetaProdutoResource;
use App\Http\Resources\Coleta\ColetaStatusResource;
use App\Http\Resources\Endereco\EnderecoResource;
use App\Http\Resources\Usuario\UsuarioPedidoResource;
use Illuminate\Database\Eloquent\Model;

class Coleta extends Model
{
    protected $table = 'sc__coleta';

    protected $primaryKey = 'cole_id';

    // public function getAll($params = [])
    // {
    //     $coleta_id = isset($params['coleta_id']) ? $params['coleta_id'] : false;
    //     $cliente_id = isset($params['cliente_id']) ? $params['cliente_id'] : false;
    //     $motorista_id = isset($params['motorista_id']) ? $params['motorista_id'] : false;
    //     $financeiro_id = isset($params['financeiro_id']) ? $params['financeiro_id'] : false;

    //     $sql = 'SELECT ';
    //     $sql .= "Col.id, date_format(Col.date, '%d/%m/%Y %H:%i') date, Col.price, Col.status, Col.coleta_status, ";
    //     $sql .= "S.id Col_status_id, S.status Col_status, ";
    //     $sql .= "C.id C_id, C.name C_name, ";
    //     $sql .= "M.id M_id, M.name M_name, ";
    //     $sql .= "F.id F_id, F.name F_name ";
    //     $sql .= "FROM sc__coleta Col ";
    //     $sql .= "left JOIN sc__coleta_status S on S.id = Col.coleta_status ";
    //     $sql .= "left JOIN sc__usuario C on C.id = Col.cliente_id ";
    //     $sql .= "left JOIN sc__usuario M on M.id = Col.motorista_id ";
    //     $sql .= "left JOIN sc__usuario F on M.id = Col.financeiro_id ";

    //     if ($coleta_id !== false) $sql .= "where Col.id = {$coleta_id} ";
    //     if ($cliente_id !== false) $sql .= "where C.id = {$cliente_id} ";
    //     if ($motorista_id !== false) $sql .= "where M.id = {$motorista_id} ";
    //     if ($financeiro_id !== false) $sql .= "where F.id = {$financeiro_id} ";

    //     $coletas = DB::select($sql);

    //     foreach ($coletas as $key => $coleta) {

    //         $sql  = "SELECT ";
    //         $sql .= "CH.id, date_format(CH.date, '%d/%m/%Y %H:%i') date, CH.status_id, ";
    //         $sql .= "S.status status_name, ";
    //         $sql .= "U.name usuario_name  ";
    //         $sql .= "from sc__coleta_historico CH ";
    //         $sql .= "LEFT JOIN sc__coleta_status S ON S.id = CH.status_id ";
    //         $sql .= "LEFT JOIN sc__usuario U ON U.id = CH.usuario_id ";
    //         $sql .= "WHERE CH.coleta_id = {$coleta->id} ";

    //         $coletas[$key]->historico = DB::select($sql);
    //     }

    //     return $coletas;
    // }

    public function end()
    {
        $model = $this->hasOne('App\Endereco', 'cole_id', 'cole_id');
        return new EnderecoResource($model->first());
    }

    public function colh()
    {
        $data = $this->hasMany('App\ColetaHistorico', 'cole_id', 'cole_id')->get();
        foreach ($data as $key => $value) {
            $value->colh_date = date('d/m/Y H:i:s', strtotime($value->colh_date));
            $value->cols = $value->cols();
            $value->usua = $value->usua();
            $data[$key] = new ColetaHistoricoResource($value);
        }
        return $data;
    }

    public function colp()
    {
        $data = $this->hasMany('App\ColetaProduto', 'cole_id', 'cole_id')->get();
        foreach ($data as $key => $value) {
            $value->copt = $value->copt();
            $data[$key] = new ColetaProdutoResource($value);
        }
        return $data;
    }

    public function clie()
    {
        $model = $this->hasOne('App\Usuario', 'usua_id', 'clie_id');
        return  new UsuarioPedidoResource($model->first());
    }

    public function motr()
    {
        $model = $this->hasOne('App\Usuario', 'usua_id', 'motr_id');
        return  new UsuarioPedidoResource($model->first());
        // return  $model->first();
    }

    public function finc()
    {
        $model = $this->hasOne('App\Usuario', 'usua_id', 'finc_id');
        return  new UsuarioPedidoResource($model->first());
    }

    public function cols()
    {
        $model = $this->hasOne('App\ColetaStatus', 'cols_id', 'cols_id');
        return new ColetaStatusResource($model->first());
    }
}
