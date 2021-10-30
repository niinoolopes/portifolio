<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Pedido;

class CreateTablePedido extends Migration
{
    public function up()
    {
        Schema::dropIfExists('SAD__PEDIDO');

        Schema::create('SAD__PEDIDO', function (Blueprint $table) {
            $table->bigIncrements('PEDIDO_ID')->increments('PEDIDO_ID');
            $table->string('N_ATENDIMENTO');
            $table->string('USUARIO_ID');
            $table->string('VALOR');
            $table->string('DATA_TRANSFERENCIA');
            $table->string('BANCO_ID');
            $table->string('COMPROVANTE');
            $table->string('STATUS_ID');
            $table->string('STATUS');
            $table->timestamps();
        });



        // ------------------------



        for ($i = 0; $i < 50; $i++) {
            $pedido = new Pedido;
            $pedido->N_ATENDIMENTO      = '00' . $i;
            $pedido->USUARIO_ID        = 2;
            $pedido->VALOR              = 12.0 . $i;
            $pedido->DATA_TRANSFERENCIA = '2020-05-11';
            $pedido->BANCO_ID           = 1;
            $pedido->COMPROVANTE        = '';
            $pedido->STATUS_ID          = 1;
            $pedido->STATUS             = 1;
            // $pedido->save();
        }
    }

    public function down()
    {
        Schema::dropIfExists('SAD__PEDIDO');
    }
}
