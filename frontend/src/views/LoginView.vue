<script setup>
import { ref } from 'vue';
import { useAuthStore } from '../stores/auth.js'; // Importamos nuestro almacén
import { useRouter } from 'vue-router'; // Importamos el router

const correo = ref('');
const clave = ref('');
const error = ref(null);
const authStore = useAuthStore();
const router = useRouter();

const handleLogin = async () => {
  error.value = null;
  try {
    await authStore.login(correo.value, clave.value); // Usamos la acción del almacén
    router.push('/app/dashboard'); // Redirigimos al dashboard
  } catch (err) {
    error.value = 'Las credenciales son incorrectas.';
    alert(error.value);
  }
};
</script>

<template>
  <div class="login-container">
    <h1>Iniciar Sesión</h1>
    <form @submit.prevent="handleLogin">
      <div class="form-group">
        <label for="email">Correo Electrónico</label>
        <input type="email" id="email" v-model="correo" placeholder="tu@correo.com" required>
      </div>
      <div class="form-group">
        <label for="password">Contraseña</label>
        <input type="password" id="password" v-model="clave" placeholder="••••••••" required>
      </div>
      <button type="submit">Entrar</button>
    </form>
  </div>
</template>

<style scoped>
.login-container {
  max-width: 400px;
  margin: 100px auto;
  padding: 2rem;
  border-radius: 8px;
  box-shadow: 0 4px 8px rgba(0,0,0,0.1);
}
.form-group {
  margin-bottom: 1rem;
}
input {
  width: 100%;
  padding: 0.75rem;
  border: 1px solid #ccc;
  border-radius: 4px;
}
button {
  width: 100%;
  padding: 0.75rem;
  border: none;
  background-color: #0d6efd;
  color: white;
  border-radius: 4px;
  cursor: pointer;
}
</style>