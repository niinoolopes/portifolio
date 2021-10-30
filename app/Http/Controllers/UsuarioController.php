<?php

namespace App\Http\Controllers;

use App\Usuario;
use App\Endereco;
use App\Http\Middleware\Token;
use App\Http\Resources\Usuario\UsuarioResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UsuarioController extends Controller
{
    public function index($id = false)
    {
        try {
            if ($id) {
                $data = Usuario::where('usua_id', $id)->get();
                if (!$data) return response()->json(['message' => "ID $id não encontrado!"], 400);
            } else {
                $data = Usuario::all();
            }

            foreach ($data as $key => $value) {
                $value->end = $value->end();
                $value->usut = $value->usut();
                $data[$key] = new UsuarioResource($value);
            }

            return response()->json([
                'data' => ($id) ? $data[0] : $data
            ]);
        } catch (\Throwable $th) {
            return response()->json(['error' => 'ocorreu um erro inesperado. contate o administrador do sistema!'], 500);
        }
    }

    public function store(Request $request)
    {
        try {
            $usuarioModel = new Usuario;
            $usuarioModel->usua_login    = $request['usua_login'];
            $usuarioModel->usua_password = base64_encode($request['usua_password']);
            $usuarioModel->usua_name     = $request['usua_name'];
            $usuarioModel->usua_email    = $request['usua_email'];
            $usuarioModel->usua_cnpj     = $request['usua_cnpj'];
            $usuarioModel->usua_pix      = $request['usua_pix'];
            $usuarioModel->usua_whatsapp = $request['usua_whatsapp'];
            $usuarioModel->usua_banco    = $request['usua_banco'];
            $usuarioModel->usua_agencia  = $request['usua_agencia'];
            $usuarioModel->usua_conta    = $request['usua_conta'];
            $usuarioModel->usut_id       = $request['usut_id'];
            $usuarioModel->usua_status   = 1;
            $usuarioModel->save();

            $enderecoModel = new Endereco;
            $enderecoModel->end_complement   = $request['end_complement'];
            $enderecoModel->end_address  = $request['end_address'];
            $enderecoModel->end_number   = $request['end_number'];
            $enderecoModel->end_zipcode  = $request['end_zipcode'];
            $enderecoModel->end_district = $request['end_district'];
            $enderecoModel->end_city     = $request['end_city'];
            $enderecoModel->usua_id      = $usuarioModel->usua_id;
            $enderecoModel->save();


            $data = Usuario::where('usua_id', $usuarioModel->usua_id)->get();
            foreach ($data as $key => $value) {
                $value->end = $value->end();
                $value->usut = $value->usut();
                $data[$key] = new UsuarioResource($value);
            }

            return response()->json(['message' => 'Usuario cadastrado!', 'data' => $data[0]]);
        } catch (\Throwable $th) {
            return response()->json(['error' => 'ocorreu um erro inesperado. contate o administrador do sistema!'], 500);
        }
    }

    public function update(Request $request, $usua_id)
    {
        $count = Usuario::where('usua_login', $request['usua_login'])->where('usua_id', '!=', $usua_id)->count();

        if ($count) {
            return response()->json(['message' => "Login '{$request['usua_login']}' existente, tente outro login!"], 400);
        }
        $count = Usuario::where('usua_email', $request['usua_email'])->where('usua_id', '!=', $usua_id)->count();
        if ($count) {
            return response()->json(['message' => "Email '{$request['usua_email']}' existente, tente outro email!"], 400);
        }

        $usuarioModel = Usuario::where('usua_id', $usua_id)->first();

        if ($usuarioModel) {

            $usuarioModel->usua_login    = isset($request['usua_login'])    ? $request['usua_login']    : $usuarioModel->usua_login;
            $usuarioModel->usua_password = isset($request['usua_password']) && $request['usua_password'] ? base64_encode($request['usua_password']) : $usuarioModel->usua_password;
            $usuarioModel->usua_name     = isset($request['usua_name'])     ? $request['usua_name']     : $usuarioModel->usua_name;
            $usuarioModel->usua_email    = isset($request['usua_email'])    ? $request['usua_email']    : $usuarioModel->usua_email;
            $usuarioModel->usua_cnpj     = isset($request['usua_cnpj'])     ? $request['usua_cnpj']     : $usuarioModel->usua_cnpj;
            $usuarioModel->usua_pix      = isset($request['usua_pix'])      ? $request['usua_pix']      : $usuarioModel->usua_pix;
            $usuarioModel->usua_whatsapp = isset($request['usua_whatsapp']) ? $request['usua_whatsapp'] : $usuarioModel->usua_whatsapp;
            $usuarioModel->usua_banco    = isset($request['usua_banco'])    ? $request['usua_banco']    : $usuarioModel->usua_banco;
            $usuarioModel->usua_agencia  = isset($request['usua_agencia'])  ? $request['usua_agencia']  : $usuarioModel->usua_agencia;
            $usuarioModel->usua_conta    = isset($request['usua_conta'])    ? $request['usua_conta']    : $usuarioModel->usua_conta;
            $usuarioModel->usut_id       = isset($request['usut_id'])       ? $request['usut_id']       : $usuarioModel->usut_id;
            $usuarioModel->usua_status   = 1;
            $usuarioModel->save();

            $enderecoModel = Endereco::where('usua_id', $usua_id)->first();
            if ($enderecoModel) {
                $enderecoModel->end_complement = isset($request['end_complement']) ? $request['end_complement'] : $enderecoModel->end_complement;
                $enderecoModel->end_address    = isset($request['end_address'])    ? $request['end_address']    : $enderecoModel->end_address;
                $enderecoModel->end_number     = isset($request['end_number'])     ? $request['end_number']     : $enderecoModel->end_number;
                $enderecoModel->end_zipcode    = isset($request['end_zipcode'])    ? $request['end_zipcode']    : $enderecoModel->end_zipcode;
                $enderecoModel->end_district   = isset($request['end_district'])   ? $request['end_district']   : $enderecoModel->end_district;
                $enderecoModel->end_city       = isset($request['end_city'])       ? $request['end_city']       : $enderecoModel->end_city;
                $enderecoModel->save();
            } else {
                $enderecoModel = new Endereco();
                $enderecoModel->end_complement   = $request['end_complement'];
                $enderecoModel->end_address  = $request['end_address'];
                $enderecoModel->end_number   = $request['end_number'];
                $enderecoModel->end_zipcode  = $request['end_zipcode'];
                $enderecoModel->end_district = $request['end_district'];
                $enderecoModel->end_city     = $request['end_city'];
                $enderecoModel->usua_id      = $usuarioModel->usua_id;
                $enderecoModel->save();
            }


            $data = Usuario::where('usua_id', $usua_id)->get();
            foreach ($data as $key => $value) {
                $value->end = $value->end();
                $value->usut = $value->usut();
                $data[$key] = new UsuarioResource($value);
            }

            return response()->json(['message' => 'Usuario atualizado!', 'data' => $data[0]]);
        } else {
            return response()->json(['message' => "ID $id não encontrado!"], 400);
        }
        try {
        } catch (\Throwable $th) {
            return response()->json(['error' => 'ocorreu um erro inesperado. contate o administrador do sistema!'], 500);
        }
    }

    public function login(Request $request, Usuario $usuario, Token $token)
    {
        $usua_login = $request['usua_login'];
        $usua_password = base64_encode($request['usua_password']);

        $user = $usuario::where('usua_login', $usua_login)->first();

        if (!$user) {
            return response()->json(['message' => 'Login não encontrado'], 400);
        }
        if ($usua_password != $user['usua_password']) {
            return response()->json(['message' => 'Senha incorreta'], 400);
        }

        $tokenDo = $token->do(['id' => $user->usua_id]);

        $user->end = $user->end();
        $user->usut = $user->usut();
        $user = new UsuarioResource($user);

        $data = [
            'user' => $user,
            'token' => $tokenDo,
        ];
        return response()->json(['data' => $data]);
    }

    public function list()
    {
        try {
            $data = Usuario::where('usut_id', '!=', 3)->get();

            foreach ($data as $key => $value) {
                $value->end = $value->end();
                $value->usut = $value->usut();
                $data[$key] = new UsuarioResource($value);
            }

            return response()->json(['data' => $data]);
        } catch (\Throwable $th) {
            return response()->json(['error' => 'ocorreu um erro inesperado. contate o administrador do sistema!'], 500);
        }
    }

    public function customers()
    {
        try {
            $data = Usuario::where('usut_id', 3)->get();

            foreach ($data as $key => $value) {
                $value->end = $value->end();
                $value->usut = $value->usut();
                $data[$key] = new UsuarioResource($value);
            }

            return response()->json(['data' => $data]);
        } catch (\Throwable $th) {
            return response()->json(['error' => 'ocorreu um erro inesperado. contate o administrador do sistema!'], 500);
        }
    }




    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Usuario  $usuario
     * @return \Illuminate\Http\Response
     */
    public function destroy(Usuario $usuario, $USU_ID)
    {
        try {
            $USU = $usuario::find($USU_ID);

            if ($USU) {
                $USU->delete();
                return response()->json(['message' => 'Usuario deletado!']);
            } else {
                return response()->json(['message' => "ID $USU_ID não encontrado!"], 400);
            }
        } catch (\Throwable $th) {
            return response()->json(['error' => 'ocorreu um erro inesperado. contate o administrador do sistema!'], 500);
        }
    }
}
