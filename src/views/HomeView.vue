<template>
  <div class="home">
    <img alt="Vue logo" src="../assets/logo.png" />
    <HelloWorld msg="Welcome to Your Vue.js + TypeScript App" />
  </div>

  <h1>{{ counterStore.count }}</h1>
  <button @click="counterStore.increment">increment</button>
</template>

<script lang="ts" setup>
import HelloWorld from "@/components/HelloWorld.vue";
import { useCounterStore } from "@/stores/useCounterStore";
const counterStore = useCounterStore();
</script>
