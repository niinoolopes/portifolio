export default {
  getFilter(state) {
    return state?.filter
  },
  getTasks(state) {
    return state?.taskList
  },
  getTasksEnable(state) {
    return state?.taskList.filter(el => !el.status)
  },
  getTasksDisable(state) {
    return state?.taskList.filter(el => el.status)
  },
}