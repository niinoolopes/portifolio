@extends('layout.template')

@section('conteudo')

<section class="col-12 col-lg-6">
    <a href="{{ route('pedido.cadastrar') }}" class="jumbotron d-block mb-3">
        <div class="d-sm-flex align-items-center justify-content-between">
            <div class="div">
                <h1 class="display-4 jumbotron-home text-dark">Pedido</h1>
                <p class="lead m-0 text-dark">Para realizar um novo cadastro.</p>
            </div>
        </div>
        <hr class="my-2 bg-teal">
    </a>
</section>

<section class="col-12 col-lg-6">
    <a href="{{ route('pedido.consultar') }}" class="jumbotron d-block mb-3">
        <div class="d-sm-flex align-items-center justify-content-between">
            <div class="div">
                <h1 class="display-4 jumbotron-home text-dark">Consultar</h1>
                <p class="lead m-0 text-dark">Para consultar um pedido existente.</p>
            </div>
        </div>
        <hr class="my-2 bg-teal">
    </a>
    </div>
</section>

@endsection