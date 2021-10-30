@extends('layout.template')

@section('conteudo')


@if( $autoplay )
<div class="col-12 p-2 mb-2">
    <audio controls id="play" <?= $autoplay ? 'autoplay' : '' ?>>
        <source src="{{ url('public') }}/audio/notification.mp3" type="audio/mpeg">
    </audio>
</div>
@endif


<div class="col-12 p-2 mb-2 bg-light container-area">
    <form action="{{ route('pedido.painel.busca') }}" method="POST">
        {{ csrf_field() }}
        <div class="row m-0 align-items-center">
            <div class="col-12 col-sm-4 col-md-2 mb-1 p-0 pr-1">
                <select class="custom-select custom-select-sm col-12" id='filtro' name="filtro" required>
                    <option value="">Filtrar por ...</option>

                    <option <?= $filtro == 'numero-atendimento' ? 'selected' : '' ?> value="numero-atendimento">Nº Atendimento</option>

                    @if(session()->get('USUARIO.TIPO_ID') == 1)
                    <option <?= $filtro == 'empresa' ? 'selected' : '' ?> value="empresa">Empresa</option>
                    <option <?= $filtro == 'valor' ? 'selected' : '' ?> value="valor">Valor</option>
                    @endif
                </select>
            </div>
            <div class="col-12 col-sm-8 col-md mb-1 p-0 pr-1">
                <input type="text" class="form-control form-control-sm" id="conteudo" name="conteudo" required value="{{$conteudo}}">
            </div>
            <button class="btn btn-sm btn-teal mb-1 mr-3" type="submit">Buscar</button>
            <ul class="nav nav-tabs">
                <li class="nav-item">
                    <a class="btn btn-sm btn-teal mb-1 mr-1" data-toggle="tab" href="#card"><i class="fas fa-th"></i></a>
                </li>
                <li class="nav-item">
                    <a class="btn btn-sm btn-teal mb-1 mr-1" data-toggle="tab" href="#table"><i class="fas fa-table"></i></a>
                </li>
            </ul>
        </div>
    </form>
</div>


<div class="col-12 p-0 tab-content">
    <div class="tab-pane fade show active" id="card">
        <div class="d-flex flex-wrap justify-content-start">
            @forelse($pedidos as $pedido)
            <?PHP
            if ($pedido->STATUS_ID == 1)
                $css_status = 'border border-2 border-orange';

            if ($pedido->STATUS_ID == 2)
                $css_status = 'border border-2 border-success';

            if ($pedido->STATUS_ID == 3)
                $css_status = 'border border-2 border-danger';
            ?>

            <div class="col-12 col-md-4 col-lg-3 px-1 mb-2">
                <div class="card px-3 py-2 {{ $css_status }} shadow">

                    <p class="mb-0 small"><b>Nº Atendimento:</b> {{$pedido->N_ATENDIMENTO}}</p>
                    <hr class="my-1">
                    <p class="mb-0 small"><b>Banco:</b> {{isset($pedido->B_NOME) ? $pedido->B_NOME : ''}}, <b>Valor:</b> R$ {{ number_format($pedido->VALOR ? $pedido->VALOR : 0, 2, ',', '.') }}</p>
                    <p class="mb-0 small"><b>Data transferência :</b> {{ date('d/m/Y', strtotime($pedido->DATA_TRANSFERENCIA) ) }}</p>
                    <hr class="my-1">
                    <p class="mb-0 small"><b>Vendedor:</b> {{$pedido->U_NOME}}</p>
                    <p class="mb-0 small" style="background: {{$pedido->E_COR ? $pedido->E_COR : ''}}"><b>Empresa:</b> {{ $pedido->E_NOME ? $pedido->E_NOME : '' }}</p>
                    <hr class="my-1">
                    <p class="mb-0 small"><b>Data Pedido :</b> {{ date('d/m/Y', strtotime($pedido->created_at) ) }}</p>
                    <p class="mb-0 small"><b>Status:</b> {{$pedido->S_DESCRICAO}}</p>
                    <p class="mb-0 small"><b>Motivo Cancel.:</b> {{$pedido->M_DESCRICAO}}</p>
                    <p class="mb-0 small"><b>NFe:</b> {{$pedido->NFE ? 'Sim' : 'Não'}}</p>

                    <div class="d-flex flex-wrap justify-content-start pt-2 border-top">
                        @if( session()->get('USUARIO.TIPO_ID') == 1 )
                        <a href="{{ route('pedido.acao',['acao' => 'aceitar', 'id' => $pedido->PEDIDO_ID]) }}">
                            <div class="d-flex justify-content-center align-items-center py-1 px-2 mr-2 rounded bg-success cursor-pointer">
                                <i class="far fa-lgg fa-check-circle text-white"></i>
                            </div>
                        </a>
                        <div class="d-flex justify-content-center align-items-center py-1 px-2 mr-2 rounded bg-danger cursor-pointer cancelar-pedido" href="{{ url('') }}" acao="cancelar" pedido_id="{{$pedido->PEDIDO_ID}}">
                            <i class="far fa-lgg fa-times-circle text-white"></i>
                        </div>
                        <a src="{{ route('pedido.acao',['acao' => 'deletar', 'id' => $pedido->PEDIDO_ID]) }}" class="deletar-pedido">
                            <div class="d-flex justify-content-center align-items-center py-1 px-2 mr-2 rounded bg-danger cursor-pointer">
                                <i class="fas fa-trash-alt text-white"></i>
                            </div>
                        </a>
                        @endif
                        <div class="d-flex justify-content-center align-items-center py-1 px-2 mr-2 rounded bg-secondary cursor-pointer" data-toggle="modal" data-target="#modal_pedido-{{ $pedido->PEDIDO_ID }}">
                            <i class="far fa-lgg fa-search text-white"></i>
                        </div>
                    </div>
                </div>
            </div>

            @empty
            @if($filtro)
            <p>Não foi encontrado registros com o filtro gerado</p>
            <!-- <th scope="col" colspan="4" class="d-lg-none">Não foi encontrado registros com o filtro gerado.</th> -->
            <!-- <th scope="col" colspan="9" class="d-none d-lg-table-cell">Não foi encontrado registros com o filtro gerado.</th> -->
            @endif
            @endforelse
        </div>
    </div>
    <div class="tab-pane fade" id="table">
        <div class="w-100 p-3 bg-light table-container container-area">
            <table class="table table-sm">
                <thead>
                    <tr>
                        <th scope="col" class="d-none d-md-block"><span>ID</span></th>
                        <th scope="col" class="d-lg-none"><span>Nº</span></th>
                        <th scope="col" class="d-none d-lg-table-cell"><span>Nº Atendimento</span></th>
                        <th scope="col" class="">Banco</th>
                        <th scope="col">Valor</th>
                        <th scope="col" class="d-none d-lg-table-cell">Data transferencia</th>
                        <th scope="col" class="d-none d-lg-table-cell">Vendedor</th>
                        <th scope="col">Empresa</th>
                        <th scope="col" class="d-none d-md-table-cell">Data Pedido</th>
                        <th scope="col">Status</th>
                        <th scope="col">Motivo Cancel.</th>
                        <th scope="col">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pedidos as $pedido)
                    <?php
                    ?>
                    @include('components.table-pedido',[ 'arrTable_pedido' => $pedido ])

                    @empty
                    <tr>
                        @if($filtro)
                        <th scope="col" colspan="4" class="d-lg-none">Não foi encontrado registros com o filtro gerado.</th>
                        <th scope="col" colspan="9" class="d-none d-lg-table-cell">Não foi encontrado registros com o filtro gerado.</th>
                        @endif
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
<!-- Button trigger modal -->
<input type="hidden" data-toggle="modal" data-target="#modalPedidoCancelar">

<!-- Modal -->
<div class="modal fade" id="modalPedidoCancelar" tabindex="-1" role="dialog" aria-labelledby="modalPedidoCancelarLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form id="form-cancelar-pedido">
            <div class="modal-content">
                <div class="modal-body">

                    <h4>Por qual motivo deseja cancelar o pedido?</h4>

                    @foreach($motivos as $motivo)
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="exampleRadios" id="{{$motivo->MOTIVO_ID}}" value="{{$motivo->MOTIVO_ID}}" required>
                        <label class="form-check-label" for="{{$motivo->MOTIVO_ID}}">
                            {{$motivo->DESCRICAO}}
                        </label>
                    </div>
                    @endforeach

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-sm btn-primary">Save changes</button>
                </div>
            </div>
        </form>
    </div>
</div>

@include('components.modal-pedido',[ 'arrModal_pedido' => $pedidos ])

<script>
    setInterval(function() {
        window.location.reload()
    }, 60 * 1000)
</script>
@endsection