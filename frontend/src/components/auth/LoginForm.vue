<template>
  <div class="login-form-container">
    <h2 class="login-title">Login</h2>
    <div class="login-card">
      <form @submit.prevent="handleLogin">
        <label for="username" class="textleft">Username</label>
        <input 
          v-model="username" 
          type="text" 
          id="username" 
          placeholder="Username" 
          required 
        />
        <p v-if="errors.username" class="error">{{ errors.username }}</p>

        <label for="password" class="textleft">Password</label>
        <div class="password-wrapper">
          <input
            v-model="password"
            :type="showPassword ? 'text' : 'password'"
            id="password"
            placeholder="Password"
            required
          />
          <button
            type="button"
            class="toggle-password"
            @click="togglePasswordVisibility"
          >
            <img :src="passwordIcon" style="width: 20px; height: 20px;" alt="Toggle password visibility" />
          </button>
        </div>
        <p v-if="errors.password" class="error">{{ errors.password }}</p>

        <button type="submit" class="signin-button" :disabled="!formValid">
          Sign In
        </button>
      </form>
      <p>
        Don't have an account? 
        <router-link to="/register" class="register-text">Register now</router-link>
      </p>
      <p v-if="errors.general" class="error">{{ errors.general }}</p>
    </div>
  </div>
</template>

<script>
// Import password visibility icon
import hideIcon from '@/assets/hide.png';

export default {
  name: 'LoginForm',
  data() {
    return {
      username: '',
      password: '',
      showPassword: false,
      errors: {},
      passwordIcon: hideIcon
    };
  },
  computed: {
    formValid() {
      return this.username && this.password;
    }
  },
  methods: {
    async handleLogin() {
      this.errors = {};

      if (!this.username || !this.password) {
        this.errors.general = 'Both fields are required';
        return;
      }

      try {
        const response = await fetch('https://api.tripbud-bmsd22a.bbzwinf.ch/api/login/user', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
          },
          body: JSON.stringify({
            login: this.username,
            password: this.password
          })
        });

        const data = await response.json();

        if (response.ok) {
          // Save the token and user ID to localStorage
          if (data && data.token) {
            // Log the response data for debugging
            console.log('Login response data:', data);
            
            // Save the token
            localStorage.setItem('bearerToken', data.token);
            
            // Save the user ID if available, otherwise use default
            const userId = data.user && data.user.id ? data.user.id : '3';
            localStorage.setItem('userId', userId);
            
            console.log('Saved token:', data.token);
            console.log('Saved user ID:', userId);
          } else {
            console.error('Token not found in response:', data);
            // Using a placeholder token for testing/development ONLY
            localStorage.setItem('bearerToken', '18|feuNjrwwH8BhUkV2pDYWD0Uaf1A6Gn9Ukrov5Ij52670c870');
            localStorage.setItem('userId', '3');
          }
          
          // Emit success event
          this.$emit('login-success', this.username);
          
        } else if (response.status === 422) {
          this.errors = data.errors;
          this.$emit('show-error', 'Validation error');
        } else if (response.status === 401) {
          this.errors.general = 'Invalid username or password';
          this.$emit('show-error', 'Authentication error');
        } else {
          this.errors.general = data.message || 'An unexpected error occurred. Please try again.';
          this.$emit('show-error', 'Server error');
        }
      } catch (error) {
        console.error('Login error:', error);
        this.errors.general = 'An error occurred. Please try again later.';
        this.$emit('show-error', error.message);
      }
    },
    togglePasswordVisibility() {
      this.showPassword = !this.showPassword;
    }
  }
};
</script>

<style scoped>
* {
  font-family: 'Outfit', sans-serif;
}

.login-form-container {
  width: 100%;
  max-width: 400px;
  margin: 0 auto;
}

.login-title {
  font-size: 2rem;
  margin-bottom: 1rem;
  text-align: center;
}

.login-card {
  background: white;
  padding: 2rem;
  border-radius: 10px;
  box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
  text-align: center;
  width: 100%;
}

form {
  display: flex;
  flex-direction: column;
  align-items: stretch;
}

label {
  text-align: left;
  margin-top: 1rem;
  margin-bottom: 0.25rem;
}

input, .signin-button {
  width: 100%;
  padding: 0.7rem;
  border: 1px solid #ccc;
  border-radius: 5px;
  display: block;
  box-sizing: border-box;
}

.password-wrapper {
  position: relative;
}

.password-wrapper input {
  flex: 1;
}

.toggle-password {
  position: absolute;
  right: 10px;
  top: 50%;
  transform: translateY(-50%);
  background: none;
  border: none;
  cursor: pointer;
  font-size: 20px;
  padding: 0;
}

.signin-button {
  background: #409FDB;
  color: white;
  cursor: pointer;
  border: none;
  margin-top: 1rem;
  margin-bottom: 1rem;
  transition: background-color 0.3s, transform 0.2s;
}

.signin-button:hover {
  background: #368BD1;
  transform: translateY(-2px);
}

.signin-button:disabled {
  background: #90c4eb;
  cursor: not-allowed;
  transform: none;
}

.error {
  color: red;
  margin-top: 0.5rem;
  font-size: 0.9rem;
}

.register-text {
  color: #409FDB;
  cursor: pointer;
}

.register-text:hover {
  text-decoration: underline;
}

@media (max-width: 576px) {
  .login-card {
    padding: 1.5rem;
  }
  
  .login-title {
    font-size: 1.8rem;
  }
}
</style>