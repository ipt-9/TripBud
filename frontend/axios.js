import axios from 'axios';
const api = axios.create({
  baseURL: 'https://api.tripbud-bmsd22a.bbzwinf.ch/api', // Update to your production API URL
  timeout: 5000, // Increased timeout for production environment
  headers: {
    'Content-Type': 'application/json',
  },
  withCredentials: true, // This is essential for Sanctum to work across domains
});
// If you're using token authentication instead of Sanctum's cookie-based auth
api.interceptors.request.use((config) => {
  const token = localStorage.getItem('token');
  if (token) {
    config.headers['Authorization'] = `Bearer ${token}`;
  }
  return config;
});
export default api;