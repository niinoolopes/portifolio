export default {
  getQuantityProducts(state) {
    const { items } = state

    return [...items].reduce((sum, { quantity }) => sum += Number(quantity), 0)
  },

  getPriceTotalProducts(state) {
    const { items } = state

    return [...items].reduce((sum, { priceTotal }) => sum += Number(priceTotal), 0)
  },

  getPriceMediaProducts(state, getters) {
    const quantity = getters.getQuantityProducts

    const priceTotal = getters.getPriceTotalProducts

    return +Number(priceTotal / quantity).toFixed(2)
  }
}