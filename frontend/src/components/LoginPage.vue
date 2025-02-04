<template>
    <div class="login-container">
        <!-- TripBud Logo and Name -->
    <div class="logo-container">
        <img src="C:\Users\mpira\TripBud\TripBud\frontend\src\assets\TripBudLogo.png" alt="TripBud Logo" class="logo" />
      <span class="logo-text">TripBud</span>
    </div>
    
    <!-- Login Title Outside Card -->
    <h2 class="login-title">Login</h2>
      <div class="login-card">
        <form @submit.prevent="handleLogin">
          <label for="username" class="textleft">Username</label>
          <input v-model="username" type="text" id="username" placeholder="Username" required />
          
          <label for="password" class="textleft">Password</label>
          <input v-model="password" type="password" id="password" placeholder="Password" required />
          
          <button type="submit">Sign Up</button>
        </form>
        <p>Don't have an account? <router-link to="/register"class="register-text">Register now</router-link></p>
        <p v-if="errorMessage" class="error">{{ errorMessage }}</p>
      </div>
    </div>
  </template>

<script>
export default {
  data() {
    return {
      username: '',
      password: '',
      errorMessage: ''
    };
    
  },
  methods: {
    handleLogin() {
      if (this.username !== 'testuser' || this.password !== 'testpass') {
        this.errorMessage = 'Invalid username or password';
      } else {
        this.$router.push('/dashboard'); // Hier deine Zielseite einfügen
      }
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
  height: 40px;
  margin-right: 10px;
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
  width: 300px; /* Prevents resizing issues */
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

input,
button {
  width: 100%; /* Ensures inputs and button are aligned */
  padding: 0.7rem;
  border: 1px solid #ccc;
  border-radius: 5px;
  display: block;
  box-sizing: border-box; /* Prevents extra width from padding */
}

button {
  background: #409FDB;
  color: white;
  cursor: pointer;
  border: none;
  margin-top: 1rem;
}

button:hover {
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
.logo-container img {
  height: 50px; /* Increased logo size */
}
.logo-container span {
  font-size: 32px; /* Bigger text */
  font-weight: bold;
  color: #409FDB;
}

</style>