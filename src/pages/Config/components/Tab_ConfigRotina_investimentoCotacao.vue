<template>
  <section>

  <div class="d-flex">
    <Column class="col-12 col-xl-10">
      <label class="m-0" for="form-FNIT_OBS"><small>Link Planilha Google</small></label>
      <textarea class="form-control form-control-sm" id="form-PLANILHA-COTACAO" v-model="item.CNFG_VALOR" rows="3" ></textarea>
      <ButtonSalvar class='mt-1' :salvar='salvarLink' disabled="false" />
    </Column>
  </div>

  <div class="d-flex">
    <Column class="col-12 col-xl-10">
      <label class="m-0"><small>Ultimas Execuções</small></label>
      <Table colspan='3' :timeTable='false' :itemsTable='[]' >
        <template v-slot:thead>
        </template>
        <template v-slot:tbody>
        </template>
      </Table>
    </Column>
  </div>

  </section>
</template>

<script>
import service from "@/service.js"

export default {

  components: {
    ButtonSalvar: () => import('@/components/Button_salvar'),
    Table: () => import('@/components/Table'),
  },

  data() {
    return {
      timeTable: false,
      itemsTable: [],
      invCotacaoDescricao: 'inv-cotacao-link-planilha',
      invCotacaoValor: '',

      item: {
        CNFG_ID: 'novo',
        CNFG_DESCRICAO: "inv-cotacao-link-planilha",
        CNFG_VALOR: "",
        CNFG_STATUS: 1,
        USUA_ID: 1,
      }
    }
  },

  mounted () {
    this.getDados()
  },

  methods: {
    getDados(){
      // this.time = false;
      // this.items = []

      setTimeout(() => {

        service.config.configuracao.get({
          USUA_ID: this.$store.getters.USUA_ID,
          CNFG_DESCRICAO: this.item.CNFG_DESCRICAO
        })
        .then(({ STATUS, data, msg }) => {

          if (STATUS == "success") { 
            if(data.length > 0){
              this.item = data[0]
            }

          } else if (STATUS == "error") {
            this.$store.commit('SET_MESSAGE', { active: true, type: "erro", texto: msg });

          } else if (STATUS == "token") {
            this.$store.commit('SET_MESSAGE', { active: true, type: "erro", texto: service.arrMessage, });
            this.$store.commit("SET_LOGIN", false);

          }

          // this.time = true;
        });
      }, service.timeLoading);
    },

    salvarLink() {

      let data = {}
        data.CNFG_ID        = this.item.CNFG_ID
        data.CNFG_DESCRICAO = this.item.CNFG_DESCRICAO
        data.CNFG_STATUS    = this.item.CNFG_STATUS
        data.CNFG_VALOR     = this.item.CNFG_VALOR
        data.USUA_ID        = this.item.USUA_ID

      let option = {}
        option.USUA_ID = this.$store.getters.USUA_ID
        option.CNFG_ID = this.item.CNFG_ID
        option.data = data


      setTimeout(() => {
        if(this.item.CNFG_ID == 'novo'){
          
          service.config.configuracao.post(option).then(({ STATUS, data, msg }) => {
            if (STATUS == "success") { 
              this.$store.commit('SET_MESSAGE',{ active: true, type: 'ok', texto: 'Variavel Cadastrada!' }) // message
  
            } else if (STATUS == "error") {
              this.$store.commit('SET_MESSAGE', { active: true, type: "erro", texto: msg });
  
            } else if (STATUS == "token") {
              this.$store.commit('SET_MESSAGE', { active: true, type: "erro", texto: service.arrMessage, });
              this.$store.commit("SET_LOGIN", false);
  
            }
          });
        } else {
          
          service.config.configuracao.put(option).then(({ STATUS, data, msg }) => {
            if (STATUS == "success") { 
              this.$store.commit('SET_MESSAGE',{ active: true, type: 'ok', texto: 'Variavel Atualizada!' }) // message
  
            } else if (STATUS == "error") {
              this.$store.commit('SET_MESSAGE', { active: true, type: "erro", texto: msg });
  
            } else if (STATUS == "token") {
              this.$store.commit('SET_MESSAGE', { active: true, type: "erro", texto: service.arrMessage, });
              this.$store.commit("SET_LOGIN", false);
  
            }
          });

        }

        this.getDados();

      }, service.timeLoading);
      
    }
  },
};
</script>
