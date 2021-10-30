<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Usuario_cargo extends Model
{
    protected $table = 'sad__usuario_cargo';
    protected $primaryKey = 'CARGO_ID';

    public function getAll()
    {
        $sql = "SELECT * FROM sad__usuario_cargo order by CARGO_STATUS desc, CARGO_NOME asc;";
        return DB::select($sql);
    }

    public function getAllEnable()
    {
        $sql = "SELECT * FROM sad__usuario_cargo where CARGO_STATUS = 1 order by CARGO_STATUS desc, CARGO_NOME asc;";
        return DB::select($sql);
    }
}
