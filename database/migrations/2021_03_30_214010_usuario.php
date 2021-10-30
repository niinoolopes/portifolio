<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Usuario extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('sc__usuario');

        Schema::create('sc__usuario', function (Blueprint $table) {
            $table->id('usua_id');
            $table->string('usua_login')->unique();
            $table->string('usua_password');
            $table->string('usua_name');
            $table->string('usua_email')->unique();
            $table->string('usua_cnpj');
            $table->string('usua_pix');
            $table->string('usua_whatsapp');
            $table->string('usua_banco');
            $table->string('usua_agencia');
            $table->string('usua_conta');
            $table->integer('usua_status')->default(1);
            $table->integer('type_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sc__usuario');
    }
}
