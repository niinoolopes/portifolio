export default {
  SET_TASK(state, payload) {

    const { obj, key, value } = payload

    if (!!obj) {

      state[obj][key] = value
      return
    }

    state[key] = value
  }
}