@include('commons.header')

<main class="container">
    <div class="row align-content-start">
     
        @if( isset($_msg) && $_msg != false ) 
            <div class="col-12">
                <div class="alert alert-<?= $_msg['tipo']?> alert-dismissible fade show" role="alert">
                <strong>MENSAGEM:</strong> <?= $_msg['text']?>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                </div>
            </div>
        @endif

        @yield('conteudo')
    </div>
</main>

@include('commons.footer')