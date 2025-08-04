import { defineStore } from 'pinia'
import axios from 'axios'

export const useAuthStore = defineStore('auth', {
  state: () => ({
    user: null,
    token: null,
  }),
  actions: {
    async login(correo, clave) {
      const response = await axios.post('http://localhost:8080/api/login', {
        correo: correo,
        clave: clave,
      });

      // Guardamos los datos en el state
      this.token = response.data.access_token;
      this.user = response.data.usuario;

      // Guardamos el token en el almacenamiento local del navegador para persistencia
      localStorage.setItem('authToken', this.token);
    }
  },
})