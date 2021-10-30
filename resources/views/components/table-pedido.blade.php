<?PHP
if ($pedido->STATUS_ID == 1)
    $css_status = 'bg-orange text-white';

if ($pedido->STATUS_ID == 2)
    $css_status = 'bg-success text-white';

if ($pedido->STATUS_ID == 3)
    $css_status = 'bg-danger text-white';
?>

<tr>
    <td class="d-none d-md-block">
        <span>{{$pedido->PEDIDO_ID}}</span>
    </td>

    <td>
        <span>{{$pedido->N_ATENDIMENTO}}</span>
    </td>

    <td class="">
        <span>{{ isset($pedido->B_NOME) ? $pedido->B_NOME : ''}}</span>
    </td>

    <td>
        <span>R$ {{ number_format($pedido->VALOR ? $pedido->VALOR : 0, 2, ',', '.') }}</span>
    </td>

    <td class="d-none d-lg-table-cell">
        <span>{{ date('d-m-Y', strtotime($pedido->DATA_TRANSFERENCIA) ) }}</span>
    </td>

    <td class="d-none d-lg-table-cell">
        <span>{{$pedido->U_NOME}}</span>
    </td>

    <td class="d-none d-lg-table-cell">
        <div class="d-flex">
            <div class="d-flex justify-content-center align-items-center py-1 px-2 mr-2 rounded" style="background: {{$pedido->E_COR ? $pedido->E_COR : ''}}">
                {{$pedido->E_NOME ? $pedido->E_NOME : ''}}
            </div>
        </div>
    </td>

    <td class="d-none d-md-table-cell">
        <span>{{ date('d-m-Y', strtotime($pedido->created_at) ) }}</span>
    </td>

    <td>
        <span class="{{ $css_status }} d-block pl-2 w-100 small">{{$pedido->S_DESCRICAO}}</span>
    </td>
    <td>
        <span class="d-block pl-2 w-100 small">{{$pedido->M_DESCRICAO}}</span>
    </td>

    <td>
        <div class="d-flex">
            @if( session()->get('USUARIO.TIPO_ID') == 1 )

            <a href="{{ route('pedido.acao',['acao' => 'aceitar', 'id' => $pedido->PEDIDO_ID]) }}">
                <div class="d-flex justify-content-center align-items-center py-1 px-2 mr-2 rounded bg-success cursor-pointer">
                    <i class="far fa-lgg fa-check-circle text-white"></i>
                </div>
            </a>
            <!-- <a href="{{ route('pedido.acao',['acao' => 'cancelar', 'id' => $pedido->PEDIDO_ID]) }}" class="cancelar-pedido"> -->
                <div class="d-flex justify-content-center align-items-center py-1 px-2 mr-2 rounded bg-danger cursor-pointer cancelar-pedido"
                href="{{ url('') }}" 
                acao="cancelar"
                pedido_id="{{$pedido->PEDIDO_ID}}"
                >
                    <i class="far fa-lgg fa-times-circle text-white"></i>
                </div>
            <!-- </a> -->
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
    </td>
</tr>

<?PHP
unset($pedido);
?>