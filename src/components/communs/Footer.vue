<template>
  <footer
    id="app-footer"
    class="d-flex align-items-center justify-content-center text-muted"
  >
    <p class="m-0">
      <a
        href="https://www.instagram.com/niinoo.lopes/"
        target="_blank"
        class="text-decoration-none fst-italic text-muted"
        >@niinoo.lopes</a
      > <span class="fw-light">- <small>2021</small></span>
    </p>
  </footer>
</template>

<script>
export default {
  name: "Footer",
};
</script>

<style lang="scss" scopeed>
#app-footer {
  min-height: 30px;
}
small {
  font-size: 12px;
}
</style>
