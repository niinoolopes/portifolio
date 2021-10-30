<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableFinancaItemConsolidado extends Migration
{
  public function up()
  {
    Schema::create('api_crm_financa_item_consolidado', function (Blueprint $table) {
      $table->id('fnic_id');
      $table->date('fnic_date');
      $table->text('fnic_json')->default('{}');
      $table->foreignId('fnct_id')->foreign('fnct_id')->references('fnct_id')->on('api_crm_financa_carteira');
      $table->timestamps();
    });
  }

  public function down()
  {
    Schema::dropIfExists('api_crm_financa_item_consolidado');
  }
}
