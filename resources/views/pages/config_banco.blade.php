@extends('layout.template')

@section('conteudo')

<div class="col-12 mb-0 p-2">
    <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#modal_banco-novo">Novo Banco</button>
</div>

<div class="col-12 mb-3 p-2">
    <div class="bg-light px-2 table-container container-area">
        <table class="table table-sm">
            <thead>
                <tr>
                    <th scope="col">Nome</th>
                    <th scope="col">Código</th>
                    <th scope="col">Site</th>
                    <th scope="col">Status</th>
                    <th scope="col">Detalhes</th>
                </tr>
            </thead>
            <tbody>
                @foreach($bancos as $banco)
                <tr>
                    <td>{{ $banco->NOME }}</td>
                    <td>{{ $banco->CODIGO }}</td>
                    <td>{{ $banco->SITE }}</td>
                    <td>{{ $banco->STATUS ? 'Ativo' : 'Inativo' }}</td>
                    <td>
                        <div class="d-flex cursor-pointer">
                            <div class="d-flex justify-content-center align-items-center py-1 px-2 mr-2">
                                <i class="far fa-lg fa-address-card text-dark" data-toggle="modal" data-target="#modal_banco-{{ $banco->BANCO_ID }}"></i>
                            </div>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

@include('components.modal-banco')

@include('components.modal-banco',[
'arrModal_banco' => $bancos
])

@endsection