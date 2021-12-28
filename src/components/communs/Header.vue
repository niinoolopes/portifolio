<template>
  <header id="app-header" class="d-flex align-items-center">
    <h1 class="display-1 me-auto" @click="toHome">Tarefas</h1>

    <button class="btn btn-sm d-flex gap-3 pt-2" @click="resetTask">
      <font-awesome-icon :icon="['fa', 'recycle']" style="font-size: 18px" />
    </button>

    <button class="btn btn-sm d-flex gap-3 pt-2" @click="signOut">
      <font-awesome-icon
        :icon="['fa', 'sign-out-alt']"
        style="font-size: 18px"
      />
    </button>
  </header>
</template>

<script>
export default {
  name: "Header",

  methods: {
    toHome() {
      this.$router.push({ name: "Home" });
    },
    
    async resetTask() {
      await this.$store.dispatch("resetTask", { context: this });
    },

    async signOut() {
      await this.$store.dispatch("signOut", { context: this });
    },
  },
};
</script>

<style lang="scss" scopeed>
#app-header {
  min-height: 80px;
}
</style>