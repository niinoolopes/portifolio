<template>
  <section class="mb-2">
    <b-button
      variant="outline-secondary"
      class="px-2"
      size="sm"
      @click="storeItem"
    >
      <font-awesome-icon :icon="['fas', 'plus']" />
    </b-button>
  </section>
</template>

<script>
export default {
  // data() {
  //   return {
  //     selected: false,
  //     options: [
  //       { value: false, text: "Abertos" },
  //       { value: true, text: "Concluídos" },
  //       { value: "all", text: "Todos" },
  //     ],
  //   };
  // },

  methods: {
    async storeItem() {
      await this.$store.dispatch("resetModal");

      await this.$store.dispatch("update", {
        obj: "modal",
        key: "status",
        value: true,
      });
    },
  },
};
</script>