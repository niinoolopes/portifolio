<div class="bg-light px-2 table-container container-area">
    <table class="table table-sm">
        <thead>
            <tr>
                <th scope="col">Nome</th>
                <th scope="col">Email</th>
                <th scope="col">Cargo</th>
                <th scope="col">Tipo</th>
                <th scope="col">Empresa</th>
                <th scope="col">Login</th>
                <th scope="col">Status</th>
                <th scope="col">Detalhes</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($arrDados as $row => $usuario)
            <tr>
                <td>{{ $usuario->NOME }}</td>
                <td>{{ $usuario->EMAIL }}</td>
                <td>{{ $usuario->CARGO_NOME }}</td>
                <td>{{ $usuario->TIPO_NOME }}</td>
                <td>{{ $usuario->EMPRESA_NOME }}</td>
                <td>{{ $usuario->LOGIN }}</td>
                <td>{{ $usuario->STATUS ? 'Ativo' : 'Inativo' }}</td>
                <td>
                    <div class="d-flex">
                        <div class="d-flex justify-content-center align-items-center py-1 px-2 mr-2 cursor-pointer">
                            <i class="far fa-lg fa-address-card text-dark" data-toggle="modal" data-target="#mdoal_usuario-{{ $usuario->USUARIO_ID }}"></i>
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


@include('components.modal-usuario',['arrModal_usuario' => $arrDados])


<?php unset($arrDados); ?>