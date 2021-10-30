@extends('layout.template')

@section('conteudo')


<div class="col-12">
  <ul class="nav nav-tabs" role="tablist">
    <li class="nav-item">
      <a class="nav-link <?= ($tab_form_cadastro != null ? 'active' : '') ?>" data-toggle="tab" href="#form_cadastro">Form Cadastro</a>
    </li>
    <li class="nav-item d-none">
      <a class="nav-link <?= ($tab_form_pedido != null ? 'active' : '') ?>" data-toggle="tab" href="#form_pedido">Form Pedido</a>
    </li>
  </ul>
</div>
<div class="col-12">
  <div class="tab-content">
    <div class="tab-pane fade py-2 <?= ($tab_form_cadastro != null ? 'show active' : '') ?>" id="form_cadastro" role="tabpanel" aria-labelledby="form_cadastro-tab">


      <form action="{{route('config.form.put')}}" class="px-2 py-3 bg-white container-area" method="POST">
        {{ csrf_field() }}
        <div class="row">

          <div class="col-12">
            <label class="d-block m-0">Lista de Vendedores: Selecione um ou mais tipos para aparecer como vendedor.</label>

            <div class="d-flex flex-wrap mb-3 p-2 pt-3 border" style="max-height: 350px; overflow-y: auto;">
              <?php
              if (property_exists($dados_FORM_CADASTRO, 'TIPO_ID')) {
                $TIPO_IDs = $dados_FORM_CADASTRO->TIPO_ID;
              } else {
                $TIPO_IDs = [];
              }
              ?>
              @foreach ($usuario_tipos_enable as $tipo)
              <div class="form-group form-check border mb-2 mr-1 p-2 d-flex align-items-center">
                <input type="checkbox" class="mr-2 cursor-pointer" name="TIPO_ID[]" value="{{$tipo->TIPO_ID}}" id="tipo-{{$tipo->TIPO_ID}}" <?= (in_array($tipo->TIPO_ID, $TIPO_IDs)) ? 'checked' : '' ?>>
                <label class="form-check-label cursor-pointer" for="tipo-{{$tipo->TIPO_ID}}">{{$tipo->TIPO_NOME}}</label>
              </div>
              @endforeach
            </div>
          </div>


          <div class="col-12 col-md-4">
            <label class="m-0" for="N_ATENDIMENTO">Campo: 'N Atendimento'</label>
            <div class="form-group form-check mb-3">
              <?php
              if (property_exists($dados_FORM_CADASTRO, 'N_ATENDIMENTO')) {
                $checked = $dados_FORM_CADASTRO->N_ATENDIMENTO ? 'checked' : '';
              } else {
                $checked = '';
              }
              ?>
              <input <?= $checked ?> input-status='N_ATENDIMENTO' data-text-ativo='Campo obrigatório' data-text-inativo='Campo opcional' type="checkbox" class="form-check-input" id="N_ATENDIMENTO" name="N_ATENDIMENTO">
              <label label-status='N_ATENDIMENTO' class="form-check-label" for="N_ATENDIMENTO">{{$checked == '' ? 'Campo opcional' : 'Campo obrigatório'}}</label>
            </div>
          </div>

          <div class="col-12 col-md-4">
            <label class="m-0" for="VALOR">Campo: 'Valor'</label>
            <div class="form-group form-check mb-3">
              <?php
              if (property_exists($dados_FORM_CADASTRO, 'VALOR')) {
                $checked = $dados_FORM_CADASTRO->VALOR ? 'checked' : '';
              } else {
                $checked = '';
              }
              ?>
              <input <?= $checked ?> input-status='VALOR' data-text-ativo='Campo obrigatório' data-text-inativo='Campo opcional' type="checkbox" class="form-check-input" id="VALOR" name="VALOR">
              <label label-status='VALOR' class="form-check-label" for="VALOR">{{$checked == '' ? 'Campo opcional' : 'Campo obrigatório'}}</label>
            </div>
          </div>

          <div class="col-12 col-md-4">
            <label class="m-0" for="DATA">Campo: 'Data'</label>
            <div class="form-group form-check mb-3">
              <?php
              if (property_exists($dados_FORM_CADASTRO, 'DATA')) {
                $checked = $dados_FORM_CADASTRO->DATA ? 'checked' : '';
              } else {
                $checked = '';
              }
              ?>
              <input <?= $checked ?> input-status='DATA' data-text-ativo='Campo obrigatório' data-text-inativo='Campo opcional' type="checkbox" class="form-check-input" id="DATA" name="DATA">
              <label label-status='DATA' class="form-check-label" for="DATA">{{$checked == '' ? 'Campo opcional' : 'Campo obrigatório'}}</label>
            </div>
          </div>

          <div class="col-12 col-md-4">
            <label class="m-0" for="BANCO">Campo: 'Banco'</label>
            <div class="form-group form-check mb-3">
              <?php
              if (property_exists($dados_FORM_CADASTRO, 'BANCO')) {
                $checked = $dados_FORM_CADASTRO->BANCO ? 'checked' : '';
              } else {
                $checked = '';
              }
              ?>
              <input <?= $checked ?> input-status='BANCO' data-text-ativo='Campo obrigatório' data-text-inativo='Campo opcional' type="checkbox" class="form-check-input" id="BANCO" name="BANCO">
              <label label-status='BANCO' class="form-check-label" for="BANCO">{{$checked == '' ? 'Campo opcional' : 'Campo obrigatório'}}</label>
            </div>
          </div>

          <div class="col-12 col-md-4">
            <label class="m-0" for="COMPROVANTE">Campo: 'Comprovante'</label>
            <div class="form-group form-check mb-3">
              <?php
              if (property_exists($dados_FORM_CADASTRO, 'COMPROVANTE')) {
                $checked = $dados_FORM_CADASTRO->COMPROVANTE ? 'checked' : '';
              } else {
                $checked = '';
              }
              ?>
              <input <?= $checked ?> input-status='COMPROVANTE' data-text-ativo='Campo obrigatório' data-text-inativo='Campo opcional' type="checkbox" class="form-check-input" id="COMPROVANTE" name="COMPROVANTE">
              <label label-status='COMPROVANTE' class="form-check-label" for="COMPROVANTE">{{$checked == '' ? 'Campo opcional' : 'Campo obrigatório'}}</label>
            </div>
          </div>


        </div>
        <div class="form-group pt-3 m-0">
          <button type="submit" class="btn btn-sm btn-outline-primary">Salvar</button>
        </div>

      </form>
    </div>

    <div class="tab-pane fade py-2 <?= ($tab_form_pedido != null ? 'show active' : '') ?>" id="form_pedido" role="tabpanel" aria-labelledby="form_pedido-tab">
      b
    </div>
  </div>
</div>


@endsection