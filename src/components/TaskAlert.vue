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

  props: {
    tasksListEmpty: {
      type: Boolean,
      require: true,
    },
    tasksEmpty: {
      type: Boolean,
      require: true,
    },
  },
};
</script>