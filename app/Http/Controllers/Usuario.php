<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\UsuarioModel;
use Illuminate\Support\Facades\Route;

class Usuario extends Controller
{
    private $data = [];

    function __construct()
    {
        $this->usuarioModel = new UsuarioModel;
        $this->data['sidebar'] = 'usuario_sidebar';
        $this->data['sidebar_text'] = 'Usuário';
        $this->data['routeName'] = Route::currentRouteName();
    }

    public function lista() {

        $this->data['usuarios'] = $this->usuarioModel->all();

        $this->data['main'] = 'usuario_lista';

        return view('layout.default', $this->data);
    }

    public function add() {
        $this->data['action'] = 'add';
        $this->data['form_action'] = route('usuario.store');

        $this->data['main'] = 'usuario_cadastrar';
        
        return view('layout.default', $this->data);
    }

    public function edit($id = false) {
        $this->data['usuario'] = $this->usuarioModel->find($id);
        $this->data['action'] = 'edit';
        $this->data['form_action'] = route('usuario.update', ['id' => $id]);
        $this->data['form_delete'] = route('usuario.delete', ['id' => $id]);

        $this->data['main'] = 'usuario_cadastrar';

        return view('layout.default', $this->data);
    }

    public function store(Request $request) {
        $input = $request->all();

        $this->usuarioModel->USUARIO_NOME            = $input['USUARIO_NOME'];
        $this->usuarioModel->USUARIO_SOBRENOME       = $input['USUARIO_SOBRENOME'];
        $this->usuarioModel->USUARIO_DATA_NASCIMENTO = $input['USUARIO_DATA_NASCIMENTO'];
        $this->usuarioModel->USUARIO_SEXO            = $input['USUARIO_SEXO'];
        $result_insert = $this->usuarioModel->save() ? true : false;
        $result_insert = 1;

        $type = $result_insert ? 'sucess' : 'danger';
        $msg  = $result_insert ? 'Usuario cadastrado!' : 'Erro tende novamente!';
        $request->session()->flash('alert', ['type' => $type,'msg' => $msg]);

        return redirect()->route('usuario.lista');
    }

    public function update(Request $request, $id) {
        $input = $request->all();

        $usuario = $this->usuarioModel->find($id);
        $usuario['USUARIO_NOME']            = $input['USUARIO_NOME'];
        $usuario['USUARIO_SOBRENOME']       = $input['USUARIO_SOBRENOME'];
        $usuario['USUARIO_DATA_NASCIMENTO'] = $input['USUARIO_DATA_NASCIMENTO'];
        $usuario['USUARIO_SEXO']            = $input['USUARIO_SEXO'];

        $result_update = $usuario->save() ? true : false;
        
        $type = $result_update ? 'sucess' : 'danger';
        $msg  = $result_update ? 'Usuario atualizado!' : 'Erro tende novamente!';
        $request->session()->flash('alert', ['type' => $type,'msg' => $msg]);

        return redirect()->route('usuario.lista');
    }

    public function delete(Request $request, $id) {
        
        $usuario = $this->usuarioModel->find($id);
        
        $result_delete = $usuario->delete() ? true : false;
        
        $type = $result_delete ? 'sucess' : 'danger';
        $msg  = $result_delete ? 'Usuario deletado!' : 'Erro tende novamente!';
        $request->session()->flash('alert', ['type' => $type,'msg' => $msg]);
        
        return redirect()->route('usuario.lista');

    }
}
