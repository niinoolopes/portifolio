<template>
  <LayoutInitial>
    <div class="py-4">
      <h2 class="fs-1 fw-light">Promoções</h2>

      <div class="d-flex flex-wrap justify-content-center">
        <div
          class="col-12 col-sm-6 col-lg-3"
          v-for="(promo, i) in promos"
          :key="i"
        >
          <div
            class="promo cursor-pointer rounded p-2"
            @click="toPage(`promocao/${promo.slug}`)"
          >
            <img :src="require(`@/assets/img/${promo.img}`)" />
          </div>
        </div>
      </div>
    </div>

    <div class="py-4">
      <h2 class="fs-1 fw-light">Categorias</h2>
      <div class="d-flex flex-wrap justify-content-center">
        <div
          class="col-12 col-sm-6 col-lg-2"
          v-for="(categoria, i) in categorias"
          :key="i"
        >
          <div
            class="categoria cursor-pointer rounded m-2"
            @click="toPage(`category/${categoria.slug}`)"
          >
            <img :src="require(`@/assets/img/category/${categoria.img}`)" />
          </div>
        </div>
      </div>
    </div>

    <!-- 
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
    </div> -->
  </LayoutInitial>
</template>

<script lang="ts" setup>
import LayoutInitial from "@/layout/Initial.vue";
import categorias from "@/content/category-list";
import promos from "@/content/promo-list";

import { useRouterHook } from "@/hooks/useRouterHook";
const { toPage } = useRouterHook();
</script>

<style lang="scss" scoped>
.promo,
.categoria {
  transition: 0.2s;

  &:hover {
    box-shadow: 0 8px 0.25rem -2px var(--bs-gray-300);
    transform: scale(0.95);
  }
  img {
    display: block;
    max-width: 100%;
    max-height: 100%;
  }
}

.categoria {
  box-shadow: 0 8px 0.25rem -2px var(--bs-gray-100);
}
</style>