<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Usuario_tipo;

class CreateTableUsuarioTipo extends Migration
{
    public function up()
    {
        Schema::create('SAD__USUARIO_TIPO', function (Blueprint $table) {
            $table->bigIncrements('TIPO_ID')->increments('TIPO_ID');
            $table->string('TIPO_NOME')->unique();
            $table->string('TIPO_STATUS');
            $table->timestamps();
        });



        // ------------------------



        $dados = [
            (object) [
                'TIPO_NOME'   => 'administrador',
                'TIPO_STATUS' => 1,
            ],
            // (object) [
            //     'TIPO_NOME'   => 'vendedor',
            //     'TIPO_STATUS' => 1,
            // ]
        ];
        foreach ($dados as $key => $value) {
            $tipo = new Usuario_tipo;
            $tipo->TIPO_NOME    = $value->TIPO_NOME;
            $tipo->TIPO_STATUS  = $value->TIPO_STATUS;
            $tipo->save();
        }
    }

    public function down()
    {
        Schema::dropIfExists('SAD__USUARIO_TIPO');
    }
}
