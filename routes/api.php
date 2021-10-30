<?php

use Illuminate\Http\Request;
use App\UsuarioModel;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/usuario', function () {
    try {
        $status = 'success';
        $message = '';
        $data = App\UsuarioModel::all();

    } catch (\Throwable $th) {
        $status = 'error';
        $message = 'Um erro aconteceu';
        $data = [];
    }

    return response()->json(
        [
            'message' => $message,
            'status' => $status, 
            'data' => $data
        ]
    );
});

Route::post('/usuario-store', function (Request $request) {
    
    try {
        $input = $request->all();
        $usuarioModel = new UsuarioModel;

        $usuarioModel->USUARIO_NOME            = $input['USUARIO_NOME'];
        $usuarioModel->USUARIO_SOBRENOME       = $input['USUARIO_SOBRENOME'];
        $usuarioModel->USUARIO_DATA_NASCIMENTO = $input['USUARIO_DATA_NASCIMENTO'];
        $usuarioModel->USUARIO_SEXO            = $input['USUARIO_SEXO'];
        
        $status = $usuarioModel->save() ? true : false;
        $message = 'Registro cadastrado.';
        $data = $usuarioModel;

    } catch (\Throwable $th) {
        $status = 'error';
        $message = 'Um erro aconteceu';
        $data = [];
    }

    return response()->json(
        [
            'message' => $message,
            'status' => $status, 
            'data' => $data
        ]
    );
});

Route::post('/usuario-update', function (Request $request) {
    if(!isset($_GET['USUARIO_ID'])) 
        return response()->json(
            [
                'status' => 'error', 
                'data' => 'Parametro GET USUARIO_ID é obrigatório'
            ]
        );


    try {
        $input = $request->all();
        $usuarioModel = new UsuarioModel;
    
        $usuario = $usuarioModel->find($_GET['USUARIO_ID']);
        $usuario['USUARIO_NOME']            = $input['USUARIO_NOME'];
        $usuario['USUARIO_SOBRENOME']       = $input['USUARIO_SOBRENOME'];
        $usuario['USUARIO_DATA_NASCIMENTO'] = $input['USUARIO_DATA_NASCIMENTO'];
        $usuario['USUARIO_SEXO']            = $input['USUARIO_SEXO'];
    
        $status = $usuario->save() ? true : false;
        $message = 'Registro atualizado.';
        $data = $usuario;

    } catch (\Throwable $th) {
        $status = 'error';
        $message = 'Um erro aconteceu';
        $data = [];
    }

    return response()->json(
        [
            'message' => $message,
            'status' => $status, 
            'data' => $data
        ]
    );
});

Route::get('/usuario-delete', function () {
    if(!isset($_GET['USUARIO_ID'])) 
        return response()->json(
            [
                'status' => 'error', 
                'data' => 'Parametro GET USUARIO_ID é obrigatório'
            ]
        );


    try {
        $usuarioModel = new UsuarioModel;
    
        $usuario = $usuarioModel->find($_GET['USUARIO_ID']);

        if($usuario != null){
            $status = $usuario->delete() ? true : false;
            $data = true;
            $message = 'Registro excluido com sucesso.';
        } else {
            $status = 'error';
            $message = 'O USUARIO_ID informado não existe.';
            $data = false;
        }
        
    } catch (\Throwable $th) {
        $status = 'error';
        $message = 'Um erro aconteceu';
        $data = false;
    }

    return response()->json(
        [
            'message' => $message,
            'status' => $status, 
            'data' => $data
        ]
    );
});