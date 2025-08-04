<script setup>
import { ref, onMounted } from 'vue';
import axios from 'axios';
import { useAuthStore } from '@/stores/auth';
const antenas = ref([]);
const isLoading = ref(true);
const authStore = useAuthStore();
onMounted(async () => {
  try {
    const response = await axios.get('http://localhost:8080/api/antenas', {
      headers: { 'Authorization': `Bearer ${authStore.token}` }
    });
    antenas.value = response.data;
  } finally {
    isLoading.value = false;
  }
});
</script>
<template>
  <div>
    <header class="view-header">
      <h1>Gestión de Antenas</h1>
      <RouterLink to="/app/antenas/crear" class="primary-button">Añadir Antena</RouterLink>
    </header>
    <div class="table-container">
      <div v-if="isLoading">Cargando...</div>
      <table v-else>
        <thead>
          <tr>
            <th>Nombre Antena</th>
            <th>IP</th>
            <th>Modelo</th>
            <th>Estado</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="antena in antenas" :key="antena.idAntena">
            <td>{{ antena.nombre }}</td>
            <td>{{ antena.ip }}</td>
            <td>{{ antena.modelo }}</td>
            <td>{{ antena.estado }}</td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</template>
<style scoped>
/* Copia los estilos de las otras vistas de lista */
.view-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem; }
.primary-button { padding: 0.75rem 1.5rem; border: none; background-color: #0d6efd; color: white; border-radius: 6px; cursor: pointer; font-size: 1rem; text-decoration: none; }
.table-container { background-color: #fff; padding: 1.5rem; border-radius: 8px; box-shadow: 0 4px 8px rgba(0,0,0,0.05); }
table { width: 100%; border-collapse: collapse; }
th, td { padding: 1rem; text-align: left; border-bottom: 1px solid #dee2e6; }
</style>