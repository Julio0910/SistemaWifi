<script setup>
import { ref, onMounted } from 'vue';
import axios from 'axios';
import { useAuthStore } from '@/stores/auth';

const grupos = ref([]);
const isLoading = ref(true);
const authStore = useAuthStore();

onMounted(async () => {
  try {
    const response = await axios.get('http://localhost:8080/api/grupos-antena', {
      headers: { 'Authorization': `Bearer ${authStore.token}` }
    });
    grupos.value = response.data;
  } catch (error) {
    console.error("Error al cargar los grupos:", error);
  } finally {
    isLoading.value = false;
  }
});
</script>
<template>
  <div>
    <header class="view-header">
      <h1>Grupos de Antena</h1>
      <RouterLink to="/app/grupos-antena/crear" class="primary-button">Añadir Grupo</RouterLink>
    </header>
    <div class="table-container">
      <div v-if="isLoading">Cargando...</div>
      <table v-else>
        <thead>
          <tr>
            <th>Nombre del Grupo</th>
            <th>Descripción</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="grupo in grupos" :key="grupo.idGrupoAntena">
            <td>{{ grupo.nombre }}</td>
            <td>{{ grupo.descripcion }}</td>
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