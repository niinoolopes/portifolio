export default {
  SET(state, payload) {
    const { module, obj, key, value } = payload

    if (!!module && !!obj) {
      state[module][obj][key] = value
      return
    }

    if (!!module) {
      state[module][key] = value
      return
    }

    if (!!obj) {
      state[obj][key] = value
      return
    }

    state[key] = value
  }
}