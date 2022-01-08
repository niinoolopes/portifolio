const key = 'p-nuxt2-firebase-list'

export default {
  async getLocalStorage({ commit, dispatch }, { context }) {
    const data = window.localStorage.getItem(key)

    const parseInitial = {
      name: "", logged: false
    }

    const dataInitial = data ? JSON.parse(data) : parseInitial
    const itemsInitial = data ? dataInitial.items : []

    await commit("SET", { key: 'logged', value: dataInitial.logged });
    await commit("SET", { key: 'name', value: dataInitial.name });

    await context.$store.dispatch("update", {
      key: 'items',
      value: itemsInitial
    });

    if (!data) {
      await dispatch('setLocalStorage')
    }
  },

  async setLocalStorage() {
    const payload = {
      items: this.state.items,
      logged: this.state.localStorage.logged,
      name: this.state.localStorage.name,
    }

    const stringify = JSON.stringify(payload)

    window.localStorage.setItem(key, stringify)
  },

  // CRUD
  async storeItem({ dispatch }, payload) {
    const { form } = payload

    const newItem = {
      ...form
    }

    const newItems = [
      newItem,
      ...this.state.items
    ]

    await this.dispatch("update", {
      key: 'items',
      value: newItems
    });

    await dispatch('setLocalStorage')

    return newItem
  },

  async updateItem({ dispatch }, payload) {
    const { id, form } = payload

    const oldItems = [...this.state.items]

    const newItems = oldItems.map(el => {
      if (el.id === id) {
        el = {
          ...el,
          ...form
        }
      }
      return el
    })

    await this.dispatch("update", {
      key: 'items',
      value: newItems
    });

    await dispatch('setLocalStorage')
  },

  async deleteItem({ dispatch }, payload) {
    const { id } = payload

    const oldItems = [...this.state.items]

    const newItems = oldItems.filter(el => el.id !== id)

    await this.dispatch("update", {
      key: 'items',
      value: newItems
    });

    await dispatch('setLocalStorage')
  }
}