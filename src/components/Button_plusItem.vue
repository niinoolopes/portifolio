<template>
  <button 
    type="button" 
    class="div-btn btn-hover btn btn-sm btn-outline-info py-0 d-flex justify-content-center align-items-center"
    @click="add('ID')"
  >
    <i class="fas fa-plus"></i>
  </button>
</template>

<script>
  export default {
    props:['ID', 'add']
  }
</script>