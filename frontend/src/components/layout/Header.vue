// Header.vue
<template>
  <header>
    <div class="logo">
      <img src="@/assets/TripBudLogo.png" class="logo-img" alt="TripBud Logo" @click.prevent="scrollToSection('hero')"/>
      <h1>TripBud</h1>
    </div>
    <nav>
      <ul class="nav-links">
        <li><a href="#" @click.prevent="scrollToSection('whyus')">Why Us</a></li>
        <li><a href="#" @click.prevent="scrollToSection('destinations')">Popular Destinations</a></li>
        <li><a href="#" @click.prevent="scrollToSection('pricing')">Plans</a></li>
      </ul>
      <ul class="auth-links">
        <li><router-link to="/register" class="btn-signup">Sign Up</router-link></li>
        <li><router-link to="/login" class="btn-login">Login</router-link></li>
      </ul>
    </nav>
  </header>
</template>

<script>
export default {
  name: 'Header',
  methods: {
    scrollToSection(sectionId) {
      const section = document.getElementById(sectionId);
      if (section) {
        const headerHeight = document.querySelector('header').offsetHeight;
        const sectionPosition = section.getBoundingClientRect().top + window.pageYOffset;
        
        window.scrollTo({
          top: sectionPosition - headerHeight,
          behavior: 'smooth'
        });
      }
    }
  }
};
</script>

<style scoped>
header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 1rem 2rem;
  background: transparent;
  color: black;
  position: sticky;
  top: 0;
  z-index: 100;
  backdrop-filter: blur(10px);
}

.header-scrolled {
  padding: 1rem 2rem;
  box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
}

.logo {
  display: flex;
  align-items: center;
}

.logo-img {
  height: 40px;
  margin-right: 0.5rem;
}

.logo h1 {
  color: #409FDB;
  font-weight: 600;
}

nav {
  display: flex;
  align-items: center;
  flex-grow: 1;
  justify-content: flex-end;
}

.nav-links {
  display: flex;
  list-style-type: none;
  margin: 0;
  padding: 0;
  position: absolute;
  flex-direction: row;
  left: 50%;
  transform: translateX(-50%);
}

.auth-links {
  display: flex;
  list-style-type: none;
  margin: 0;
  padding: 0;
}

nav li {
  margin-right: 1.5rem;
}

nav li:last-child {
  margin-right: 0;
}

nav a {
  text-decoration: none;
  color: black;
  cursor: pointer;
  transition: color 0.3s;
}

nav a:hover {
  color: #007bff;
}

.btn-signup {
  background-color: #e68200;
  padding: 0.5rem 1rem;
  border-radius: 8px;
  color: white !important;
  transition: background-color 0.3s;
  box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
}

.btn-signup:hover {
  background-color: #FF9466;
  transform: translateY(-2px);
  box-shadow: 0 6px 20px rgba(0, 0, 0, 0.15);
}

.btn-login {
  border: 1px solid black;
  padding: 0.5rem 1rem;
  border-radius: 8px;
  transition: border-color 0.3s, color 0.3s;
}

.btn-login:hover {
  border-color: #007bff;
  color: #007bff;
}

@media (max-width: 992px) {
  .nav-links {
    position: relative;
    left: 0;
    transform: none;
    margin-left: 2rem;
  }
}

@media (max-width: 768px) {
  header {
    flex-direction: column;
    padding: 1rem;
  }
  
  .logo {
    margin-bottom: 1rem;
  }
  
  nav {
    flex-direction: column;
    width: 100%;
  }
  
  .nav-links {
    position: static;
    transform: none;
    width: 100%;
    justify-content: center;
    margin: 0.5rem 0;
    margin-left: 0;
  }
  
  .auth-links {
    width: 100%;
    justify-content: center;
    margin-top: 0.5rem;
  }
  
  nav li {
    margin-right: 1rem;
  }
}

@media (max-width: 576px) {
  header {
    flex-direction: row;
    justify-content: space-between;
    align-items: center;
    padding: 0.8rem 1rem;
  }
  
  .logo {
    margin-bottom: 0;
  }
  
  nav {
    flex-direction: row;
    width: auto;
    justify-content: flex-end;
  }
  
  .logo-img {
    height: 30px;
  }
  
  .logo h1 {
    font-size: 1.2rem;
  }
  
  .nav-links {
    display: none;
  }
  
  .auth-links {
    width: auto;
    margin-top: 0;
    flex-wrap: nowrap;
    justify-content: flex-end;
  }
  
  nav li {
    margin-right: 0.5rem;
  }
  
  .btn-signup, .btn-login {
    padding: 0.4rem 0.8rem;
    font-size: 0.9rem;
  }
}

@media (max-width: 375px) {
  header {
    padding: 0.8rem;
  }
  
  .logo-img {
    height: 25px;
  }
  
  .logo h1 {
    font-size: 1.1rem;
  }
  
  .auth-links {
    justify-content: flex-end;
  }
  
  nav li {
    margin-right: 0.3rem;
  }
  
  .btn-signup, .btn-login {
    padding: 0.3rem 0.6rem;
    font-size: 0.8rem;
  }
}
</style>