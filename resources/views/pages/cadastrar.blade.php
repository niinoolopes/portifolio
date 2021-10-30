@extends('layout.template')

@section('conteudo')
<div class="col-12">
    <div class="d-flex justify-content-center">

        <form id="form-cadastro" class="col-lg-8 py-3 px-2 p-md-4 bg-white" method="POST" enctype="multipart/form-data" action="{{ route('pedido.post') }}">
            {{ csrf_field() }}

            <h3 class="display-5">Novo Pedido</h3>

            <hr>

            <div class="row">

                <div class="form-group col-md-6">
                    <label class="m-0" for="N_ATENDIMENTO">Nº ATENDIMENTO</label>
                    <input class="form-control" id="N_ATENDIMENTO" name="N_ATENDIMENTO" type="text" value="{{$campos['N_ATENDIMENTO']}}" <?= $config->N_ATENDIMENTO ? 'required' : '' ?>>
                </div>

                <div class="form-group col-md-6">
                    <label class="m-0" for="USUARIO_ID">Vendedor</label>
                    <select class="form-control" id="USUARIO_ID" name="USUARIO_ID" required>
                        <option value="">Selecione</option>
                        @foreach ($vendedores as $vendedor)
                        <option value="{{$vendedor->USUARIO_ID}}" <?= $campos['USUARIO_ID'] == $vendedor->USUARIO_ID ? 'selected' : '' ?>>{{$vendedor->NOME}}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="row">
                <div class="form-group col-12 col-md-6">
                    <label class="m-0" for="VALOR">Valor</label>
                    <input class="form-control" id="VALOR" name="VALOR" type="number" step="0.01" value="{{$campos['VALOR']}}" <?= $config->VALOR ? 'required' : '' ?>>
                </div>
                <div class="form-group col-12 col-md-6">
                    <label class="m-0" for="DATA_TRANSFERENCIA">Data</label>
                    <input class="form-control" id="DATA_TRANSFERENCIA" name="DATA_TRANSFERENCIA" type="date" value="{{$campos['DATA_TRANSFERENCIA']}}" <?= $config->DATA ? 'required' : '' ?>>
                </div>
            </div>

            <div class="row">
                <div class="form-group col-12 col-md-6">
                    <label class="m-0" for="BANCO_ID">Banco</label>
                    <select class="custom-select" id="BANCO_ID" name="BANCO_ID" <?= $config->BANCO ? 'required' : '' ?>>
                        <option selected>Selecione</option>
                        @foreach ($bancos as $banco)
                        <option data-logo="{{ 'storage/app/public/images/bancos/'. $banco->LOGO }}" value="{{$banco->BANCO_ID}}" <?= $campos['BANCO_ID'] == $banco->BANCO_ID ? 'selected' : '' ?>>
                            {{$banco->NOME}}
                        </option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group col-12 col-md-6">
                    <div class="d-flex align-items-center justify-content-start">
                        <img id="input-bank-img" src="https://via.placeholder.com/120x60" alt="">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="form-group col-12">
                    <label class="m-0" for="COMPROVANTE">Comprovante</label>
                    <input type="file" class="form-control-file" id="COMPROVANTE" name="COMPROVANTE" <?= $config->COMPROVANTE ? 'required' : '' ?>>
                </div>
            </div>


            <div class="row">
                <div class="form-group col-12 m-0">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="NFE" name="NFE" value="1">
                        <label class="form-check-label" for="NFE">
                            NFe
                        </label>
                    </div>
                </div>
            </div>

            <div class="form-group pt-3 m-0">
                <button type="submit" class="btn btn-sm btn-outline-primary">Cadastrar</button>
                <button type="reset" class="btn btn-sm btn-outline-secondary">Limpar</button>
            </div>
        </form>

    </div>
</div>

@endsection