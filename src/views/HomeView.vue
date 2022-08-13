<template>
  <div class="h-100vh container d-flex">
    <div class="w-100vw d-flex flex-wrap justify-content-center m-auto">
      <article
        class="col-10 col-md-4 m-3 cursor-pointer"
        v-for="option in options"
        :key="option.text"
        @click="toPage(option.to)"
      >
        <div
          class="
            px-3
            py-5
            rounded
            border
            shadow
            d-flex
            flex-column
            align-items-center
            bg-white
          "
        >
          <font-awesome-icon
            :icon="option.icon"
            size="2xl"
            class="text-muted"
          />
          <h3 class="m-0 pt-3">{{ option.text }}</h3>
        </div>
      </article>
    </div>
  </div>
</template>

<script lang="ts" setup>
import { useRouter } from "vue-router";
const router = useRouter();

type Option = {
  to: string;
  text: string;
  icon: "fa-solid fa-utensils" | "fa-solid fa-clipboard-list";
};

const options: Option[] = [
  {
    to: "/place-order",
    text: "Fazer Pedido",
    icon: "fa-solid fa-utensils",
  },
  {
    to: "/track-order",
    text: "Acompanhar Pedido",
    icon: "fa-solid fa-clipboard-list",
  },
];

function toPage(path: string) {
  router.push({
    path
  });
}
</script>

<style lang="scss" scoped>
article {
  transition: 0.2s;
  &:hover {
    transform: rotate(4deg) scale(1.05);
  }
}
</style>