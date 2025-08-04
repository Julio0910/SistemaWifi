<script setup>
import { ref, onMounted } from 'vue';
import axios from 'axios';
import { useAuthStore } from '@/stores/auth';

const stats = ref({
  eventos_activos: 0,
  antenas_activas: 0,
  codigos_generados_hoy: 0,
  consumo_total_gb: 0,
});

const authStore = useAuthStore();

onMounted(async () => {
  try {
    const response = await axios.get('http://localhost:8080/api/dashboard-stats', {
      headers: {
        'Authorization': `Bearer ${authStore.token}`
      }
    });
    stats.value = response.data;
  } catch (error) {
    console.error("Error al cargar las estadísticas:", error);
  }
});
</script>

<template>
  <div class="dashboard">
    <div class="stats-cards">
      <div class="card">
        <div class="card-icon">📊</div>
        <div class="card-info">
          <span class="value">{{ stats.eventos_activos }}</span>
          <span class="label">Eventos activos</span>
        </div>
      </div>
      <div class="card">
        <div class="card-icon">📡</div>
        <div class="card-info">
          <span class="value">{{ stats.antenas_activas }}</span>
          <span class="label">Antenas activas</span>
        </div>
      </div>
      <div class="card">
        <div class="card-icon">🔑</div>
        <div class="card-info">
          <span class="value">{{ stats.codigos_generados_hoy }}</span>
          <span class="label">Códigos generados hoy</span>
        </div>
      </div>
      <div class="card">
        <div class="card-icon">📈</div>
        <div class="card-info">
          <span class="value">{{ stats.consumo_total_gb }} GB</span>
          <span class="label">Consumo total</span>
        </div>
      </div>
    </div>

    <div class="chart-container">
      <h2>Uso de WiFi por día</h2>
      <p>(Gráfica en construcción)</p>
    </div>
  </div>
</template>

<style scoped>
.dashboard {
  display: flex;
  flex-direction: column;
  gap: 2rem;
}
.stats-cards {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
  gap: 1.5rem;
}
.card {
  background-color: #fff;
  padding: 1.5rem;
  border-radius: 8px;
  box-shadow: 0 4px 8px rgba(0,0,0,0.05);
  display: flex;
  align-items: center;
  gap: 1rem;
}
.card-icon {
  font-size: 2.5rem;
  color: #adb5bd;
}
.card-info {
  display: flex;
  flex-direction: column;
}
.card-info .value {
  font-size: 1.8rem;
  font-weight: bold;
  color: #343a40;
}
.card-info .label {
  color: #6c757d;
}
.chart-container {
  background-color: #fff;
  padding: 1.5rem;
  border-radius: 8px;
  box-shadow: 0 4px 8px rgba(0,0,0,0.05);
}
</style>