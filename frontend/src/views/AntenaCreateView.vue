<script setup>
import { ref, onMounted } from 'vue';
import axios from 'axios';
import { useAuthStore } from '@/stores/auth';
import { useRouter } from 'vue-router';

const antena = ref({ nombre: '', ip: '', modelo: '', idGrupoAntena: null });
const grupos = ref([]);
const isLoading = ref(false);
const authStore = useAuthStore();
const router = useRouter();

onMounted(async () => {
    const response = await axios.get('http://localhost:8080/api/grupos-antena', {
      headers: { 'Authorization': `Bearer ${authStore.token}` }
    });
    grupos.value = response.data;
});

const handleSave = async () => {
  isLoading.value = true;
  try {
    await axios.post('http://localhost:8080/api/antenas', antena.value, {
      headers: { 'Authorization': `Bearer ${authStore.token}` }
    });
    router.push('/app/antenas');
  } catch (error) {
    alert('Hubo un error al guardar.');
  } finally {
    isLoading.value = false;
  }
};
</script>
<template>
  <div class="form-container">
    <h1>Crear Nueva Antena</h1>
    <form @submit.prevent="handleSave">
      <div class="form-group">
        <label>Grupo de Antena</label>
        <select v-model="antena.idGrupoAntena" required>
          <option :value="null" disabled>-- Seleccione un grupo --</option>
          <option v-for="grupo in grupos" :key="grupo.idGrupoAntena" :value="grupo.idGrupoAntena">{{ grupo.nombre }}</option>
        </select>
      </div>
      <div class="form-group">
        <label>Nombre de la Antena</label>
        <input type="text" v-model="antena.nombre" required>
      </div>
       <div class="form-group">
        <label>Dirección IP</label>
        <input type="text" v-model="antena.ip" required>
      </div>
       <div class="form-group">
        <label>Modelo</label>
        <input type="text" v-model="antena.modelo">
      </div>
      <button type="submit" class="primary-button" :disabled="isLoading">{{ isLoading ? 'Guardando...' : 'Guardar Antena' }}</button>
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