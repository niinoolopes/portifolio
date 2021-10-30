<?php

namespace App;

// use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class MotivoCancelamento extends Model
{
    protected $table = 'sad__pedido_motivo';
    protected $primaryKey = 'MOTIVO_ID';
    public $timestamps = false;


    // public function getAll()
    // {
    //     $sql  = "SELECT empresa.* ";
    //     $sql .= "FROM sad__empresa empresa ";
    //     $sql .= ";";
    //     return DB::select($sql);
    // }

    // public function getAllEnable()
    // {
    //     $sql  = "SELECT empresa.* ";
    //     $sql .= "FROM sad__empresa empresa ";
    //     $sql .= "WHERE empresa.STATUS = 1 ";
    //     $sql .= ";";
    //     return DB::select($sql);
    // }
}
