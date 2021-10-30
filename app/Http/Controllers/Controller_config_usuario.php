<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Usuario;
use App\Usuario_tipo;
use App\Usuario_cargo;
use App\Empresa;

class Controller_config_usuario extends Controller
{
    public function index()
    {
        $this->dados['_msg'] = session()->get('_msg');
        $this->dados['tab']  = session()->get('tab');

        $this->dados['tab_usuario'] = session()->get('tab_usuario');
        $this->dados['tab_tipo']    = session()->get('tab_tipo');
        $this->dados['tab_cargo']   = session()->get('tab_cargo');

        if( session()->get('tab_tipo') == null && session()->get('tab_cargo') == null ) {
            $this->dados['tab_usuario'] = true;
        }

        $Usuario_tipo = new Usuario_tipo;
        $this->dados['usuario_tipos']       = $Usuario_tipo->getAll();
        $this->dados['usuario_tipos_enable'] = $Usuario_tipo->getAllEnable();


        $Usuario_cargo = new Usuario_cargo;
        $this->dados['usuario_cargos']       = $Usuario_cargo->getAll();
        $this->dados['usuario_cargos_enable'] = $Usuario_cargo->getAllEnable();


        $this->dados['usuarios'] = [];
        $Usuario = new Usuario;
        $result  = $Usuario->getAll();
        $tmp = [];

        foreach ($result as $key_usuario => $usuario) {

            if (key_exists($usuario->TIPO_NOME, $tmp)) {
                $this->dados['usuarios'][$tmp[$usuario->TIPO_NOME]]->LISTA[] = $usuario;
            } else {
                $tmp[$usuario->TIPO_NOME] =  $key_usuario;

                $this->dados['usuarios'][$key_usuario] = (object) [
                    'TIPO'    => $usuario->TIPO_NOME,
                    'TIPO_ID' => $usuario->TIPO_ID,
                    'LISTA'   => [],
                ];
                $this->dados['usuarios'][$tmp[$usuario->TIPO_NOME]]->LISTA[] = $usuario;
            }
        }

        $Empresa = new Empresa;
        $this->dados['empresas_enable'] = $Empresa->getAllEnable();

        // dd($tmp);
        // dd($this->dados['usuarios']);

        $this->dados['titulo'] = 'Config  Usuários';


        return view('pages.config_usuario', $this->dados);
    }

    public function post(Request $request)
    {
        $request->session()->flash('tab_usuario', true);

        $usuario = new Usuario;

        $existEmail = count($usuario::where('EMAIL', $request->post('EMAIL'))->get()) > 0;
        if ($existEmail) {
            $request->session()->flash('_msg', ['text' => 'O E-MAIL que você tentou cadastrar já existe!', 'tipo' => 'danger']);
        }
        $existLogin = count($usuario::where('LOGIN', $request->post('LOGIN'))->get()) > 0;
        if ($existLogin) {
            $request->session()->flash('_msg', ['text' => 'O LOGIN que você tentou cadastrar já existe!', 'tipo' => 'danger']);
        }
        if ($existEmail || $existEmail) {
            return redirect()->route('config.usuario');
        }

        $usuario->NOME       = $request->post('NOME');
        $usuario->CARGO_ID   = $request->post('CARGO_ID') == null ? '' : $request->post('CARGO_ID');
        $usuario->TIPO_ID    = $request->post('TIPO_ID')  == null ? '' : $request->post('TIPO_ID');
        $usuario->EMPRESA_ID = $request->post('EMPRESA_ID')  == null ? '' : $request->post('EMPRESA_ID');
        $usuario->EMAIL      = $request->post('EMAIL');
        $usuario->LOGIN      = $request->post('LOGIN');
        $usuario->SENHA      = base64_encode($request->post('SENHA'));
        $usuario->JSON       = json_encode($request->post('JSON'));
        $usuario->STATUS     = 1;

        $usuario->save();

        $request->session()->flash('_msg', ['text' => 'Usuário cadastrado!', 'tipo' => 'success']);
        $request->session()->flash('tab', $usuario->TIPO_ID);

        return redirect()->route('config.usuario');
    }

    public function put(Request $request)
    {
        $request->session()->flash('tab_usuario', true);

        $Usuario = new Usuario;
        $nome = $request->post('NOME');

        if ($Usuario::where('NOME', '=', $request->post('NOME'))->where('USUARIO_ID', '!=', $request->post('USUARIO_ID'))->count()) {
            $request->session()->flash('_msg', ['text' => "O nome <strong>{$nome}</strong> informado já existe, não é permitido nomes iguais!", 'tipo' => 'danger']);
            return redirect()->route('config.usuario');
        }

        $usuario = $Usuario::where('USUARIO_ID', '=', $request->post('USUARIO_ID'))->first();

        $usuario->NOME       = $request->post('NOME');
        $usuario->CARGO_ID   = $request->post('CARGO_ID') == null ? '' : $request->post('CARGO_ID');
        $usuario->TIPO_ID    = $request->post('TIPO_ID')  == null ? '' : $request->post('TIPO_ID');
        $usuario->EMPRESA_ID = $request->post('EMPRESA_ID')  == null ? '' : $request->post('EMPRESA_ID');
        $usuario->EMAIL      = $request->post('EMAIL');
        $usuario->LOGIN      = $request->post('LOGIN');
        $usuario->SENHA      = base64_encode($request->post('SENHA'));
        $usuario->STATUS     = $request->post('STATUS') == 'on' ? 1 : 0;
        $usuario->JSON       = json_encode($request->post('JSON'));

        $usuario->save();

        $request->session()->flash('_msg', ['text' => 'Usuário atualizado!', 'tipo' => 'success']);
        $request->session()->flash('tab', $usuario->TIPO_ID);

        return redirect()->route('config.usuario');
    }
}
