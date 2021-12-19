<template>
  <header
    id="app-header"
    class="d-flex justify-content-between align-items-center"
  >
    <h1 class="display-1 m-0">Tarefas</h1>

    <button
      class="btn btn-sm d-flex pt-2"
      @click="() => $emit('resetTask')"
    >
      <i class="fa fa-recycle"></i>
    </button>
  </header>
</template>

<script>
export default {
  name: "Header",
};
</script>

<style lang="scss" scopeed>
#app-header {
  min-height: 80px;
}
</style>