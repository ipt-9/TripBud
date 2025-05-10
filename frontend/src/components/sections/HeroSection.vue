<template>
  <div class="hero" id="hero">
    <div class="hero-text">
      <h1>Plan your next trip together.</h1>
      <p>Let's plan your perfect trip together, including all the details! Include all your buddies and store your files in-app!</p>
      <router-link to="/createtrip">
        <button class="btn-plan-trip">Plan your Trip now!</button>
      </router-link>
    </div>
    <div class="hero-image">
      <img src="@/assets/hero_image.svg" alt="Trip Planning Illustration" />
    </div>
  </div>
</template>

<script>
export default {
  name: 'HeroSection'
};
</script>

<style scoped>
.hero {
  display: flex;
  align-items: center;
  justify-content: space-between;
  padding: 3rem 5rem;
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
  text-fill-color: transparent;
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
  transition: all 0.3s cubic-bezier(0.165, 0.84, 0.44, 1);
  box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
}

.btn-plan-trip:hover {
  background-color: #0056b3;
  transform: translateY(-2px);
  box-shadow: 0 6px 20px rgba(0, 0, 0, 0.15);
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

@media (max-width: 1200px) {
  .hero h1 {
    font-size: 2.5rem;
  }
}

@media (max-width: 992px) {
  .hero {
    flex-direction: column;
    padding: 3rem 2rem;
  }
  
  .hero-text, .hero-image {
    max-width: 100%;
    width: 100%;
  }
  
  .hero-image {
    padding-left: 0;
    margin-top: 2rem;
  }
}

@media (max-width: 768px) {
  .hero {
    padding: 2rem 1rem;
  }
  
  .hero h1 {
    font-size: 2rem;
  }
  
  .hero p {
    font-size: 1rem;
  }
}

@media (max-width: 576px) {
  .hero h1 {
    font-size: 1.8rem;
  }
  
  .hero p {
    font-size: 0.9rem;
    margin-bottom: 1.5rem;
  }
  
  .btn-plan-trip {
    padding: 0.6rem 1.2rem;
    font-size: 1rem;
    width: 100%;
  }
}

@media (max-width: 375px) {
  .hero h1 {
    font-size: 1.5rem;
  }
}
</style>