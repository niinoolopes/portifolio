<template>
  <section id="form-task" class="mb-3">
    <form @submit.prevent="newTaks">
      <div class="input-group mb-3">
        <input
          type="text"
          class="form-control form-control-sm"
          placeholder="Digite uma nova tarfa"
          v-model="form.text"
          required
        />
        <div class="input-group-append">
          <button class="btn btn-sm d-flex py-2 px-3" type="submit">
            <i class="fa fa-save"></i>
          </button>
        </div>
      </div>
    </form>
  </section>
</template>

<script>
export default {
  name: "Lista",

  data() {
    return {
      form: {
        text: "",
      },
    };
  },

  methods: {
    newTaks() {
      this.$emit("addTaks", { text: this.form.text });

      this.form.text = "";
    },
  },
};
</script>