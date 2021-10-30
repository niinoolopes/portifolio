<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Config;

class CreateTableConfig extends Migration
{
    public function up()
    {
        Schema::dropIfExists('SAD__CONFIG');

        Schema::create('SAD__CONFIG', function (Blueprint $table) {
            $table->bigIncrements('CONFIG_ID')->increments('CONFIG_ID');
            $table->string('DESCRICAO')->unique();
            $table->string('JSON');
            $table->timestamps();
        });

        $dados = [
            (object) [
                'DESCRICAO' => 'FORM_CADASTRO',
                'JSON' => '{"TIPO_ID":["2"],"N_ATENDIMENTO":false,"VALOR":false,"DATA":false,"BANCO":false,"COMPROVANTE":false}',
            ],
            (object) [
                'DESCRICAO' => 'FORM_PEDIDO',
                'JSON' => '{}',
            ],
        ];
        foreach ($dados as $value) {
            $status = new Config;
            $status->DESCRICAO = $value->DESCRICAO;
            $status->JSON    = $value->STATUS;
            // $status->save();
        }
    }

    public function down()
    {
        Schema::dropIfExists('SAD__CONFIG');
    }
}
