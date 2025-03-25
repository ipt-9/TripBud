<template>
  <div class="start-page">
    <header>
      <div class="logo">
        <img :src="images[0]" class="logo" />
        <h1>TripBud</h1>
      </div>
      <nav>
        <ul>
          <li><a href="#" @click.prevent="scrollToSection('whyus')">Why Us</a></li>
          <li><a href="#" @click.prevent="scrollToSection('pricing')">Plans</a></li>
          <li><a href="/register" class="btn-signup">Sign Up</a></li>
          <li><a href="/login" class="btn-login">Login</a></li>
        </ul>
      </nav>
    </header>

    <main>
      <div class="hero">
        <div class="hero-text">
          <h1>Plan your next trip together.</h1>
          <p>Let's plan your perfect trip together, including all the details! Include all your buddies and store your files in-app!</p>
          <router-link to="/createtrip">
            <button class="btn-plan-trip"> Plan your Trip now!</button>
          </router-link>
        </div>
        <div class="hero-image">
          <img v-for="(img, index) in StartImages" :key="index" :src="img" />
        </div>
      </div>

      <!-- Why Us Section -->
      <div class="whyus-container" id="whyus">
        <div class="whyus-img">
          <img v-for="(img, index) in whyusImages" :key="index" :src="img" class="whyus-image" />
        </div>
        <div class="whyus-content">
          <h1>Why Choose Us</h1>
          <p>Enjoy unique experiences in every place you visit and discover new, affordable adventures.</p>
          <div class="features-box">
            <div class="feature-item" v-for="(feature, index) in features" :key="index" @mouseover="hoveredIndex = index" @mouseleave="hoveredIndex = null" :class="{ 'dimmed': hoveredIndex !== null && hoveredIndex !== index }">
              <img :src="feature.icon" class="icon" />
              <div>
                <h3>{{ feature.title }}</h3>
                <p>{{ feature.description }}</p>
              </div>
            </div>
          </div>
          <router-link to="/register" class="login-text">Create an account! ></router-link>
        </div>
      </div>

      <!-- Pricing Section -->
      <div class="pricing-container" id="pricing">
        <h1 class="title">Plans</h1>
        <div class="cards-container">
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
          <div class="card premium" @mouseover="pausePulse" @mouseleave="resumePulse">
            <h2>Premium</h2>
            <p class="price">$8.99<span>/mo</span></p>
            <div class="plan-info">
              <p>10 saved trips</p>
              <p>Up to 5 buddies per trip</p>
              <p>Up to 5 GB trip storage</p>
            </div>
            <button class="btn">Get Premium</button>
            <div class="badge">Best Deal</div>
          </div>
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
          <img v-for="(img, index) in logoImages" :key="index" :src="img" style="width: 70px; height: 70px;" />
          <p>&copy; 2025 TripBud all rights reserved.</p>
          <div class="app-links">
            <img v-for="(img, index) in googleImages" :key="index" :src="img" style="width: 120px; height: 50px;" />
            <img v-for="(img, index) in appleImages" :key="index" :src="img" style="width: 100px; height: 35px;" />
          </div>
        </div>
        <div class="footer-section">
          <h3>Pages</h3>
          <ul>
            <li><a href="#">Home</a></li>
            <li><a href="#" @click.prevent="scrollToSection('whyus')">Why Us</a></li>
            <li><a href="#" @click.prevent="scrollToSection('pricing')">Plans</a></li>
            <li><a href="/register">Sign Up</a></li>
            <li><a href="/login">Login</a></li>
          </ul>
        </div>
        <div class="footer-section">
          <h3>Address</h3>
          <p>Zumhofstrasse 77</p>
          <p>6010 Kriens</p>
          <p>Switzerland</p>
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
      images: ['src/assets/TripBudLogo.png'],
      StartImages: ['src/assets/FrontImg.png'],
      whyusImages: ['src/assets/why-us-img.png'],
      features: [
        { icon: 'src/assets/download-symbol.png', title: 'In-App Storage', description: 'Store your travel documents for your trip directly in the app!' },
        { icon: 'src/assets/group-symbol.png', title: 'Plan Together', description: 'Invite your friends to the trip and exchange together!' },
        { icon: 'src/assets/document-symbol.png', title: 'Integrated Blog', description: 'Capture your journey and create an album!' }
      ],
      hoveredIndex: null,
      appleImages: ['src/assets/AppleStore.png'],
      googleImages: ['src/assets/GooglePlay.png'],
      logoImages: ['src/assets/TripBudLogo.png']
    };
  },
  methods: {
    pausePulse(event) {
      event.target.style.animationPlayState = 'paused';
    },
    resumePulse(event) {
      event.target.style.animationPlayState = 'running';
    },
    scrollToSection(sectionId) {
      const section = document.getElementById(sectionId);
      if (section) {
        section.scrollIntoView({ behavior: 'smooth', block: 'start', inline: 'nearest' });
      }
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
  font-family: 'Roboto', sans-serif;
  color: #333;
  background: linear-gradient(to bottom, #e0f2fe, #ffffff);
  min-height: 100vh;
  display: flex;
  flex-direction: column;
  transition: opacity 0.5s ease-in-out; /* Fade effect */
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
  cursor: pointer;
  transition: color 0.3s;
}

nav a:hover {
  color: #007bff;
}

.btn-signup {
  background-color: #ff9800;
  padding: 0.5rem 1rem;
  border-radius: 4px;
  color: white;
  transition: background-color 0.3s;
}

.btn-signup:hover {
  background-color: #e68200;
}

.btn-login {
  border: 1px solid black;
  padding: 0.5rem 1rem;
  border-radius: 4px;
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
  background-color: #007bff;
  color: #fff;
  border: none;
  border-radius: 4px;
  cursor: pointer;
  transition: background-color 0.3s;
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
  height: auto;
}

.whyus-container {
  display: flex;
  justify-content: space-between;
  padding: 4rem;
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

.feature-item img {
  width: 50px;
  height: 50px;
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

.pricing-container {
  padding: 4rem;
}

.pricing-container .title {
  font-size: 2rem;
  text-align: center;
  margin-bottom: 3rem;
}

.cards-container {
  display: flex;
  justify-content: space-between;
}

.card {
  background-color: #fff; /* Default white background */
  border-radius: 12px; /* Smoother corners */
  padding: 2rem;
  text-align: center;
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
  margin: 1rem;
  width: 30%;
  position: relative;
  transition: transform 0.3s, box-shadow 0.3s; /* Smoother transitions */
}

.card.free {
  background-color: #fff; /* White background for Free plan */
}

.card.premium {
  background-color: #409FDB; /* Blue background for Premium plan */
  animation: pulse 2s infinite; /* Reintroduced pulse animation */
}

.card.business {
  background-color: #fff; /* White background for Business plan */
}

.card button {
  background-color: #007bff; /* Blue button for Free and Business plans */
  color: white;
  padding: 1rem 2rem;
  border: none;
  border-radius: 4px;
  cursor: pointer;
  transition: background-color 0.3s;
}

.card.premium button {
  background-color: white; /* White button for Premium plan */
  color: #007bff; /* Blue text for visibility */
  border: 1px solid #007bff; /* Blue border */
}

.card h2 {
  font-size: 1.8rem;
  margin-bottom: 1.5rem;
}

.card p {
  font-size: 1.2rem;
}

.card .price {
  font-size: 2.5rem;
  font-weight: bold;
}

.card .plan-info p {
  font-size: 1rem;
  margin: 1rem 0;
}

.premium .badge {
  position: absolute;
  top: 10px;
  right: 10px;
  background-color: #ff9800;
  color: white;
  padding: 0.5rem 1rem;
  border-radius: 4px;
  font-weight: bold;
}

.whyus-img {
  margin-right: 0rem; /* Added space between image and content */
}

.footer {
  background: transparent;
  padding: 2rem;
  text-align: center;
  margin-top: auto;
}

.footer .footer-content {
  display: flex;
  justify-content: space-between;
  flex-wrap: wrap;
}

.footer-section {
  margin: 1rem;
  width: 23%;
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
  cursor: pointer;
  transition: color 0.3s;
}

.footer-section a:hover {
  color: #007bff;
}

.footer input,
.footer textarea {
  width: 100%;
  padding: 0.5rem;
  margin-bottom: 1rem;
  border-radius: 4px;
  border: 1px solid #ccc;
  transition: border-color 0.3s;
}

.footer input:focus,
.footer textarea:focus {
  border-color: #007bff;
}

.footer button {
  padding: 0.75rem 1.5rem;
  background-color: #007bff;
  color: white;
  border: none;
  border-radius: 4px;
  cursor: pointer;
  transition: background-color 0.3s;
}

.footer button:hover {
  background-color: #0056b3;
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
</style>
