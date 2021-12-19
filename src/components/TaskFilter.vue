<template>
  <div class="mb-2">
    <button
      class="btn btn-sm"
      :class="filterActive === 1 ? 'btn-secondary' : ''"
      @click="() => $emit('onClickFilter', 1)"
    >
      Abertas
    </button>
    <button
      class="btn btn-sm"
      :class="filterActive === 2 ? 'btn-secondary' : ''"
      @click="() => $emit('onClickFilter', 2)"
    >
      Concluidas
    </button>
    <button
      class="btn btn-sm"
      :class="filterActive === 3 ? 'btn-secondary' : ''"
      @click="() => $emit('onClickFilter', 3)"
    >
      Todas
    </button>
  </div>
</template>

<script>
export default {
  name: "TaskFilter",

  props: {
    filterActive: {
      type: Number,
      required: true,
    },
  },
};
</script>