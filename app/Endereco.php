<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
// use Illuminate\Support\Facades\DB;

class Endereco extends Model
{
    protected $table = 'sc__endereco';

    protected $primaryKey = 'end_id';
}
