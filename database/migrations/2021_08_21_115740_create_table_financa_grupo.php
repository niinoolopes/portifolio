<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableFinancaGrupo extends Migration
{
  public function up()
  {
    Schema::create('api_crm_financa_grupo', function (Blueprint $table) {
      $table->id('fngp_id');
      $table->string('fngp_description');
      $table->enum('fngp_enable', [1, 0])->default(1);
      $table->enum('fngp_fechamento', [1, 0])->default(0);
      $table->foreignId('fntp_id')->foreign('fntp_id')->references('fntp_id')->on('api_crm_financa_tipo');
      $table->foreignId('fnct_id')->foreign('fnct_id')->references('fnct_id')->on('api_crm_financa_carteira');
      $table->foreignId('usua_id')->foreign('usua_id')->references('id')->on('api_sys_users');
      $table->timestamps();
    });
  }

  public function down()
  {
    Schema::dropIfExists('api_crm_financa_grupo');
  }
}
