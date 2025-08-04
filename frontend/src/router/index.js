import { createRouter, createWebHistory } from 'vue-router'
import { useAuthStore } from '@/stores/auth' // <-- 1. FALTABA ESTA IMPORTACIÓN
import LoginView from '../views/LoginView.vue'
import DashboardView from '../views/DashboardView.vue'
import AppLayout from '../layouts/AppLayout.vue'
import EventosView from '../views/EventosView.vue'
import CodigosView from '../views/CodigosView.vue'
import AntenasView from '../views/AntenasView.vue'
import FacturacionView from '../views/FacturacionView.vue'
import EventoCreateView from '../views/EventoCreateView.vue';
import ClientesView from '../views/ClientesView.vue';
import ClienteCreateView from '../views/ClienteCreateView.vue';
import SalonesView from '../views/SalonesView.vue';
import SalonCreateView from '../views/SalonCreateView.vue';
import GruposAntenaView from '../views/GruposAntenaView.vue';
import GrupoAntenaCreateView from '../views/GrupoAntenaCreateView.vue';
import AntenaCreateView from '../views/AntenaCreateView.vue';



const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    { path: '/', name: 'login', component: LoginView },
    {
      path: '/app',
      component: AppLayout,
      meta: { requiresAuth: true }, // <-- 2. FALTABA MARCAR LAS RUTAS COMO PROTEGIDAS
      children: [
        { path: 'dashboard', name: 'dashboard', component: DashboardView },
        { path: 'eventos', name: 'eventos', component: EventosView },
        { path: 'codigos', name: 'codigos', component: CodigosView },
        { path: 'antenas', name: 'antenas', component: AntenasView },
        { path: 'salones', name: 'salones', component: SalonesView }, 
        { path: 'facturacion', name: 'facturacion', component: FacturacionView }, 
        { path: 'eventos/crear', name: 'eventos-crear', component: EventoCreateView },
        { path: 'clientes', name: 'clientes', component: ClientesView },
        { path: 'clientes/crear', name: 'clientes-crear', component: ClienteCreateView },
        { path: 'salones', name: 'salones', component: SalonesView },
        { path: 'salones/crear', name: 'salones-crear', component: SalonCreateView },
        { path: 'grupos-antena', name: 'grupos-antena', component: GruposAntenaView },
        { path: 'grupos-antena/crear', name: 'grupos-antena-crear', component: GrupoAntenaCreateView },
        { path: 'antenas', name: 'antenas', component: AntenasView },
        { path: 'antenas/crear', name: 'antenas-crear', component: AntenaCreateView },
      ]
    }
  ]
})

// --- EL GUARDIA DE NAVEGACIÓN ---
router.beforeEach((to, from, next) => {
  const authStore = useAuthStore();

  // Si la ruta requiere autenticación y el usuario no está logueado
  if (to.meta.requiresAuth && !authStore.isAuthenticated) {
    // Redirige al login
    next({ name: 'login' });
  } else {
    // Deja pasar al usuario
    next();
  }
});
// ---------------------------------

export default router