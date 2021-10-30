<template>
  <section class="w-100">

    <!--
    <PageContentNav>
      <template v-slot:menu></template>
      <template v-slot:btn></template>
    </PageContentNav> 
    -->

    <PageContentFiltro 
      :changeBusca='changeBusca'
      :camposBusca='camposBusca'
      :camposBuscaBoolean='camposBuscaBoolean'
      :btn_getDados='getDados'
      :btn_plus='{
        tipo: `modal`,
        target: `InvestimentoModal-Rendimento`,
        novo: `novo`,
        setItem: setItem
      }'
    />

    <PageSection>
      <FiltroRendimento :itemsFiltro='itemsFiltro' :setFiltro='setFiltro' />

      <TableRendimento :items="itemsTable" :time="time" :setItem="setItem" />
    </PageSection>

    <ModalRendimento :INAR="INAR" :setItem="setItem" />

  </section>
</template>

<script>
  import service from '@/service.js'

  export default {
    props: ['INAV_ID'],

    components: { 
      PageContentFiltro: () => import('@/components/PageContent_filtroBusca'),
      FiltroRendimento:  () => import('@/pages/Investimento/components/Section_filtro_rendimento'),
      TableRendimento:   () => import('@/pages/Investimento/components/Table_Rendimento'),
      ModalRendimento:   () => import('@/pages/Investimento/components/Modal_Rendimento'),
    },

    data() {
      return {
        INAR : 'init',
        camposBuscaBoolean : false,
        camposBusca: {
          itemsTipo: false,
          tipo: 'mes',
          limit: '',
          dataDe: '',
          dataAte: '',
        },
        itemsFiltro: [],
        camposFiltro: {},
        time: false,
        items: [],
        itemsTable: [],
      }
    },

    mounted () {
      if( !this.$store.getters.I_CarteiraPainel ){
        setTimeout(() => { this.getDados() }, service.timeLoading);
      }
    },

    methods: {
      makeUrl() {
        var url = ''
        url += 'lista';
        url += `?usuario=${this.$store.getters.USUA_ID}`;
        url += `&INCT_ID=${this.$store.getters.I_INCT_ID}`;
        url += `&INAV_ID=${this.INAV_ID}`;
        url += `&INAR_STATUS=1`;
        url += `&retorno=I_rendimento`;
        url += `&dataDe=${this.camposBusca.dataDe}`;
        url += `&dataAte=${this.camposBusca.dataAte}`;
        url += `&limit=${this.camposBusca.limit}`;
        url += `&orderby=INAR_DATA:DESC`;
        return url
      },

      getDados(){
        this.time = false
        this.items = [];
        this.itemsTable = 'init';

        setTimeout( () => {
          service.busca( this.makeUrl() )
          .then( ({STATUS, data, msg}) => {
            if(STATUS == 'success'){
              var {items, itemsFiltro, dataDe, dataAte, limit} = data.I_rendimento
              this.items = items
              this.itemsTable = items
              this.itemsFiltro = itemsFiltro
              if(limit) this.camposBusca.limit = limit
              if(dataDe) this.camposBusca.dataDe = dataDe
              if(dataAte) this.camposBusca.dataAte = dataAte

            }
            else if(STATUS == 'error'){
              this.$store.commit('SET_MESSAGE',{ active: true, type: 'erro', texto: msg })
            }
            else if(STATUS == 'token'){
              this.$store.commit('SET_MESSAGE',{ active: true, type: 'erro', texto: service.arrMessage })
              this.$store.commit('SET_LOGIN', false);
            }
            this.time = true
          })
        }, service.timeLoading)

      },

      changeBusca(objBusca){
        this.camposBusca = objBusca;
        this.getDados()
      },

      // FILTRO ITEMS
      setFiltro(campos) {
        this.itemsTable = service.invest.filtroRendimentos(campos, this.items)
      },

      clearFiltro() {
        this.itemsTable   = this.items
      },

      // MODAL 
      setItem(INAR){
        this.INAR = INAR
        if(INAR == 'getDados') this.getDados()
      },
    },

    watch: {
      '$store.getters.I_INCT_ID'(newValue, oldValue) {
        this.getDados()
      },
      '$store.getters.Periodo'(newValue, oldValue) {
        this.getDados()
      },
    },
  }
</script>