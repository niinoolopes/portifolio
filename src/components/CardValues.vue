<template>
  <div id="layout-cards" class="d-sm-flex">
    <b-col
      class="mb-2 px-1"
      md="4"
      lg="3"
      v-for="(label, idx) in labels"
      :key="label"
    >
      <b-card
        no-body
        header-bg-variant="secondary"
        header-class="text-white font-weight-bold py-2"
        :header="label"
        tag="article"
      >
        <b-card-text class="py-1 px-3 text-right h1 font-weight-light">
          {{ values[idx] }}
        </b-card-text>
      </b-card>
    </b-col>
  </div>
</template>

<script>
export default {
  data() {
    return {
      labels: ["Quantidade", "Preço Total", "Preço Médio"],
      values: [0, 0, 0],
    };
  },

  mounted() {},

  methods: {
    getValues() {
      const quantity = this.$store.getters.getQuantityProducts;
      const priceTotal = this.$store.getters.getPriceTotalProducts;
      const priceMedia = this.$store.getters.getPriceMediaProducts;

      this.values = [quantity, priceTotal, priceMedia];
    },
  },

  watch: {
    "$store.state.items": {
      handler: function () {
        this.getValues();
      },
      deep: true,
    },
  },
};
</script>

<style scopped>
/* #layout-cards-wrapper {
  overflow-x: auto;
} */
/* #layout-cards {
  display: flex;
  width: max-content;
}
[class*="col"] {
  min-width: 175px;
} */
</style>