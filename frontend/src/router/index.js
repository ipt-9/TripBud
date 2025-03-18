import { createRouter, createWebHistory } from 'vue-router';
import RegisterPage from '../components/RegisterPage.vue';
import LoginPage from '../components/LoginPage.vue';
import PlansPage from '../components/PlansPage.vue';
import CreateTrip from '../components/CreateTrip.vue';
import SettingsPage from '../components/SettingsPage.vue';
import StartPage from '../components/StartPage.vue';

const routes = [
  { path: '/plans', component: PlansPage }, // Automatically go to register
  { path: '/register', component: RegisterPage },
  { path: '/login', component: LoginPage },
  { path: '/createtrip', component: CreateTrip }, // <- Hier fehlte das Komma!
  { path: '/settings', component: SettingsPage },
  { path: '/start', component: StartPage }
];


const router = createRouter({
  history: createWebHistory(),
  routes,
});

export default router;