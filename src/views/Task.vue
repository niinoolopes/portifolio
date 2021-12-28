<template>
  <div class="container" v-if="isMounted">
    <Header />

    <hr class="mt-0 mb-3" />

    <Main>
      <TaskFilter />
      <FormTask />
      <TaskList />
      <TaskAlert />
    </Main>

    <Footer />
  </div>
</template>

<script>
import Header from "../components/communs/Header.vue";
import Footer from "../components/communs/Footer.vue";
import Main from "../components/communs/Main.vue";
import TaskFilter from "../components/TaskFilter.vue";
import FormTask from "../components/FormTask.vue";
import TaskList from "../components/TaskList.vue";
import TaskAlert from "../components/TaskAlert.vue";

export default {
  name: "Task",

  data: () => ({
    isMounted: false,
  }),

  components: {
    Header,
    Footer,
    Main,
    TaskFilter,
    FormTask,
    TaskList,
    TaskAlert,
  },

  computed: {
    isLogged() {
      return this.$store.getters.isLogged;
    },
  },

  mounted() {
    if (!this.isLogged) {
      this.$router.push({ name: "Home" });
    }

    this.isMounted = true;
  },
};
</script>