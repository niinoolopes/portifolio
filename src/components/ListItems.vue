<template>
  <b-table hover small sticky-header :items="items" :fields="fields" responsive>
    <template #cell(id)="data">
      <b-button
        variant="outline-secondary"
        class="p-2 d-flex justify-content-center"
        size="sm"
        @click="editItem(data.item.id)"
      >
        <font-awesome-icon :icon="['fas', 'edit']" />
      </b-button>
    </template>
  </b-table>
</template>

<script>
export default {
  computed: {
    fields() {
      return [
        {
          class: "text-center",
          key: "id",
          label: "",
          thStyle: { width: "50px", minWidth: "50px" },
        },
        {
          class: "text-left",
          key: "name",
          label: "Produto",
          thStyle: { minWidth: "100px" },
        },
        {
          class: "text-center",
          key: "quantity",
          label: "Quantidade",
          thStyle: { minWidth: "120px" },
        },
        {
          class: "text-center",
          key: "price",
          label: "Preço unidade",
          thStyle: { minWidth: "120px" },
        },
        {
          class: "text-center",
          key: "priceTotal",
          label: "Preço total",
          thStyle: { minWidth: "120px" },
        },
      ];
    },
    items() {
      return this.$store.state.items;
    },
  },

  methods: {
    async editItem(id) {
      await this.$store.dispatch("modalShowItem", { id });
    },
  },
};
</script>