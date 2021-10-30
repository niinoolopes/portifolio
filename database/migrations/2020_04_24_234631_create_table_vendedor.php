<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Vendedor;

class CreateTableVendedor extends Migration
{
    public function up()
    {
        Schema::create('SAD__VENDEDOR', function (Blueprint $table) {
            $table->bigIncrements('VENDEDOR_ID')->increments('VENDEDOR_ID');
            $table->string('NOME');
            $table->string('TIPO_ID');
            $table->string('LOGIN')->unique();
            $table->string('SENHA');
            $table->string('STATUS');
            $table->string('EMPRESA_ID');
            $table->string('token');
            $table->timestamps();
        });



        // ------------------------



        $dados = [
            (object) [
                'NOME'       => 'Vendedor 1',
                'TIPO_ID'    => 2,
                'LOGIN'      => 'vendedor-1',
                'EMPRESA_ID' => 1,
                'token'      => '',
            ],
            (object) [
                'NOME'       => 'Vendedor 2',
                'TIPO_ID'    => 2,
                'LOGIN'      => 'vendedor-2',
                'EMPRESA_ID' => 1,
                'token'      => '',
            ]
        ];
        foreach ($dados as $key => $value) {
            $empresa             = new Vendedor;
            $empresa->NOME       = $value->NOME;
            $empresa->TIPO_ID    = $value->TIPO_ID;
            $empresa->LOGIN      = $value->LOGIN;
            $empresa->SENHA      = base64_encode(123);
            $empresa->STATUS     = 1;
            $empresa->EMPRESA_ID = $value->EMPRESA_ID;
            $empresa->token      = $value->token;
            // $empresa->save();
        }
    }

    public function down()
    {
        Schema::dropIfExists('SAD__VENDEDOR');
    }
}
