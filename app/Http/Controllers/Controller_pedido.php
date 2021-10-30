<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Usuario;
use App\Pedido;
use App\PedidoMotivo;
use App\Banco;
use App\Config;

class Controller_pedido extends Controller
{
    private $exts        = ['png', 'jpeg', 'jpg', 'pdf'];
    private $upload_path = '/images/comprovante';
    private $file_name   = 'COMPROVANTE-PEDIDO-';
    private $dados = [];

    public function cadastrar()
    {
        $this->dados_config();

        $this->dados['_msg']   = session()->get('_msg');
        $this->dados['campos'] = session()->get('campos') != null ? session()->get('campos') : [
            'N_ATENDIMENTO' => '',
            'USUARIO_ID' => session()->get('USUARIO.USUARIO_ID'),
            'VALOR' => '',
            'DATA_TRANSFERENCIA' => '',
            'BANCO_ID' => '',
            'COMPROVANTE' => '',
        ];

        $this->dados['bancos'] = Banco::all();

        $Usuario = new Usuario;
        // $this->dados['vendedores']  = $Usuario->getAllVendedores($this->dados['config']->TIPO_ID);
        // $this->dados['vendedores']  = $Usuario->getAllVendedores([session()->get('USUARIO.TIPO_ID')]);
        $this->dados['vendedores']  = $Usuario->getVendedorByUsuaId(session()->get('USUARIO.USUARIO_ID'));
 
        $this->dados['titulo'] = 'Cadastrar Pedido';
        return view('pages.cadastrar', $this->dados);
    }

    public function painel(Request $request)
    {
        $this->dados_config();

        $this->dados['_msg'] = session()->get('_msg');

        $this->dados['pedidos']  = [];
        $this->dados['filtro']   = '';
        $this->dados['conteudo'] = '';


        $this->dados['autoplay'] = false;
        $total_pedidos = Pedido::where('STATUS', '=', 1)->count();
        if ($total_pedidos > session()->get('total_pedidos_s')) {
            session(['total_pedidos_s' => Pedido::where('STATUS', '=', 1)->count()]);
            $this->dados['autoplay'] = true;
        }


        $Pedido = new Pedido;

        if (is_array($request->post()) && count($request->post()) > 0) {
            $this->dados['pedidos']  = $Pedido->getAllFiltro($request->post());
            $this->dados['filtro']   = $request->post('filtro');
            $this->dados['conteudo'] = $request->post('conteudo');
        } else {
            $this->dados['pedidos']  = $Pedido->getAll();
        }

        foreach ( $this->dados['pedidos'] as $key => $pedido) {
            if($pedido->COMPROVANTE == '') {
                $this->dados['pedidos'][$key]->tipoComprovante = false;
            }else{
                $this->dados['pedidos'][$key]->tipoComprovante = explode('.',$pedido->COMPROVANTE)[1];
            }
        }

        $Usuario = new Usuario;
        $this->dados['vendedores']  = $Usuario->getAllVendedores($this->dados['config']->TIPO_ID);


        $this->dados['bancos'] = Banco::all();
        $this->dados['motivos'] = PedidoMotivo::where('STATUS', 1)->get();

        $this->dados['titulo'] = 'Pedidos';
        return view('pages.painel', $this->dados);
    }

    private function dados_config()
    {
        $config = Config::where('DESCRICAO', 'FORM_CADASTRO')->first();
        if (is_object($config) || is_array($config)) {
            $this->dados['config'] = json_decode($config->JSON);
            $this->dados['aviso'] = false;
        } else {
            $this->dados['config'] = [
                "TIPO_ID"       =>  [],
                "N_ATENDIMENTO" =>  false,
                "VALOR"         =>  false,
                "DATA"          =>  false,
                "BANCO"         =>  false,
                "COMPROVANTE"   =>  false,
            ];
            $this->dados['aviso'] = true;
        }
    }

    public function consultar(Request $request)
    {
        $this->dados_config();

        $this->dados['_msg'] = session()->get('_msg');

        $this->dados['filtro']   = '';
        $this->dados['conteudo'] = '';

        $this->dados['pedidos']  = [];

        if (is_array($request->post()) && count($request->post()) > 0) {
            $Pedido = new Pedido;
            $this->dados['pedidos']  = $Pedido->getAllFiltro($request->post());
            $this->dados['filtro']   = $request->post('filtro');
            $this->dados['conteudo'] = $request->post('conteudo');
        }

        $Usuario = new Usuario;
        $this->dados['vendedores']  = $Usuario->getAllVendedores($this->dados['config']->TIPO_ID);

        $this->dados['bancos'] = Banco::all();

        $this->dados['titulo'] = 'Pedidos';
        return view('pages.consultar', $this->dados);
    }

    public function consultarPedido(Request $request)
    {
        $this->dados_config();

        $this->dados['_msg'] = session()->get('_msg');

        $this->dados['conteudo'] = '';
        $this->dados['pedidos']  = false;

        
        if (is_array($request->post()) && count($request->post()) > 0) {
            

            $Pedido = new Pedido;
            $this->dados['pedidos']  = $Pedido->getAllFiltro($request->post());

            $this->dados['conteudo'] = $request->post('conteudo');
            // dd( $this->dados['pedido'] );
            // dd( $request->all() );
        }

        $Usuario = new Usuario;
        $this->dados['vendedores']  = $Usuario->getAllVendedores($this->dados['config']->TIPO_ID);

        $this->dados['bancos'] = Banco::all();

        $this->dados['titulo'] = 'Pedidos';
        return view('pages.consultarPedido', $this->dados);
    }

    public function post(Request $request)
    {
        $request->validate([
            'g-recaptcha-response' => 'required|captcha'
        ]);

        $EXT = '';
        if ($request->hasFile('COMPROVANTE') && $request->file('COMPROVANTE')->isValid()) {

            $COMPROVANTE     = $request->file('COMPROVANTE');
            $EXT             = strtolower($COMPROVANTE->extension());

            // VALIDA EXTENSÃO ARQUIVO
            if (!in_array($EXT, $this->exts)) {
                $request->session()->flash('_msg', ['text' => "Comprovante deve ter extenção pdf, png, jpg ou jpeg!", 'tipo' => 'danger']);
                return redirect()->route('pedido.cadastrar');
            }
        }
      
        // --
        
        $pedido = new Pedido;
        $pedido->N_ATENDIMENTO      = $request->post('N_ATENDIMENTO') == null ? '' : $request->post('N_ATENDIMENTO');
        $pedido->USUARIO_ID         = $request->post('USUARIO_ID') == null ? '' : $request->post('USUARIO_ID');
        $pedido->VALOR              = $request->post('VALOR') == null ? '' : $request->post('VALOR');
        $pedido->DATA_TRANSFERENCIA = $request->post('DATA_TRANSFERENCIA') == null ? '' : $request->post('DATA_TRANSFERENCIA');
        $pedido->BANCO_ID           = $request->post('BANCO_ID') == null ? '' : $request->post('BANCO_ID');
        $pedido->NFE                = $request->post('NFE') == null ? 0 : $request->post('NFE');
        $pedido->COMPROVANTE        = '';
        $pedido->STATUS_ID          = 1;
        $pedido->STATUS             = 1;
        $pedido->save();
        
        // adiciona imagem
        if ($request->hasFile('COMPROVANTE') && $request->file('COMPROVANTE')->isValid()) {
            $this->file_name .= $pedido->PEDIDO_ID;
            $this->file_name .= '.' . $EXT;
            $this->file_name  = strtolower($this->file_name);

            $pedido->COMPROVANTE        = $this->file_name;
            $pedido->save();

            // UPLOAD IMAGE
            $request->file('COMPROVANTE')->storeAs($this->upload_path, $this->file_name);
        }
        // --

        $request->session()->flash('_msg', ['text' => 'Pedido cadastrado!', 'tipo' => 'success']);

        return redirect()->route('pedido.cadastrar');
    }

    public function put(Request $request, $id)
    {
        $EXT = '';
        if ($request->hasFile('COMPROVANTE') && $request->file('COMPROVANTE')->isValid()) {

            $COMPROVANTE     = $request->file('COMPROVANTE');
            $EXT             = strtolower($COMPROVANTE->extension());

            // VALIDA EXTENSÃO ARQUIVO
            if (!in_array($EXT, $this->exts)) {
                $request->session()->flash('_msg', ['text' => "Comprovante deve ter extenção pdf, png, jpg ou jpeg!", 'tipo' => 'danger']);
                return redirect()->route('config.banco');
            }
        }

        $pedido = Pedido::find($id);
        if($pedido) {
            $pedido->N_ATENDIMENTO = $request->get('N_ATENDIMENTO');
            $pedido->USUARIO_ID = $request->get('VENDEDOR_ID');
            $pedido->VALOR = $request->get('VALOR');
            $pedido->DATA_TRANSFERENCIA = $request->get('DATA_TRANSFERENCIA');
            $pedido->BANCO_ID = $request->get('BANCO_ID');
            $pedido->STATUS_ID = $request->get('STATUS_ID');
            $pedido->MOTIVO_ID = $request->get('MOTIVO_ID');
            $pedido->NFE = $request->get('NFE');
            $pedido->save();

            // adiciona imagem
            if ($request->hasFile('COMPROVANTE') && $request->file('COMPROVANTE')->isValid()) {
                $this->file_name .= $pedido->PEDIDO_ID;
                $this->file_name .= '.' . $EXT;
                $this->file_name  = strtolower($this->file_name);
    
                $pedido->COMPROVANTE        = $this->file_name;
                $pedido->save();
    
                // UPLOAD IMAGE
                $request->file('COMPROVANTE')->storeAs($this->upload_path, $this->file_name);
            }
            $request->session()->flash('_msg', ['text' => 'Pedido atualizado!', 'tipo' => 'success']);
        } else {
            $request->session()->flash('_msg', ['text' => 'Não foi encontrado o pedido!', 'tipo' => 'danger']);
        }
        // --
        return redirect()->route('pedido.painel');
    }

    public function statusPedido($ACAO, $PEDIDO_ID, $MOTIVO_ID = 0)
    {
        
        $Pedido = new Pedido;

        $pedido = $Pedido::where('PEDIDO_ID', '=', $PEDIDO_ID)->first();

        if ($ACAO == 'pendente') {
            $pedido->STATUS_ID = 1;
            $msg = 'pendente';
            $pedido->save();
        }
        if ($ACAO == 'aceitar') {
            $pedido->STATUS_ID = 2;
            $msg = 'aceito';
            $pedido->save();
        }
        if ($ACAO == 'cancelar') {
            $pedido->STATUS_ID = 3;
            $pedido->MOTIVO_ID = $MOTIVO_ID;
            $msg = 'cancelado';
            $pedido->save();
        } 
        if ($ACAO == 'deletar') {
            $msg = 'deletado';
            $pedido->delete();
        } 

        session()->flash('_msg', ['text' => "Pedido {$msg}!", 'tipo' => 'success']);

        return redirect()->route('pedido.painel');
    }
}
