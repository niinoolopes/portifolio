<main class="col-12 col-md-9 p-2 p-md-3">

  @if( session()->get('alert') !== null )
    <div class="alert alert-{{ session()->get('alert')['type']}} alert-success alert-dismissible fade show" role="alert">
      <strong>Mensagem: </strong> {{ session()->get('alert')['msg']}}
    </div>
  @endif

@include($main)

</main>