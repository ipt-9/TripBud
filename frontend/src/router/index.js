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
import Dashboard from '../components/Dashboard.vue';
import BudgetPage from '../components/BudgetPage.vue';
import TravelBlog from '../components/TravelBlog.vue';
import Schedule from '../components/Schedule.vue';

const routes = [
  { path: '/', component: MainPage},
  { path: '/plans', component: PlansPage },
  { path: '/register', component: RegisterPage },
  { path: '/login', component: LoginPage },
  { path: '/createtrip', component: CreateTrip},
  { path: '/whyus', component: WhyUs },
  { path: '/start', component: StartPage},
  { path: '/settings', component: SettingsPage},
  { path: '/triporganizer', component: TripOrganizer},
  { path: '/documents', component: documents},
  { path: '/chat', component: ChatPage, meta: {requiresAuth: true}},
  { path: '/dashboard', component: Dashboard},
  { path: '/travelblog', component: TravelBlog},
  { path: '/schedule', component: Schedule},
  { path: '/budgetplaner', component: BudgetPage}
  
];


const router = createRouter({
  history: createWebHistory(),
  routes,
});

export default router;