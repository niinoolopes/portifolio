<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableFinancaConsolidadoItemYear extends Migration
{
  public function up()
  {
    Schema::create('api_crm_financa_consolidado_item_year', function (Blueprint $table) {
      $table->id('fnciy_id');
      $table->string('fnciy_year')->default('');
      $table->text('fnciy_json')->default('{}');
      $table->foreignId('fnct_id')->foreign('fnct_id')->references('fnct_id')->on('api_crm_financa_carteira');
    });
  }

  public function down()
  {
    Schema::dropIfExists('api_crm_financa_consolidado_item_year');
  }
}
