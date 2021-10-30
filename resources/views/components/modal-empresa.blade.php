<?php
if (!isset($arrModal)) {
    $arrModal[] = (object) [
        'EMPRESA_ID'     => 'novo',
        'NOME'   => '',
        'COR'    => '',
        'STATUS' => '1',
    ];
    $modal      = 'novo';
    $text_modal = 'Novo empresa';
    $action     = route('config.empresa.post');
} else {
    $modal      = 'editar';
    $text_modal = 'Editar empresa';
    $action     = route('config.empresa.put');
}
?>

@foreach($arrModal as $empresa)

<!-- Modal -->
<div class="modal fade" id="mdoal_empresa-{{$empresa->EMPRESA_ID}}" tabindex="-1" role="dialog" aria-labelledby="mdoal_empresa-{{$empresa->EMPRESA_ID}}" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">

            <form action="{{$action}}" method="POST">
                {{ csrf_field() }}
                <input type="hidden" name="EMPRESA_ID" value="{{$empresa->EMPRESA_ID}}">

                <div class="modal-header">
                    <h5 class="modal-title" id="mdoal_empresa-{{$empresa->EMPRESA_ID}}"> {{$text_modal}} </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label class="d-block m-0" for="EMPRESA-NOME-{{$empresa->EMPRESA_ID}}">Nome</label>
                        <input class="form-control" name="NOME" id="EMPRESA-NOME-{{$empresa->EMPRESA_ID}}" type="text" required value="{{$empresa->NOME}}">
                    </div>
                    <div class="form-group">
                        <label class="d-block m-0" for="EMPRESA-COR-{{$empresa->EMPRESA_ID}}">Cor</label>
                        <input class="form-control" name="COR" id="EMPRESA-COR-{{$empresa->EMPRESA_ID}}" type="color" required value="{{$empresa->COR}}">
                    </div>
                    <div class="form-group form-check">
                        <input input-status='EMPRESA-STATUS-{{$empresa->EMPRESA_ID}}' data-text-ativo='Empresa ativa' data-text-inativo='Empresa inativa' type="checkbox" class="form-check-input" name="STATUS" id="EMPRESA-STATUS-{{$empresa->EMPRESA_ID}}" {{ $empresa->STATUS ? 'checked=checked' : '' }}>
                        <label label-status='EMPRESA-STATUS-{{$empresa->EMPRESA_ID}}' class="d-block form-check-label" for="EMPRESA-STATUS-{{$empresa->EMPRESA_ID}}">{{ $empresa->STATUS ? 'Empresa ativa' : 'Empresa inativa' }}</label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-sm btn-primary">Salvar</button>
                    <a type="submit" href="{{route('config.empresa.del',['id' => $empresa->EMPRESA_ID])}}" class="btn btn-sm btn-danger text-white">Deletar</a>
                    <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Fechar</button>
                </div>

            </form>

        </div>
    </div>
</div>
@endforeach