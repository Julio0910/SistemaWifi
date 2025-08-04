<script setup>
import { ref, onMounted } from 'vue';
import axios from 'axios';
import { useAuthStore } from '@/stores/auth';

// Variables reactivas
const eventos = ref([]);
const isLoading = ref(true); // Se muestra "Cargando..." al inicio
const authStore = useAuthStore();

// onMounted se ejecuta automáticamente cuando el componente se carga
onMounted(async () => {
  try {
    // Hacemos la petición a la API para obtener los eventos
    const response = await axios.get('http://localhost:8080/api/eventos', {
      headers: {
        'Authorization': `Bearer ${authStore.token}`
      }
    });
    // Guardamos la respuesta en nuestra variable
    eventos.value = response.data;
  } catch (error) {
    console.error("Error al cargar los eventos:", error);
  } finally {
    // Esta parte se ejecuta siempre, haya error o no
    isLoading.value = false; // Oculta el mensaje "Cargando..."
  }
});
</script>

<template>
  <div class="eventos-view">
    <header class="view-header">
      <h1>Gestión de Eventos</h1>
      <RouterLink to="/app/eventos/crear" class="primary-button">Añadir Evento</RouterLink>
    </header>

    <div class="table-container">
      <div v-if="isLoading" class="loading-message">
        Cargando eventos...
      </div>

      <table v-else>
        <thead>
          <tr>
            <th>Nombre del Evento</th>
            <th>Cliente</th>
            <th>Fecha de Inicio</th>
            <th>Fecha de Finalización</th>
          </tr>
        </thead>
        <tbody>
          <tr v-if="eventos.length === 0">
            <td colspan="4" class="empty-message">No hay eventos para mostrar.</td>
          </tr>
          <tr v-for="evento in eventos" :key="evento.idEvento">
            <td>{{ evento.nombre }}</td>
            <td>{{ evento.cliente.nombreEmpresa }}</td>
            <td>{{ new Date(evento.fechaInicio).toLocaleString() }}</td>
            <td>{{ new Date(evento.fechaFin).toLocaleString() }}</td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</template>

<style scoped>
.view-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 2rem;
}

.primary-button {
  padding: 0.75rem 1.5rem;
  border: none;
  background-color: #0d6efd;
  color: white;
  border-radius: 6px;
  cursor: pointer;
  font-size: 1rem;
}

.table-container {
  background-color: #fff;
  padding: 1.5rem;
  border-radius: 8px;
  box-shadow: 0 4px 8px rgba(0,0,0,0.05);
}

table {
  width: 100%;
  border-collapse: collapse;
}

th, td {
  padding: 1rem;
  text-align: left;
  border-bottom: 1px solid #dee2e6;
}

thead th {
  font-weight: 600;
  color: #495057;
}

tbody tr:last-child td {
  border-bottom: none;
}
</style>