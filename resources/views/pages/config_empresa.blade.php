@extends('layout.template')

@section('conteudo')

<div class="col-12 mb-0 p-2">
    <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#mdoal_empresa-novo">Novo Empresa</button>
</div>

<div class="col-12 mb-3 p-2">
    <div class="bg-light px-2 table-container container-area">
        <table class="table table-sm">
            <thead>
                <tr>
                    <th scope="col">Descrição</th>
                    <th scope="col">Cor</th>
                    <th scope="col">Status</th>
                    <th scope="col">Detalhes</th>
                </tr>
            </thead>
            <tbody>
                @foreach($empresas as $empresa)
                <tr>
                    <td>{{ $empresa->NOME }}</td>
                    <td>
                        <div class="d-flex">
                            <div class="d-flex justify-content-center align-items-center py-1 px-2 mr-2 rounded" style="background-color:<?= $empresa->COR ?>">
                                <i class="far fa-lgg fa-building text-white"></i>
                            </div>
                        </div>
                    </td>
                    <td>{{ $empresa->STATUS ? 'Ativo' : 'Inativo' }}</td>
                    <td>
                        <div class="d-flex">
                            <div class="d-flex justify-content-center align-items-center py-1 px-2 mr-2 cursor-pointer">
                                <i class="far fa-lg fa-address-card text-dark" data-toggle="modal" data-target="#mdoal_empresa-{{ $empresa->EMPRESA_ID }}"></i>
                            </div>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

@include('components.modal-empresa')

@include('components.modal-empresa',[ 'arrModal' => $empresas ])

@endsection