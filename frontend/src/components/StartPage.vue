<template>
    <div class="start-page">
      <header>
        <div class="logo">
          <img v-for="img in images" v-bind:src="img" class="logo" />
          <h1>TripBud</h1>
        </div>
        <nav>
          <ul>
            <li><a href="#">Why Us</a></li>
            <li><a href="#">Popular Destinations</a></li>
            <li><a href="#">Plans</a></li>
            <li><a href="#" class="btn-signup">Sign Up</a></li>
            <li><a href="#" class="btn-login">Login</a></li>
          </ul>
        </nav>
      </header>
  
      <main>
        <div class="hero">
          <div class="hero-text">
            <h1>Plan your next trip together.</h1>
            <p>Let's plan your perfect trip together, including all the details! Include all your buddies and store your files in-app!</p>
            <button class="btn-plan-trip">Plan your Trip now!</button>
          </div>
          <div class="hero-image">
            <img v-for="(img, index) in StartImages" :key="index" :src="img" />
          </div>
        </div>
      </main>
    </div>
  </template>
  
  <script>
  export default {
    data() {
      return {
        images: ['../assets/TripBudLogo.png'],
        StartImages: ['../assets/FrontImg.png']
      };
    },
    name: 'StartPage'
  };
  </script>
  
  <style scoped>
  .start-page {
    font-family: 'Roboto', sans-serif;
    color: #333;
    background: linear-gradient(to bottom, #e0f2fe, #ffffff);
    min-height: 100vh;
    display: flex;
    flex-direction: column;
  }
  
  header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 1rem 2rem;
    background: #e0f2fe;
    color: black;
  }
  
  .logo {
    display: flex;
    align-items: center;
  }
  
  .logo img {
    height: 40px;
    margin-right: 0.5rem;
  }
  
  nav ul {
    display: flex;
    list-style-type: none;
    margin: 0;
    padding: 0;
  }
  
  nav li {
    margin-right: 1.5rem;
  }
  
  nav a {
    text-decoration: none;
    color: black;
    font-weight: bold;
  }
  
  .btn-signup {
    background-color: #ff9800;
    padding: 0.5rem 1rem;
    border-radius: 4px;
    color: white;
  }
  
  .btn-login {
    border: 1px solid black;
    padding: 0.5rem 1rem;
    border-radius: 4px;
  }
  
  .hero {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 3rem 5rem;
  }
  
  .hero-text {
    flex: 1;
    max-width: 50%;
  }
  
  .hero h1 {
    font-size: 3rem;
    margin-bottom: 1rem;
  }
  
  .hero p {
    font-size: 1.2rem;
    margin-bottom: 2rem;
  }
  
  .btn-plan-trip {
    padding: 0.75rem 1.5rem;
    font-size: 1.1rem;
    background-color: #007bff;
    color: #fff;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    transition: 0.3s;
  }
  
  .btn-plan-trip:hover {
    background-color: #0056b3;
  }
  
  .hero-image {
    flex: 1;
    display: flex;
    justify-content: center;
    padding-left: 2rem;
  }
  
  .hero-image img {
    width: 100%;
    max-width: 600px;
    border-radius: 10px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
  } 
  </style>