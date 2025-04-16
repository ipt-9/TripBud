<template>
  <div class="start-page">
    <header :class="{'header-scrolled': isScrolled}">
      <div class="logo">
        <img src="../assets/TripBudLogo.png" class="logo-img" alt="TripBud Logo" @click="scrollToSection('hero')" />
        <h1>TripBud</h1>
      </div>
      <div class="mobile-menu-button" @click="toggleMobileMenu">
        <span></span>
        <span></span>
        <span></span>
      </div>
      <nav :class="{'mobile-active': mobileMenuOpen}">
        <ul class="nav-links">
          <li><a href="#" @click="scrollToSection('whyus')">Why Us</a></li>
          <li><a href="#" @click="scrollToSection('destinations')">Popular Destinations</a></li>
          <li><a href="#" @click="scrollToSection('pricing')">Plans</a></li>
        </ul>
        <ul class="auth-links">
          <li><router-link to="/register" class="btn-signup">Sign Up</router-link></li>
          <li><router-link to="/login" class="btn-login">Login</router-link></li>
        </ul>
      </nav>
    </header>

    <main>
      <!-- Hero Section -->
      <section class="hero" id="hero">
        <div class="hero-text">
          <h1>Plan your next trip together.</h1>
          <p>Let's plan your perfect trip together, including all the details! Include all your buddies and store your files in-app!</p>
          <router-link to="/createtrip">
            <button class="btn-plan-trip">Plan your Trip now!</button>
          </router-link>
        </div>
        <div class="hero-image">
          <img src="../assets/hero_image.svg" alt="Trip Planning Illustration" />
        </div>
      </section>

      <!-- Why Us Section -->
      <section class="whyus-container" id="whyus">
        <div class="whyus-img">
          <img src="../assets/explorer.svg" alt="Traveler with backpack" class="whyus-image" />
        </div>
        <div class="whyus-content">
          <h2>Why Choose Us</h2>
          <p>Enjoy unique experiences in every place you visit and discover new, affordable adventures.</p>
          
          <div class="features-box">
            <div 
              v-for="(feature, index) in features" 
              :key="index" 
              class="feature-item"
              @mouseover="hoveredIndex = index" 
              @mouseleave="hoveredIndex = null"
              :class="{ 'dimmed': hoveredIndex !== null && hoveredIndex !== index }"
            >
              <img :src="feature.icon" class="icon" alt="Feature icon" />
              <div>
                <h3>{{ feature.title }}</h3>
                <p>{{ feature.description }}</p>
              </div>
            </div>
          </div>
          
          <router-link to="/register" class="create-account">Create an account!</router-link>
        </div>
      </section>

      <!-- Destinations Section -->
      <section class="destination-container" id="destinations">
        <h2>Popular Destinations</h2>
        <img src="../assets/destinations.svg" alt="popular destinations" class="destinationImg">
      </section>

      <!-- Pricing Section -->
      <section class="pricing-container" id="pricing">
        <h2>Plans</h2>
        <div class="cards-container">
          <!-- Free Plan -->
          <div class="card free">
            <h3>Free</h3>
            <p class="price">$0<span>/mo</span></p>
            <div class="plan-info">
              <p>2 saved trips</p>
              <p>Up to 2 buddies per trip</p>
              <p>Up to 1 GB trip storage</p>
            </div>
            <button class="btn">Start Free</button>
          </div>
          
          <!-- Premium Plan -->
          <div 
            class="card premium" 
            @mouseover="pausePulse" 
            @mouseleave="resumePulse"
          >
            <h3>Premium</h3>
            <p class="price">$8.99<span>/mo</span></p>
            <div class="plan-info">
              <p>10 saved trips</p>
              <p>Up to 5 buddies per trip</p>
              <p>Up to 5 GB trip storage</p>
            </div>
            <button class="btn">Get Premium</button>
          </div>
          
          <!-- Business Plan -->
          <div class="card business">
            <h3>Business</h3>
            <p class="price">$24.99<span>/mo</span></p>
            <div class="plan-info">
              <p>Unlimited saved trips</p>
              <p>Unlimited buddies per trip</p>
              <p>Unlimited trip storage</p>
            </div>
            <button class="btn">Get Business</button>
          </div>
        </div>
      </section>
    </main>

    <!-- Footer Section -->
    <footer class="footer">
      <div class="footer-content">
        <div class="footer-section">
          <img src="../assets/TripBudLogo.png" class="footer-logo" alt="TripBud Logo" />
          <p><strong>&copy; 2025 TripBud all rights reserved.</strong></p>
          <div class="app-links">
            <img src="../assets/GooglePlay.png" class="google-play" alt="Google Play" />
            <img src="../assets/AppleStore.png" class="apple-store" alt="App Store" />
          </div>
        </div>
        
        <div class="footer-section">
          <h3>Pages</h3>
          <ul>
            <li><a href="#">Home</a></li>
            <li><a href="#" @click="scrollToSection('whyus')">Why Us</a></li>
            <li><a href="#" @click="scrollToSection('pricing')">Plans</a></li>
            <li><router-link to="/register">Sign Up</router-link></li>
            <li><router-link to="/login">Login</router-link></li>
          </ul>
        </div>
        
        <div class="footer-section address-section">
          <h3>Address</h3>
          <p>Zumhofstrasse 77</p>
          <p>6010 Kriens</p>
          <p>Switzerland</p>
          
          <div class="travel-img-container">
            <img src="../assets/travel.svg" alt="travel image" class="travelImg"/>
          </div>
        </div>
        
        <div class="footer-section">
          <h3>Data</h3>
          <ul>
            <li><a href="#">Impressum</a></li>
            <li><a href="#">Data privacy</a></li>
          </ul>
        </div>
        
        <div class="footer-section">
          <h3>Contact Us</h3>
          <form @submit.prevent="submitContact">
            <input type="email" placeholder="Email" v-model="contactEmail" required />
            <textarea placeholder="Message" v-model="contactMessage" required></textarea>
            <button type="submit">Submit</button>
          </form>
        </div>
      </div>
    </footer>
  </div>
</template>

<script>
export default {
  data() {
    return {
      isScrolled: false,
      mobileMenuOpen: false,
      hoveredIndex: null,
      contactEmail: '',
      contactMessage: '',
      features: [
        { 
          icon: '../assets/download.png', 
          title: 'In-App Storage', 
          description: 'Store your travel documents for your trip directly in the app!' 
        },
        { 
          icon: '../assets/users.png', 
          title: 'Plan Together', 
          description: 'Invite your friends to the trip and exchange together!' 
        },
        { 
          icon: '../assets/document.png', 
          title: 'Integrated Blog', 
          description: 'Capture your journey and create an album!' 
        }
      ]
    };
  },
  mounted() {
    window.addEventListener('scroll', this.handleScroll);
    this.handleScroll();
    
    // Close mobile menu when clicking outside
    document.addEventListener('click', this.closeMobileMenuOutside);
  },
  beforeDestroy() {
    window.removeEventListener('scroll', this.handleScroll);
    document.removeEventListener('click', this.closeMobileMenuOutside);
  },
  methods: {
    scrollToSection(sectionId) {
      // Close mobile menu when navigating
      this.mobileMenuOpen = false;
      
      const section = document.getElementById(sectionId);
      if (section) {
        const headerHeight = document.querySelector('header').offsetHeight;
        const sectionPosition = section.getBoundingClientRect().top + window.pageYOffset;
        
        window.scrollTo({
          top: sectionPosition - headerHeight,
          behavior: 'smooth'
        });
      }
    },
    
    toggleMobileMenu(event) {
      this.mobileMenuOpen = !this.mobileMenuOpen;
      // Prevent event from bubbling
      event.stopPropagation();
    },
    
    closeMobileMenuOutside(event) {
      // Close menu when clicking outside of nav and menu button
      const nav = document.querySelector('nav');
      const menuButton = document.querySelector('.mobile-menu-button');
      
      if (this.mobileMenuOpen && 
          !nav.contains(event.target) && 
          !menuButton.contains(event.target)) {
        this.mobileMenuOpen = false;
      }
    },
    
    pausePulse(event) {
      event.target.style.animationPlayState = 'paused';
    },
    
    resumePulse(event) {
      event.target.style.animationPlayState = 'running';
    },
    
    handleScroll() {
      // Header shrink effect
      this.isScrolled = window.scrollY > 50;
      
      // Reveal sections when scrolled into view
      const sections = document.querySelectorAll('.hero, .whyus-container, .destination-container, .pricing-container');
      sections.forEach(section => {
        const sectionTop = section.getBoundingClientRect().top;
        if (sectionTop < window.innerHeight - 100) {
          section.classList.add('show-section');
        }
      });
    },
    
    submitContact() {
      // Handle contact form submission
      console.log('Submitting contact form:', { 
        email: this.contactEmail, 
        message: this.contactMessage 
      });
      
      // Reset form after submission
      this.contactEmail = '';
      this.contactMessage = '';
      
      // Show success message (in a real app)
      alert('Thank you for your message! We will get back to you soon.');
    }
  }
};
</script>

<style scoped>
@import url('https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;700&display=swap');

* {
  margin: 0;
  padding: 0;
  font-family: 'Outfit', sans-serif;
  box-sizing: border-box;
}

html {
  scroll-behavior: smooth;
}

body {
  overflow-x: hidden;
}

.start-page {
  color: #333;
  background: linear-gradient(135deg, #e0f2fe 0%, #d3eeff 40%, #ffffff 100%);
  min-height: 100vh;
  display: flex;
  flex-direction: column;
}

/* Header Styles */
header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 1rem 2rem;
  background: rgba(255, 255, 255, 0.8);
  backdrop-filter: blur(10px);
  position: sticky;
  top: 0;
  z-index: 100;
  transition: all 0.3s ease;
}

.header-scrolled {
  padding: 0.5rem 2rem;
  box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
}

.logo {
  display: flex;
  align-items: center;
  z-index: 101;
}

.logo-img {
  height: 40px;
  width: auto;
  margin-right: 0.5rem;
  cursor: pointer;
}

.logo h1 {
  color: #409FDB;
  font-weight: 600;
  margin: 0;
}

/* Mobile Menu Button */
.mobile-menu-button {
  display: none;
  flex-direction: column;
  justify-content: space-between;
  height: 24px;
  width: 30px;
  cursor: pointer;
  z-index: 101;
}

.mobile-menu-button span {
  width: 100%;
  height: 3px;
  background-color: #409FDB;
  border-radius: 3px;
  transition: all 0.3s ease;
}

/* Navigation */
nav {
  display: flex;
  align-items: center;
  justify-content: space-between;
  flex-grow: 1;
  position: relative;
}

.nav-links {
  display: flex;
  list-style-type: none;
  margin: 0;
  padding: 0;
  position: absolute;
  left: 50%;
  transform: translateX(-50%);
}

.auth-links {
  display: flex;
  list-style-type: none;
  margin: 0;
  padding: 0;
  margin-left: auto;
}

nav li {
  margin-right: 1.5rem;
}

nav li:last-child {
  margin-right: 0;
}

nav a {
  text-decoration: none;
  color: #333;
  font-weight: 500;
  transition: color 0.3s;
  position: relative;
}

nav a:hover {
  color: #409FDB;
}

nav a:hover::after {
  content: '';
  position: absolute;
  bottom: -5px;
  left: 0;
  width: 100%;
  height: 2px;
  background-color: #409FDB;
  transform: scaleX(1);
}

.btn-signup {
  background-color: #e68200;
  padding: 0.5rem 1rem;
  border-radius: 8px;
  color: white !important;
  transition: all 0.3s;
  box-shadow: 0 4px 15px rgba(230, 130, 0, 0.2);
}

.btn-signup:hover {
  background-color: #FF9466;
  transform: translateY(-2px);
  box-shadow: 0 6px 20px rgba(230, 130, 0, 0.3);
}

.btn-signup:hover::after {
  display: none;
}

.btn-login {
  border: 1px solid #333;
  padding: 0.5rem 1rem;
  border-radius: 8px;
  transition: all 0.3s;
}

.btn-login:hover {
  border-color: #409FDB;
  color: #409FDB;
  transform: translateY(-2px);
}

.btn-login:hover::after {
  display: none;
}

/* Hero Section */
.hero {
  display: flex;
  align-items: center;
  justify-content: space-between;
  padding: 5rem 5rem 3rem;
  opacity: 0;
  transform: translateY(20px);
  transition: opacity 0.6s ease, transform 0.6s ease;
}

.hero-text {
  flex: 1;
  max-width: 50%;
}

.hero h1 {
  font-size: 3rem;
  margin-bottom: 1rem;
  background: linear-gradient(90deg, #333 0%, #409FDB 100%);
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
  background-clip: text;
}

.hero p {
  font-size: 1.2rem;
  margin-bottom: 2rem;
  line-height: 1.6;
}

.btn-plan-trip {
  padding: 0.75rem 1.5rem;
  font-size: 1.1rem;
  background-color: #409FDB;
  color: #fff;
  border: none;
  border-radius: 8px;
  cursor: pointer;
  transition: all 0.3s;
  box-shadow: 0 4px 15px rgba(64, 159, 219, 0.2);
}

.btn-plan-trip:hover {
  background-color: #3088c3;
  transform: translateY(-2px);
  box-shadow: 0 6px 20px rgba(64, 159, 219, 0.3);
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
  height: auto;
  filter: drop-shadow(0 10px 20px rgba(0, 0, 0, 0.1));
}

/* Why Us Section */
.whyus-container {
  display: flex;
  justify-content: space-between;
  padding: 5rem 5rem 3rem;
  opacity: 0;
  transform: translateY(20px);
  transition: opacity 0.6s ease, transform 0.6s ease;
}

.whyus-img {
  flex: 0 0 40%;
}

.whyus-image {
  width: 100%;
  max-width: 500px;
  height: auto;
  filter: drop-shadow(0 10px 20px rgba(0, 0, 0, 0.1));
}

.whyus-content {
  flex: 0 0 55%;
  margin-left: 5%;
}

.whyus-content h2 {
  font-size: 2.5rem;
  margin-bottom: 1rem;
  color: #333;
}

.features-box {
  display: flex;
  flex-direction: column;
  align-items: flex-start;
  margin-top: 2rem;
}

.feature-item {
  display: flex;
  align-items: flex-start;
  text-align: left;
  cursor: pointer;
  transition: all 0.3s ease;
  margin-bottom: 2rem;
  padding: 15px;
  border-radius: 10px;
  width: 100%;
}

.feature-item.dimmed {
  opacity: 0.5;
}

.feature-item:hover {
  background-color: rgba(255, 255, 255, 0.8);
  box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
  transform: translateX(10px);
}

.feature-item .icon {
  width: 30px;
  height: 30px;
  margin-right: 1.5rem;
}

.feature-item h3 {
  font-size: 1.2rem;
  margin-bottom: 0.5rem;
  color: #333;
}

.feature-item p {
  font-size: 1rem;
  color: #666;
  line-height: 1.5;
}

.create-account {
  color: #409FDB;
  text-decoration: none;
  font-weight: 500;
  display: inline-block;
  margin-top: 1.5rem;
  transition: transform 0.3s;
}

.create-account::after {
  content: " >";
  transition: margin-left 0.3s;
}

.create-account:hover {
  transform: translateX(5px);
}

.create-account:hover::after {
  margin-left: 5px;
}

/* Destinations Section */
.destination-container {
  padding: 5rem 5rem 3rem;
  text-align: center;
  opacity: 0;
  transform: translateY(20px);
  transition: opacity 0.6s ease, transform 0.6s ease;
}

.destination-container h2 {
  font-size: 2.5rem;
  margin-bottom: 2rem;
  color: #333;
}

.destinationImg {
  max-width: 100%;
  height: auto;
  padding: 2rem;
  filter: drop-shadow(0 10px 20px rgba(0, 0, 0, 0.1));
}

/* Pricing Section */
.pricing-container {
  padding: 5rem 5rem 3rem;
  text-align: center;
  opacity: 0;
  transform: translateY(20px);
  transition: opacity 0.6s ease, transform 0.6s ease;
}

.pricing-container h2 {
  font-size: 2.5rem;
  margin-bottom: 3rem;
  color: #333;
}

.cards-container {
  display: flex;
  justify-content: center;
  gap: 24px;
  padding-bottom: 3rem;
}

.card {
  background-color: #fff;
  border-radius: 12px;
  padding: 2rem;
  text-align: center;
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
  width: 280px;
  position: relative;
  transition: transform 0.3s, box-shadow 0.3s;
  border: 1px solid rgba(0, 0, 0, 0.05);
}

.card:hover {
  transform: translateY(-10px);
  box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
}

.card.premium {
  background: linear-gradient(135deg, #409FDB 0%, #3088c3 100%);
  color: white;
  animation: pulse 2s infinite;
  box-shadow: 0 10px 25px rgba(64, 159, 219, 0.3);
  border: none;
}

@keyframes pulse {
  0% {
    transform: scale(1);
  }
  50% {
    transform: scale(1.05);
  }
  100% {
    transform: scale(1);
  }
}

.card h3 {
  font-size: 1.8rem;
  margin-bottom: 1.5rem;
}

.price {
  font-size: 2.5rem;
  font-weight: bold;
  margin-bottom: 1.5rem;
}

.price span {
  font-size: 1.2rem;
  font-weight: normal;
}

.plan-info {
  margin-bottom: 2rem;
}

.plan-info p {
  margin-bottom: 0.75rem;
}

.card .btn {
  width: 100%;
  padding: 0.75rem 0;
  font-size: 1rem;
  background-color: #409FDB;
  color: white;
  border: none;
  border-radius: 8px;
  cursor: pointer;
  transition: all 0.3s;
  box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
}

.card .btn:hover {
  background-color: #3088c3;
  transform: translateY(-2px);
  box-shadow: 0 6px 20px rgba(0, 0, 0, 0.15);
}

.card.premium .btn {
  background-color: white;
  color: #409FDB;
}

/* Footer Styles */
.footer {
  background: linear-gradient(to top, rgba(224, 242, 254, 0.5), transparent);
  padding: 3rem 5rem 1rem;
  margin-top: auto;
  border-top: 1px solid rgba(0, 0, 0, 0.05);
}

.footer-content {
  display: flex;
  justify-content: space-between;
  flex-wrap: wrap;
  gap: 2rem;
}

.footer-section {
  flex: 1;
  min-width: 200px;
}

.footer-section h3 {
  font-size: 1.2rem;
  margin-bottom: 1rem;
  color: #333;
}

.footer-logo {
  height: 70px;
  width: 70px;
  margin-bottom: 1rem;
}

.footer-section ul {
  list-style-type: none;
  padding: 0;
}

.footer-section li {
  margin-bottom: 0.5rem;
}

.footer-section a {
  color: #333;
  text-decoration: none;
  transition: color 0.3s;
}

.footer-section a:hover {
  color: #409FDB;
}

.app-links {
  display: flex;
  gap: 12px;
  margin-top: 1rem;
}

.google-play {
  width: 120px;
  height: 50px;
}

.apple-store {
  width: 100px;
  height: 35px;
}

form input,
form textarea {
  width: 100%;
  padding: 0.75rem;
  margin-bottom: 1rem;
  border: 1px solid #e0e0e0;
  border-radius: 8px;
  transition: all 0.3s ease;
}

form input:focus,
form textarea:focus {
  outline: none;
  border-color: #409FDB;
  box-shadow: 0 0 0 3px rgba(64, 159, 219, 0.2);
}

form textarea {
  height: 120px;
  resize: none;
}

form button {
  padding: 0.75rem 1.5rem;
  background-color: #409FDB;
  color: white;
  border: none;
  border-radius: 8px;
  cursor: pointer;
  transition: all 0.3s;
  box-shadow: 0 4px 15px rgba(64, 159, 219, 0.2);
}

form button:hover {
  background-color: #3088c3;
  transform: translateY(-2px);
  box-shadow: 0 6px 20px rgba(64, 159, 219, 0.3);
}

.travelImg {
  max-width: 100%;
  height: auto;
  padding-top: 1rem;
}

/* Animation Effects */
.show-section {
  opacity: 1 !important;
  transform: translateY(0) !important;
}

/* Responsive Design */
@media (max-width: 1200px) {
  .hero, .whyus-container {
    padding: 4rem 3rem;
  }
  
  .destination-container, .pricing-container {
    padding: 4rem 3rem;
  }
  
  .footer {
    padding: 3rem 3rem 1rem;
  }
}

@media (max-width: 992px) {
  .hero {
    flex-direction: column;
    text-align: center;
    gap: 2rem;
  }
  
  .hero-text {
    max-width: 100%;
  }
  
  .whyus-container {
    flex-direction: column;
    align-items: center;
    margin-bottom: 10rem;
  }
  
  .whyus-img, .whyus-content {
    max-width: 100%;
    width: 100%;
  }
  
  .whyus-content {
    margin-left: 0;
    margin-top: 2rem;
  }
  
  .cards-container {
    flex-wrap: wrap;
    justify-content: center;
  }
  
  .footer-section {
    flex: 0 0 calc(50% - 1rem);
  }
}

@media (max-width: 768px) {
  header {
    padding: 1rem;
  }
  
  .mobile-menu-button {
    display: flex;
  }
  
  nav {
    position: fixed;
    top: 0;
    right: -100%;
    width: 80%;
    max-width: 300px;
    height: 100vh;
    background: white;
    flex-direction: column;
    align-items: flex-start;
    justify-content: flex-start;
    padding: 5rem 2rem 2rem;
    transition: right 0.3s ease;
    box-shadow: -5px 0 15px rgba(0, 0, 0, 0.1);
  }
  
  nav.mobile-active {
    right: 0;
  }
  
  .nav-links, .auth-links {
    position: static;
    transform: none;
    flex-direction: column;
    width: 100%;
  }
  
  .nav-links li, .auth-links li {
    margin: 0 0 1.5rem 0;
  }
  
  .hero, .whyus-container, .destination-container, .pricing-container {
    padding: 3rem 1.5rem;
  }
  
  .hero h1 {
    font-size: 2.5rem;
  }
  
  .whyus-content h2, .destination-container h2, .pricing-container h2 {
    font-size: 2rem;
  }
  
  .footer {
    padding: 3rem 1.5rem 1rem;
  }
  
  .footer-section {
    flex: 0 0 100%;
    margin-bottom: 2rem;
  }
  
  .cards-container {
    gap: 2rem;
  }
  
  .card {
    width: 100%;
    max-width: 320px;
  }
}

@media (max-width: 480px) {
  .hero h1 {
    font-size: 2rem;
  }
  
  .hero p {
    font-size: 1rem;
  }
  
  .btn-plan-trip {
    width: 100%;
    padding: 0.75rem;
  }
  
  .feature-item {
    align-items: center;
    flex-direction: column;
    text-align: center;
  }
  
  .feature-item .icon {
    margin-right: 0;
    margin-bottom: 1rem;
  }
  
  .card {
    padding: 1.5rem;
  }

  .whyus-container {
    flex-direction: column;
    align-items: center;
    margin-bottom: 15rem;
  }
}

/* Custom scrollbar */
::-webkit-scrollbar {
  width: 8px;
}

::-webkit-scrollbar-track {
  background: #f5f5f5;
}

::-webkit-scrollbar-thumb {
  background: #409FDB;
  border-radius: 6px;
  border: 3px solid #f5f5f5;
}

::-webkit-scrollbar-thumb:hover {
  background: #3088c3;
}

/* Animation for sections */
@keyframes fadeIn {
  from {
    opacity: 0;
    transform: translateY(20px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
}

/* Custom utility classes */
.text-center {
  text-align: center;
}

.hidden {
  opacity: 0;
  visibility: hidden;
}

.visible {
  opacity: 1;
  visibility: visible;
}
</style>