<template>
  <header class="text-center text-white">

    <h1 class="py-3 py-md-4 m-0">
      {{ strNome }}
    </h1>

    <hr class="border-top-1 my-0">
    
    <h2 class="py-1 py-md-2 m-0 font-weight-light font-italic" id="crm-modulo">
      NN-CRM
    </h2>

  </header>
</template>

<script>
  export default {
    name: 'Sidnav_header',

    data() {
      return {
        strNome: ''
      }
    },

    mounted () {
      this.getName();
    },

    methods: {
      getName() {
        if(!this.$store.state.login) {
          this.strNome = ''

        } else {

          var nome = this.$store.state.usuario.USUA_NOME
          var nomeSplit = nome.split(' ')
          var tmp = '';
          

          for( var i = 0 ; i <= nomeSplit.length -1; i++){
            if(i == 1) tmp += ' ';
            tmp += nomeSplit[i];
            if(i == 1) break;
          }
          
          this.strNome = tmp
        }
      }
    },

    watch: {
      '$store.state.login'(newValue, oldValue) {
        this.getName()
      },
      '$store.state.usuario.USUA_NOME'(newValue, oldValue) {
        this.getName()
      },
      '$store.state.usuario.USUA_NOME_SOBRENOME'(newValue, oldValue) {
        this.getName()
      },
    },
  }
</script>

<style scoped>
  h1 {
    font-size: 24px;
  }

  h2 {
    font-size: 16px;
  }

  hr {
    background: rgba(255,255,255, 0.50)
  }
</style>