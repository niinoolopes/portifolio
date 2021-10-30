<template>
  <button 
    type="button" 
    class="div-btn btn-hover btn btn-sm btn-outline-info py-0 d-flex justify-content-center align-items-center"
    data-toggle="modal" :data-target="`#${target}`" 
    @click="setItem('novo')"
  >
    <i class="fas fa-plus"></i>
  </button>
</template>

<script>
  export default {
    props:['target', 'novo', 'setItem']
  }
</script>