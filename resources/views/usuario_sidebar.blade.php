<div class="list-group">
  <a href="{{ route('usuario.lista') }}" class="py-2 list-group-item list-group-item-action {{$routeName == 'usuario.lista' ? 'active' : ''}}">
    <i class="fas fa-list-alt mr-1"></i>
    Lista
  </a>
  <a href="{{ route('usuario.add') }}" class="py-2 list-group-item list-group-item-action {{$routeName == 'usuario.add' ? 'active' : ''}}">
    <i class="far fa-address-card mr-1"></i>
    Cadastrar
  </a>
</div>
