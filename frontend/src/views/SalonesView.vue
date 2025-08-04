<script setup>
import { ref, onMounted } from 'vue';
import axios from 'axios';
import { useAuthStore } from '@/stores/auth';

const salones = ref([]);
const isLoading = ref(true);
const authStore = useAuthStore();

onMounted(async () => {
  try {
    const response = await axios.get('http://localhost:8080/api/salones', {
      headers: { 'Authorization': `Bearer ${authStore.token}` }
    });
    salones.value = response.data;
  } catch (error) {
    console.error("Error al cargar los salones:", error);
  } finally {
    isLoading.value = false;
  }
});
</script>

<template>
  <div>
    <header class="view-header">
      <h1>Gestión de Salones</h1>
      <RouterLink to="/app/salones/crear" class="primary-button">Añadir Salón</RouterLink>
    </header>

    <div class="table-container">
      <div v-if="isLoading">Cargando...</div>
      <table v-else>
        <thead>
          <tr>
            <th>Nombre del Salón</th>
            <th>Capacidad</th>
            <th>Estado</th>
          </tr>
        </thead>
        <tbody>
          <tr v-if="salones.length === 0">
            <td colspan="3">No hay salones para mostrar.</td>
          </tr>
          <tr v-for="salon in salones" :key="salon.idSalon">
            <td>{{ salon.nombre }}</td>
            <td>{{ salon.capacidad }}</td>
            <td>{{ salon.estado }}</td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</template>

<style scoped>
.view-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem; }
.primary-button { padding: 0.75rem 1.5rem; border: none; background-color: #0d6efd; color: white; border-radius: 6px; cursor: pointer; font-size: 1rem; text-decoration: none; }
.table-container { background-color: #fff; padding: 1.5rem; border-radius: 8px; box-shadow: 0 4px 8px rgba(0,0,0,0.05); }
table { width: 100%; border-collapse: collapse; }
th, td { padding: 1rem; text-align: left; border-bottom: 1px solid #dee2e6; }
thead th { font-weight: 600; color: #495057; }
</style>