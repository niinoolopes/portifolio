<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ColetaHistorico extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('sc__coleta_historico');
        
        Schema::create('sc__coleta_historico', function (Blueprint $table) {
            $table->id('colh_id');
            $table->timestamp('colh_date')->useCurrent();
            $table->integer('cole_id');
            $table->integer('cols_id');
            $table->integer('usua_id');
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
        Schema::dropIfExists('sc__coleta_historico');
    }
}
