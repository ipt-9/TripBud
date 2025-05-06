<!-- WhyUsSection.vue -->
<template>
  <div class="whyus-container" id="whyus">
    <div class="whyus-img">
      <img src="@/assets/explorer.svg" alt="Traveler with backpack" class="whyus-image" />
    </div>
    <div class="whyus-content">
      <h1>Why Choose Us</h1>
      <p>Enjoy unique experiences in every place you visit and discover new, affordable adventures.</p>
      
      <div class="features-box">
        <FeatureItem 
          v-for="(feature, index) in features" 
          :key="index"
          :feature="feature"
          :index="index"
          :isDimmed="hoveredIndex !== null && hoveredIndex !== index"
          @hover="hoveredIndex = $event"
          @leave="hoveredIndex = null"
        />
      </div>
      
      <router-link to="/register" class="create-account">Create an account!</router-link>
    </div>
  </div>
</template>

<script>
import FeatureItem from '@/components/ui/FeatureItem.vue';
// Import images directly
import downloadIcon from '@/assets/download.png';
import usersIcon from '@/assets/users.png';
import documentIcon from '@/assets/document.png';

export default {
  name: 'WhyUsSection',
  components: {
    FeatureItem
  },
  data() {
    return {
      hoveredIndex: null,
      features: [
        { 
          icon: downloadIcon, 
          title: 'In-App Storage', 
          description: 'Store your travel documents for your trip directly in the app!' 
        },
        { 
          icon: usersIcon, 
          title: 'Plan Together', 
          description: 'Invite your friends to the trip and exchange together!' 
        },
        { 
          icon: documentIcon, 
          title: 'Integrated Blog', 
          description: 'Capture your journey and create an album!' 
        }
      ]
    };
  }
};
</script>

<style scoped>
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
  filter: drop-shadow(0 10px 20px rgba(0, 0, 0, 0.1));
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
  background-color: #f8f9fa;
  width: 90%;
  border-radius: 15px;
  padding: 1.5rem;
  box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
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

@media (max-width: 1200px) {
  .whyus-image {
    width: 100%;
  }
}

@media (max-width: 992px) {
  .whyus-container {
    flex-direction: column;
    padding: 3rem 2rem;
  }
  
  .whyus-img, .whyus-content {
    max-width: 100%;
    width: 100%;
  }
  
  .whyus-img {
    display: flex;
    justify-content: center;
  }
  
  .whyus-image {
    width: 80%;
    max-height: 400px;
  }
  
  .whyus-content {
    margin-left: 0;
    margin-top: 2rem;
  }
  
  .features-box {
    width: 100%;
  }
}

@media (max-width: 768px) {
  .whyus-container {
    padding: 2rem 1rem;
  }
}

@media (max-width: 576px) {
  .whyus-content h1 {
    font-size: 1.8rem;
    display: flex;
    justify-content: center;
  }
}
</style>