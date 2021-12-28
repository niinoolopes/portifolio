
import {
  getTaskByUserId,
  createTaskByUserId,
  updateTaskById
} from "../../../services/firebase-collections";

export default {
  async setFilterTask({ state, commit }, type) {

    const userId = this.state.auth.usuario.id
    const taskId = state.id
    const oldTaskList = state.taskList

    await commit('SET_TASK', {
      key: 'filter',
      value: type
    })

    await updateTaskById(taskId, {
      userId: userId,
      tasks: oldTaskList,
      filter: type,
    })
  },

  async getTasksById({ dispatch }, { context }) {

    const userId = this.state.auth.usuario.id

    if (!userId) {
      return
    }

    const result = await getTaskByUserId(userId);

    if (!result) {
      await createTaskByUserId(userId);
      await dispatch.getTasksById({ context });
      return;
    }

    await context.$store.dispatch('updates', [
      {
        module: 'task',
        key: "filter",
        value: result.filter,
      },
      {
        module: 'task',
        key: "id",
        value: result.id,
      },
      {
        module: 'task',
        key: "taskList",
        value: result.tasks,
      },
    ]);
  },

  async addTask({ state, commit }, payload) {

    const userId = this.state.auth.usuario.id
    const taskFilter = state.filter
    const taskId = state.id
    const oldTaskList = state.taskList

    const newTask = {
      id: (new Date()).getTime(),
      text: payload.text,
      status: false,
    }

    const newTaskList = [
      newTask,
      ...oldTaskList,
    ]

    await commit('SET_TASK', {
      key: 'taskList',
      value: newTaskList
    })

    await updateTaskById(taskId, {
      userId: userId,
      tasks: newTaskList,
      filter: taskFilter,
    })
  },

  async updateTask({ state, commit }, payload) {

    const { id, key, value } = payload

    const userId = this.state.auth.usuario.id
    const taskFilter = state.filter
    const taskId = state.id
    const oldTaskList = state.taskList

    oldTaskList.map(el => {
      if (el.id === id) {
        el[key] = value
      }
      return el
    })

    const newTaskList = oldTaskList

    await commit('SET_TASK', {
      key: 'taskList',
      value: newTaskList
    })

    await updateTaskById(taskId, {
      userId: userId,
      tasks: newTaskList,
      filter: taskFilter,
    })
  },

  async removeTask({ state, commit }, payload) {

    const { id } = payload

    const userId = this.state.auth.usuario.id
    const taskFilter = state.filter
    const taskId = state.id
    const oldTaskList = state.taskList

    const newTaskList = oldTaskList.filter(el => el.id !== id)

    if (newTaskList.length === 0) {
      await commit('SET_TASK', {
        key: 'filter',
        value: 'enable'
      })
    }

    await commit('SET_TASK', {
      key: 'taskList',
      value: newTaskList
    })

    await updateTaskById(taskId, {
      userId: userId,
      tasks: newTaskList,
      filter: taskFilter,
    })
  },

  async resetTask({ state }, { context }) {

    const userId = this.state.auth.usuario.id
    const taskId = state.id

    await context.$store.dispatch("updates", [
      {
        module: "task",
        key: "filter",
        value: "enable",
      },
      {
        module: "task",
        key: "taskList",
        value: [],
      },
    ]);

    await updateTaskById(taskId, {
      userId: userId,
      tasks: [],
      filter: 'enable',
    })

  }
}