<template>
  <div>...</div>
</template>

<script>
  export default {

    created () {
      this.$store.commit('RESET_STATE');
      // this.$store.commit('SET_LOGIN', false);
      // this.$router.push({name: 'Login'})
    },
  }
</script>
