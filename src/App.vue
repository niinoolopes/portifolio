<template>
  <div id="app" class="container">
    <Header />
    <Main>
      <FormTask @addTaks="addTaks" />
      <TaskFilter :filterActive="filterActive" @onClickFilter="onClickFilter" />

      <TaskList
        v-if="tasks.length > 0"
        :tasks="tasks"
        @handleInput="handleInput"
        @removeTask="removeTask"
      />

      <div
        v-if="tasks.length === 0 && tasksData.length > 0"
        class="card ps-3 py-2"
      >
        <div>lista vazia</div>
      </div>

      <div
        v-if="tasks.length === 0 && tasksData.length === 0"
        class="card ps-3 py-2"
      >
        <div>Nâo existe nenhuma tarefa</div>
      </div>
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

export default {
  components: {
    Header,
    Main,
    Footer,
    FormTask,
    TaskFilter,
    TaskList,
  },

  data() {
    return {
      filterActive: 0,
      nextId: 0,
      tasks: [],
      tasksData: [],
    };
  },

  methods: {
    // CRUD
    addTaks(newTaks = { text: "" }) {
      const hasTasks = this.tasksData.length > 0;

      const lastTask = hasTasks
        ? [...this.tasksData].slice(-1)[0]
        : { id: 0, text: "" };

      const nextId = Number((lastTask.id || 0) + 1);

      const newTask = {
        id: nextId,
        text: newTaks.text,
        status: false,
      };

      this.tasksData = [...[newTask], ...this.tasksData];

      this.filterActive = 1;
    },
    removeTask(id = 0) {
      this.tasksData = [...this.tasksData].filter((el) => el.id !== id);
    },

    // EVENTS
    handleInput(parameters = []) {
      const [id, key, value] = parameters;

      this.tasksData = [...this.tasksData].map((task) => {
        if (task?.id === id) {
          task[key] = value;
        }
        return task;
      });
    },
    onClickFilter(type) {
      if (type === 1) {
        this.filterActive = 1;
        this.showTasksAbertas();
      }
      if (type === 2) {
        this.filterActive = 2;
        this.showTasksClesed();
      }
      if (type === 3) {
        this.filterActive = 3;
        this.showAllTasks();
      }
      this.setLocalStorage();
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
    tasksData() {
      this.setLocalStorage();
      this.filterActive == 1 && this.showTasksAbertas();
      this.filterActive == 2 && this.showTasksClesed();
      this.filterActive == 3 && this.showAllTasks();
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

  #app-main {
    flex-grow: 1;
  }
}
</style>
