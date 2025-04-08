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
import TripOrganizer from '../components/TripOrganizer.vue';
import ChatPage from '../components/Chatpage.vue';

const routes = [
  { path: '/', component: documents},
  { path: '/plans', component: PlansPage },
  { path: '/register', component: RegisterPage },
  { path: '/login', component: LoginPage },
  { path: '/createtrip', component: CreateTrip},
  { path: '/whyus', component: WhyUs },
  { path: '/start', component: StartPage},
  { path: '/settings', component: SettingsPage},
  { path: '/triporganizer', component: TripOrganizer},
<<<<<<< HEAD
  { path: '/mainpage', component: MainPage}
=======
  { path: '/documents', component: documents},
  { path: '/chat', component: ChatPage, meta: {requiresAuth: true}}

>>>>>>> dbb4ea5163127501e2b3affe2c611105e4fd911d
  
];


const router = createRouter({
  history: createWebHistory(),
  routes,
});

export default router;