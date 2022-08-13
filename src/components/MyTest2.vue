<template>
  <div>
    <h1>Test2 {{ counterStore.count }}</h1>
  </div>
</template>

<script lang="ts" setup>
import { useCounterStore } from "@/stores/useCounterStore";
const counterStore = useCounterStore();
</script>