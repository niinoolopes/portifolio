@extends('layout.template')

@section('conteudo')

<div class="col-12">
    <div class="row">

        @foreach ($pages as $key => $page)
        <div class="col-6 col-md-4 col-lg-3 px-2 mb-3">
            <div class="card config-card m-auto" style="width: 18rem;">
                <div class="config-card-img bg-light pt-4 d-flex justify-content-center align-items-center flex-column">
                    <span class="fa fa-5x fa-{{ $page->ICONE }} {{ $key == 0 ? 'ml-4' : '' }}"></span>
                    <h5 class="mt-2">{{ $page->NOME }}</h5>
                </div>
                <div class="card-body py-3">
                    <p class="card-text mb-2" style="min-height: 45px">{{ $page->DESCRICAO }}</p>
                    <a href="{{ $page->LINK }}" class="m-0 btn btn-sm btn-primary">Ver mais</a>
                </div>
            </div>
        </div>
        @endforeach

    </div>
</div>


@endsection