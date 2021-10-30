<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateTableFinancaTipo extends Migration
{
  public function up()
  {
    Schema::create('api_crm_financa_tipo', function (Blueprint $table) {
      $table->id('fntp_id');
      $table->string('fntp_description');
    });


    DB::table('api_crm_financa_tipo')->insert([
      ['fntp_id' => 1, 'fntp_description' => 'Receita'],
      ['fntp_id' => 2, 'fntp_description' => 'Despesa'],
    ]);
  }

  public function down()
  {
    Schema::dropIfExists('api_crm_financa_tipo');
  }
}
