<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UsuarioModel extends Model
{
    protected $primaryKey = 'USUARIO_ID';

    protected $table = 'usuario';
    
    public $timestamps = false;
}
