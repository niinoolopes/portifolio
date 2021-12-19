<template>
  <div id="app" class="container">
    <Header @resetTask="resetTask" />
    <hr class="mt-0 mb-3" />
    <Main>
      <FormTask ref="formTask" @addTaks="addTaks" />

      <TaskFilter
        :filterActive="filterActive"
        :tasksEmpty="tasksEmpty"
        @onClickFilter="onClickFilter"
      />

      <TaskList
        v-if="tasks.length > 0"
        :tasks="tasks"
        @handleInput="handleInput"
        @removeTask="removeTask"
      />

      <TaskAlert :tasksListEmpty="tasksListEmpty" :tasksEmpty="tasksEmpty" />
    </Main>
    <Footer />
  </div>
</template>

<script>
import Header from "./components/communs/Header.vue";
import Main from "./components/communs/Main.vue";
import Footer from "./components/communs/Footer.vue";
import FormTask from "./components/FormTask.vue";
import TaskFilter from "./components/TaskFilter.vue";
import TaskList from "./components/TaskList.vue";
import TaskAlert from "./components/TaskAlert.vue";

export default {
  components: {
    Header,
    Main,
    Footer,
    FormTask,
    TaskFilter,
    TaskList,
    TaskAlert,
  },

  data() {
    return {
      debaunce: null,
      filterActive: 0,
      nextId: 0,
      tasks: [],
      tasksData: [],
    };
  },

  computed: {
    tasksListEmpty() {
      return this.tasks.length === 0 && this.tasksData.length > 0;
    },
    tasksEmpty() {
      return this.tasks.length === 0 && this.tasksData.length === 0;
    },
  },

  methods: {
    // CRUD
    addTaks(newTaks = { text: "" }) {
      const hasTasks = [...this.tasksData].length > 0;

      const lastTask = hasTasks ? [...this.tasksData][0] : { id: 0, text: "" };

      const nextId = Number((lastTask.id || 0) + 1);

      const newTask = {
        id: nextId,
        text: newTaks.text,
        status: false,
      };

      this.tasksData = [...[newTask], ...this.tasksData];

      this.setBtnOpened();
    },
    removeTask(id = 0) {
      this.tasksData = [...this.tasksData].filter((el) => el.id !== id);
    },
    resetTask() {
      this.resetLocalStorage();

      this.autoFocus();
    },

    // EVENTS
    handleInput(parameters = []) {
      let [id, key, value] = parameters;

      this.tasksData = [...this.tasksData].map((task) => {
        if (task?.id === id) {
          task[key] = value;
        }
        return task;
      });

      this.handleInputSelectFilter();
    },
    handleInputSelectFilter() {
      const lengthOpened = [...this.tasksData].filter((e) => !e.status).length;
      const lengthClosed = [...this.tasksData].filter((e) => e.status).length;

      if (this.filterActive === 1 && lengthOpened === 0) {
        this.setBtnClosed();
        return false;
      }

      if (this.filterActive === 2 && lengthClosed === 0) {
        this.setBtnOpened();
        return false;
      }
    },
    onClickFilter(type) {
      if (type === 1) {
        this.setBtnOpened();
        this.showTasksAbertas();
      }
      if (type === 2) {
        this.setBtnClosed();
        this.showTasksClesed();
      }
      if (type === 3) {
        this.setBtnAll();
        this.showAllTasks();
      }
      this.setLocalStorage();
    },
    autoFocus() {
      this.$refs.formTask.autoFocus();
    },

    setBtnOpened() {
      this.filterActive = 1;
    },
    setBtnClosed() {
      this.filterActive = 2;
    },
    setBtnAll() {
      this.filterActive = 3;
    },

    // LOCALSTORAGE
    getLocalStorage() {
      const dataLocal = window.localStorage.getItem("nn-p-tarefas") || "{}";
      const data = JSON.parse(dataLocal);

      this.tasksData = data?.tasks || [];
      this.filterActive = data?.filterActive;
    },
    setLocalStorage() {
      const data = JSON.stringify({
        tasks: this.tasksData,
        filterActive: this.filterActive,
      });
      window.localStorage.setItem("nn-p-tarefas", data);
    },
    resetLocalStorage() {
      const data = JSON.stringify({
        tasks: [],
        filterActive: 1,
      });
      window.localStorage.setItem("nn-p-tarefas", data);

      this.getLocalStorage();
    },

    // FILTER
    showTasksAbertas() {
      this.tasks = [...this.tasksData].filter((el) => !el.status);
    },
    showTasksClesed() {
      this.tasks = [...this.tasksData].filter((el) => el.status);
    },
    showAllTasks() {
      this.tasks = [...this.tasksData];
    },
  },

  watch: {
    tasksData(newtasksData) {
      window.clearTimeout(this.debaunce);

      this.debaunce = setTimeout(() => {
        console.log('object')
        this.setLocalStorage();
        this.filterActive == 1 && this.showTasksAbertas();
        this.filterActive == 2 && this.showTasksClesed();
        this.filterActive == 3 && this.showAllTasks();

        const isEmpty = newtasksData.length === 0;
        if (isEmpty) {
          this.autoFocus();
          this.setBtnOpened();
        }
      }, 100);
    },
  },

  mounted() {
    this.getLocalStorage();
  },
};
</script>

<style lang="scss">
@import "./assets/styles/app";

#app {
  display: flex;
  flex-direction: column;
  justify-content: flex-start;

  width: 100vw;
  height: 100vh;
}
</style>
