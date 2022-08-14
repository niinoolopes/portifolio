<template>
  <div class="layout-internal">
    <Header />
    <div class="layout-internal-content container flex-grow-1">
        <slot></slot>
    </div>
    <Footer />
  </div>
</template>

<script lang="ts" setup>
import Header from "@/components/Layout-internal/Header.vue";
import Footer from "@/components/Layout-internal/Footer.vue";
</script>