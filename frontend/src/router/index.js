import { createRouter, createWebHistory } from 'vue-router';
import RegisterPage from '../components/RegisterPage.vue';
import LoginPage from '../components/LoginPage.vue';
import PlansPage from '../components/PlansPage.vue';
import CreateTrip from '../components/CreateTrip.vue';
import SettingsPage from '../components/SettingsPage.vue';
import WhyUs from '../components/WhyUs.vue';
import StartPage from '../components/StartPage.vue';
import documents from '../components/documents.vue';
import MainPage from '../components/MainPage.vue';

const routes = [
  { path: '/plans', component: PlansPage }, // Automatically go to register
  { path: '/register', component: RegisterPage },
  { path: '/login', component: LoginPage },
  { path: '/createtrip', component: CreateTrip},
  { path: '/whyus', component: WhyUs },
  { path: '/start', component: StartPage},
  { path: '/settings', component: SettingsPage},
  { path: '/documents', component: documents},
  { path: '/', component: MainPage}
];


const router = createRouter({
  history: createWebHistory(),
  routes,
});

export default router;