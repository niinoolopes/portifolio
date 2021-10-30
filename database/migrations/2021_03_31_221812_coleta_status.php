<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class ColetaStatus extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('sc__coleta_status');

        Schema::create('sc__coleta_status', function (Blueprint $table) {
            $table->id('cols_id');
            $table->string('cols_name')->unique();
            $table->timestamps();
        });

        DB::table('sc__coleta_status')->insert(
            ['cols_id' => 1,'cols_name' => 'Coleta solicitada'],
        );
        DB::table('sc__coleta_status')->insert(
            ['cols_id' => 2,'cols_name' => 'Coleta em andamento'],
        );
        DB::table('sc__coleta_status')->insert(
            ['cols_id' => 3,'cols_name' => 'Coleta realizada'],
        );
        DB::table('sc__coleta_status')->insert(
            ['cols_id' => 4,'cols_name' => 'Coleta entregue'],
        );
        DB::table('sc__coleta_status')->insert(
            ['cols_id' => 5,'cols_name' => 'Coleta concluida'],
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sc__coleta_status');
    }
}
