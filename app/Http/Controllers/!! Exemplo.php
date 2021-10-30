<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Exemplo extends Controller
{
    public function teste() {
        return die(json_encode(['teste'=> true]));
    }
}
