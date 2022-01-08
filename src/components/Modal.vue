<template>
  <div>
    <b-button
      ref="btn"
      @click="$bvModal.show('bv-modal-example')"
      class="d-none"
    />

    <b-modal
      id="bv-modal-example"
      hide-footer
      @show="showModal"
      @hide="hideModal"
    >
      <template #modal-title> {{ getTitle }} </template>
      <form @submit.prevent="handleSubmit">
        <b-form-group required class="mb-2" label="Nome">
          <b-form-input
            :value="getModal.name"
            @input="(value) => handleInput({ key: 'name', value })"
          />
        </b-form-group>

        <b-form-group required class="mb-2" label="Quantidade">
          <b-form-input
            type="number"
            :value="getModal.quantity"
            @input="(value) => handleInput({ key: 'quantity', value })"
          />
        </b-form-group>

        <b-form-group required class="mb-2" label="Preço">
          <b-form-input
            type="number"
            step="0.01"
            :value="getModal.price"
            @input="(value) => handleInput({ key: 'price', value })"
          />
        </b-form-group>

        <b-form-group required class="mb-2" label="Total">
          <b-form-input
            type="number"
            step="0.01"
            :value="getModal.priceTotal"
            @input="(value) => handleInput({ key: 'priceTotal', value })"
          />
        </b-form-group>

        <b-button ref="btnForm" type="submit" class="d-none" />
      </form>

      <div>
        <b-alert
          :show="alert.dismissCountDown"
          dismissible
          variant="warning"
          @dismissed="alert.dismissCountDown = 0"
          @dismiss-count-down="alertCountDownChanged"
        >
          {{ isEdit ? "Atualizando" : "Cadastrando" }} ...
          {{ alert.dismissCountDown }}
        </b-alert>
      </div>
    </b-modal>
  </div>
</template>

<script>
export default {
  data: () => ({
    alert: {
      dismissCountDown: 0,
    },
    debaundeForm: null,
  }),

  computed: {
    getModal() {
      return this.$store.state.modal;
    },
    getTitle() {
      return this.getModal.id ? "Edição" : "Cadastro";
    },
    isEdit() {
      return !!this.getModal.id;
    },
  },

  watch: {
    "$store.state.modal": {
      handler: function ({ status }) {
        if (status) {
          this.$refs.btn.click();
        }
      },
      deep: true,
    },
  },

  methods: {
    // ALERT
    alertCountDownChanged(dismissCountDown) {
      this.alert.dismissCountDown = dismissCountDown;
    },
    alertShow() {
      this.alert.dismissCountDown = 2;
    },

    // FORM
    async handleInput({ key, value }) {
      await this.$store.dispatch("update", {
        obj: "modal",
        key,
        value,
      });

      const { name, quantity, price } = await this.getModal;

      if (!!value && !!name && !!quantity && !!price) {
        const n = key === "price" ? quantity : price;

        await this.$store.dispatch("update", {
          obj: "modal",
          key: "priceTotal",
          value: +Number(+n * +value).toFixed(2),
        });

        clearTimeout(this.debaundeForm);

        this.debaundeForm = setTimeout(() => {
          this.$refs.btnForm.click();
        }, 1000);
      }
    },

    async handleSubmit(e) {
      e.preventDefault();

      this.alertShow();

      const { id, ...form } = this.getModal;

      const paylaod = {
        id,
        form,
      };

      this.isEdit
        ? await this.$store.dispatch("updateItem", paylaod)
        : await this.$store.dispatch("storeItem", paylaod);
    },

    // MODAL
    async showModal() {
      console.log("... show modal");
      // await this.$store.dispatch("resetModal");
    },

    async hideModal() {
      console.log("... hide modal");

      await this.$store.dispatch("update", {
        obj: "modal",
        key: "status",
        value: false,
      });
    },
  },
};
</script>

<style>
</style>