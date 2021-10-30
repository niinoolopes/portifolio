<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableFinancaConsolidadoItemMonth extends Migration
{
  public function up()
  {
    Schema::create('api_crm_financa_consolidado_item_month', function (Blueprint $table) {
      $table->id('fncim_id');
      $table->string('fncim_year')->default('');
      $table->string('fncim_month')->default('');
      $table->text('fncim_json')->default('{}');
      $table->foreignId('fnct_id')->foreign('fnct_id')->references('fnct_id')->on('api_crm_financa_carteira');
    });
  }

  public function down()
  {
    Schema::dropIfExists('api_crm_financa_consolidado_item_month');
  }
}
