// src/router/index.js
import { createRouter, createWebHistory } from 'vue-router';

// Import refactored views
import LandingPage from '../views/LandingPage.vue';
import LoginPage from '../views/LoginPage.vue';
import RegisterPage from '../views/RegisterPage.vue';
import TripOrganizerPage from '../components/TripOrganizer.vue';
import DashboardPage from '../components/Dashboard.vue';
import ChatPage from '../components/ChatPage.vue';
import CreateTrip from '../components/CreateTrip.vue';
import SettingsPage from '../components/SettingsPage.vue';
import documents from '../components/documents.vue';
import TravelBlog from '../components/TravelBlog.vue';
import Schedule from '../components/Schedule.vue';
import BudgetPage from '../components/BudgetPage.vue';


const routes = [
  { path: '/', component: LandingPage },
  { path: '/register', component: RegisterPage },
  { path: '/login', component: LoginPage },
   { 
     path: '/createtrip', 
     component: CreateTrip, 
     meta: { requiresAuth: true }
   },
   { 
     path: '/settings', 
     component: SettingsPage,
     meta: { requiresAuth: true }
   },
   { 
     path: '/triporganizer', 
     component: TripOrganizerPage,
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
     component: DashboardPage,
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

 router.beforeEach((to, from, next) => {
   const isAuthenticated = !!localStorage.getItem('bearerToken');
  
   if (to.meta.requiresAuth && !isAuthenticated) {
     next('/login');
   } else {
     next();
   }
 });

export default router;