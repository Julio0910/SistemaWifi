<script setup>
import { RouterView } from 'vue-router';
import { useAuthStore } from '@/stores/auth'; // 1. Importa el store

const authStore = useAuthStore(); // 2. Inicializa el store

// 3. La función ahora llama a la acción de logout del store
const logout = () => {
  authStore.logout();
};
</script>

<template>
  <div class="app-layout">
    <aside class="sidebar">
      <div class="sidebar-header">
        <span class="logo">📡</span>
        <h2>Gestión WiFi</h2>
      </div>
   <nav>
  <ul>
    <li><RouterLink to="/app/dashboard">🏠 Inicio</RouterLink></li>
    <li><RouterLink to="/app/eventos">📅 Eventos</RouterLink></li>
    <li><RouterLink to="/app/codigos">🔑 Códigos</RouterLink></li>
    <li><RouterLink to="/app/clientes">👤 Clientes</RouterLink></li>
    <li><RouterLink to="/app/salones">🚪 Salones</RouterLink></li>

    <li><RouterLink to="/app/grupos-antena">📡 Grupos de Antena</RouterLink></li>

    <li><RouterLink to="/app/antenas">🛰️ Antenas</RouterLink></li>
    <li><RouterLink to="/app/facturacion">🧾 Facturación</RouterLink></li>
  </ul>
</nav>
    </aside>

    <main class="main-content">
      <header class="main-header">
        <h1>Inicio</h1>
        <div class="user-info">
          <span>Cliente Hotel</span>
          <a href="#" @click.prevent="logout" class="logout-link">Cerrar sesión</a>
        </div>
      </header>

      <div class="page-content">
        <RouterView />
      </div>
    </main>
  </div>
</template>

<style scoped>
.app-layout {
  display: flex;
  height: 100vh;
  background-color: #f8f9fa;
}

.sidebar {
  width: 250px;
  background-color: #fff;
  border-right: 1px solid #dee2e6;
  display: flex;
  flex-direction: column;
  padding: 1.5rem 1rem;
}
.sidebar-header {
  display: flex;
  align-items: center;
  margin-bottom: 2rem;
}
.logo { font-size: 2rem; margin-right: 10px; }
.sidebar h2 { font-size: 1.2rem; }
.sidebar nav ul { list-style: none; padding: 0; }
.sidebar nav li a {
  display: block;
  padding: 0.75rem 1rem;
  border-radius: 6px;
  text-decoration: none;
  color: #495057;
  margin-bottom: 0.5rem;
}
.sidebar nav li a:hover { background-color: #e9ecef; }

.main-content {
  flex-grow: 1;
  display: flex;
  flex-direction: column;
}
.main-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 1rem 2rem;
  background-color: #fff;
  border-bottom: 1px solid #dee2e6;
}
.user-info .logout-link {
  margin-left: 1rem;
  color: #0d6efd;
  text-decoration: none;
}
.page-content {
  padding: 2rem;
  flex-grow: 1;
  overflow-y: auto;
}
</style>