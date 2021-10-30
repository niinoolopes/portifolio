<section class="p-2 p-md-3 border shadow bg-white overflow-auto">
  <table class="table table-sm table-hover">
    <thead>
      <tr>
        <th scope="col">#</th>
        <th scope="col">Nome</th>
        <th scope="col">Sobrenome</th>
        <th scope="col">Idade</th>
        <th scope="col">Sexo</th>
        <th></th>
        <th></th>
      </tr>
    </thead>
    <tbody>
      @forelse ($usuarios as $usuario)
        <tr>
          <th scope="row">{{$usuario->USUARIO_ID}}</th>
          <td>{{$usuario->USUARIO_NOME}}</td>
          <td>{{$usuario->USUARIO_SOBRENOME}}</td>
          <td>{{ date('d/m/Y', strtotime($usuario->USUARIO_DATA_NASCIMENTO)) }}</td>
          <td>{{$usuario->USUARIO_SEXO == 'M' ? 'Masculino' : 'Feminino'}}</td>
          
          <td>
            <a href="{{ route('usuario.edit', [ 'id' => $usuario->USUARIO_ID ]) }}" class="d-flex justify-content-center align-items-center">
              <button class="btn btn-sm border-0 py-0">
                <i class="text-muted fas fa-user-edit"></i>
              </button>
            </a>
          </td>
          <td>
            <a class="d-flex justify-content-center align-items-center">
              <button class="btn btn-sm border-0 py-0" data-toggle="modal" data-target="#usuario-{{ $usuario->USUARIO_ID }}">
                <i class="text-muted fas fa-user-cog"></i>
              </button>
            </a>
          </td>
        </tr>
      @empty
        <tr>
          <td colspan="6">Nâo existe Usuários cadastrados.</td>
        </tr>
      @endforelse
    </tbody>
  </table>

  @foreach ($usuarios as $usuario)
    <div class="modal fade" id="usuario-{{ $usuario->USUARIO_ID }}" tabindex="-1">
      <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">

          <div class="modal-header p-2">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>

          <div class="modal-body">
            <p>Nome: <strong>{{$usuario->USUARIO_NOME}}</strong></p>
            <p>Sobrenome: <strong>{{$usuario->USUARIO_SOBRENOME}}</strong></p>
            <p>Data Nasc.: <strong>{{date('d/m/Y', strtotime($usuario->USUARIO_DATA_NASCIMENTO))}}</strong></p>
            <p class="m-0">Sexo: <strong>{{$usuario->USUARIO_SEXO == 'M' ? 'Masculino' : 'Femenino'}}</strong></p>
          </div>

          <div class="modal-footer">
            <button type="button" class="btn btn-sm btn-secondary py-0" data-dismiss="modal">Close</button>
          </div>

        </div>
      </div>
    </div>
  @endforeach

</section>
