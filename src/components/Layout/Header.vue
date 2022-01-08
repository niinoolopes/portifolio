<template>
  <header id="layout-header">
    <b-container class="p-3 d-flex align-items-center">
      <h3 class="m-0 mr-2 display-4">Lista de Compra</h3>

      <nav class="ml-auto d-flex flex-wrap">
        <b-button
          class="m-1"
          size="sm"
          variant="outline-secondary"
          @click="recycle"
        >
          <font-awesome-icon :icon="['fas', 'recycle']" />
        </b-button>
        <b-button
          class="m-1"
          size="sm"
          variant="outline-secondary"
          @click="signIn"
        >
          <font-awesome-icon :icon="['fas', 'sign-in-alt']" />
        </b-button>
        <b-button
          class="m-1"
          size="sm"
          variant="outline-secondary"
          @click="signOut"
        >
          <font-awesome-icon :icon="['fas', 'sign-out-alt']" />
        </b-button>
      </nav>
    </b-container>
  </header>
</template>

<script>
export default {
  name: "Header",

  methods: {
    recycle() {
      console.log("recycle");
    },
    signIn() {
      console.log("signIn");
    },
    signOut() {
      console.log("signOut");
    },
  },
};
</script>

<style>
</style>