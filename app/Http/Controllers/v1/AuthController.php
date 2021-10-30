<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{
  public function register(Request $request)
  {
    $user = User::create([
      "name" => $request->input('name'),
      "email" => $request->input('email'),
      "password" => Hash::make($request->input('password')),
    ]);
    return ['data' => $user];
  }

  public function login(Request $request)
  {
    // validação de email e senha
    if (Auth::attempt($request->only('email', 'password'))) {

      // dados do usuario
      $user = Auth::user();

      // apaga tikens anteriores
      DB::table('personal_access_tokens')->where('name', $user->email)->delete();

      // token de acesso
      $token = $user->createToken($request->email)->plainTextToken;

      $sts = Response::HTTP_CREATED;
      $rtn = [
        'user' => new UserResource($user),
        'token' => $token
      ];
    } else {

      $sts = Response::HTTP_NO_CONTENT;
      $rtn = null;
    }

    return response()->json($rtn, $sts);
  }

  public function logout(Request $request)
  {
    // validate fields
    $request->validate([
      'email' => 'required|email',
      'password' => 'required',
    ]);

    Auth::attempt($request->only('email', 'password'));

    $user = Auth::user();

    // remove tokens
    $user->tokens()->delete();


    return response([
      'message' => 'success'
    ]);
  }
}
