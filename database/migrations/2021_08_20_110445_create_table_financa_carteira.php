<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableFinancaCarteira extends Migration
{
  public function up()
  {
    Schema::create('api_crm_financa_carteira', function (Blueprint $table) {
      $table->id('fnct_id');
      $table->string('fnct_description');
      $table->text('fnct_json')->default('{}');
      $table->enum('fnct_enable', [1, 0])->default(1);
      $table->enum('fnct_panel', [1, 0])->default(0);
      $table->foreignId('usua_id')->foreign('usua_id')->references('id')->on('api_sys_users');
      $table->timestamps();
    });
  }

  public function down()
  {
    Schema::dropIfExists('api_crm_financa_carteira');
  }
}
