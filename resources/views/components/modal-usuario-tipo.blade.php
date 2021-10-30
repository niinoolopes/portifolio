<?php
if (!isset($arrModal)) {
    $arrModal[] = (object) [
        'TIPO_ID'     => 'novo',
        'TIPO_NOME'   => '',
        'TIPO_STATUS' => '1',
    ];
    $text_modal = 'Novo tipo';
    $action     = route('config.usuario.tipo.post');
} else {
    $text_modal = 'Editar tipo';
    $action     = route('config.usuario.tipo.put');
}
?>

@foreach($arrModal as $tipo)

<!-- Modal -->
<div class="modal fade" id="mdoal_usuario_tipo-{{ $tipo->TIPO_ID }}" tabindex="-1" role="dialog" aria-labelledby="mdoal_usuario_tipo-{{ $tipo->TIPO_ID }}" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">

            <form action="{{ $action }}" method="POST">
                {{ csrf_field() }}
                <input type="hidden" name="TIPO_ID" value="{{$tipo->TIPO_ID}}">

                <div class="modal-header">
                    <h5 class="modal-title" id="mdoal_usuario_tipo-{{ $tipo->TIPO_ID }}"> {{$text_modal}} </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label class="d-block m-0" for="USUA-TIPO-{{$tipo->TIPO_NOME}}">Descrição</label>
                        <input class="form-control" name="TIPO_NOME" id="USUA-TIPO-{{$tipo->TIPO_NOME}}" required value="{{$tipo->TIPO_NOME}}">
                    </div>
                    <div class="form-group form-check">
                        <input input-status='{{$tipo->TIPO_NOME}}' data-text-ativo='Tipo ativo' data-text-inativo='Tipo inativo' type="checkbox" class="form-check-input" name="TIPO_STATUS" id="USUA-STATUS-{{$tipo->TIPO_NOME}}" {{ $tipo->TIPO_STATUS ? 'checked=checked' : '' }}>
                        <label label-status='{{$tipo->TIPO_NOME}}' class="d-block form-check-label" for="USUA-STATUS-{{$tipo->TIPO_NOME}}">{{ $tipo->TIPO_STATUS ? 'Tipo ativo' : 'Tipo inativo' }}</label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-sm btn-primary">Salvar</button>
                    <a type="submit" href="{{route('config.usuario.tipo.del',['id' => $tipo->TIPO_ID])}}" class="btn btn-sm btn-danger text-white">Deletar</a>
                    <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Fechar</button>
                </div>

            </form>

        </div>
    </div>
</div>
@endforeach

<?php unset($arrModal); ?>