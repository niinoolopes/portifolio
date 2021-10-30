<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Banco;

class CreateTableBanco extends Migration
{
    public function up()
    {
        Schema::create('SAD__BANCO', function (Blueprint $table) {
            $table->bigIncrements('BANCO_ID')->increments('BANCO_ID');
            $table->string('NOME')->unique();
            $table->string('SITE');
            $table->string('CODIGO');
            $table->string('LOGO');
            $table->string('STATUS');
            $table->timestamps();
        });



        // ------------------------



        $dados = [
            (object) [
                'NOME'   => 'Banco 1',
                'SITE'   => 'www.banco1.com.br',
                'CODIGO' => '001',
                'LOGO'   => 'logo-banco-1.jpeg',
                'STATUS' => 1,
            ],
            (object) [
                'NOME'   => 'Banco 2',
                'SITE'   => 'www.banco2.com.br',
                'CODIGO' => '002',
                'LOGO'   => 'logo-banco-2.jpeg',
                'STATUS' => 1,
            ],
            (object) [
                'NOME'   => 'Banco 3',
                'SITE'   => 'www.banco3.com.br',
                'CODIGO' => '003',
                'LOGO'   => 'logo-banco-3.jpeg',
                'STATUS' => 0,
            ]
        ];
        foreach ($dados as $value) {
            $banco = new Banco;
            $banco->NOME    = $value->NOME;
            $banco->SITE    = $value->SITE;
            $banco->CODIGO  = $value->CODIGO;
            $banco->LOGO    = $value->LOGO;
            $banco->STATUS  = $value->STATUS;
            // $banco->save();
        }
    }

    public function down()
    {
        Schema::dropIfExists('SAD__BANCO');
    }
}
