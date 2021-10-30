<section class="p-2 p-md-3 border shadow bg-white">
  <form method="post" action="{{$form_action}}">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">


    <div class="row">
      <div class="col-12 col-md-4 col-xl-3">
        <div class="form-group">
          <label for="USUARIO_NOME">Nome</label>
          <input type="text" class="form-control form-control-sm" id="USUARIO_NOME" name="USUARIO_NOME" placeholder="Nome" required 
            value="{{$action == 'edit' ? $usuario->USUARIO_NOME : ''}}">
        </div>
      </div>

      <div class="col-12 col-md-4 col-xl-3">
        <div class="form-group">
          <label for="USUARIO_SOBRENOME">Segundo Nome</label>
          <input type="text" class="form-control form-control-sm" id="USUARIO_SOBRENOME" name="USUARIO_SOBRENOME" placeholder="Sobrenome" required
            value="{{$action == 'edit' ? $usuario->USUARIO_SOBRENOME : ''}}">
        </div>
      </div>

      <div class="col-12 col-md-4 col-xl-3">
        <div class="form-group">
          <label for="USUARIO_DATA_NASCIMENTO">Data Nasc.</label>
          <input type="date" class="form-control form-control-sm" id="USUARIO_DATA_NASCIMENTO" name="USUARIO_DATA_NASCIMENTO" max="{{ date('Y-m-d') }}" required
          value="{{$action == 'edit' ? $usuario->USUARIO_DATA_NASCIMENTO : ''}}">
        </div>
      </div>

      <div class="col-12 col-md-4 col-xl-3">
        <div class="form-group">
          <label for="USUARIO_SEXO">Sexo</label>
          <select class="form-control form-control-sm" id="USUARIO_SEXO" name="USUARIO_SEXO" required>
            <option value="">Selecione</option>
            <option value="M" {{$action == 'edit' && $usuario->USUARIO_SEXO == 'M' ? 'selected' : ''}} >Masculino</option>
            <option value="F" {{$action == 'edit' && $usuario->USUARIO_SEXO == 'F' ? 'selected' : ''}} >Feminino</option>
          </select>
        </div>
      </div>
    </div>
    
    <button type="submit" class="btn btn-sm btn-outline-primary py-0">Salvar</button>
    @if($action == 'edit')
    <a class="btn btn-sm btn-outline-danger py-0" href="{{ $form_delete }}">Excluir</a>
    @endif
  </form>

</section>