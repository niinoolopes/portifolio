<template>
  <div id="app-filter-actions" class="btn-group mb-2">
    <button
      type="button"
      :disabled="tasksEmpty"
      :class="css('enable')"
      @click="() => onClickFilter('enable')"
    >
      Abertas
    </button>
    <button
      type="button"
      :disabled="tasksEmpty"
      :class="css('disable')"
      @click="() => onClickFilter('disable')"
    >
      Concluidas
    </button>
    <button
      type="button"
      :disabled="tasksEmpty"
      :class="css('all')"
      @click="() => onClickFilter('all')"
    >
      Todas
    </button>
  </div>
</template>

<script>
export default {
  name: "TaskFilter",

  computed: {
    getFilter() {
      return this.$store.getters.getFilter;
    },
    tasksEmpty() {
      return this.$store.getters.getTasks.length === 0;
    },
  },

  methods: {
    css(type) {
      const cssActive =
        this.getFilter === type
          ? "btn-secondary active"
          : "btn-outline-secondary";

      return `btn btn-sm py-1 ${cssActive}`;
    },
    onClickFilter(type) {
      this.$store.dispatch("setFilterTask", type);
    },
  },
};
</script>

<style lang="scss" scopeed>
#app-filter-actions {
  opacity: 1;
}
</style>