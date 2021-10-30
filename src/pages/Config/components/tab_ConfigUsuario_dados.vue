<template>
  <form class="opacity-fetch" :class="time ? '' : 'opacity-fetch-active'">
    <div class="row">

      <div class="px-1 px-md-3 mb-2 form-group col-12 col-lg-3">
        <label for="form-USUA_NOME">Nome</label>
        <input class="form-control form-control-sm" type="text" id="form-USUA_NOME" v-model="dadosUsuario.USUA_NOME">
      </div>

      <div class="px-1 px-md-3 mb-2 form-group col-12 col-lg-3">
        <label for="form-USUA_EMAIL">Email</label>
        <input class="form-control form-control-sm" type="email" id="form-USUA_EMAIL" v-model="dadosUsuario.USUA_EMAIL">
      </div>
      
      <div class="px-1 px-md-3 mb-2 col-12 col-lg-3">
        <label for="form-USUA_SENHA">Senha</label>
        <input class="form-control form-control-sm" type="password" id="form-USUA_SENHA" v-model="dadosUsuario.USUA_SENHA"
          placeholder="Alterar Senha">
      </div>

    </div>

    <hr>

    <ButtonSalvar :salvar='salvar' disabled="false" />
  </form>
</template>

<script>
  import service from "@/service.js"

  export default {

    components: {
      ButtonSalvar: () => import('@/components/Button_salvar'),
    },

    data() {
      return {
        time: true,
        dadosUsuario: {},
      }
    },

    created () {
      this.dadosUsuario.USUA_ID    = this.$store.state.usuario.USUA_ID 
      this.dadosUsuario.USUA_NOME  = this.$store.state.usuario.USUA_NOME
      this.dadosUsuario.USUA_EMAIL = this.$store.state.usuario.USUA_EMAIL
    },

    methods: {
      salvar() {
        this.time = false

        let data = {}
        data.USUA_NOME  = this.dadosUsuario.USUA_NOME
        data.USUA_EMAIL = this.dadosUsuario.USUA_EMAIL
        if(this.dadosUsuario.USUA_SENHA) 
          data.USUA_SENHA = this.dadosUsuario.USUA_SENHA

        let option = {}
        option.USUA_ID = this.dadosUsuario.USUA_ID
        option.data = data

        let checkForm = {}
        checkForm.USUA_NOME  = this.dadosUsuario.USUA_NOME
        checkForm.USUA_EMAIL = this.dadosUsuario.USUA_EMAIL

        setTimeout( () => {
          if(service.checkForm(checkForm)){

            service.config.usua.dados.put(option)
            .then( ({STATUS, data, msg}) => {

              if(STATUS == 'success'){
                this.$store.commit("SET_USUARIO", data);
                this.$store.commit('SET_MESSAGE',{ active: true, type: 'ok', texto: 'Dados atualizados!' }) // message
                service.initForm([
                  'USUA_NOME',
                  'USUA_EMAIL',
                ])

              }
              else if (STATUS == "erro") {
                this.$store.commit('SET_MESSAGE', { active: true, type: "erro", texto: msg });
              } 
              else if (STATUS == "token") {
                this.$store.commit('SET_MESSAGE', { active: true, type: "erro", texto: service.arrMessage, });
                this.$store.commit("SET_LOGIN", false);
              }

            })

            this.time = true
          }
        }, service.timeLoading)
      },

    }
  }
</script>

<style scoped>

</style>