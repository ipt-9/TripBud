<template>
  <div class="pricing-container">
    <h1 class="title">Plans</h1>
    <div class="cards">
      <div class="card">
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
        <button class="btn white-btn">Get Premium</button>
        <div class="badge">Best Deal</div>
      </div>
      <div class="card">
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
  
  <footer class="footer">
    <div class="footer-content">
      <div class="footer-section">
        <img v-for="(img, index) in logoImages" :key="index" :src="img" style="width: 70px; height: 70px;" />
        <p>&copy; 202 TripBud all rights reserved.</p>
        <div class="app-links">
          <img v-for="(img, index) in googleImages" :key="index" :src="img" style="width: 120px; height: 50px;" />
          <img v-for="(img, index) in appleImages" :key="index" :src="img" style="width: 100px; height: 35px;" />
        </div>
      </div>
      <div class="footer-section">
        <h3>Pages</h3>
        <ul>
          <li>Home</li>
          <li>Why Us</li>
          <li>Plans</li>
          <li>Sign Up</li>
          <li>Login</li>
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
          <li>Impressum</li>
          <li>Data privacy</li>
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
</template>

<script>
export default {
  data() {
    return {
      appleImages: ['src/assets/AppleStore.png'],
      googleImages: ['src/assets/GooglePlay.png'],
      logoImages: ['src/assets/TripBudLogo.png']
    };
  },

  methods: {
    pausePulse(event) {
      event.target.style.animationPlayState = "paused"; 
    },
    resumePulse(event) {
      event.target.style.animationPlayState = "running";
    }
  }
};
</script>

<style scoped>
@import url('https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;700&display=swap');

* {
  font-family: 'Outfit', sans-serif;
}

.pricing-container {
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  min-height: 100vh;
  background: linear-gradient(to bottom, #e0f2fe, #ffffff);
  padding-bottom: 100px; /* Added space below the cards */
}

.title {
  font-size: 2.5rem;
  font-weight: 700;
  margin-bottom: 20px;
}

.cards {
  display: flex;
  justify-content: center;
  gap: 30px;
}

.card {
  background: white;
  padding: 30px;
  border-radius: 15px;
  box-shadow: 0 6px 15px rgba(0, 0, 0, 0.1);
  text-align: center;
  width: 300px;
  transition: transform 0.3s ease, background 0.3s ease;
}

.card:hover {
  background: #409FDB;
  color: white;
  transform: scale(1.05);
}

.premium {
  background: #4F9BFC;
  color: white;
  transform: scale(1.05);
  box-shadow: 0 8px 25px rgba(0, 0, 0, 0.2);
  position: relative;
  z-index: 2;
  border: 2px solid #409FDB;
  animation: pulse 1.5s infinite;
  animation-play-state: running;
}

@keyframes pulse {
  0% { transform: scale(1.05); }
  50% { transform: scale(1.1); }
  100% { transform: scale(1.05); }
}

.footer {
  background: #f8f9fa;
  padding: 30px 0;
  width: 100%;
  position: relative;
  bottom: 0;
}

.footer-content {
  display: flex;
  justify-content: space-around;
  flex-wrap: wrap;
  max-width: 1200px;
  margin: auto;
}
</style>
