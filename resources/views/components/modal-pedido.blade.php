<?php
if (!isset($arrModal_pedido)) {
    $arrModal_pedido[] = (object) [
        'PEDIDO_ID'     => 'novo',
        'N_ATENDIMENTO' => '',
        'VALOR'         => '',
        'DATA'          => '',
        'STATUS'        => '',
        'BANCO_ID'      => '',
        'NOME'    => '',
        'LOGO'    => '',
        'VENDEDOR_ID'       => '',
        'USUARIO_ID'       => '',
        'NOME'     => '',
    ];
}
$disabledInput = session()->get('USUARIO.USUARIO_ID') == 1 ? '' : 'disabled';
$userRoot = session()->get('USUARIO.USUARIO_ID') == 1 ? true : false;
?>

@foreach($arrModal_pedido as $pedido)

<!-- Modal -->
<div class="modal fade" id="modal_pedido-{{$pedido->PEDIDO_ID}}" tabindex="-1" role="dialog" aria-labelledby="modal_pedido-{{$pedido->PEDIDO_ID}}" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">

            <form method="POST" enctype="multipart/form-data" action="{{ route('pedido.put', $pedido->PEDIDO_ID)}}">
                {{ csrf_field() }}
                <input type="hidden" name="PEDIDO_ID" value="{{$pedido->PEDIDO_ID}}">

                <div class="modal-header">
                    <h5 class="modal-title" id="modal_pedido-{{$pedido->PEDIDO_ID}}">Código: {{$pedido->PEDIDO_ID}}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <div class="row">
                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <label class="d-block m-0" for="N_ATENDIMENTO-{{$pedido->PEDIDO_ID}}">Nº Atendimento</label>
                                <input class="form-control" id="N_ATENDIMENTO-{{$pedido->PEDIDO_ID}}" name="N_ATENDIMENTO" type="text" required value="{{$pedido->N_ATENDIMENTO}}" <?= $disabledInput ?>>
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <label class="d-block m-0" for="STATUS_ID-{{$pedido->PEDIDO_ID}}">Status</label>
                                <!-- <input class="form-control" id="STATUS_ID-{{$pedido->PEDIDO_ID}}" type="text" required value="{{$pedido->S_DESCRICAO ? $pedido->S_DESCRICAO : ''}}" <?= $disabledInput ?>> -->
                                <select class="form-control" id="STATUS_ID-{{$pedido->PEDIDO_ID}}" name="STATUS_ID" required <?= $disabledInput ?>>
                                    <option <?= $pedido->STATUS_ID == 1 ? 'selected' : '' ?> value="1">Pendente</option>
                                    <option <?= $pedido->STATUS_ID == 2 ? 'selected' : '' ?> value="2">Aceito</option>
                                    <option <?= $pedido->STATUS_ID == 3 ? 'selected' : '' ?> value="3">Cancelado</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <label class="d-block m-0" for="VENDEDOR_ID-{{$pedido->PEDIDO_ID}}">Vendedor</label>
                                <select class="form-control" id="VENDEDOR_ID-{{$pedido->PEDIDO_ID}}" name="VENDEDOR_ID" required <?= $disabledInput ?>>
                                    <option value="">Selecione</option>
                                    @foreach ($vendedores as $vendedor)
                                    <option <?= $pedido->USUARIO_ID == $vendedor->USUARIO_ID ? 'selected' : '' ?> value="{{$vendedor->USUARIO_ID}}">{{$vendedor->NOME}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <label class="d-block m-0" for="EMPRESA-{{$pedido->PEDIDO_ID}}">Empresa</label>
                                <input class="form-control" id="EMPRESA-{{$pedido->PEDIDO_ID}}" type="text" value="{{$pedido->E_NOME ? $pedido->E_NOME : ''}}" disabled>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 col-md-4">
                            <div class="form-group">
                                <label class="d-block m-0" for="VALOR-{{$pedido->PEDIDO_ID}}">Valor</label>
                                <input class="form-control" id="VALOR-{{$pedido->PEDIDO_ID}}" name="VALOR" type="number" placeholder="0.00" step="0.01" required value="{{ number_format($pedido->VALOR ? $pedido->VALOR : 0, 2, '.', '') }}" <?= $disabledInput ?>>
                            </div>
                        </div>
                        <div class="col-12 col-md-4">
                            <div class="form-group">
                                <label class="d-block m-0" for="DATA-{{$pedido->PEDIDO_ID}}">Data Transferencia</label>
                                <input class="form-control" id="DATA-{{$pedido->PEDIDO_ID}}" name="DATA_TRANSFERENCIA" type="date" required value="{{$pedido->DATA_TRANSFERENCIA}}" <?= $disabledInput ?>>
                            </div>
                        </div>
                        <div class="col-12 col-md-4">
                            <div class="form-group">
                                <label class="d-block m-0" for="DATA-{{$pedido->PEDIDO_ID}}">Data Pedido</label>
                                <input class="form-control" id="DATA-{{$pedido->PEDIDO_ID}}" name="DATA_PEDIDO" type="date" required value="{{ explode(' ',$pedido->created_at)[0] }}" disabled>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-12 col-md-6">
                            <label class="d-block m-0" for="BANCO_ID-{{$pedido->PEDIDO_ID}}">Banco</label>
                            <select class="custom-select" id="BANCO_ID-{{$pedido->PEDIDO_ID}}" name="BANCO_ID" <?= $disabledInput ?>>
                                <option selected>Selecione</option>
                                @foreach ($bancos as $banco)
                                <option <?= $pedido->BANCO_ID == $banco->BANCO_ID ? 'selected' : '' ?> data-logo="{{ 'storage/app/public/images/bancos/'. $banco->LOGO }}" value="{{$banco->BANCO_ID}}">{{$banco->NOME}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-12 col-md-6">
                            <div class="d-flex align-items-center justify-content-start">
                                <img id="input-bank-img" src="{{ 'storage/app/public/images/bancos/'. $pedido->B_LOGO }}" alt="">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-12 m-0">
                            <div class="form-group m-0">

                                @if( $pedido->tipoComprovante == 'pdf')
                                <p>
                                    Para abrir o comprovante
                                    <a href="{{ url('storage/app/public/images/comprovante') .'/'. $pedido->COMPROVANTE }}" target="_blank">clique aqui</a>
                                </p>
                                @else
                                <label class="d-block m-0" for="COMPROVANTE-{{$pedido->PEDIDO_ID}}">Comprovante</label>
                                <input type="file" class="form-control-file mb-3  <?= $userRoot ? '' : 'd-none' ?>" id="COMPROVANTE-{{$pedido->PEDIDO_ID}}" name="COMPROVANTE" value="{{$pedido->COMPROVANTE}}" <?= $disabledInput ?>>

                                <label for="COMPROVANTE-{{$pedido->PEDIDO_ID}}" style="display: flex; overflow: overlay;">
                                    <div style="margin: auto; max-width: 100%; max-height: 50vh;">
                                        @if($pedido->COMPROVANTE == '')
                                        <img class="p-3 img-fluid" src="https://via.placeholder.com/1000x200" alt="LOGO">
                                        @else
                                        <a href="{{ url('storage/app/public/images/comprovante') .'/'. $pedido->COMPROVANTE }}" target="_blank">
                                            <img class="p-3 img-fluid" src="{{ url('storage/app/public/images/comprovante') .'/'. $pedido->COMPROVANTE }}" alt="COMPROVANTE">
                                        </a>
                                        @endif
                                    </div>
                                </label>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- <div class="form-group">
                        <label class="d-block m-0" for="DATA-CREATE">Data Pedido</label>
                        <input class="form-control" type="date" value="{{date('Y-m-d', strtotime($pedido->created_at))}}" id="DATA-CREATE" <?= $disabledInput ?>>
                    </div> -->


                    @if($pedido->M_DESCRICAO)
                    <hr>
                    <div class="form-group">
                        <label class="d-block m-0" for="MOTIVO-CANCELAMENTO">Motivo cancelamento</label>

                        @if($userRoot)
                        @foreach($motivos as $motivo)
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="MOTIVO_ID" id="{{$motivo->MOTIVO_ID}}-{{$pedido->PEDIDO_ID}}" value="{{$motivo->MOTIVO_ID}}" required <?= $pedido->MOTIVO_ID == $motivo->MOTIVO_ID ? 'checked' : '' ?>>
                            <label class="form-check-label" for="{{$motivo->MOTIVO_ID}}-{{$pedido->PEDIDO_ID}}">
                                {{$motivo->DESCRICAO}}
                            </label>
                        </div>
                        @endforeach
                        @else
                        <input class="form-control" type="text" value="{{$pedido->M_DESCRICAO}}" id="MOTIVO-CANCELAMENTO" disabled>
                        @endif

                    </div>
                    @endif

                    <hr>

                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="NFE-{{$pedido->PEDIDO_ID}}" name="NFE" value="1" <?= $pedido->NFE == 1 ? 'checked' : '' ?> <?= $disabledInput ?>>
                        <label class="form-check-label" for="NFE-{{$pedido->PEDIDO_ID}}">
                            NFe
                        </label>
                    </div>
                </div>

                <div class="modal-footer justify-content-start">
                    <button type="submit" class="btn btn-sm btn-outline-primary" <?= $disabledInput ?>>Salvar</button>
                    <button type="reset" class="d-none btn btn-sm btn-outline-secondary">Limpar</button>
                    <button type="button" class="btn btn-sm btn-outline-secondary" data-dismiss="modal">Fechar</button>
                </div>
            </form>

        </div>
    </div>
</div>
@endforeach

<script>
    const inputFiles = document.querySelectorAll('.form-control-file')
    Array.from(inputFiles).map(input => {
        input.addEventListener('change', () => {
            const label = document.querySelectorAll(`label[for="${input.id}"]`)[1]
            label.style.opacity = '0.1'
        })
    })
</script>