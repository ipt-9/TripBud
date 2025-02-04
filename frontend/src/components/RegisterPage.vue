<template>
    <div class="container">
    <div class="logo-container">
        <!-- <img src="C:\Users\schus\TripBud\TripBud\frontend\src\assets\hide.png" alt="TripBud Logo" class="logo" /> -->
      <span class="logo-text">TripBud</span>
    </div>
      <h2 class="form-title">Sign Up</h2>
      <h1 class="name-title">TripBud</h1>
      <div class="form-wrapper">
        <form>
          <div class="form-group">
            <label for="fullname">Fullname</label>
            <input type="text" id="fullname" placeholder="Fullname" required />
          </div>
  
          <div class="form-group">
            <label for="username">Username</label>
            <input type="text" id="username" placeholder="Username" required />
          </div>
  
          <div class="form-group">
            <label for="email">Email</label>
            <input type="email" id="email" placeholder="Email" required />
          </div>
  
          <div class="form-group">
            <label for="password">Password</label>
            <div class="password-wrapper">
              <input 
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
                <img src="C:\Users\schus\TripBud\TripBud\frontend\src\assets\hide.png" style="width: 20px; height: 20px;"></img>
              </button>
            </div>
          </div>
  
          <button type="submit" class="submit-btn">
            Sign Up
          </button>
  
          <p class="login-link">
            Already have an account?
            <a href="/login">Login</a>
          </p>
        </form>
      </div>
    </div>
  </template>
  
  <script>
  export default {
    name: "SignupPage",
    data() {
      return {
        showPassword: false,
      };
    },
    methods: {
      togglePasswordVisibility() {
        this.showPassword = !this.showPassword;
      },
    },
  };
  </script>
  
  <style>
  * {
  font-family: 'Outfit', sans-serif;
}
 
  body {
    font-family: 'Arial', sans-serif;
  }
  
  .container {
    display: flex;
    justify-content: center;
    align-items: center;
    min-height: 100vh;
    background-color: #ebf5ff;
  }
  
  .name-title {
    color: #409FDB;
  }
  
  .form-wrapper {
    width: 100%;
    max-width: 400px;
    background: white;
    padding: 24px;
    border-radius: 16px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
  }
  
  h2 {
    font-size: 24px;
    text-align: center;
    margin-bottom: 24px;
    font-weight: 600;
  }
  
  .form-group {
    margin-bottom: 16px;
  }
  
  label {
    display: block;
    font-size: 14px;
    font-weight: 600;
    margin-bottom: 8px;
  }
  
  input {
    width: 100%;
    padding: 10px;
    border: 1px solid #d1d5db;
    border-radius: 8px;
    outline: none;
    transition: box-shadow 0.2s;
  }
  
  input:focus {
    box-shadow: 0 0 0 2px #60a5fa;
  }
  
  .password-wrapper {
    position: relative;
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
  
  .submit-btn {
    width: 100%;
    background-color: #409FDB;
    color: white;
    padding: 12px;
    border-radius: 8px;
    border: none;
    cursor: pointer;
    font-weight: 600;
    transition: background-color 0.2s;
  }
  
  .submit-btn:hover {
    background-color: #368bd1;
  }
  
  .login-link {
    text-align: center;
    margin-top: 16px;
    font-size: 14px;
  }
  
  .login-link a {
    color: #3b82f6;
    text-decoration: none;
  }
  </style>
  