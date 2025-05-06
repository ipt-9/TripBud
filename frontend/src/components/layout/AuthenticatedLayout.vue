// AuthenticatedLayout.vue
<template>
  <div class="authenticated-layout">
    <!-- Custom header slot -->
    <slot name="header">
      <!-- Default header if not provided -->
      <header class="default-header">
        <div class="logo-container">
          <img :src="logoSrc" class="logo" alt="TripBud Logo" />
          <h1>{{ pageTitle }}</h1>
        </div>
        <img 
          :src="profileSrc" 
          class="settings-icon" 
          @click="openSettings" 
          alt="Settings" 
        />
      </header>
    </slot>
    
    <div class="main-layout">
      <AppNavigation :activePage="activePage" />
      
      <div class="content-container">
        <slot></slot>
      </div>
    </div>
  </div>
</template>

<script>
// Update the import path to match your actual directory structure
import AppNavigation from '../navigation/AppNavigation.vue';
import logoImg from '@/assets/TripBudLogo.png';
import profileImg from '@/assets/default.png';

export default {
  name: 'AuthenticatedLayout',
  components: {
    AppNavigation
  },
  props: {
    pageTitle: {
      type: String,
      default: 'TripBud'
    },
    activePage: {
      type: String,
      required: true
    }
  },
  data() {
    return {
      logoSrc: logoImg,
      profileSrc: profileImg
    };
  },
  methods: {
    openSettings() {
      this.$router.push('/settings');
    }
  },
  created() {
    // Check for authentication
    const bearerToken = localStorage.getItem('bearerToken');
    if (!bearerToken) {
      console.warn('No bearer token found. Redirecting to login...');
      this.$router.push('/login');
    }
  }
}
</script>

<style scoped>
.authenticated-layout {
  display: flex;
  flex-direction: column;
  background: linear-gradient(to bottom, #e0f2fe, #ffffff);
  background-image: url('@/assets/lines.png');
  background-size: cover;
  min-height: 100vh;
  position: relative;
  padding-bottom: 70px; /* Add padding to prevent content from being hidden behind mobile nav */
}

.default-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 1rem;
  margin-bottom: 1%;
}

.logo-container {
  display: flex;
  align-items: center;
}
 
.logo {
  width: 50px;
  margin-right: 15px;
}
 
.settings-icon {
  width: 40px;
  height: 40px;
  border-radius: 50%;
  cursor: pointer;
  transition: transform 0.2s ease;
}

.settings-icon:hover {
  transform: scale(1.05);
}

.main-layout {
  display: flex;
  flex: 1;
  padding: 0 2rem 2rem;
  gap: 2rem;
}

.content-container {
  flex: 1;
}

@media (max-width: 768px) {
  .main-layout {
    padding: 0 1rem 1rem;
  }
  
  .default-header {
    padding: 0.75rem;
  }
  
  h1 {
    font-size: 1.2rem;
  }
  
  .logo {
    width: 40px;
  }
  
  .settings-icon {
    width: 35px;
    height: 35px;
  }
}
 
@media (max-width: 480px) {
  .main-layout {
    padding: 0 0.5rem 0.5rem;
  }
}

@media (max-width: 320px) {
  .default-header {
    flex-direction: column;
    align-items: flex-start;
    gap: 0.5rem;
  }
  
  .settings-icon {
    position: absolute;
    top: 1rem;
    right: 1rem;
  }
}
</style>