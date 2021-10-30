<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Usuario_cargo;

class CreateTableUsuarioCargo extends Migration
{
    public function up()
    {
        Schema::create('SAD__USUARIO_CARGO', function (Blueprint $table) {
            $table->bigIncrements('CARGO_ID')->increments('CARGO_ID');
            $table->string('CARGO_NOME')->unique();
            $table->string('CARGO_STATUS');
            $table->timestamps();
        });


        // ------------------------


        $dados = [
            (object) [
                'nome' => 'Gerente',
                'status' => 1
            ],
            (object) [
                'nome' => 'Recrutador',
                'status' => 0
            ]
        ];
        foreach ($dados as $key => $value) {
            $cargo = new Usuario_cargo;
            $cargo->CARGO_NOME        = $value->nome;
            $cargo->CARGO_STATUS = $value->status;
            // $cargo->save();
        }
    }

    public function down()
    {
        Schema::dropIfExists('SAD__USUARIO_CARGO');
    }
}
