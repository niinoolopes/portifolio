<?php

namespace App;

use App\Usuario_tipo;
use App\Usuario_cargo;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class Usuario extends Model
{
    protected $table = 'sad__usuario';
    protected $primaryKey = 'USUARIO_ID';


    public function getAll()
    {
        $sql  = "SELECT usuario.*, tipo.TIPO_NOME, cargo.CARGO_NOME, empresa.NOME EMPRESA_NOME ";
        $sql .= "FROM sad__usuario as usuario ";
        $sql .= "LEFT JOIN sad__usuario_tipo as tipo ON tipo.TIPO_ID = usuario.TIPO_ID ";
        $sql .= "LEFT JOIN sad__usuario_cargo cargo ON cargo.CARGO_ID = usuario.CARGO_ID ";
        $sql .= "LEFT JOIN sad__empresa empresa ON empresa.EMPRESA_ID = usuario.EMPRESA_ID ";
        $sql .= ";";

        return DB::select($sql);
    }

    public function getAllVendedores($TIPO_IDs)
    {
        $TIPO = implode(',', $TIPO_IDs);

        $sql  = "SELECT usuario.*, tipo.TIPO_NOME, cargo.CARGO_NOME, empresa.NOME EMPRESA_NOME ";
        $sql .= "FROM sad__usuario as usuario ";
        $sql .= "LEFT JOIN sad__usuario_tipo as tipo ON tipo.TIPO_ID = usuario.TIPO_ID ";
        $sql .= "LEFT JOIN sad__usuario_cargo cargo ON cargo.CARGO_ID = usuario.CARGO_ID ";
        $sql .= "LEFT JOIN sad__empresa empresa ON empresa.EMPRESA_ID = usuario.EMPRESA_ID ";
        $sql .= "WHERE usuario.TIPO_ID in ({$TIPO}) ";
        $sql .= ";";

        return DB::select($sql);
    }

    public function getVendedorByUsuaId($USUARIO_ID)
    {
        $sql  = "SELECT usuario.*, tipo.TIPO_NOME, cargo.CARGO_NOME, empresa.NOME EMPRESA_NOME ";
        $sql .= "FROM sad__usuario as usuario ";
        $sql .= "LEFT JOIN sad__usuario_tipo as tipo ON tipo.TIPO_ID = usuario.TIPO_ID ";
        $sql .= "LEFT JOIN sad__usuario_cargo cargo ON cargo.CARGO_ID = usuario.CARGO_ID ";
        $sql .= "LEFT JOIN sad__empresa empresa ON empresa.EMPRESA_ID = usuario.EMPRESA_ID ";
        $sql .= "WHERE usuario.USUARIO_ID = {$USUARIO_ID} ";
        $sql .= ";";

        return DB::select($sql);
    }

    public function getByEmail($email)
    {
        $sql  = "SELECT * ";
        $sql .= "FROM sad__usuario as usuario ";
        $sql .= "WHERE usuario.LOGIN = '{$email}' ";
        $sql .= "AND STATUS = 1 ";
        $sql .= ";";

        return DB::select($sql);
    }
}
