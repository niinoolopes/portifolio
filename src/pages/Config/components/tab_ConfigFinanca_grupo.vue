<template>
  <section>
    <PageContentNav>
        <template v-slot:menu>
          <div class="col-12 col-sm-6 col-lg-4 col-xl-3 p-0 pr-1 mb-2">
            <select class="form-control form-control-sm mb-2 m-sm-0" v-model="FINC_ID">
              <option value="0">Selecione...</option>
              <option v-for="(c,i) in $store.getters.F_CarteirasAtivas" :key="i" :value="c.FINC_ID">{{c.FINC_DESCRICAO}}</option>
            </select>
          </div>
        </template>

        <template v-slot:btn>
          <ButtonplusItem :setItem='setItem' novo='novo' target='FinancaModalGrupo' class='mb-2 mr-1' />
          <ButtongetDados :getDados='getDados' class='mb-2 mr-1' />
        </template>
    </PageContentNav>
  
    <Table colspan='5' :timeTable='time' :itemsTable='itemsTable' >
      <template v-slot:thead>
        <th scope="col">#</th>
        <th scope="col">Descrição</th>
        <th scope="col">Tipo</th>
        <th scope="col">Status</th>
        <th></th>
      </template>
      <template v-slot:tbody>
        <tr v-for="(item,i) in itemsTable" :key="i">
          <th scope="row">{{item.FIGP_ID}}</th>
          <td>{{item.FIGP_DESCRICAO}}</td>
          <td>{{item.FITP_DESCRICAO}}</td>
          <td>{{item.FIGP_STATUS ? 'Ativo' : 'Inativo'}}</td>
          <td>
            <i
              class=" cursor-pointer far fa-file-alt"
              data-toggle="modal" 
              data-target="#FinancaModalGrupo" 
              @click="setItem(item.FIGP_ID)"></i>
          </td>
        </tr>
      </template>
    </Table>

    <Modal modal='modal-lg' :salvar="salvar" :deletar="deletar" :idItem="itemModal.FIGP_ID" :timeModal="time" idModal="FinancaModalGrupo" >
      <Column class="col-12 col-sm-6 col-md-3">
        <label for="form-FINC_ID">Carteira</label>
        <select id="form-FINC_ID" class="form-control form-control-sm mb-2" v-model="itemModal.FINC_ID">
          <option value="">Selecione...</option>
          <option v-for="(c,i) in $store.getters.F_CarteirasAtivas" :key="i" :value="c.FINC_ID">{{c.FINC_DESCRICAO}}</option>
        </select>
      </Column>

      <Column class="col-12 col-sm-6 col-md-3">
        <label for="form-FITP_ID">Tipo</label>
        <select id="form-FITP_ID" class="form-control form-control-sm mb-2" v-model="itemModal.FITP_ID">
          <option value="">Selecione...</option>
          <option v-for="(t,i) in $store.getters.F_TiposAtivos" :key="i" :value="t.FITP_ID">{{t.FITP_DESCRICAO}}</option>
        </select>
      </Column> 

      <Column class="col-12 col-sm-6">
        <label for="form-FIGP_DESCRICAO">Descrição</label>
        <input id="form-FIGP_DESCRICAO" class="form-control form-control-sm" type="text" v-model="itemModal.FIGP_DESCRICAO" >
      </Column>

      <Column class="col-12 m-0">
        <div class="form-group form-check m-0">
          <input id="form-FIGP_STATUS" type="checkbox" class="form-check-input" v-model="itemModal.FIGP_STATUS">
          <label for="form-FIGP_STATUS" class="form-check-label">Grupo {{itemModal.FIGP_STATUS ? 'Ativo' : 'Inativo'}}</label>
        </div>
      </Column>
    </Modal>

  </section>
</template>

<script>
  const empyt_grupo = {
    FIGP_ID: 'novo',
    FIGP_DESCRICAO: '',
    FIGP_STATUS: 1,
    FITP_ID: null,
    FINC_ID: null
  }

  import {mapState} from 'vuex'
  import service from '@/service.js'

  export default {

    components: {
      ButtongetDados: () => import('@/components/Button_getDados'),
      ButtonplusItem: () => import('@/components/Button_plusItemModal'),
      Table:          () => import('@/components/Table'),
      Modal:          () => import('@/components/Modal'),
    },

    computed: { ...mapState(['usuario']) },
    
    data() {
      return {
        time: false,
        grupos: [],
        itemsTable: [],

        FINC_ID: 0,
        btns: true,

        itemModal: {},
      }
    },

    mounted () {
      if( !this.$store.getters.F_CarteiraPainel ){

        this.FINC_ID = this.$store.getters.F_FINC_ID

        if(this.FINC_ID) {
          this.getDados()
          this.btns = 1
        }
      }
    },

    methods: {
      getDados(){
        this.grupos = [];
        this.time = false;

        setTimeout( () => {
          let option = {}
          option.USUA_ID = this.usuario.USUA_ID
          option.FINC_ID = this.FINC_ID

          service.config.financ.grupo.get(option).then( ({STATUS, data, msg}) => {
            if(STATUS == 'success'){
              this.grupos = data
              this.grupos.push(empyt_grupo)
              this.itemsTable = this.grupos.filter( g => g.FIGP_ID != 'novo' )
            }
            this.time = true
          })

        }, service.timeLoading)
      },

      setItem(FIGP_ID){
        
        service.initForm([
          'FIGP_DESCRICAO',
          'FITP_ID',
          'FINC_ID',
        ])

        this.itemModal = this.grupos.filter( i => i.FIGP_ID == FIGP_ID)[0]
      },

      salvar(){
        let data = {}
        data.FIGP_DESCRICAO = this.itemModal.FIGP_DESCRICAO
        data.FIGP_ID        = this.itemModal.FIGP_ID
        data.FIGP_STATUS    = this.itemModal.FIGP_STATUS ? 1 : 0
        data.FITP_ID        = this.itemModal.FITP_ID
        data.FINC_ID        = this.itemModal.FINC_ID

        let option = {}
        option.USUA_ID = this.usuario.USUA_ID
        option.FIGP_ID = this.itemModal.FIGP_ID
        option.data = data

        let checkForm = {}
        checkForm.FINC_ID = this.itemModal.FINC_ID
        checkForm.FITP_ID = this.itemModal.FITP_ID
        checkForm.FIGP_DESCRICAO = this.itemModal.FIGP_DESCRICAO

        setTimeout( () => {
          if(service.checkForm(checkForm)){
            if(this.itemModal.FIGP_ID == 'novo'){
              service.config.financ.grupo.post(option).then( ({STATUS, msg}) => {
                if(STATUS == 'success'){
                  this.$store.commit('SET_MESSAGE',{ active: true, type: 'ok', texto: 'Grupo cadastrado!' }) // message
                  this.getDados()
                }else{
                  this.$store.commit('SET_MESSAGE',{ active: true, type: 'erro', texto: 'Erro ao cadastrar, tente novamente!' }) // message
                }
              })
            } else {
              service.config.financ.grupo.put(option).then( ({STATUS, msg}) => {
                if(STATUS == 'success'){
                  this.$store.commit('SET_MESSAGE',{ active: true, type: 'ok', texto: 'Grupo atualizada!' }) // message
                  this.getDados()
                }else{
                  this.$store.commit('SET_MESSAGE',{ active: true, type: 'erro', texto: 'Erro ao atualizar, tente novamente!' }) // message
                }
              })
            }
            this.$store.dispatch("F_Grupos")
            service.closeModal('FinancaModalGrupo-close')
          }
        }, service.timeLoading)
      },

      deletar(){
        var comfirm = confirm("ao excluir será apagado permanentemente as informações, deseja continuar?")

        if(comfirm){
          let option = {}
          option.FIGP_ID = this.itemModal.FIGP_ID
          
          service.config.financ.grupo.del(option).then( ({STATUS, data, msg}) => {
            if(STATUS == 'success'){
              this.$store.commit('SET_MESSAGE',{ active: true, type: 'ok', texto: 'Grupo excluido!' }) // message
              this.getDados();

            }else{
              this.$store.commit('SET_MESSAGE',{ active: true, type: 'erro', texto: 'Erro ao excluir, tente novamente!' }) // message
            }
          })
        }
        this.$store.dispatch("F_Grupos")
        service.closeModal('FinancaModalGrupo-close')
      }
    },

    watch: {
      'FINC_ID'(newValue, oldValue) {
        if( newValue == 0){
          this.btns = true
          this.itemsTable = []
          this.grupos = []

        }else{
          this.btns = false
          this.getDados()

        }
      }
    },

  }
</script>

<style scoped>

</style>