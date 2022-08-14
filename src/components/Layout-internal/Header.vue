<template>
  <header class="container p-3 border-bottom d-flex justify-content-between">
    <span class="fs-3 text-primary">ZéFood</span>

    <div class="btn-group" role="group" aria-label="Basic outlined example">
      <button
        style="min-width: 50px"
        type="button"
        class="btn btn-sm btn-outline-primary"
        v-for="btn in btns"
        :key="btn.icon"
        @click="toPage(btn.to)"
      >
        <font-awesome-icon :icon="btn.icon" size="xl" />
      </button>
    </div>
  </header>
</template>

<script lang="ts" setup>
import { useRouterHook } from "@/hooks/useRouterHook";
const { toPage } = useRouterHook();

type Btn = {
  to: string;
  icon: "fa-solid fa-utensils" | "fa-solid fa-clipboard-list";
};

const btns: Btn[] = [
  {
    icon: "fa-solid fa-utensils",
    to: "/place-order",
  },
  {
    icon: "fa-solid fa-clipboard-list",
    to: "/track-order",
  },
];
</script>