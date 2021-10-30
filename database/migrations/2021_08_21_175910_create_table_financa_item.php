<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableFinancaItem extends Migration
{
  public function up()
  {
    Schema::create('api_crm_financa_item', function (Blueprint $table) {
      $table->id('fnit_id');
      $table->double('fnit_value', 8, 2);
      $table->date('fnit_date');
      $table->string('fnit_obs', 300)->default('');
      $table->enum('fnit_enable', [1, 0])->default(1);
      $table->foreignId('fnis_id')->foreign('fnis_id')->references('fnis_id')->on('api_crm_financa_situacao');
      $table->foreignId('fntp_id')->foreign('fntp_id')->references('fntp_id')->on('api_crm_financa_tipo');
      $table->foreignId('fnct_id')->foreign('fnct_id')->references('fnct_id')->on('api_crm_financa_carteira');
      $table->foreignId('fngp_id')->foreign('fngp_id')->references('fngp_id')->on('api_crm_financa_grupo');
      $table->foreignId('fncg_id')->foreign('fncg_id')->references('fncg_id')->on('api_crm_financa_categoria');
      $table->foreignId('usua_id')->foreign('usua_id')->references('id')->on('api_sys_users');
      $table->timestamps();
    });
  }

  public function down()
  {
    Schema::dropIfExists('api_crm_financa_item');
  }
}
