<template>
  <section>

    <PageContentNav>
        <!-- <template v-slot:menu> </template> -->

        <template v-slot:btn>
          <ButtonplusItem :setItem='setItem' novo='novo' target='CofreModalCarteira' class='mb-2 mr-1' />
          <ButtongetDados :getDados='getDados' class='mb-2 mr-1' />
        </template>
    </PageContentNav>
    
    
    <Table colspan='5' :timeTable='time' :itemsTable='itemsTable' >
      <template v-slot:thead>
        <th scope="col">#</th>
        <th scope="col">Descrição</th>
        <th scope="col">Status</th>
        <th scope="col">Painel</th>
        <th></th>
      </template>
      <template v-slot:tbody>
        <tr v-for="(tr,i) in itemsTable" :key="i">
          <th scope="row">{{tr.COCT_ID}}</th>
          <td>{{tr.COCT_DESCRICAO}}</td>
          <td>{{tr.COCT_STATUS == 1? 'Ativa' : 'Inativa'}}</td>
          <td>{{tr.COCT_PAINEL == 1? 'x' : ''}}</td>
          <td>
            <i class=" cursor-pointer far fa-file-alt"
              data-toggle="modal" 
              data-target="#CofreModalCarteira" 
              @click="setItem(tr.COCT_ID)"></i>
          </td>
        </tr>
      </template>
    </Table>
    
    <Modal modal='modal-lg' :salvar="salvar" :deletar="deletar" :idItem="itemModal.COCT_ID" :timeModal="time" idModal="CofreModalCarteira" >
      <Column class="form-group col-12">
        <label for="form-COCT_DESCRICAO">Descrição</label>
        <input id="form-COCT_DESCRICAO" class="form-control form-control-sm" type="text" v-model="itemModal.COCT_DESCRICAO" >
      </Column>
      
      <Column class="form-group col-12" v-if="itemModal.COCT_ID != 'novo'">
        <div class="form-group form-check m-0">
          <input id="COCT_STATUS" type="checkbox" class="form-check-input" v-model="itemModal.COCT_STATUS">
          <label for="COCT_STATUS" class="form-check-label">Carteira {{itemModal.COCT_STATUS ? 'Ativo' : 'Inativo'}}</label>
        </div>
      </Column>
      
      <Column class="form-group col-12" v-if="itemModal.COCT_ID != 'novo'">
        <div class="form-group form-check m-0">
          <input id="COCT_PAINEL" type="checkbox" class="form-check-input" v-model="itemModal.COCT_PAINEL">
          <label for="COCT_PAINEL" class="form-check-label">Carteira {{itemModal.COCT_PAINEL ? 'principal' : 'não principal'}}</label>
        </div>
      </Column>
    </Modal>
    
  </section>
</template>

<script>
  const empyt_carteira = {
    COCT_ID: 'novo',
    COCT_DESCRICAO: '',
    COCT_PAINEL: 0,
    COCT_STATUS: 1,
    USUA_ID: '',
  }

  import {mapState} from 'vuex';
  import service from '@/service.js'
  
  export default {

    components: {
      ButtongetDados: () => import('@/components/Button_getDados'),
      ButtonplusItem: () => import('@/components/Button_plusItemModal'),
      Modal:          () => import('@/components/Modal'),
      Table:          () => import('@/components/Table'),
    },

    computed: { ...mapState(['usuario']) },

    data() {
      return {
        items: [],
        itemsTable: [],
        itemModal: {},

        time: false,
        carteiras: [],
      }
    },

    created () {
      this.getDados()
    },

    methods: {
      getDados(commit = false){
        this.items      = []
        this.itemsTable = []
        this.time = false

        setTimeout( () => {
          var options = {};
          options.USUA_ID = this.$store.getters.USUA_ID;

          service.config.cofre.carteira.get(options).then( ({STATUS, data, msg}) => {
            
            if(STATUS == 'success'){
              var items = data
              items.push(empyt_carteira)
              this.items      = items
              this.itemsTable = items.filter( c => c.COCT_ID != 'novo' )


              if(commit && this.itemsTable.length > 0) {
                // atualiza COFRE CARTEIRA no state
                this.$store.commit('COFRE_CARTEIRA', this.itemsTable);

                // atualiza COFRE COCT_ID no state
                let carteiras = this.itemsTable
                let carteiraPainel = carteiras.filter( c => c.COCT_PAINEL )
                let COCT_ID = (carteiraPainel.length > 0) ? carteiraPainel[0].COCT_ID : 0
                this.$store.commit('COFRE_ID', COCT_ID);
              }

            }
            else if(STATUS == 'erro'){
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
      
      setItem(COCT_ID){

        service.initForm([
          "COCT_DESCRICAO",
        ])

        this.itemModal = this.items.filter( i => i.COCT_ID == COCT_ID)[0]
      },

      salvar(){
        let data = {}
        data.COCT_ID        = this.itemModal.COCT_ID
        data.COCT_DESCRICAO = this.itemModal.COCT_DESCRICAO
        data.COCT_PAINEL    = this.itemModal.COCT_PAINEL ? 1 : 0
        data.COCT_STATUS    = this.itemModal.COCT_STATUS ? 1 : 0
        data.USUA_ID        = this.$store.getters.USUA_ID


        let option = {}
        option.USUA_ID = this.$store.getters.USUA_ID
        option.COCT_ID = this.itemModal.COCT_ID
        option.data = data

        let checkForm = {}
        checkForm.COCT_DESCRICAO = this.itemModal.COCT_DESCRICAO

        setTimeout( () => {
          if(service.checkForm(checkForm)){

            if(this.itemModal.COCT_ID == 'novo'){
              service.config.cofre.carteira.post(option).then( ({STATUS, msg}) => {
                if(STATUS == 'success'){
                  this.$store.commit('SET_MESSAGE',{ active: true, type: 'ok', texto: 'Carteira cadastrado!' }) // message
                  this.getDados(true)
                }
                else if(STATUS == 'erro'){
                  this.$store.commit('SET_MESSAGE',{ active: true, type: 'erro', texto: msg })
                }
                else if(STATUS == 'token'){
                  this.$store.commit('SET_MESSAGE',{ active: true, type: 'erro', texto: service.arrMessage })
                  this.$store.commit('SET_LOGIN', false);
                }
              })
            } 
            else {
              service.config.cofre.carteira.put(option).then( ({STATUS, msg}) => {
                if(STATUS == 'success'){
                  this.$store.commit('SET_MESSAGE',{ active: true, type: 'ok', texto: 'Carteira atualizada!' }) // message
                  this.getDados(true)
                }
                else if(STATUS == 'erro'){
                  this.$store.commit('SET_MESSAGE',{ active: true, type: 'erro', texto: msg })
                }
                else if(STATUS == 'token'){
                  this.$store.commit('SET_MESSAGE',{ active: true, type: 'erro', texto: service.arrMessage })
                  this.$store.commit('SET_LOGIN', false);
                }
              })
            }
        //     this.$store.dispatch("F_Carteiras")
            service.closeModal('CofreModalCarteira-close')
          }
        }, service.timeLoading)
      },

      deletar(){
        var comfirm = confirm("ao excluir será apagado permanentemente as informações, deseja continuar?")

        if(comfirm){
          let option = { FINC_ID: this.itemModal.FINC_ID }
          service.config.financ.carteira.del(option).then( ({STATUS, data, msg}) => {
            if(STATUS == 'success'){
              this.$store.commit('SET_MESSAGE',{ active: true, type: 'ok', texto: 'Carteira excluido!' }) // message
              this.getDados();

            }else{
              this.$store.commit('SET_MESSAGE',{ active: true, type: 'erro', texto: 'Erro ao excluir, tente novamente!' }) // message
            }
          })
        }
        this.$store.dispatch("F_Carteiras")
        service.closeModal('InvestimentoModalCarteira-close')
      }
    },  
  }
</script>