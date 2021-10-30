<?php
if (!isset($arrModal_banco)) {
    $arrModal_banco[] = (object) [
        'BANCO_ID'     => 'novo',
        'NOME'   => '',
        'SITE'   => '',
        'CODIGO' => '',
        'LOGO'   => 'LOGO-BANCO',
        'STATUS' => '1',
    ];

    $modal      = 'novo';
    $text_modal = 'Novo banco';
    $action     = route('config.banco.post');
} else {
    $modal      = 'editar';
    $text_modal = 'Editar banco';
    $action     = route('config.banco.put');
}
?>

@foreach($arrModal_banco as $banco)

<!-- Modal -->
<div class="modal fade" id="modal_banco-{{$banco->BANCO_ID}}" tabindex="-1" role="dialog" aria-labelledby="modal_banco-{{$banco->BANCO_ID}}" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">

            <form action="{{$action}}" method="POST" enctype="multipart/form-data">
                {{ csrf_field() }}
                <input type="hidden" name="BANCO_ID" value="{{$banco->BANCO_ID}}">

                <div class="modal-header">
                    <h5 class="modal-title" id="modal_banco-{{$banco->BANCO_ID}}">{{$text_modal}}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label class="d-block m-0" for="NOME-{{$banco->BANCO_ID}}">Nome</label>
                        <input class="form-control form-control-sm" id="BANCO-NOME-{{$banco->BANCO_ID}}" name="NOME" type="text" required value="{{$banco->NOME}}">
                    </div>
                    <div class="form-group">
                        <label class="d-block m-0" for="CODIGO-{{$banco->BANCO_ID}}">Código</label>
                        <input class="form-control form-control-sm" id="BANCO-CODIGO-{{$banco->BANCO_ID}}" name="CODIGO" type="text" value="{{$banco->CODIGO}}">
                    </div>
                    <div class="form-group">
                        <label class="d-block m-0" for="SITE-{{$banco->BANCO_ID}}">Site</label>
                        <input class="form-control form-control-sm" id="BANCO-SITE-{{$banco->BANCO_ID}}" name="SITE" type="text" value="{{$banco->SITE}}">
                    </div>
                    <div class="form-group">
                        <label class="d-block m-0" for="LOGO-{{$banco->BANCO_ID}}">Logo</label>

                        @if($banco->LOGO == 'LOGO-BANCO')

                        <input type="file" class="form-control-file" id="LOGO-{{$banco->BANCO_ID}}" name="LOGO" value="{{$banco->LOGO}}">
                        @else
                        <input type="file" class="form-control-file d-none" change-logo="LOGO-{{$banco->BANCO_ID}}" id="LOGO-{{$banco->BANCO_ID}}" name="LOGO" value="{{$banco->LOGO}}">
                        <label for="LOGO-{{$banco->BANCO_ID}}" label-logo="LOGO-{{$banco->BANCO_ID}}">
                            <img class="p-3 img-fluid cursor-pointer" img-logo="LOGO-{{$banco->BANCO_ID}}" src="{{ url('storage\app\public\images\bancos') .'/'. $banco->LOGO }}" alt="LOGO {{$banco->NOME}}">
                        </label>
                        @endif


                    </div>
                    <div class="form-group form-check">
                        <input input-status='STATUS-{{$banco->BANCO_ID}}' data-text-ativo='Banco ativo' data-text-inativo='Banco inativo' type="checkbox" class="form-check-input" name="STATUS" id="STATUS-{{$banco->BANCO_ID}}" {{ $banco->STATUS ? 'checked=checked' : '' }}>
                        <label label-status='STATUS-{{$banco->BANCO_ID}}' class="d-block form-check-label" for="STATUS-{{$banco->BANCO_ID}}">{{ $banco->STATUS ? 'Banco ativo' : 'Banco inativo' }}</label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-sm btn-primary">Salvar</button>
                    <a type="submit" href="{{route('config.banco.del',['id' => $banco->BANCO_ID])}}" class="btn btn-sm btn-danger text-white">Deletar</a>
                    <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Fechar</button>
                </div>

            </form>

        </div>
    </div>
</div>
@endforeach