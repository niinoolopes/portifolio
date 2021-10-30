<?php
if (!isset($arrModal_usuario)) {
    $arrModal_usuario[] = (object) [
        'USUARIO_ID' => 'novo',
        'NOME'       => '',
        'CARGO_ID'   => '',
        'TIPO_ID'    => '',
        'EMPRESA_ID' => '',
        'EMAIL'      => '',
        'LOGIN'      => '',
        'SENHA'      => '',
        'STATUS'     => '1',
        'JSON'       => '{"PAINEL":"","CONFIG":""}',
    ];
    $text_modal = 'Novo';
    $action     = route('config.usuario.post');
} else {
    $text_modal = 'Editar';
    $action     = route('config.usuario.put');
}
?>

@foreach($arrModal_usuario as $usuario)
<?PHP
// dd();
?>
<!-- Modal -->
<div class="modal fade" id="mdoal_usuario-{{ $usuario->USUARIO_ID }}" tabindex="-1" role="dialog" aria-labelledby="mdoal_usuario-{{ $usuario->USUARIO_ID }}" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">

            <form action="{{ $action }}" method="POST">
                {{ csrf_field() }}
                <input type="hidden" name="USUARIO_ID" value="{{$usuario->USUARIO_ID}}">

                <div class="modal-header">
                    <h5 class="modal-title">{{$text_modal}}</h5>
                    <button type=" button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <div class="row">
                        <div class="col-12">
                            <h5>Dados de usuário</h5>
                        </div>
                        <div class="col-12">
                            <!-- NOME  -->
                            <div class="form-group">
                                <label class="d-block m-0" for="NOME-{{$usuario->USUARIO_ID}}">Nome</label>
                                <input class="form-control" name="NOME" id="NOME-{{$usuario->USUARIO_ID}}" type="text" required value="{{$usuario->NOME}}">
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <!-- EMAIL -->
                            <div class="form-group">
                                <label class="d-block m-0" for="USUA-EMAIL-{{$usuario->USUARIO_ID}}">Email</label>
                                <input class="form-control" name="EMAIL" id="USUA-EMAIL-{{$usuario->USUARIO_ID}}" type="email" value="{{$usuario->EMAIL}}">
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <!-- CARGO  -->
                            <div class="form-group">
                                <label class="d-block m-0" for="USUA-CARGO-{{$usuario->USUARIO_ID}}">Cargo</label>
                                <select class="form-control" name="CARGO_ID" id="USUA-CARGO-{{$usuario->USUARIO_ID}}">
                                    <option value="">Selecione</option>
                                    @foreach ($usuario_cargos_enable as $usuario_cargo)
                                    <option <?= $usuario_cargo->CARGO_ID == $usuario->CARGO_ID ? 'selected' : '' ?> value="{{$usuario_cargo->CARGO_ID}}">{{$usuario_cargo->CARGO_NOME}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <!-- TIPO  -->
                            <div class="form-group">
                                <label class="d-block m-0" for="USUA-TIPO-{{$usuario->USUARIO_ID}}">Tipo</label>
                                <select class="form-control" name="TIPO_ID" id="USUA-TIPO-{{$usuario->USUARIO_ID}}" required {{ $usuario->USUARIO_ID == 1 ? 'readonly' : '' }}>
                                    <option value="">Selecione</option>
                                    @foreach ($usuario_tipos_enable as $usuario_tipo)
                                    <option <?= $usuario_tipo->TIPO_ID == $usuario->TIPO_ID ? 'selected' : '' ?> value="{{$usuario_tipo->TIPO_ID}}">{{$usuario_tipo->TIPO_NOME}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <!-- EMPRESA  -->
                            <div class="form-group">
                                <label class="d-block m-0" for="EMPRESA-{{$usuario->USUARIO_ID}}">Empresa</label>
                                <select class="form-control" name="EMPRESA_ID" id="EMPRESA-{{$usuario->USUARIO_ID}}">
                                    <option value="">Selecione</option>
                                    @foreach ($empresas_enable as $empresa)
                                    <option <?= $empresa->EMPRESA_ID == $usuario->EMPRESA_ID ? 'selected' : '' ?> value="{{$empresa->EMPRESA_ID}}">{{$empresa->NOME}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-12">
                            <!-- status -->
                            <div class="form-group form-check  m-0">
                                <input input-status='USUA-STATUS-{{$usuario->USUARIO_ID}}' data-text-ativo='Usuário ativo' data-text-inativo='Usuário inativo' type="checkbox" class="form-check-input" name="STATUS" id="USUA-STATUS-{{$usuario->USUARIO_ID}}" {{ $usuario->STATUS ? 'checked=checked' : '' }}>
                                <label label-status='USUA-STATUS-{{$usuario->USUARIO_ID}}' class="d-block form-check-label" for="USUA-STATUS-{{$usuario->USUARIO_ID}}">{{ $usuario->STATUS ? 'Usuário ativo' : 'Usuário inativo' }}</label>
                            </div>
                        </div>
                    </div>

                    <hr>

                    <div class="row">
                        <div class="col-12">
                            <h5>Login</h5>
                        </div>
                        <!-- LOGIN  -->
                        <div class="col-12 col-md-6 form-group">
                            <label class="d-block m-0" for="LOGIN-{{$usuario->USUARIO_ID}}">Login</label>
                            <input class="form-control" name="LOGIN" id="LOGIN-{{$usuario->USUARIO_ID}}" type="text" required value="{{$usuario->LOGIN}}">
                        </div>
                        <!-- SENHA  -->
                        <div class="col-12 col-md-6 form-group">
                            <label class="d-block m-0" for="USUA-SENHA-{{$usuario->USUARIO_ID}}">Senha</label>
                            <div class="input-group">
                                <input input-senha="USUA-SENHA-{{$usuario->USUARIO_ID}}" class="form-control" name="SENHA" id="USUA-SENHA-{{$usuario->USUARIO_ID}}" type="password" value="{{ base64_decode($usuario->SENHA) }}" required>
                                <div class="input-group-append">
                                    <span class="input-group-text">
                                        <i show-senha="USUA-SENHA-{{$usuario->USUARIO_ID}}" class="far fa-lg fa-eye-slash text-dark"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <hr>

                    <div class="row">
                        <div class="col-12">
                            <h5>Permissões</h5>
                        </div>
                        <div class="col-12">
                            <div class="row">
                                <div class="ccol-12 col-md-6">
                                    <div class="form-group">
                                        <label class="d-block m-0" for="visao-painel-{{$usuario->USUARIO_ID}}">Ver no painel</label>
                                        <select class="form-control" id="visao-painel-{{$usuario->USUARIO_ID}}" name="JSON[PAINEL]" required>
                                            <option value="">Selecione</option>
                                            <option <?= json_decode($usuario->JSON)->PAINEL == 'self' ? 'selected' : '' ?> value="self">Pedidos próprio</option>
                                            <option <?= json_decode($usuario->JSON)->PAINEL == 'all'  ? 'selected' : '' ?> value="all">todos os pedidos</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="ccol-12 col-md-6">
                                    <div class="form-group">
                                        <label class="d-block m-0" for="visao-config-{{$usuario->USUARIO_ID}}">Acesso Config</label>
                                        <select class="form-control" id="visao-config-{{$usuario->USUARIO_ID}}" name="JSON[CONFIG]" required>
                                            <option value="">Selecione</option>
                                            <option <?= json_decode($usuario->JSON)->CONFIG == 'S' ? 'selected' : '' ?> value="S">Sim</option>
                                            <option <?= json_decode($usuario->JSON)->CONFIG == 'N' ? 'selected' : '' ?> value="N">Não</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>



                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-sm btn-primary">Salvar</button>
                    <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Fechar</button>
                </div>

            </form>

        </div>
    </div>
</div>
@endforeach