import { defineStore } from 'pinia'
import { ref } from 'vue'

export const useCounterStore = defineStore('counter', () => {
  // state in Pinia
  const count = ref(0)

  // actions in Pinia
  function increment() {
    count.value++
  }
  function decrement() {
    count.value++
  }

  // getters in Pinia, use computed

  return { count, increment, decrement }
})