<template>
  <div class="login-container">
    <div class="logo-container">
      <img src="C:\Users\schus\TripBud\TripBud\frontend\src\assets\TripBudLogo.png" alt="TripBud Logo" class="logo" />
      <span class="logo-text">TripBud</span>
    </div>

    <h2 class="login-title">Register</h2>
    <div class="login-card">
      <form @submit.prevent="handleLogin">
        <label for="fullname" class="textleft">Fullname</label>
        <input v-model="username" type="text" id="fullname" placeholder="Fullname" required />

        <label for="username" class="textleft">Username</label>
        <input v-model="username" type="text" id="username" placeholder="Username" required />

        <label for="email" class="textleft">Email</label>
        <input v-model="username" type="text" id="email" placeholder="Email" required />

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
            <img src="C:\Users\schus\TripBud\TripBud\frontend\src\assets\hide.png" alt="Toggle Password" style="width: 20px; height: 20px;" />
          </button>
        </div>

        <button type="submit" class="signup-button">Sign Up</button>
      </form>
      <p>Already have an account? <router-link to="/login" class="login-text">Login now</router-link></p>
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
      showPassword: false,
      errorMessage: ''
    };
  },
  methods: {
    handleLogin() {
      if (this.username !== 'testuser' || this.password !== 'testpass') {
        this.errorMessage = 'Invalid username or password';
      } else {
        this.$router.push('/dashboard');
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

input, .signup-button{
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

.signup-button {
  background: #409FDB;
  color: white;
  cursor: pointer;
  border: none;
  margin-top: 1rem;
  margin-bottom: 1rem;
}

.signup-button:hover {
  background: #368BD1;
}

.error {
  color: red;
  margin-top: 1rem;
}

.login-text {
  color: #409FDB;
  cursor: pointer;
}

.login-text:hover {
  text-decoration: underline;
}
</style>
