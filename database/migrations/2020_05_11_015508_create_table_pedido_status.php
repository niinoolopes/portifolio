<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Pedido_status;

class CreateTablePedidoStatus extends Migration
{

    public function up()
    {
        Schema::create('SAD__PEDIDO_STATUS', function (Blueprint $table) {
            $table->bigIncrements('STATUS_ID');
            $table->string('DESCRICAO')->unique();
            $table->string('STATUS');
            $table->timestamps();
        });



        // ------------------------



        $dados = [
            (object) [
                'DESCRICAO' => 'Pendente',
                'STATUS' => 1,
            ],
            (object) [
                'DESCRICAO' => 'Aceito',
                'STATUS' => 1,
            ],
            (object) [
                'DESCRICAO' => 'Cancelado',
                'STATUS' => 1,
            ]
        ];
        foreach ($dados as $value) {
            $status = new Pedido_status;
            $status->DESCRICAO = $value->DESCRICAO;
            $status->STATUS    = $value->STATUS;
            $status->save();
        }
    }

    public function down()
    {
        Schema::dropIfExists('SAD__PEDIDO_STATUS');
    }
}
