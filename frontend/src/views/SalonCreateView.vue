<script setup>
import { ref, onMounted } from 'vue';
import axios from 'axios';
import { useAuthStore } from '@/stores/auth';
import { useRouter } from 'vue-router';

const salon = ref({
  nombre: '',
  capacidad: 0,
  idCliente: null,
});
const clientes = ref([]);
const isLoading = ref(false);
const authStore = useAuthStore();
const router = useRouter();

onMounted(async () => {
  try {
    const response = await axios.get('http://localhost:8080/api/clientes', {
      headers: { 'Authorization': `Bearer ${authStore.token}` }
    });
    clientes.value = response.data;
  } catch (error) {
    console.error("Error al cargar clientes:", error);
  }
});

const handleSave = async () => {
  isLoading.value = true;
  try {
    await axios.post('http://localhost:8080/api/salones', salon.value, {
      headers: { 'Authorization': `Bearer ${authStore.token}` }
    });
    router.push('/app/salones');
  } catch (error) {
    console.error("Error al guardar el salón:", error);
    alert('Hubo un error al guardar.');
  } finally {
    isLoading.value = false;
  }
};
</script>

<template>
  <div class="form-container">
    <h1>Crear Nuevo Salón</h1>
    <form @submit.prevent="handleSave">
       <div class="form-group">
        <label>Cliente (Hotel)</label>
        <select v-model="salon.idCliente" required>
          <option :value="null" disabled>-- Seleccione un cliente --</option>
          <option v-for="cliente in clientes" :key="cliente.idCliente" :value="cliente.idCliente">
            {{ cliente.nombreEmpresa }}
          </option>
        </select>
      </div>
      <div class="form-group">
        <label>Nombre del Salón</label>
        <input type="text" v-model="salon.nombre" required>
      </div>
      <div class="form-group">
        <label>Capacidad</label>
        <input type="number" v-model="salon.capacidad">
      </div>
      <button type="submit" class="primary-button" :disabled="isLoading">
        {{ isLoading ? 'Guardando...' : 'Guardar Salón' }}
      </button>
    </form>
  </div>
</template>

<style scoped>
/* Puedes copiar los estilos de las otras vistas de formulario */
.form-container { max-width: 600px; margin: 0 auto; background-color: #fff; padding: 2rem; border-radius: 8px; }
.form-group { margin-bottom: 1.5rem; }
input, select { width: 100%; padding: 0.75rem; border: 1px solid #ccc; border-radius: 4px; }
.primary-button { padding: 0.75rem 1.5rem; border: none; background-color: #0d6efd; color: white; border-radius: 6px; cursor: pointer; font-size: 1rem; }
</style>