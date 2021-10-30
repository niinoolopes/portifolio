@extends('layout.template')

@section('conteudo')

<div class="col-12">
  <div class="d-flex justify-content-center">

    <form action="{{route('config.relatorio.pedido.post')}}" method="POST" class="col-lg-8 py-3 px-2 p-md-4 bg-white" id="form-relatorio">
      {{ csrf_field() }}

      <h3 class="display-5">Relatório: Pedido</h3>
      <hr>

      <input type="hidden" name="GERAR" value="1">


      <label class="d-block m-0">Periodo</label>
      <div class="row m-0 mb-3 py-3 border">
        <div class="form-group col-12 col-md-6 mb-2">
          <label class="m-0" for="DATA_DE">Data de:</label>
          <input class="form-control" id="DATA_DE" name="DATA_DE" type="date" required value="{{$campo->DATA_DE}}">
        </div>
        <div class="form-group col-12 col-md-6 mb-2">
          <label class="m-0" for="DATA_ATE">Data até:</label>
          <input class="form-control" id="DATA_ATE" name="DATA_ATE" type="date" required value="{{$campo->DATA_DE}}">
        </div>
      </div>


      <label class="d-block m-0" for="BANCO_ID">Banco</label>
      <div class="d-flex flex-wrap mb-3 p-2 pt-3 border" style="max-height: 350px; overflow-y: auto;">
        @foreach ($bancos as $banco)
        <div class="form-group form-check border mb-2 mr-1 p-2 d-flex align-items-center">
          <input type="checkbox" class="mr-2 cursor-pointer cursor-pointer" name="banco[]" value="{{$banco->BANCO_ID}}" id="banco-{{$banco->BANCO_ID}}" <?= $check = (in_array($banco->BANCO_ID, $campo->BANCO)) ? 'checked' : '' ?>>
          <label class="form-check-label cursor-pointer" for="banco-{{$banco->BANCO_ID}}">{{$banco->NOME}}</label>
        </div>
        @endforeach
      </div>


      <label class="d-block m-0" for="USUARIO_ID">Vendedor</label>
      <div class="d-flex flex-wrap mb-3 p-2 pt-3 border" style="max-height: 350px; overflow-y: auto;">
        @foreach ($vendedores as $vencedor)
        <div class="form-group form-check border mb-2 mr-1 p-2 d-flex align-items-center">
          <input type="checkbox" class="mr-2 cursor-pointer" name="vencedor[]" value="{{$vencedor->USUARIO_ID}}" id="vencedor-{{$vencedor->USUARIO_ID}}" <?= $check = (in_array($vencedor->USUARIO_ID, $campo->VENDEDOR)) ? 'checked' : '' ?>>
          <label class="form-check-label cursor-pointer" for="vencedor-{{$vencedor->USUARIO_ID}}">{{$vencedor->NOME}}</label>
        </div>
        @endforeach
      </div>




      <label class="d-block m-0" for="EMPRESA_ID">Empresa</label>
      <div class="d-flex flex-wrap mb-3 p-2 pt-3 border" style="max-height: 350px; overflow-y: auto;">
        @foreach ($empresas as $empresa)
        <div class="form-group form-check border mb-2 mr-1 p-2 d-flex align-items-center">
          <input type="checkbox" class="mr-2 cursor-pointer cursor-pointer" name="empresa[]" value="{{$empresa->EMPRESA_ID}}" id="empresa-{{$empresa->EMPRESA_ID}}" <?= $check = (in_array($empresa->EMPRESA_ID, $campo->EMPRESA)) ? 'checked' : '' ?>>
          <label class="form-check-label cursor-pointer" for="empresa-{{$empresa->EMPRESA_ID}}">{{$empresa->NOME}}</label>
        </div>
        @endforeach
      </div>

      <div class="form-group pt-3 m-0">
        <button type="submit" class="btn btn-sm btn-outline-primary">Gerar</button>
      </div>
    </form>

  </div>
</div>

@endsection