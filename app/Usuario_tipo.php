<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Usuario_tipo extends Model
{
    protected $table = 'sad__usuario_tipo';
    protected $primaryKey = 'TIPO_ID';

    public function getAll()
    {
        $sql = "SELECT * FROM sad__usuario_tipo order by TIPO_STATUS desc, TIPO_NOME asc;";
        return DB::select($sql);
    }

    public function getAllEnable()
    {
        $sql = "SELECT * FROM sad__usuario_tipo where TIPO_STATUS = 1 order by TIPO_STATUS desc, TIPO_NOME asc;";
        return DB::select($sql);
    }
}
