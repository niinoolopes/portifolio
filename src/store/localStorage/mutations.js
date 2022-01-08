export default {
  SET(state, payload) {
    const { obj, key, value } = payload

    if (!key && !value) {
      return
    }

    if (!!obj) {
      state[obj][key] = value
      return
    }

    state[key] = value
  }
}