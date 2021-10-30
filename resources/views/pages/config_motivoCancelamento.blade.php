@extends('layout.template')

@section('conteudo')

<div class="col-12 mb-0 p-2">
    <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#modal_motivo-novo">Novo Motivo de cancelamento</button>
</div>

<div class="col-12 mb-3 p-2">
    <div class="bg-light px-2 table-container container-area">
        <table class="table table-sm">
            <thead>
                <tr>
                    <th scope="col">Descrição</th>
                    <th scope="col">Status</th>
                    <th scope="col">Detalhes</th>
                </tr>
            </thead>
            <tbody>
                @foreach($motivos as $motivo)
                <tr>
                    <td>{{ $motivo->DESCRICAO }}</td>
                    <td>{{ $motivo->STATUS ? 'Ativo' : 'Inativo' }}</td>
                    <td>
                        <div class="d-flex">
                            <div class="d-flex justify-content-center align-items-center py-1 px-2 mr-2 cursor-pointer">
                                <i class="far fa-lg fa-edit text-dark" data-toggle="modal" data-target="#modal_motivo-{{ $motivo->MOTIVO_ID }}"></i>
                            </div>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

@include('components.modal-motivoCancelamento')

@include('components.modal-motivoCancelamento',[ 'arrModal' => $motivos ])

@endsection