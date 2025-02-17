import { createRouter, createWebHistory } from 'vue-router';
import RegisterPage from '../components/RegisterPage.vue';
import LoginPage from '../components/LoginPage.vue';
import PlansPage from '../components/PlansPage.vue';
import CreateTrip from '../components/CreateTrip.vue';

const routes = [
  
  { path: 'Plans', component: PlansPage}, // Automatically go to register
  { path: '/register', component: RegisterPage },
  { path: '/login', component: LoginPage },
  { path: '/createtrip', component: CreateTrip}
];

const router = createRouter({
  history: createWebHistory(),
  routes,
});

export default router;