<template>
  <div class="start-page">
    <div class="background-svg"></div>
    <header>
      <div class="logo">
        <img src="../assets/TripBudLogo.png" class="logo-img" alt="TripBud Logo" @click.prevent="scrollToSection('hero')"/>
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


    <main>
      <!-- Hero Section -->
      <div class="hero" id="hero">
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
      </div>

      <!-- Why Us Section -->
      <div class="whyus-container" id="whyus">
        <div class="whyus-img">
          <img src="../assets/explorer.svg" alt="Traveler with backpack" class="whyus-image" />
        </div>
        <div class="whyus-content">
          <h1>Why Choose Us</h1>
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
      </div>

      <!-- Destinations Section -->
      <div class="destination-container" id="destinations">
        <h1>Popular Destinations</h1>
        <img src="../assets/destinations.svg" alt="popular destinations" class="destinationImg">
      </div>

      <!-- Pricing Section -->
      <div class="pricing-container" id="pricing">
        <h1>Plans</h1>
        <div class="cards-container">
          <!-- Free Plan -->
          <div class="card free">
            <h2>Free</h2>
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
            <h2>Premium</h2>
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
            <h2>Business</h2>
            <p class="price">$24.99<span>/mo</span></p>
            <div class="plan-info">
              <p>Unlimited saved trips</p>
              <p>Unlimited buddies per trip</p>
              <p>Unlimited trip storage</p>
            </div>
            <button class="btn">Get Business</button>
          </div>
        </div>
      </div>
    </main>

    <!-- Footer Section -->
    <footer class="footer">
      <div class="footer-content">
        <div class="footer-section">
          <img src="../assets/TripBudLogo.png" style="width: 70px; height: 70px;" alt="TripBud Logo" />
          <p>&copy; 2025 TripBud all rights reserved.</p>
          <div class="app-links">
            <img src="../assets/GooglePlay.png" style="width: 120px; height: 50px;" alt="Google Play" />
            <img src="../assets/AppleStore.png" style="width: 100px; height: 35px;" alt="App Store" />
          </div>
        </div>
        
        <div class="footer-section">
          <h3>Pages</h3>
          <ul>
            <li><a href="#">Home</a></li>
            <li><a href="#" @click.prevent="scrollToSection('whyus')">Why Us</a></li>
            <li><a href="#" @click.prevent="scrollToSection('pricing')">Plans</a></li>
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
          <input type="email" placeholder="Email" />
          <textarea placeholder="Message"></textarea>
          <button>Submit</button>
        </div>
      </div>
    </footer>
  </div>
</template>

<script>
export default {
  data() {
    return {
      logoImage: 'src/assets/TripBudLogo.png',
      frontImage: 'src/assets/FrontImg.png',
      whyUsImage: 'src/assets/why-us-img.png',
      googleImage: 'src/assets/GooglePlay.png',
      appleImage: 'src/assets/AppleStore.png',
      hoveredIndex: null,
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
  // Add these lifecycle hooks
  mounted() {
    // Add scroll event listener for animations
    window.addEventListener('scroll', this.handleScroll);
    
    // Initially check which sections are visible
    this.handleScroll();
  },
  beforeDestroy() {
    // Clean up event listener
    window.removeEventListener('scroll', this.handleScroll);
  },
  methods: {
    // Keep your existing methods
    scrollToSection(sectionId) {
      const section = document.getElementById(sectionId);
      if (section) {
        // Calculate header height to adjust scroll position
        const headerHeight = document.querySelector('header').offsetHeight;
        const sectionPosition = section.getBoundingClientRect().top + window.pageYOffset;
        
        // Scroll to section with header height offset
        window.scrollTo({
          top: sectionPosition - headerHeight,
          behavior: 'smooth'
        });
      }
    },
    
    pausePulse(event) {
      event.target.style.animationPlayState = 'paused';
    },
    resumePulse(event) {
      event.target.style.animationPlayState = 'running';
    },
    // Add this new method
    handleScroll() {
      // Header shrink effect
      const header = document.querySelector('header');
      if (window.scrollY > 100) {
        header.classList.add('header-scrolled');
      } else {
        header.classList.remove('header-scrolled');
      }
      
      // Reveal sections when scrolled into view
      const sections = document.querySelectorAll('.hero, .whyus-container, .pricing-container');
      sections.forEach(section => {
        const sectionTop = section.getBoundingClientRect().top;
        if (sectionTop < window.innerHeight - 100) {
          section.classList.add('show-section');
        }
      });
    }
  }
};
</script>

<style scoped>
@import url('https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;700&display=swap');

* {
  font-family: 'Outfit', sans-serif;
  box-sizing: border-box;
}

.start-page {
  color: #333;
  background: linear-gradient(135deg, #e0f2fe 0%, #d3eeff 40%, #ffffff 100%);
  min-height: 100vh;
  display: flex;
  flex-direction: column;
  transition: opacity 0.5s ease-in-out;
}

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
}

.btn-signup:hover {
  background-color: #FF9466;
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
  background-color: #409FDB;
  color: #fff;
  border: none;
  border-radius: 8px;
  cursor: pointer;
  transition: background-color 0.3s;
}

.btn-plan-trip:hover {
  background-color: #0056b3;
}

html {
  scroll-behavior: smooth;
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
}

.whyus-container {
  display: flex;
  justify-content: space-between;

  padding: 4rem;
}

.whyus-img {
  flex: 0 0 40%;
}

.whyus-image {
  width: 110%;
  height: auto;
  box-shadow: none;
  max-height: 500px;
}
.whyus-content {
  flex: 0 0 55%;
  margin-left: 5%;
}

.whyus-content h1 {
  font-size: 2rem;
  margin-bottom: 1rem;
}

.features-box {
  display: flex;
  flex-direction: column;
  align-items: flex-start;
  margin-top: 2rem;
}

.feature-item {
  display: flex;
  align-items: center;
  text-align: left;
  cursor: pointer;
  transition: transform 0.3s;
  margin-bottom: 2rem;
}

.feature-item.dimmed {
  opacity: 0.5;
}

.feature-item:hover {
  transform: translateX(10px);
}

.feature-item .icon {
  width: 30px;
  height: 30px;
  margin-right: 1.5rem;
}

.feature-item h3 {
  font-size: 1.1rem;
  margin-bottom: 0.5rem;
}

.feature-item p {
  font-size: 0.9rem;
  color: #666;
}

.create-account {
  color: #409FDB;
  text-decoration: none;
  font-weight: 500;
  display: inline-block;
  margin-top: 1rem;
}

.create-account::after {
  content: " >";
}

.destination-container {
  padding: 4rem;
  text-align: center;
}

.destinationImg{
  padding: 2rem;
}

.pricing-container {
  padding: 4rem;
  text-align: center;
}

.pricing-container h1 {
  font-size: 2rem;
  margin-bottom: 3rem;
}

.cards-container {
  display: flex;
  justify-content: center;
  gap: 24px;
  padding-bottom: 5rem;
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
}

.card.premium {
  background-color: #409FDB;
  color: white;
  animation: pulse 2s infinite;
}

.card.business, .card.free {
  background-color: #fff;
}

.card h2 {
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
  transition: background-color 0.3s;
}

.card.premium .btn {
  background-color: white;
  color: #409FDB;
}

.badge {
  position: absolute;
  top: 10px;
  right: 10px;
  background-color: #ff9800;
  color: white;
  padding: 0.5rem 1rem;
  border-radius: 4px;
  font-weight: bold;
}

.footer {
  background: transparent;
  padding: 3rem 2rem 0;
  margin-top: auto;
  position: relative;
  overflow: hidden;
}

.footer-content {
  display: flex;
  justify-content: space-between;
  flex-wrap: wrap;
}

.footer-section {
  flex: 0 0 18%;
}


.footer-section h3 {
  font-size: 1.2rem;
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

.footer-section input,
.footer-section textarea {
  width: 100%;
  padding: 0.5rem;
  margin-bottom: 1rem;
  border: 1px solid #ccc;
  border-radius: 8px;
}

.footer-section textarea {
  height: 100px;
  resize: none;
}

.footer-section button {
  padding: 0.75rem 1.5rem;
  background-color: #409FDB;
  color: white;
  border: none;
  border-radius: 8px;
  cursor: pointer;
  margin-bottom: 0;
}

.travelImg {
  padding-top: 1rem;
  width: 150%;
  height: auto;
}

.app-links {
  display: flex;
  gap: 12px;
  margin-top: 1rem;
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

@media (max-width: 992px) {
  .hero, .whyus-container {
    flex-direction: column;
  }
  
  .hero-text, .whyus-img, .whyus-content {
    max-width: 100%;
    width: 100%;
  }
  
  .whyus-content {
    margin-left: 0;
    margin-top: 2rem;
  }
  
  .cards-container {
    flex-wrap: wrap;
  }
  
  .footer-section {
    flex: 0 0 48%;
  }
}

@media (max-width: 768px) {
  header {
    flex-direction: column;
  }
  
  nav ul {
    margin-top: 1rem;
    flex-wrap: wrap;
    justify-content: center;
  }
  
  .hero {
    padding: 2rem;
  }
  
  .cards-container {
    flex-direction: column;
    align-items: center;
  }
  
  .card {
    width: 100%;
    max-width: 300px;
    margin-bottom: 1.5rem;
  }
  
  .footer-section {
    flex: 0 0 100%;
  }
}

/* Enhanced gradients and depth */
.start-page {
  background: linear-gradient(135deg, #e0f2fe 0%, #d3eeff 40%, #ffffff 100%);
}

/* Improved header with glass effect */
header {
  backdrop-filter: blur(10px);
}

/* Enhanced navigation interactions */
nav a {
  position: relative;
}


nav a:hover::after {
  width: 100%;
}

/* Animated buttons with subtle hover effects */
.btn-signup, .btn-plan-trip, .card .btn, .footer-section button {
  box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
  transition: all 0.3s cubic-bezier(0.165, 0.84, 0.44, 1);
}

.btn-signup:hover, .btn-plan-trip:hover, .card .btn:hover, .footer-section button:hover {
  transform: translateY(-2px);
  box-shadow: 0 6px 20px rgba(0, 0, 0, 0.15);
}

/* Hero section improvements */
.hero {
  position: relative;
  overflow: hidden;
}

.hero::before {
  content: '';
  position: absolute;
  top: -50px;
  right: -50px;
  width: 300px;
  height: 300px;
  border-radius: 50%;
  z-index: -1;
}

.hero h1 {
  background: linear-gradient(90deg, #333 0%, #409FDB 100%);
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
  background-clip: text;
  text-fill-color: transparent;
}

/* Enhanced card designs */
.card {
  border: 1px solid rgba(0, 0, 0, 0.05);
  transform-origin: center bottom;
}

.card:hover {
  transform: translateY(-10px);
  box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
}

.card.premium {
  background: linear-gradient(135deg, #409FDB 0%, #3088c3 100%);
  box-shadow: 0 10px 25px rgba(64, 159, 219, 0.3);
  border: none;
}

/* Improved feature items */
.feature-item {
  padding: 15px;
  border-radius: 10px;
  transition: all 0.3s ease;
}

.feature-item:hover {
  background-color: rgba(255, 255, 255, 0.8);
  box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
  transform: translateX(10px) scale(1.02);
}

/* Form element improvements */
.footer-section input, 
.footer-section textarea {
  transition: all 0.3s ease;
  border: 1px solid #e0e0e0;
}

.footer-section input:focus, 
.footer-section textarea:focus {
  outline: none;
  border-color: #409FDB;
  box-shadow: 0 0 0 3px rgba(64, 159, 219, 0.2);
}

/* Custom scrollbar */
::-webkit-scrollbar {
  width: 12px;
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

/* Photo and image enhancements */
.hero-image img, .whyus-image {
  filter: drop-shadow(0 10px 20px rgba(0, 0, 0, 0.1));
}

/* Footer improvements */
.footer {
  background: linear-gradient(to top, rgba(224, 242, 254, 0.5), transparent);
  border-top: 1px solid rgba(0, 0, 0, 0.05);
}

.travel-img-container {
  display: flex;
  justify-content: center;
  align-items: center;
}

.scroll-indicator {
  position: absolute;
  bottom: 30px;
  left: 50%;
  transform: translateX(-50%);
  width: 30px;
  height: 50px;
  border: 2px solid #409FDB;
  border-radius: 15px;
  display: flex;
  justify-content: center;
  cursor: pointer;
  animation: fadeInOut 2s infinite;
}

.scroll-indicator:before {
  content: '';
  width: 8px;
  height: 8px;
  background: #409FDB;
  border-radius: 50%;
  position: absolute;
  top: 10px;
  animation: scrollDown 2s infinite;
}

@keyframes scrollDown {
  0% {
    transform: translateY(0);
    opacity: 1;
  }
  80% {
    transform: translateY(20px);
    opacity: 0;
  }
  100% {
    transform: translateY(0);
    opacity: 0;
  }
}

@keyframes fadeInOut {
  0%, 100% {
    opacity: 0.5;
  }
  50% {
    opacity: 1;
  }
}

/* Add a small animation for sections when they come into view */
.hero, .whyus-container, .pricing-container {
  opacity: 0;
  transform: translateY(20px);
  transition: opacity 0.6s ease, transform 0.6s ease;
}

.show-section {
  opacity: 1;
  transform: translateY(0);
}

/* Header shrink effect on scroll */
.header-scrolled {
  padding: 1rem 2rem;
  box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
}
</style>