<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ColetaProduto extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('sc__coleta_produto');

        Schema::create('sc__coleta_produto', function (Blueprint $table) {
            $table->id('colp_id');
            $table->string('colp_description');
            $table->decimal('colp_quantity', 8, 2)->default(0);
            $table->decimal('colp_price_unit', 8, 2)->default(0);
            $table->decimal('colp_price', 8, 2)->default(0);
            $table->integer('colp_status')->default(1);
            $table->integer('cole_id');
            $table->integer('copt_id');
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
        Schema::dropIfExists('sc__coleta_produto');
    }
}
