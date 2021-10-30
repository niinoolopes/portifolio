<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsuarioTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('usuario', function (Blueprint $table) {
            $table->id('USUARIO_ID')->bigIncrements()->unique();
            $table->string('USUARIO_NOME', 100);
            $table->string('USUARIO_SOBRENOME', 100);
            $table->date('USUARIO_DATA_NASCIMENTO', 100);
            $table->string('USUARIO_SEXO', 1);
            // $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('usuario');
    }
}
