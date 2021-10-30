<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
  
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- font-awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
    <!-- bootstrap -->
    <link rel="stylesheet" href="{{ url('/node_modules/bootstrap/dist/css/bootstrap.css') }}">
    <link rel="stylesheet" href="{{ url('/public/assets/geral.css') }}">
    
    {{-- jquery --}}
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>

    <title>Teste Laravel</title>

    <script>
      var path = "{{ url('') }}"
    </script>
  </head>
  
<body>

  <header class="container-lg mb-2 mb-md-0">
    <nav class="navbar navbar-expand-sm navbar-light bg-light">
      <a class="navbar-brand" href="{{ route('usuario.lista') }}">
        <i class="fas fa-user-friends mr-1"></i>
        <span>Base de Usuário</span>
      </a>

      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navbar">
        <ul class="navbar-nav ml-auto">

          <li class="nav-item {{ $routeName == 'usuario.lista' ? 'active' : 'bb' }}">
            <a class="nav-link" href="{{ route('usuario.lista') }}">Lista</a>
          </li>

          <li class="nav-item {{ $routeName == 'analise' ? 'active' : 'bb' }}">
            <a class="nav-link" href="{{ route('analise') }}">Analise</a>
          </li>

        </ul>
      </div>
    </nav>
  </header>

  <div class="container-lg d-flex flex-wrap">