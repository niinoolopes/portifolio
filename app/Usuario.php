<?php

namespace App;

use App\Http\Resources\Endereco\EnderecoResource;
use App\Http\Resources\Usuario\UsuarioTypeResource;
use Illuminate\Database\Eloquent\Model;

class Usuario extends Model
{
    protected $table = 'sc__usuario';

    protected $primaryKey  = 'usua_id';

    // public function getAll($parans = [])
    // {
    //     $id = isset($parans['id']) ? $parans['id'] : false;

    //     $sql  = "";
    //     $sql .= "SELECT ";
    //     $sql .= "USUARIO.id, USUARIO.login, USUARIO.name, USUARIO.email, USUARIO.cnpj, USUARIO.pix, USUARIO.whatsapp, USUARIO.type, USUARIO.banco, USUARIO.agencia, USUARIO.conta, USUARIO.status, ";
    //     $sql .= "ENDERECO.rua, ENDERECO.endereco, ENDERECO.numero, ENDERECO.cep, ENDERECO.bairro, ENDERECO.cidade ";
    //     $sql .= "FROM sc__usuario USUARIO ";
    //     $sql .= "LEFT join sc__endereco ENDERECO on ENDERECO.id = USUARIO.id ";

    //     if ($id != false) $sql .= " where USUARIO.id = $id ";

    //     return DB::select($sql);
    // }

    public function end()
    {
        $model = $this->hasOne('App\Endereco', 'usua_id', 'usua_id');
        return new EnderecoResource($model->first());
    }

    public function usut()
    {
        $model = $this->hasOne('App\UsuarioType', 'usut_id', 'usut_id');
        return new UsuarioTypeResource($model->first());
    }
}
