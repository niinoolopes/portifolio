<template>
  <b-container>
    <LayoutSection>
      <CardValues />
    </LayoutSection>

    <LayoutSection>
      <ListActions />
      <ListItems />
    </LayoutSection>

    <Modal />
  </b-container>
</template>

<script>
export default {
  name: "IndexPage",

  layout: "LayoutLista",

  mounted() {
    this.$store.dispatch("localStorage/getLocalStorage", { context: this });
  },
};
</script>