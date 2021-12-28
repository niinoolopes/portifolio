export default {
  update({ commit }, payload) {
    commit('SET', payload)
  },

  updates({ commit }, payload) {
    if (Array.isArray(payload)) {
      payload.map(e => commit('SET', e))
    }
  },
}