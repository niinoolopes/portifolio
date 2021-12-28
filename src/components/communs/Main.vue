<template>
  <main id="app-main" class="p-2">
    <slot></slot>
  </main>
</template>

<script>
export default {
  name: "Main",
};
</script>

<style lang="scss" scopeed>
#app-main {
  flex: 1;

  display: flex;
  flex-direction: column;
  align-items: flex-start;
  overflow: hidden;
}
</style>
