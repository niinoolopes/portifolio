@extends('layout.template')

@section('conteudo')

<div class="col-12 p-2 mb-2 bg-light container-area">
    <form action="{{ route('pedido.consultar.busca') }}" method="POST">
        {{ csrf_field() }}
        <div class="row m-0">
            <div class="col-12 col-sm-6 col-md-2 mb-1 p-0 pr-1">
                <select class="custom-select custom-select-sm col-12" name="filtro" required>
                    <option value="">Filtrar por ...</option>
                    <option selected value="numero-atendimento">Nº Atendimento</option>
                </select>
            </div>
            <div class="col-12 col-sm-6 col-md-9 mb-1 p-0 pr-1">
                <input type="text" class="form-control form-control-sm" name="conteudo" required value="{{$conteudo}}">
            </div>
            <div class="col-md-1 p-0 pr-1">
                <button class="w-100 btn btn-sm btn-teal" type="submit">Buscar</button>
            </div>
        </div>
    </form>
</div>

<div class="col-12 p-3 bg-light table-container container-area">
    <table class="table table-sm">
        <thead>
            <tr>
                <th scope="col" class="d-lg-none"><span>Nº</span></th>
                <th scope="col" class="d-none d-lg-table-cell"><span>Nº Atendimento</span></th>
                <th scope="col" class="d-none d-lg-table-cell">Banco</th>
                <th scope="col">Valor</th>
                <th scope="col" class="d-none d-lg-table-cell">Data transferencia</th>
                <th scope="col" class="d-none d-lg-table-cell">Vendedor</th>
                <th scope="col" class="d-none d-lg-table-cell">Empresa</th>
                <th scope="col" class="d-none d-md-table-cell">Data Pedido</th>
                <th scope="col">Status</th>
                <th scope="col">Ações</th>
            </tr>
        </thead>
        <tbody>
            @forelse($pedidos as $pedido)

            @include('components.table-pedido',[ 'arrTable_pedido' => $pedido ])

            @empty
            <tr>
                <th scope="col" colspan="4" class="d-lg-none">Não foi encontrado registros com o filtro gerado.</th>
                <th scope="col" colspan="9" class="d-none d-lg-table-cell">Não foi encontrado registros com o filtro gerado.</th>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

@include('components.modal-pedido',[
'arrModal_pedido' => $pedidos
])

@endsection