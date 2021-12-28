<template>
  <section v-if="tasksEmpty" id="task-list" class="card ps-3 py-2 w-100">
    <div v-for="task in tasks" :key="task.id" class="input-group my-2">
      <!-- <span class="p-2 input-group-id">
        {{ task.id }}
      </span> -->
      <div class="input-group-prepend d-flex">
        <label class="input-group-text" :for="`input-checkbox-${task.id}`">
          <input
            :id="`input-checkbox-${task.id}`"
            type="checkbox"
            :checked="task.status"
            @input="() => handleInput([task.id, 'status', !task.status])"
          />
        </label>
      </div>
      <input
        :disabled="task.status"
        type="text"
        class="form-control form-control-sm"
        :value="task.text"
        @input="(e) => handleInput([task.id, 'text', e.target.value])"
      />
      <button class="btn btn-sm d-flex pt-2" @click="() => removeTask(task.id)">
        <font-awesome-icon :icon="['fa', 'trash']" style="font-size: 18px" />
      </button>
    </div>
  </section>
</template>

<script>
export default {
  name: "TaskList",

  data: () => ({
    debounce: null,
  }),

  computed: {
    getFilter() {
      return this.$store.getters.getFilter;
    },

    tasks() {
      console.log(this.getFilter);
      if (this.getFilter === "enable") {
        return this.$store.getters.getTasksEnable;
      }

      if (this.getFilter === "disable") {
        return this.$store.getters.getTasksDisable;
      }

      return this.$store.getters.getTasks;
    },

    tasksEmpty() {
      return this.tasks.length > 0;
    },
  },

  mounted() {
    this.getTarefas();
  },

  methods: {
    async getTarefas() {
      await this.$store.dispatch("getTasksById", {
        context: this,
      });
    },

    handleInput([id, key, value]) {
      clearTimeout(this.debounce);

      this.debounce = setTimeout(async () => {
        await this.$store.dispatch("updateTask", {
          id,
          key,
          value,
        });
      }, 500);
    },

    async removeTask(id) {
      await this.$store.dispatch("removeTask", {
        id,
      });
    },
  },
};
</script>

<style lang="scss">
#task-list {
  flex: 1;
  overflow-y: auto;

  .input-group-id {
    min-width: 35px;
  }

  & label,
  & label input {
    cursor: pointer;
  }
}
</style>
