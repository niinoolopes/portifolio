<template>
  <div class="w-100 h-100 d-flex">
    <form
      @submit.prevent="signIn"
      class="m-auto col-10 col-sm-8 col-md-6 col-lg-3 col-xl-2 border shadow-sm p-3"
    >
      <h1 class="display-6">Login</h1>
      <hr>
      
      <button class="btn btn-sm btn-primary d-flex align-items-center gap-2" type="submit">
        <span>Google</span>
        <font-awesome-icon
          :icon="['fa', 'sign-in-alt']"
          style="font-size: 18px"
        />
      </button>
    </form>
  </div>
</template>

<script>
export default {
  name: "Home",

  methods: {
    async signIn() {
      await this.$store.dispatch("signIn", { context: this });
    },
  },
};
</script>
