// TripOrganizerHeader.vue
<template>
  <header class="trip-organizer-header">
    <div class="trip-organizer-logo-wrapper">
      <img :src="logoSrc" class="trip-organizer-logo" alt="TripBud Logo" />
      <h1>Trip Organizer</h1>
    </div>
    <img 
      :src="profileSrc" 
      class="trip-organizer-settings-icon" 
      @click="$emit('open-settings')" 
      alt="User profile"
    />
  </header>
</template>

<script>
// Import assets directly
import logoImg from '@/assets/TripBudLogo.png';
import profileImg from '@/assets/default.png';

export default {
  name: 'TripOrganizerHeader',
  data() {
    return {
      logoSrc: logoImg,
      profileSrc: profileImg
    };
  }
};
</script>

<style scoped>
.trip-organizer-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 7%;
  width: 90%;
  position: relative;
}

.trip-organizer-logo-wrapper {
  display: flex;
  align-items: center;
}

.trip-organizer-logo {
  width: 50px;
  margin-right: 15px;
}

.trip-organizer-settings-icon {
  width: 40px;
  height: 40px;
  border-radius: 50%;
  cursor: pointer;
  transition: transform 0.3s ease;
}

.trip-organizer-settings-icon:hover {
  transform: scale(1.1);
}

@media (max-width: 576px) {
  .trip-organizer-header {
    width: 95%;
    margin-bottom: 5%;
  }
  
  .trip-organizer-logo {
    width: 40px;
  }
  
  .trip-organizer-settings-icon {
    width: 35px;
    height: 35px;
  }
  
  h1 {
    font-size: 1.5rem;
  }
}
</style>