<template>
  <div id="layout">
    <LayoutHeader />
    <LayoutMain>
      <Nuxt />
    </LayoutMain>
    <LayoutFooter />
  </div>
</template>

<script>
export default {

}
</script>

<style>
/* body{
  overflow: hidden;
} */
#_layout,
#layout {
  overflow: hidden;
  width: 100vw;
  height: 100vh;
}
#layout {
  display: flex;
  flex-direction: column;
  justify-content: flex-start;
}
</style>