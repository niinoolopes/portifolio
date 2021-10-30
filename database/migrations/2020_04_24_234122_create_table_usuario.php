<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Usuario;

class CreateTableUsuario extends Migration
{
    public function up()
    {
        Schema::dropIfExists('SAD__USUARIO');

        Schema::create('SAD__USUARIO', function (Blueprint $table) {
            $table->bigIncrements('USUARIO_ID')->increments('USUARIO_ID');
            $table->string('NOME');
            $table->string('CARGO_ID')->references('CARGO_ID')->on('sad__usuario_cargo');
            $table->string('TIPO_ID')->references('TIPO_ID')->on('sad__usuario_tipo');
            $table->string('EMPRESA_ID')->references('EMPRESA_ID')->on('sad__empresa');
            $table->string('EMAIL')->unique();
            $table->string('LOGIN')->unique();
            $table->string('SENHA');
            $table->longText('JSON');
            $table->string('STATUS');
            $table->timestamps();
        });



        // ------------------------



        $dados = [
            (object) [
                'NOME'       => 'administrador',
                'CARGO_ID'   => '',
                'TIPO_ID'    => '1',
                'EMPRESA_ID' => '',
                'EMAIL'      => 'admin@admin.com',
                'LOGIN'      => 'administrador',
                'SENHA'      => base64_encode(123),
                'JSON'       => '{"PAINEL":"all","CONFIG":"S"}',
                'STATUS'     => 1,
            ],
            // (object) [
            //     'NOME'       => 'vendedor TESTE 1',
            //     'CARGO_ID'   => 1,
            //     'TIPO_ID'    => 2,
            //     'EMPRESA_ID' => 1,
            //     'EMAIL'      => 'vendedor1@admin.com',
            //     'LOGIN'      => 'vendedor-1',
            //     'SENHA'      => base64_encode(123),
            //     'JSON'       => '{"PAINEL":"all","CONFIG":"S"}',
            //     'STATUS'     => 1,
            // ],
        ];
        foreach ($dados as $key => $value) {
            $usuario = new Usuario;
            $usuario->NOME       = $value->NOME;
            $usuario->CARGO_ID   = $value->CARGO_ID;
            $usuario->TIPO_ID    = $value->TIPO_ID;
            $usuario->EMPRESA_ID = $value->EMPRESA_ID;
            $usuario->EMAIL      = $value->EMAIL;
            $usuario->LOGIN      = $value->LOGIN;
            $usuario->SENHA      = $value->SENHA;
            $usuario->JSON       = $value->JSON;
            $usuario->STATUS     = $value->STATUS;
            $usuario->save();
        }
    }

    public function down()
    {
        Schema::dropIfExists('SAD__USUARIO');
    }
}
