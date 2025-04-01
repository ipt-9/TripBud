import axios from 'axios';
 
const api = axios.create({
  baseURL: 'http://localhost:8000/api', // URL deines Backends
  timeout: 1000,
  headers: {
    'Content-Type': 'application/json',
  },
});
 
// Authentifizierte Anfragen (falls notwendig)
api.interceptors.request.use((config) => {
  const token = localStorage.getItem('token'); // Token aus dem LocalStorage holen
  if (token) {
    config.headers['Authorization'] = `Bearer ${token}`;
  }
  return config;
});
 
export default api;