<template>
  <div class="login-container">
    <div class="logo-container">
      <img v-for="img in images" :src="img" class="logo" />
      <span class="logo-text">TripBud</span>
    </div>

    <h2 class="login-title">Register</h2>
    <div class="login-card">
      <form @submit.prevent="handleRegister">
        <label for="fullname" class="textleft">Full name</label>
        <input v-model="name" type="text" id="fullname" placeholder="Full name" required />
        <p v-if="errors.name" class="error">{{ errors.name }}</p>

        <label for="username" class="textleft">Username</label>
        <input v-model="username" type="text" id="username" placeholder="Username" required />
        <p v-if="errors.username" class="error">{{ errors.username }}</p>

        <label for="email" class="textleft">Email</label>
        <input v-model="email" type="email" id="email" placeholder="Email" required />
        <p v-if="errors.email" class="error">{{ errors.email }}</p>

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
        <p :class="passwordValid ? 'valid-text' : 'invalid-text'">
          Password must be at least 8 characters long
        </p>
        <p v-if="errors.password" class="error">{{ errors.password }}</p>

        <label for="password_confirmation" class="textleft">Confirm Password</label>
        <input v-model="password_confirmation" type="password" id="password_confirmation" placeholder="Confirm Password" required />
        <p v-if="password_confirmation && password !== password_confirmation" class="error">Passwords do not match</p>
        <p v-if="errors.password_confirmation" class="error">{{ errors.password_confirmation }}</p>

        <button type="submit" class="signup-button" :disabled="!formValid">Sign Up</button>
      </form>
      <p>Already have an account? <router-link to="/login" class="login-text">Login now</router-link></p>
      <p v-if="errors.general" class="error">{{ errors.general }}</p>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      name: '',
      username: '',
      email: '',
      password: '',
      password_confirmation: '',
      showPassword: false,
      errors: {},
      images: ['../assets/TripBudLogo.png'],
      passwordImages: ['../assets/hide.png']
    };
  },
  computed: {
    passwordValid() {
      return this.password.length >= 8;
    },
    formValid() {
      return (
        this.name &&
        this.username &&
        this.email &&
        this.password &&
        this.password_confirmation &&
        this.passwordValid &&
        this.password === this.password_confirmation
      );
    }
  },
  methods: {
    async handleRegister() {
      this.errors = {};

      if (!this.passwordValid || this.password !== this.password_confirmation) {
        this.errors.password = 'Password must be at least 8 characters long and match the confirmation';
        return;
      }

      try {
        const response = await fetch('https://api.tripbud-bmsd22a.bbzwinf.ch/api/register/user', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
          },
          body: JSON.stringify({
            name: this.name,
            username: this.username,
            email: this.email,
            password: this.password,
            password_confirmation: this.password_confirmation
          })
        });

        const data = await response.json();

        if (response.ok) {
          this.$router.push('/triporganizer');
        } else if (response.status === 422) {
          this.errors = data.errors;
        } else if (response.status === 409) {
          this.errors.email = data.message;
        } else {
          this.errors.general = data.message || 'An unexpected error occurred. Please try again.';
        }
      } catch (error) {
        this.errors.general = 'An error occurred. Please try again later.';
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

input, .signup-button {
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

.signup-button:disabled {
  background: gray;
  cursor: not-allowed;
}

.signup-button:hover:enabled {
  background: #368BD1;
}

.error {
  color: red;
  font-size: 0.9rem;
  margin-top: 5px;
}

.login-text {
  color: #409FDB;
  cursor: pointer;
}

.login-text:hover {
  text-decoration: underline;
}

.invalid-text {
  color: red;
  font-size: 0.9rem;
  margin-top: 5px;
}

.valid-text {
  color: green;
  font-size: 0.9rem;
  margin-top: 5px;
}
</style>
