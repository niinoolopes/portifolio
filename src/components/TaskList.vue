<template>
  <section id="task-list" class="card ps-3 py-2 w-100">
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
            @input="
              () => $emit('handleInput', [task.id, 'status', !task.status])
            "
          />
        </label>
      </div>
      <input
        :disabled="task.status"
        type="text"
        class="form-control form-control-sm"
        :value="task.text"
        @input="(e) => $emit('handleInput', [task.id, 'text', e.target.value])"
      />
      <button
        class="btn btn-sm d-flex pt-2"
        @click="() => $emit('removeTask', task.id)"
      >
        <i class="fa fa-trash"></i>
      </button>
    </div>
  </section>
</template>

<script>
export default {
  name: "Lista",

  props: {
    tasks: {
      type: [],
      default: [],
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
