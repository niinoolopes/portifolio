<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Endereco extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('sc__endereco');

        Schema::create('sc__endereco', function (Blueprint $table) {
            $table->id('end_id');
            $table->string('end_complement');
            $table->string('end_address');
            $table->string('end_number');
            $table->string('end_zipcode');
            $table->string('end_district');
            $table->string('end_city');
            $table->integer('usua_id')->nullable();
            $table->integer('cole_id')->nullable();
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
        Schema::dropIfExists('sc__endereco');
    }
}
