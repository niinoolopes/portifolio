<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateTableFinancaSituacao extends Migration
{
  public function up()
  {
    Schema::create('api_crm_financa_situacao', function (Blueprint $table) {
      $table->id('fnis_id');
      $table->string('fnis_description');
    });

    DB::table('api_crm_financa_situacao')->insert([
      ['fnis_id' => 1, 'fnis_description' => 'Pago'],
      ['fnis_id' => 2, 'fnis_description' => 'Pendente'],
      ['fnis_id' => 3, 'fnis_description' => 'Talvez'],
    ]);
  }

  public function down()
  {
    Schema::dropIfExists('api_crm_financa_situacao');
  }
}
