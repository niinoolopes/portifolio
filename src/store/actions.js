export default {
  async resetModal({ dispatch }) {
    const payload = [
      { obj: "modal", key: "id", value: null },
      { obj: "modal", key: "name", value: null },
      { obj: "modal", key: "quantity", value: null },
      { obj: "modal", key: "price", value: null },
      { obj: "modal", key: "priceTotal", value: null },
    ];

    await dispatch("updates", payload);
  },

  async update({ commit }, payload) {
    await commit('SET', payload)
  },

  updates({ commit }, payload) {
    if (Array.isArray(payload)) {
      payload.map(async e => await commit('SET', e))
    }
  },

  // MODAL
  async modalShowItem({ state }, payload) {
    const { id } = payload

    const item = state.items.find(el => el.id === id)

    await this.dispatch('resetModal')

    await this.dispatch('updates', [
      {
        obj: "modal",
        key: "id",
        value: item.id,
      },
      {
        obj: "modal",
        key: "name",
        value: item.name,
      },
      {
        obj: "modal",
        key: "price",
        value: item.price,
      },
      {
        obj: "modal",
        key: "priceTotal",
        value: item.priceTotal,
      },
      {
        obj: "modal",
        key: "quantity",
        value: item.quantity,
      },
      {
        obj: "modal",
        key: "status",
        value: item.status,
      },

      {
        obj: "modal",
        key: "status",
        value: true,
      },
    ])
  },

  // CRUD
  async storeItem({ state, dispatch }, payload) {

    const form = {
      id: (new Date).getTime(),
      ...payload.form || {},
    }

    const isLogged = state.localStorage.logged

    // add in localStorage
    if (!isLogged) {
      const result = await dispatch('localStorage/storeItem', { form })

      await dispatch("update", {
        obj: "modal",
        key: "id",
        value: result.id,
      });
    }
  },

  async updateItem({ state, dispatch }, payload) {
    const { id, form } = payload
    const isLogged = state.localStorage.logged

    // add in localStorage
    if (!isLogged) {
      await dispatch('localStorage/updateItem', { id, form })
    }
  },

}