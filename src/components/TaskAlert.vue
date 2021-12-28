<template>
  <div v-show="tasksListEmpty || tasksEmpty" class="card ps-3 py-2 w-100">
    <p class="m-0">
      <span v-show="tasksListEmpty">lista vazia</span>
      <span v-show="tasksEmpty">Cadastre uma tarefa</span>
    </p>
  </div>
</template>

<script>
export default {
  name: "TaskAlert",

  computed: {
    getFilter() {
      return this.$store.getters.getFilter;
    },

    tasksListEmpty() {
      if (this.getFilter === "enable") {
        return this.$store.getters.getTasksEnable.length === 0;
      }

      if (this.getFilter === "disable") {
        return this.$store.getters.getTasksDisable.length === 0;
      }
      return false;
    },

    tasksEmpty() {
      return this.$store.getters.getTasks.length === 0;
    },
  },
};
</script>