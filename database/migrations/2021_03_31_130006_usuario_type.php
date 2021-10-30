<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class UsuarioType extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('sc__usuario_type');

        Schema::create('sc__usuario_type', function (Blueprint $table) {
            $table->id('usut_id');
            $table->string('usut_name')->unique();
        });

        DB::table('sc__usuario_type')->insert(
            ['usut_name' => 'Admin'],
        );
        DB::table('sc__usuario_type')->insert(
            ['usut_name' => 'Motorista'],
        );
        DB::table('sc__usuario_type')->insert(
            ['usut_name' => 'Cliente'],
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sc__usuario_type');
    }
}
