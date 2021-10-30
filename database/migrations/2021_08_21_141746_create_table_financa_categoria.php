<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableFinancaCategoria extends Migration
{
  public function up()
  {
    Schema::create('api_crm_financa_categoria', function (Blueprint $table) {
      $table->id('fncg_id');
      $table->string('fncg_description');
      $table->string('fncg_obs', 200);
      $table->enum('fncg_enable', [1, 0])->default(1);
      $table->enum('fncg_fechamento', [1, 0])->default(0);
      $table->foreignId('fngp_id')->foreign('fngp_id')->references('fngp_id')->on('api_crm_financa_grupo');
      $table->foreignId('fnct_id')->foreign('fnct_id')->references('fnct_id')->on('api_crm_financa_carteira');
      $table->foreignId('usua_id')->foreign('usua_id')->references('id')->on('api_sys_users');
      $table->timestamps();
    });
  }

  public function down()
  {
    Schema::dropIfExists('api_crm_financa_categoria');
  }
}
