<script setup>
import { ref, onMounted } from 'vue';
import axios from 'axios';
import { useAuthStore } from '@/stores/auth';
import { useRouter } from 'vue-router';

const evento = ref({
  nombre: '',
  fechaInicio: '',
  fechaFin: '',
  asistentesEstimados: 0,
  idCliente: null,
});

const clientes = ref([]); // Para llenar el <select>
const authStore = useAuthStore();
const router = useRouter();

// Cuando el componente se carga, obtenemos la lista de clientes
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

// Función para guardar el nuevo evento
const handleSave = async () => {
  try {
    await axios.post('http://localhost:8080/api/eventos', evento.value, {
      headers: { 'Authorization': `Bearer ${authStore.token}` }
    });
    // Si se guarda correctamente, redirigimos a la lista de eventos
    router.push('/app/eventos');
  } catch (error) {
    console.error("Error al guardar el evento:", error);
    alert('Hubo un error al guardar el evento.');
  }
};
</script>

<template>
  <div class="form-container">
    <h1>Crear Nuevo Evento</h1>
    <form @submit.prevent="handleSave">
      <div class="form-group">
        <label>Cliente</label>
        <select v-model="evento.idCliente" required>
          <option :value="null" disabled>-- Seleccione un cliente --</option>
          <option v-for="cliente in clientes" :key="cliente.idCliente" :value="cliente.idCliente">
            {{ cliente.nombreEmpresa }}
          </option>
        </select>
      </div>

      <div class="form-group">
        <label>Nombre del Evento</label>
        <input type="text" v-model="evento.nombre" required>
      </div>

      <div class="form-group">
        <label>Fecha y Hora de Inicio</label>
        <input type="datetime-local" v-model="evento.fechaInicio" required>
      </div>

      <div class="form-group">
        <label>Fecha y Hora de Finalización</label>
        <input type="datetime-local" v-model="evento.fechaFin" required>
      </div>

      <div class="form-group">
        <label>Asistentes Estimados</label>
        <input type="number" v-model="evento.asistentesEstimados" required>
      </div>

      <button type="submit" class="primary-button">Guardar Evento</button>
    </form>
  </div>
</template>

<style scoped>
/* Aquí puedes añadir estilos similares a los del LoginView */
.form-container {
  max-width: 600px;
  margin: 0 auto;
  background-color: #fff;
  padding: 2rem;
  border-radius: 8px;
}
.form-group {
  margin-bottom: 1.5rem;
}
input, select {
  width: 100%;
  padding: 0.75rem;
  border: 1px solid #ccc;
  border-radius: 4px;
}
</style>