<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class ProdutoType extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('sc__produto_type');
        
        Schema::create('sc__produto_type', function (Blueprint $table) {
            $table->id('copt_id');
            $table->string('copt_type');
            $table->decimal('copt_price', 8, 2)->default(0);
            $table->integer('copt_status');
            $table->timestamps();
        });
        
        DB::table('sc__produto_type')->insert(
            ['copt_id' => 1,'copt_type' => 'Usado',  'copt_price' => 1.00, 'copt_status' => 1]
        );
        DB::table('sc__produto_type')->insert(
            ['copt_id' => 2,'copt_type' => 'Vencido','copt_price' => 1.00, 'copt_status' => 1]
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sc__produto_type');
    }
}
