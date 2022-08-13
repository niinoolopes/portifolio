import { createRouter, createWebHistory, RouteRecordRaw } from 'vue-router'
import routeList from './routes'

const routes: Array<RouteRecordRaw> = routeList

const router = createRouter({
  history: createWebHistory(process.env.BASE_URL),
  routes
})

export default router
