<script setup>
import { ref, onMounted } from 'vue';
import axios from 'axios';
import { useAuthStore } from '@/stores/auth';
import { useRouter } from 'vue-router';

const grupo = ref({ nombre: '', descripcion: '', idCliente: null });
const clientes = ref([]);
const isLoading = ref(false);
const authStore = useAuthStore();
const router = useRouter();

onMounted(async () => {
    // Cargar clientes para el select
    const response = await axios.get('http://localhost:8080/api/clientes', {
      headers: { 'Authorization': `Bearer ${authStore.token}` }
    });
    clientes.value = response.data;
});

const handleSave = async () => {
  isLoading.value = true;
  try {
    await axios.post('http://localhost:8080/api/grupos-antena', grupo.value, {
      headers: { 'Authorization': `Bearer ${authStore.token}` }
    });
    router.push('/app/grupos-antena');
  } catch (error) {
    alert('Hubo un error al guardar.');
  } finally {
    isLoading.value = false;
  }
};
</script>
<template>
  <div class="form-container">
    <h1>Crear Nuevo Grupo de Antena</h1>
    <form @submit.prevent="handleSave">
      <div class="form-group">
        <label>Cliente (Hotel)</label>
        <select v-model="grupo.idCliente" required>
          <option :value="null" disabled>-- Seleccione un cliente --</option>
          <option v-for="cliente in clientes" :key="cliente.idCliente" :value="cliente.idCliente">{{ cliente.nombreEmpresa }}</option>
        </select>
      </div>
      <div class="form-group">
        <label>Nombre del Grupo</label>
        <input type="text" v-model="grupo.nombre" required>
      </div>
       <div class="form-group">
        <label>Descripción</label>
        <input type="text" v-model="grupo.descripcion">
      </div>
      <button type="submit" class="primary-button" :disabled="isLoading">{{ isLoading ? 'Guardando...' : 'Guardar Grupo' }}</button>
    </form>
  </div>
</template>
<style scoped>
/* Copia los estilos de las otras vistas de formulario */
.form-container { max-width: 600px; margin: 0 auto; background-color: #fff; padding: 2rem; border-radius: 8px; }
.form-group { margin-bottom: 1.5rem; }
input, select { width: 100%; padding: 0.75rem; border: 1px solid #ccc; border-radius: 4px; }
.primary-button { padding: 0.75rem 1.5rem; border: none; background-color: #0d6efd; color: white; border-radius: 6px; cursor: pointer; font-size: 1rem; }
</style>