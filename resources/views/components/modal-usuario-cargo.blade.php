<?php
if (!isset($arrModal)) {
    $arrModal[] = (object) [
        'CARGO_ID'     => 'novo',
        'CARGO_NOME'   => '',
        'CARGO_STATUS' => '1',
    ];
    $text_modal = 'Novo cargo';
    $action     = route('config.usuario.cargo.post');
} else {
    $text_modal = 'Editar cargo';
    $action     = route('config.usuario.cargo.put');
}
?>

@foreach($arrModal as $cargo)

<!-- Modal -->
<div class="modal fade" id="modal_usuario_cargo-{{ $cargo->CARGO_ID }}" tabindex="-1" role="dialog" aria-labelledby="modal_usuario_cargo-{{ $cargo->CARGO_ID }}" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">

            <form action="{{ $action }}" method="POST">
                {{ csrf_field() }}
                <input type="hidden" name="CARGO_ID" value="{{$cargo->CARGO_ID}}">

                <div class="modal-header">
                    <h5 class="modal-title" id="modal_usuario_cargo-{{ $cargo->CARGO_ID }}"> {{$text_modal}} </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label class="d-block m-0" for="USUA-CARGO-DESCRICAO-{{$cargo->CARGO_ID}}">Descrição</label>
                        <input class="form-control form-control-sm" name="CARGO_NOME" id="USUA-CARGO-DESCRICAO-{{$cargo->CARGO_ID}}" type="text" required value="{{$cargo->CARGO_NOME}}">
                    </div>
                    <div class="form-group form-check">
                        <input input-status="USUA-CARGO-STATUS-{{$cargo->CARGO_ID}}" data-text-ativo='Cargo ativo' data-text-inativo='Cargo inativo' type="checkbox" class="form-check-input" name="CARGO_STATUS" id="USUA-CARGO-STATUS-{{$cargo->CARGO_ID}}" {{ $cargo->CARGO_STATUS ? 'checked=checked' : '' }}>
                        <label label-status="USUA-CARGO-STATUS-{{$cargo->CARGO_ID}}" class="d-block form-check-label" for="USUA-CARGO-STATUS-{{$cargo->CARGO_ID}}">{{ $cargo->CARGO_STATUS ? 'Cargo ativo' : 'Cargo inativo' }}</label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-sm btn-primary">Salvar</button>
                    <a type="submit" href="{{route('config.usuario.cargo.del',['id' => $cargo->CARGO_ID])}}" class="btn btn-sm btn-danger text-white">Deletar</a>
                    <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Fechar</button>
                </div>

            </form>

        </div>
    </div>
</div>
@endforeach

<?php unset($arrModal); ?>