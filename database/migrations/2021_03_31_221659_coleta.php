<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Coleta extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('sc__coleta');
        
        Schema::create('sc__coleta', function (Blueprint $table) {
            $table->id('cole_id');
            $table->date('cole_date')->useCurrent();
            $table->decimal('cole_price', 8, 2)->default(0);
            $table->integer('cole_status');
            $table->integer('cols_id')->default(1);
            $table->integer('clie_id')->nullable();
            $table->integer('motr_id')->nullable();
            $table->integer('finc_id')->nullable();
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
        Schema::dropIfExists('sc__coleta');
    }
}
