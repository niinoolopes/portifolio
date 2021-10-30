@extends('layout.template')

@section('conteudo')

<div class="col-12">
    <ul class="nav nav-tabs" role="tablist">
        <li class="nav-item">
            <a class="nav-link <?= ($tab_usuario != null ? 'active' : '') ?>" id="usuarios-tab" data-toggle="tab" href="#usuarios" role="tab" aria-controls="usuarios" aria-selected="true">Usuarios</a>
        </li>
        <li class="nav-item">
            <a class="nav-link <?= ($tab_tipo != null ? 'active' : '') ?>" id="tipo-tab" data-toggle="tab" href="#tipo" role="tab" aria-controls="tipo" aria-selected="false">Tipo</a>
        </li>
        <li class="nav-item">
            <a class="nav-link <?= ($tab_cargo != null ? 'active' : '') ?>" id="cargo-tab" data-toggle="tab" href="#cargo" role="tab" aria-controls="cargo" aria-selected="false">Cargo</a>
        </li>
    </ul>
</div>
<div class="col-12">
    <div class="tab-content">
        <div class="tab-pane fade py-2 <?= ($tab_usuario != null ? 'show active' : '') ?>" id="usuarios" role="tabpanel" aria-labelledby="usuarios-tab">
            <div class="mb-2">
                <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#mdoal_usuario-novo">Novo usuário</button>
            </div>

            <ul class="nav nav-tabs" role="tablist">
                @foreach ($usuarios as $tipo => $usuario)
                <?PHP
                if ($tab) {
                    $active = $tab == $usuario->TIPO_ID ? 'show active' : '';
                } else {
                    $active = $tipo == 0 ? 'show active' : '';
                }
                ?>
                <li class="nav-item">
                    <a class="nav-link py-1 {{ $active }}" id="{{$usuario->TIPO}}-tab" data-toggle="tab" href="#LISTA-{{str_replace(' ', '-', $usuario->TIPO)}}" role="tab" aria-controls="LISTA-{{str_replace(' ', '-', $usuario->TIPO)}}" aria-selected="false">{{$usuario->TIPO}}</a>
                </li>
                @endforeach
            </ul>

            <div class="tab-content">
                @foreach ($usuarios as $tipo => $usuario)
                <?PHP
                if ($tab) {
                    $active = $tab == $usuario->TIPO_ID ? 'show active' : '';
                } else {
                    $active = $tipo == 0 ? 'show active' : '';
                }
                ?>
                <div class="tab-pane fade py-2 {{ $active }}" id="LISTA-{{str_replace(' ', '-', $usuario->TIPO)}}" role="tabpanel" aria-labelledby="LISTA-{{str_replace(' ', '-', $usuario->TIPO)}}-tab">
                    @include('components.tab-config_usuario_usuarios',['arrDados' => $usuario->LISTA ])
                </div>
                @endforeach
            </div>

            @include('components.modal-usuario')
        </div>

        <div class="tab-pane fade py-2 <?= ($tab_tipo != null ? 'show active' : '') ?>" id="tipo" role="tabpanel" aria-labelledby="tipo-tab">
            @include('components.tab-config_usuario_tipos',['arrDados' => $usuario_tipos ])
        </div>

        <div class="tab-pane fade py-2 <?= ($tab_cargo != null ? 'show active' : '') ?>" id="cargo" role="tabpanel" aria-labelledby="cargo-tab">
            @include('components.tab-config_usuario_cargos',['arrDados' => $usuario_cargos ])
        </div>
    </div>
</div>

@endsection