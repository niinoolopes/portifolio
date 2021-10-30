<?php
if (!isset($arrModal)) {
    $arrModal[] = (object) [
        'MOTIVO_ID'     => 'novo',
        'DESCRICAO'   => '',
        'STATUS' => '1',
    ];
    $modal      = 'novo';
    $text_modal = 'Novo motivo';
    $action     = route('config.motivoCancel.post');
} else {
    $modal      = 'editar';
    $text_modal = 'Editar motivo';
    $action     = route('config.motivoCancel.put');
}
?>

@foreach($arrModal as $motivo)

<!-- Modal -->
<div class="modal fade" id="modal_motivo-{{$motivo->MOTIVO_ID}}" tabindex="-1" role="dialog" aria-labelledby="modal_motivo-{{$motivo->MOTIVO_ID}}" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">

            <form action="{{$action}}" method="POST">
                {{ csrf_field() }}
                <input type="hidden" name="MOTIVO_ID" value="{{$motivo->MOTIVO_ID}}">

                <div class="modal-header">
                    <h5 class="modal-title" id="modal_motivo-{{$motivo->MOTIVO_ID}}"> {{$text_modal}} </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label class="d-block m-0" for="MOTIVO-DESCRICAO-{{$motivo->MOTIVO_ID}}">Descrição</label>
                        <input class="form-control" name="DESCRICAO" id="MOTIVO-DESCRICAO-{{$motivo->MOTIVO_ID}}" type="text" required value="{{$motivo->DESCRICAO}}">
                    </div>
                    <div class="form-group form-check">
                        <input input-status='MOTIVO-STATUS-{{$motivo->MOTIVO_ID}}' data-text-ativo='Motivo ativa' data-text-inativo='Motivo inativo' type="checkbox" class="form-check-input" name="STATUS" id="MOTIVO-STATUS-{{$motivo->MOTIVO_ID}}" {{ $motivo->STATUS ? 'checked=checked' : '' }}>
                        <label label-status='MOTIVO-STATUS-{{$motivo->MOTIVO_ID}}' class="d-block form-check-label" for="MOTIVO-STATUS-{{$motivo->MOTIVO_ID}}">{{ $motivo->STATUS ? 'Motivo ativa' : 'Motivo inativo' }}</label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-sm btn-primary">Salvar</button>
                    <a type="submit" href="{{route('config.motivoCancel.del',['id' => $motivo->MOTIVO_ID])}}" class="btn btn-sm btn-danger text-white">Deletar</a>
                    <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Fechar</button>
                </div>

            </form>

        </div>
    </div>
</div>
@endforeach