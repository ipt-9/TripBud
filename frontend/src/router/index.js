// src/router/index.js
import { createRouter, createWebHistory } from 'vue-router';

// Import refactored views
import LandingPage from '../views/LandingPage.vue';
import LoginPage from '../views/LoginPage.vue';
// import RegisterPage from '../views/RegisterPage.vue';

const routes = [
  { path: '/', component: LandingPage }, // Set LandingPage as the root route
  // { path: '/register', component: RegisterPage },
  { path: '/login', component: LoginPage },
//   { 
//     path: '/createtrip', 
//     component: CreateTrip, 
//     meta: { requiresAuth: true }
//   },
//   { path: '/whyus', component: WhyUs },
//   { path: '/start', component: StartPage },
//   { 
//     path: '/settings', 
//     component: SettingsPage,
//     meta: { requiresAuth: true }
//   },
//   { 
//     path: '/triporganizer', 
//     component: TripOrganizer,
//     meta: { requiresAuth: true }
//   },
//   { 
//     path: '/documents', 
//     component: documents,
//     meta: { requiresAuth: true }
//   },
//   { 
//     path: '/chat', 
//     component: ChatPage, 
//     meta: { requiresAuth: true }
//   },
//   { 
//     path: '/dashboard', 
//     component: Dashboard,
//     meta: { requiresAuth: true }
//   },
//   { 
//     path: '/travelblog', 
//     component: TravelBlog,
//     meta: { requiresAuth: true }
//   },
//   { 
//     path: '/schedule', 
//     component: Schedule,
//     meta: { requiresAuth: true }
//   },
//   { 
//     path: '/budgetplaner', 
//     component: BudgetPage,
//     meta: { requiresAuth: true }
//   }
];

const router = createRouter({
   history: createWebHistory(),
   routes,
 });

// // Add navigation guard to check authentication
 router.beforeEach((to, from, next) => {
   const isAuthenticated = !!localStorage.getItem('bearerToken');
  
   if (to.meta.requiresAuth && !isAuthenticated) {
//     // Redirect to login if trying to access protected route without authentication
     next('/login');
   } else {
//     // Proceed normally
     next();
   }
 });

export default router;