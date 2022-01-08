<template>
  <main id="layout-main">
    <slot></slot>
  </main>
</template>

<script>
export default {
  name: "Main",
};
</script>

<style scopped>
#layout-main {
  overflow-y: auto;
  flex: 1;
}
</style>