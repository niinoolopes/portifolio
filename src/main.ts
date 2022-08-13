import { createApp } from 'vue'
import App from './App.vue'
import router from './router'
import store from './store'
import './registerServiceWorker'
import './assets/css/app.scss'

// Pinia
import { createPinia } from 'pinia'
const pinia = createPinia()

// fontawesome
import { library } from '@fortawesome/fontawesome-svg-core'
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'
import { faUtensils, faClipboardList } from '@fortawesome/free-solid-svg-icons'
library.add(faUtensils, faClipboardList)

const app = createApp(App)
app.component('font-awesome-icon', FontAwesomeIcon)
app.use(pinia)
app.use(store)
app.use(router)
app.mount('#app')