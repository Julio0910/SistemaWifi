import './assets/main.css'

import { createApp } from 'vue'
import { createPinia } from 'pinia'
import { useAuthStore } from './stores/auth' // <-- 1. Importa el store

import App from './App.vue'
import router from './router'

const app = createApp(App)
const pinia = createPinia()

app.use(pinia) // <-- 2. Usa Pinia primero

// 3. Ahora que Pinia está activo, podemos usar el store
const authStore = useAuthStore()
authStore.tryAutoLogin() // Intenta cargar el token del navegador

// Esto es para que podamos usar el router dentro de nuestras tiendas de Pinia (como en el logout)
pinia.use(({ store }) => {
  store.router = router
})

app.use(router)

app.mount('#app')