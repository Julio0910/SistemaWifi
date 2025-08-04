import { defineStore } from 'pinia'
import axios from 'axios'

export const useAuthStore = defineStore('auth', {
  // state: son las variables que guardaremos
  state: () => ({
    user: null,
    token: null,
  }),

  // getters: son como propiedades computadas para el store
  getters: {
    isAuthenticated: (state) => !!state.token,
  },

  // actions: son las funciones que modifican el state
  actions: {
    async login(correo, clave) {
      const response = await axios.post('http://localhost:8080/api/login', {
        correo: correo,
        clave: clave,
      });
      
      this.token = response.data.access_token;
      this.user = response.data.usuario;
      localStorage.setItem('authToken', this.token);
    },

    async logout() {
      await axios.post('http://localhost:8080/api/logout', {}, {
        headers: {
          'Authorization': `Bearer ${this.token}`
        }
      });
      
      this.user = null;
      this.token = null;
      localStorage.removeItem('authToken');
      this.router.push('/');
    },

    // --- FUNCIÓN AÑADIDA ---
    // Revisa si hay un token guardado en el navegador para mantener la sesión
    tryAutoLogin() {
      const token = localStorage.getItem('authToken');
      if (token) {
        this.token = token;
      }
    }
    // -------------------------
  },
})