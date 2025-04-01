<template>
  <div class="login-container">
    <div class="logo-container">
      <img v-for="img in images" v-bind:src="img" class="logo" />
      <span class="logo-text">TripBud</span>
    </div>

    <h2 class="login-title">Login</h2>
    <div class="login-card">
      <form @submit.prevent="handleLogin">
        <!-- Username -->
        <label for="username" class="textleft">Username</label>
        <input v-model="username" type="text" id="username" placeholder="Username" required />
        <p v-if="errors.username" class="error">{{ errors.username }}</p>

        <!-- Password -->
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
            <img v-for="(img, index) in passwordImages" :key="index" :src="img" style="width: 20px; height: 20px;" />
          </button>
        </div>
        <p v-if="errors.password" class="error">{{ errors.password }}</p>

        <!-- Submit Button -->
        <button type="submit" class="signin-button" :disabled="!formValid">Sign In</button>
      </form>
      <p>Don't have an account? <router-link to="/register" class="register-text">Register now</router-link></p>
      <p v-if="errors.general" class="error">{{ errors.general }}</p>
    </div>

    <!-- Custom Popup -->
    <transition name="fade">
      <div v-if="showPopup" class="popup-overlay" @click="closePopup">
        <div class="popup-content" @click.stop>
          <div class="popup-icon">
            <svg width="40" height="40" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path d="M22 11.0857V12.0057C21.9988 14.1621 21.3005 16.2604 20.0093 17.9875C18.7182 19.7147 16.9033 20.9782 14.8354 21.5896C12.7674 22.201 10.5573 22.1276 8.53447 21.3803C6.51168 20.633 4.78465 19.2518 3.61096 17.4428C2.43727 15.6338 1.87979 13.4938 2.02168 11.342C2.16356 9.19029 2.99721 7.14205 4.39828 5.5028C5.79935 3.86354 7.69279 2.72111 9.79619 2.24587C11.8996 1.77063 14.1003 1.98806 16.07 2.86572" stroke="#409FDB" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
              <path d="M22 4L12 14.01L9 11.01" stroke="#409FDB" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
          </div>
          <h3 class="popup-title">Welcome back!</h3>
          <p class="popup-message">{{ popupMessage }}</p>
          <button class="popup-button" @click="closePopup">Continue</button>
        </div>
      </div>
    </transition>
  </div>
</template>

<script>
export default {
  data() {
    return {
      username: '',
      password: '',
      showPassword: false,
      errors: {}, // Stores validation errors
      images: ['../assets/TripBudLogo.png'],
      passwordImages: ['../assets/hide.png'],
      showPopup: false,
      popupMessage: ''
    };
  },
  computed: {
    // Frontend validation check for enabling the submit button
    formValid() {
      return this.username && this.password;
    }
  },
  methods: {
    async handleLogin() {
      this.errors = {}; // Clear previous errors

      // Basic validation before submitting to the backend
      if (!this.username || !this.password) {
        this.errors.general = 'Both fields are required';
        return;
      }

      try {
        // Submit login data to backend API
        const response = await fetch('https://api.tripbud-bmsd22a.bbzwinf.ch/api/login/user', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
          },
          body: JSON.stringify({
            login: this.username, // Assuming backend accepts either username or email
            password: this.password
          })
        });

        const data = await response.json();

        if (response.ok) {
          // Successful login, show welcome popup
          this.popupMessage = `Welcome back, ${this.username}! You've successfully logged in.`;
          this.showPopup = true;
          
          // We'll redirect after the popup is closed
        } else if (response.status === 422) {
          // Backend validation errors (e.g., empty fields or other validation issues)
          this.errors = data.errors;
        } else if (response.status === 401) {
          // Incorrect username or password
          this.errors.general = 'Invalid username or password';
        } else {
          // Handle any other errors
          this.errors.general = data.message || 'An unexpected error occurred. Please try again.';
        }
      } catch (error) {
        // Handle network or API errors
        this.errors.general = 'An error occurred. Please try again later.';
      }
    },
    togglePasswordVisibility() {
      this.showPassword = !this.showPassword;
    },
    closePopup() {
      this.showPopup = false;
      // Redirect to dashboard after closing popup
      this.$router.push('/dashboard');
    }
  }
};
</script>

<style scoped>
* {
  font-family: 'Outfit', sans-serif;
}

.login-container {
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  height: 100vh;
  background: linear-gradient(to bottom, #e0f2fe, #ffffff);
}

.logo-container {
  position: absolute;
  top: 20px;
  left: 20px;
  display: flex;
  align-items: center;
}

.logo-container img {
  height: 50px;
  margin-right: 10px;
}

.logo-container span {
  font-size: 32px;
  font-weight: bold;
  color: #409FDB;
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
  width: 300px;
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
}

.signin-button:hover {
  background: #368BD1;
}

.error {
  color: red;
  margin-top: 1rem;
}

.register-text {
  color: #409FDB;
  cursor: pointer;
}

.register-text:hover {
  text-decoration: underline;
}

/* Popup styles */
.popup-overlay {
  position: fixed;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background-color: rgba(0, 0, 0, 0.5);
  display: flex;
  justify-content: center;
  align-items: center;
  z-index: 1000;
}

.popup-content {
  background-color: white;
  border-radius: 10px;
  padding: 2rem;
  max-width: 400px;
  width: 90%;
  text-align: center;
  box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
  animation: popup-appear 0.3s ease-out;
}

.popup-icon {
  margin: 0 auto 1.5rem;
  width: 60px;
  height: 60px;
  background-color: rgba(64, 159, 219, 0.1);
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
}

.popup-title {
  color: #333;
  font-size: 1.5rem;
  margin-bottom: 0.75rem;
}

.popup-message {
  color: #666;
  margin-bottom: 1.5rem;
  line-height: 1.5;
}

.popup-button {
  background: #409FDB;
  color: white;
  border: none;
  border-radius: 5px;
  padding: 0.75rem 2rem;
  font-size: 1rem;
  cursor: pointer;
  transition: background-color 0.2s;
}

.popup-button:hover {
  background: #368BD1;
}

/* Animation */
.fade-enter-active, .fade-leave-active {
  transition: opacity 0.3s;
}

.fade-enter, .fade-leave-to {
  opacity: 0;
}

@keyframes popup-appear {
  from {
    opacity: 0;
    transform: scale(0.9);
  }
  to {
    opacity: 1;
    transform: scale(1);
  }
}
</style>