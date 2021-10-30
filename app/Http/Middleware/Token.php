<?php

namespace App\Http\Middleware;

use Closure;

class Token
{
  public function handle($request, Closure $next)
  {
    $data = $this->data();

    if ($data === 'Authorization')
      return response()->json([
        'message' => 'token obrigatório!'
      ], 400);

    if ($data === 'Token inválido')
      return response()->json([
        'message' => 'token invalido!'
      ], 400);

    return $next($request);
  }
  public function do($params = [])
  {
    $header = (object)[
      'typ' => 'JWT',
      'alg' => 'HS256'
    ];
    $payload = (object)array_merge(
      [
        // 'exp' => date('Y-m-d H:i:s', strtotime("+15 min")),
        'uid' => 1,
      ],
      (array)$params
    );

    $header  = json_encode($header);
    $payload = json_encode($payload);

    $header  = base64_encode($header);
    $payload = base64_encode($payload);

    $sign    = base64_encode($this->hash($header, $payload));

    return "{$header}.{$payload}.{$sign}";
  }
  public function get($key = false)
  {
    $h = $this->getHeaders();

    $str = $h['Authorization'];
    $str = explode('.', $str);


    $payload = $str[1];
    $payload = base64_decode($payload);
    $payload = (array)json_decode($payload);

    if ($key && isset($payload[$key])) {
      return $payload[$key];
    }

    return $payload;
  }
  private function data()
  {
    $h = $this->getHeaders();

    if (isset($h['Authorization'])) {

      $str = $h['Authorization'];
      $str = explode('.', $str);

      $header  = explode(' ', $str[0])[1];
      $payload = $str[1];
      $sign    = $str[2];

      if ($sign !== base64_encode($this->hash($header, $payload)))
        return 'Token inválido';

      $header  = base64_decode($header);
      $payload = base64_decode($payload);

      $header  = json_decode($header);
      $payload = json_decode($payload);

      return [
        'header' => $header,
        'payload' => $payload,
      ];
    }
    return 'Authorization';
  }
  private function getHeaders()
  {
    return apache_request_headers();
  }
  private function hash($header, $payload)
  {
    return hash_hmac('sha256', "{$header}.{$payload}", 'TOKEN_JWT', true);
  }
}
