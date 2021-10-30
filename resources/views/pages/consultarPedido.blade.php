@extends('layout.template')

@section('conteudo')

@section('conteudo')
<div class="col-12">
  <div class="d-flex justify-content-center">
    <form id="form-login" class="col-md-8 col-lg-5 py-3 px-2 p-md-4 bg-white container-area" action="{{ route('pedido.consultarPedido.busca') }}" method="POST">
      {{ csrf_field() }}

      <input type="hidden" name="filtro" value="atendimento">

      <h3 class="display-5 w-100 text-center">Número do Pedido</h3>

      <div class="form-group">
        <input class="form-control form-control-sm text-center" id="conteudo" name="conteudo" type="number" required value="{{$conteudo}}">
      </div>
      
      <div class="d-flex justify-content-center">
      <button type="submit" class="btn btn-sm btn-outline-primary mr-2 d-block">Buscar</button>
      <a href="{{route('pedido.consultarPedido') }}" class="btn btn-sm btn-outline-primary d-block">Limpar</a>
      </div>


      @if( is_array($pedidos) )

        <hr>
        
        <div>
          @if( count($pedidos) > 0 )

            <table class="table table-sm">
              <thead>
                <tr>
                  <th class="text-center small">Número do Pedido</th>
                  <th class="text-center small">Status</th>
                  <th class="text-center small">Motivo do cancelamento</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($pedidos as $pedido)
                  <?php 
                    if($pedido->STATUS_ID == 1) $status_css = 'text-warning-2';
                    if($pedido->STATUS_ID == 2) $status_css = 'text-success';
                    if($pedido->STATUS_ID == 3) $status_css = 'text-danger';
                  ?>
                  <tr>
                    <td class="text-center">{{$pedido->N_ATENDIMENTO}}</td>
                    <td class="text-center"><b class="text-center {{$status_css}}">{{$pedido->S_DESCRICAO}}</b></td>
                    <td class="text-center"><b class="text-center">{{$pedido->M_DESCRICAO}}</b></td>
                  </tr>
                @endforeach
              </tbody>
            </table>
          @else
          
          <p class="text-center">Nenhum pedido encontrado com o código informado.</p>
          
          @endif
        </div>

      @endif

    </form>
  </div>
</div>

@endsection