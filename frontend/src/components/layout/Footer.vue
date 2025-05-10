<template>
  <footer class="footer">
    <div class="footer-content">
      <div class="footer-section">
        <img src="@/assets/TripBudLogo.png" style="width: 70px; height: 70px;" alt="TripBud Logo" />
        <p>&copy; {{ currentYear }} TripBud all rights reserved.</p>
        <div class="app-links">
          <img src="@/assets/GooglePlay.png" style="width: 120px; height: 50px;" alt="Google Play" />
          <img src="@/assets/AppleStore.png" style="width: 100px; height: 35px;" alt="App Store" />
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
          <img src="@/assets/travel.svg" alt="travel image" class="travelImg"/>
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
</template>

<script>
export default {
  name: 'Footer',
  computed: {
    currentYear() {
      return new Date().getFullYear();
    }
  },
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
.footer {
  background: linear-gradient(to top, rgba(224, 242, 254, 0.5), transparent);
  padding: 3rem 2rem 0;
  margin-top: auto;
  position: relative;
  overflow: hidden;
  border-top: 1px solid rgba(0, 0, 0, 0.05);
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
  transition: all 0.3s ease;
}

.footer-section textarea {
  height: 100px;
  resize: none;
}

.footer-section input:focus, 
.footer-section textarea:focus {
  outline: none;
  border-color: #409FDB;
  box-shadow: 0 0 0 3px rgba(64, 159, 219, 0.2);
}

.footer-section button {
  padding: 0.75rem 1.5rem;
  background-color: #409FDB;
  color: white;
  border: none;
  border-radius: 8px;
  cursor: pointer;
  margin-bottom: 0;
  transition: all 0.3s cubic-bezier(0.165, 0.84, 0.44, 1);
  box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
}

.footer-section button:hover {
  transform: translateY(-2px);
  box-shadow: 0 6px 20px rgba(0, 0, 0, 0.15);
}

.travel-img-container {
  display: flex;
  justify-content: center;
  align-items: center;
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

@media (max-width: 992px) {
  .footer-content {
    gap: 30px;
  }
  
  .footer-section {
    flex: 0 0 calc(50% - 30px);
  }
}

@media (max-width: 768px) {
  .footer-section {
    flex: 0 0 100%;
    margin-bottom: 2rem;
  }
  
  .travelImg {
    width: 100%;
  }
}

@media (max-width: 576px) {
  .footer-section input,
  .footer-section textarea {
    padding: 0.8rem;
  }

  .travel-img-container {
    display: none;
  }
}
</style>