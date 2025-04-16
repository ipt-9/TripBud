// src/router/index.js
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
import ChatPage from '../components/ChatPage.vue';
import Dashboard from '../components/Dashboard.vue';
import BudgetPage from '../components/BudgetPage.vue';
import TravelBlog from '../components/TravelBlog.vue';
import Schedule from '../components/Schedule.vue';

const routes = [
  { path: '/', component: MainPage },
  { path: '/plans', component: PlansPage },
  { path: '/register', component: RegisterPage },
  { path: '/login', component: LoginPage },
  { 
    path: '/createtrip', 
    component: CreateTrip, 
    meta: { requiresAuth: true }
  },
  { path: '/whyus', component: WhyUs },
  { path: '/start', component: StartPage },
  { 
    path: '/settings', 
    component: SettingsPage,
    meta: { requiresAuth: true }
  },
  { 
    path: '/triporganizer', 
    component: TripOrganizer,
    meta: { requiresAuth: true }
  },
  { 
    path: '/documents', 
    component: documents,
    meta: { requiresAuth: true }
  },
  { 
    path: '/chat', 
    component: ChatPage, 
    meta: { requiresAuth: true }
  },
  { 
    path: '/dashboard', 
    component: Dashboard,
    meta: { requiresAuth: true }
  },
  { 
    path: '/travelblog', 
    component: TravelBlog,
    meta: { requiresAuth: true }
  },
  { 
    path: '/schedule', 
    component: Schedule,
    meta: { requiresAuth: true }
  },
  { 
    path: '/budgetplaner', 
    component: BudgetPage,
    meta: { requiresAuth: true }
  }
];

const router = createRouter({
  history: createWebHistory(),
  routes,
});

// Add navigation guard to check authentication
router.beforeEach((to, from, next) => {
  const isAuthenticated = !!localStorage.getItem('bearerToken');
  
  if (to.meta.requiresAuth && !isAuthenticated) {
    // Redirect to login if trying to access protected route without authentication
    next('/login');
  } else {
    // Proceed normally
    next();
  }
});

export default router;