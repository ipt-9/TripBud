// src/services/api.js
import axios from 'axios';
import router from '../router'; // Make sure this path is correct for your project

// API URL - you can switch between these based on your needs
// const API_URL = 'https://api.tripbud-bmsd22a.bbzwinf.ch/api'; // For direct access
const API_URL = '/api'; // For using with Vite proxy

// Create axios instance with configuration
const api = axios.create({
  baseURL: API_URL,
  headers: {
    'Content-Type': 'application/json',
    'Accept': 'application/json'
  },
  withCredentials: true // This is important for cookie-based auth like Sanctum
});

// Request interceptor to add authentication token to every request
api.interceptors.request.use(
  config => {
    // Use bearerToken as that's what your login component is using
    const token = localStorage.getItem('bearerToken');
    
    // Log for debugging - you can remove this in production
    console.log('Making request to:', config.url);
    console.log('Auth token:', token ? 'exists' : 'missing');
    
    if (token) {
      config.headers['Authorization'] = `Bearer ${token}`;
    }
    return config;
  },
  error => {
    return Promise.reject(error);
  }
);

// Response interceptor to handle authentication errors
api.interceptors.response.use(
  response => response,
  async error => {
    // Log detailed error information for debugging
    console.log('API Error:', error.response?.status, error.response?.data);
    
    const originalRequest = error.config;

    // Handle 401 Unauthorized errors
    if (error.response && error.response.status === 401 && !originalRequest._retry) {
      originalRequest._retry = true;
      
      // Store the attempted URL to redirect back after login
      const currentPath = window.location.pathname;
      if (currentPath !== '/login') {
        localStorage.setItem('login_redirect', currentPath);
      }
      
      // Clear auth data
      localStorage.removeItem('bearerToken');
      localStorage.removeItem('userId');
      
      // Redirect to login - use router if imported, otherwise fallback to location
      if (router) {
        router.push('/login');
      } else {
        window.location.href = '/login';
      }
      
      return Promise.reject(error);
    }

    return Promise.reject(error);
  }
);

// API service methods
const apiService = {
  // User profile and settings
  getUser() {
    return api.get('/user');
  },
  
  getUserSettings() {
    return api.get('/settings');
  },

  updateUserSettings(data) {
    return api.put('/settings/updateChanges', data);
  },

  cancelChanges() {
    return api.get('/settings/cancelChanges');
  },

  // Profile image handling
  uploadProfileImage(formData) {
    return api.put('/settings/account/profile/tempUpdateImage', formData, {
      headers: {
        'Content-Type': 'multipart/form-data'
      }
    });
  },

  deleteProfileImage() {
    return api.delete('/settings/account/profile/tempDeleteImage');
  },
  
  // Notifications
  getNotifications() {
    return api.get('/notifications');
  },
  
  markNotificationAsRead(notificationId) {
    return api.put(`/notifications/${notificationId}/read`);
  },
  
  updateNotificationSettings(settings) {
    return api.put('/settings/notifications', settings);
  },
  
  // Payment methods
  getPaymentMethods() {
    return api.get('/payment-methods');
  },
  
  addPaymentMethod(paymentData) {
    return api.post('/payment-methods', paymentData);
  },
  
  updatePaymentMethod(paymentId, paymentData) {
    return api.put(`/payment-methods/${paymentId}`, paymentData);
  },
  
  deletePaymentMethod(paymentId) {
    return api.delete(`/payment-methods/${paymentId}`);
  },

  // Subscription plans
  getPlans() {
    return api.get('/settings/plans');
  },
  
  changePlan(planId) {
    return api.put('/settings/subscription', { plan_id: planId });
  },

  // Support info
  getSupportInfo() {
    return api.get('/settings/support');
  },
  
  submitSupportRequest(data) {
    return api.post('/support/request', data);
  },
  
  submitBugReport(data) {
    return api.post('/support/bug-report', data);
  },

  // Messages
  getMessages() {
    return api.get('/messages');
  },
  
  sendMessage(messageData) {
    return api.post('/messages', messageData);
  },

  // Helper for Sanctum CSRF protection
  getCsrfCookie() {
    return api.get('/sanctum/csrf-cookie');
  },
  
  // Generic request methods for custom endpoints
  get(endpoint, params = {}) {
    return api.get(endpoint, { params });
  },
  
  post(endpoint, data = {}) {
    return api.post(endpoint, data);
  },
  
  put(endpoint, data = {}) {
    return api.put(endpoint, data);
  },
  
  delete(endpoint) {
    return api.delete(endpoint);
  }
};

export default apiService;