<template>
  <button 
    type="button" 
    class="div-btn btn-hover btn btn-sm btn-outline-info py-0 my-0 d-flex justify-content-center align-items-center" 
    :style="styles"
    @click="limpar()"
  >
    <i class="fas fa-broom"></i>
  </button>
</template>

<script>
  export default {
    props:['disabled', 'limpar'],

    data() {
      return {
        styles: {pointerEvents: 'all'}
      }
    },

    mounted () {
      let pointerEvents = 'all'
      if(this.disabled === undefined) pointerEvents = 'all'
      if(this.disabled === false    ) pointerEvents = 'all'
      if(this.disabled === true     ) pointerEvents = 'none'

      this.styles.pointerEvents = pointerEvents
    },
  }
</script>