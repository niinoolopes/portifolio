<div class="mb-2">
    <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#mdoal_usuario_tipo-novo">Novo tipo</button>
</div>
<div class="bg-light px-2 table-container container-area">
    <table class="table table-sm">
        <thead>
            <tr>
                <th scope="col">Tipo</th>
                <th scope="col">Status</th>
                <th scope="col">Detalhes</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($arrDados as $row)
            <tr>
                <td>{{ $row->TIPO_NOME }}</td>
                <td>{{ $row->TIPO_STATUS ? 'Ativo' : 'Inativo' }}</td>
                <td>
                    <div class="d-flex">
                        <div class="d-flex justify-content-start align-items-center py-1 px-2 mr-2 cursor-pointer">
                            <i class="far fa-lg fa-address-card text-dark" data-toggle="modal" data-target="#mdoal_usuario_tipo-{{ $row->TIPO_ID }}"></i>
                        </div>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td>Não existe registros cadastrados.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

@include('components.modal-usuario-tipo')

@include('components.modal-usuario-tipo',['arrModal' => $arrDados])

<?php unset($arrDados); ?>