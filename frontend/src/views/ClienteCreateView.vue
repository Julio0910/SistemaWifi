<script setup>
import { ref } from 'vue';
import axios from 'axios';
import { useAuthStore } from '@/stores/auth';
import { useRouter } from 'vue-router';

const cliente = ref({
  nombreEmpresa: '',
  razonSocial: '',
  correo: '',
  telefono: '',
});
const isLoading = ref(false);
const authStore = useAuthStore();
const router = useRouter();

const handleSave = async () => {
  isLoading.value = true;
  try {
    await axios.post('http://localhost:8080/api/clientes', cliente.value, {
      headers: { 'Authorization': `Bearer ${authStore.token}` }
    });
    router.push('/app/clientes');
  } catch (error) {
    console.error("Error al guardar el cliente:", error);
    alert('Hubo un error al guardar.');
  } finally {
    isLoading.value = false;
  }
};
</script>

<template>
  <div class="form-container">
    <h1>Crear Nuevo Cliente</h1>
    <form @submit.prevent="handleSave">
      <div class="form-group">
        <label>Nombre de la Empresa</label>
        <input type="text" v-model="cliente.nombreEmpresa" required>
      </div>
       <div class="form-group">
        <label>Razón Social</label>
        <input type="text" v-model="cliente.razonSocial" required>
      </div>
      <div class="form-group">
        <label>Correo Electrónico</label>
        <input type="email" v-model="cliente.correo" required>
      </div>
      <div class="form-group">
        <label>Teléfono</label>
        <input type="tel" v-model="cliente.telefono" required>
      </div>
      <button type="submit" class="primary-button" :disabled="isLoading">
        {{ isLoading ? 'Guardando...' : 'Guardar Cliente' }}
      </button>
    </form>
  </div>
</template>

<style scoped>
/* Puedes copiar los estilos de EventoCreateView.vue */
.form-container { max-width: 600px; margin: 0 auto; background-color: #fff; padding: 2rem; border-radius: 8px; }
.form-group { margin-bottom: 1.5rem; }
input { width: 100%; padding: 0.75rem; border: 1px solid #ccc; border-radius: 4px; }
.primary-button { padding: 0.75rem 1.5rem; border: none; background-color: #0d6efd; color: white; border-radius: 6px; cursor: pointer; font-size: 1rem; }
</style>