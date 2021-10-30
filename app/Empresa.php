<?php

namespace App;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class Empresa extends Model
{
    protected $table = 'sad__empresa';
    protected $primaryKey = 'EMPRESA_ID';


    public function getAll()
    {
        $sql  = "SELECT empresa.* ";
        $sql .= "FROM sad__empresa empresa ";
        $sql .= ";";
        return DB::select($sql);
    }

    public function getAllEnable()
    {
        $sql  = "SELECT empresa.* ";
        $sql .= "FROM sad__empresa empresa ";
        $sql .= "WHERE empresa.STATUS = 1 ";
        $sql .= ";";
        return DB::select($sql);
    }
}
