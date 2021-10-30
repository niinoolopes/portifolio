@extends('layout.template')

@section('conteudo')
<div class="col-12">
    <div class="d-flex justify-content-center">

        <form id="form-login" class="col-md-8 col-lg-5 py-3 px-2 p-md-4 bg-white" action="{{ route('login.do') }}" method="POST">
            {{ csrf_field() }}

            <h3 class="display-5">Login</h3>
            <hr>

            <div class="row">
                <div class="form-group col-12">
                    <label class="m-0" for="LOGIN">Usuario</label>
                    <input class="form-control form-control-sm" id="LOGIN" name="LOGIN" type="text" required>
                </div>

                <div class="form-group col-12">
                    <label class="m-0" for="SENHA">Senha</label>
                    <input class="form-control form-control-sm" id="SENHA" name="SENHA" type="password" required>
                </div>

                <div class="form-group col-12 pt-3 m-0">
                    <button type="submit" class="btn btn-sm btn-outline-primary">Entrar</button>
                </div>
            </div>
        </form>

    </div>
</div>

@endsection