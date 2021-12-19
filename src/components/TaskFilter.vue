<template>
  <div id="app-filter-actions" class="btn-group mb-2">
    <button
      type="button"
      :disabled="tasksEmpty"
      :class="css(1)"
      @click="() => $emit('onClickFilter', 1)"
    >
      Abertas
    </button>
    <button
      type="button"
      :disabled="tasksEmpty"
      :class="css(2)"
      @click="() => $emit('onClickFilter', 2)"
    >
      Concluidas
    </button>
    <button
      type="button"
      :disabled="tasksEmpty"
      :class="css(3)"
      @click="() => $emit('onClickFilter', 3)"
    >
      Todas
    </button>
  </div>

  <!-- <div class="mb-2">
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
  </div> -->
</template>

<script>
export default {
  name: "TaskFilter",

  props: {
    filterActive: {
      type: Number,
      required: true,
    },
    tasksEmpty: {
      type: Boolean,
      required: true,
    }
  },

  methods: {
    css(type) {
      const cssActive =
        this.filterActive === type
          ? "btn-secondary active"
          : "btn-outline-secondary";
      return `btn btn-sm py-1 ${cssActive}`;
    },
  },
};
</script>

<style lang="scss" scopeed>
#app-filter-actions {
  opacity: 1;
}
</style>