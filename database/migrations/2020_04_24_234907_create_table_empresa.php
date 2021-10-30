<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Empresa;

class CreateTableEmpresa extends Migration
{
    public function up()
    {
        Schema::create('SAD__EMPRESA', function (Blueprint $table) {
            $table->bigIncrements('EMPRESA_ID')->increments('EMPRESA_ID');
            $table->string('NOME')->unique();
            $table->string('COR');
            $table->string('STATUS');
            $table->timestamps();
        });



        // ------------------------



        $dados = [
            (object) [
                'NOME'   => 'Empresa teste 1',
                'COR'    => '#e047b3',
                'STATUS' => 1
            ],
            (object) [
                'NOME'   => 'Empresa teste 2',
                'COR'    => '#f73145',
                'STATUS' => 0
            ]
        ];
        foreach ($dados as $key => $value) {
            $empresa = new Empresa;
            $empresa->NOME    = $value->NOME;
            $empresa->COR     = $value->COR;
            $empresa->STATUS  = $value->STATUS;
            // $empresa->save();
        }
    }

    public function down()
    {
        Schema::dropIfExists('SAD__EMPRESA');
    }
}
