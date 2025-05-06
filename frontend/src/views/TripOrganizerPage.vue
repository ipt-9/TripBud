// TripOrganizerPage.vue
<template>
  <AuthenticatedLayout activePage="triporganizer">
    <!-- Custom header using the named slot -->
    <template #header>
      <header class="trip-organizer-header">
        <div class="trip-organizer-logo-wrapper">
          <img :src="logoSrc" class="trip-organizer-logo" alt="TripBud Logo" />
          <h1>Trip Organizer</h1>
        </div>
        <img 
          :src="profileSrc" 
          class="trip-organizer-settings-icon" 
          @click="openSettings" 
          alt="User profile"
        />
      </header>
    </template>
    
    <!-- Main content goes in the default slot -->
    <div class="trip-organizer-content">
      <TripList 
        :trips="trips" 
        @view-trip="viewTrip" 
        @delete-trip="confirmDelete" 
      />
      <button 
        type="submit" 
        class="trip-organizer-new-button" 
        @click="createNewTrip"
      >
        Create New Trip
      </button>
    </div>
  </AuthenticatedLayout>
</template>
  
<script>
import AuthenticatedLayout from '@/components/layout/AuthenticatedLayout.vue';
import TripList from '@/components/trip-organizer/TripList.vue';
import logoImg from '@/assets/TripBudLogo.png';
import profileImg from '@/assets/default.png';

export default {
  name: 'TripOrganizerPage',
  components: {
    AuthenticatedLayout,
    TripList
  },
  data() {
    return {
      logoSrc: logoImg,
      profileSrc: profileImg,
      trips: [
        { name: "Florence" },
        { name: "Paris" },
        { name: "Tokyo" }
      ]
    };
  },
  methods: {
    confirmDelete(index) {
      if (confirm("Do you really want to delete this trip?")) {
        this.deleteTrip(index);
      }
    },
    deleteTrip(index) {
      this.trips.splice(index, 1);
    },
    viewTrip(trip) {
      alert(`Viewing details for: ${trip.name}`);
    },
    createNewTrip() {
      this.$router.push('/createtrip');
    },
    openSettings() {
      this.$router.push('/settings');
    }
  }
};
</script>
  
<style scoped>
.trip-organizer-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 1rem;
  margin-bottom: 1%;
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

.trip-organizer-content {
  width: 100%;
  display: flex;
  flex-direction: column;
  align-items: flex-start;
}

.trip-organizer-new-button {
  background: #409FDB;
  color: white;
  display: block;
  border: none;
  padding: 12px;
  border-radius: 10px;
  cursor: pointer;
  font-size: 16px;
  width: 20%;
  margin-top: 20px;
  transition: background-color 0.3s, transform 0.3s;
}

.trip-organizer-new-button:hover {
  background: #368BD1;
  transform: translateY(-2px);
}

@media (max-width: 768px) {
  .trip-organizer-new-button {
    width: 50%;
    align-self: center;
  }
  
  .trip-organizer-header {
    padding: 0.75rem;
  }
  
  h1 {
    font-size: 1.2rem;
  }
  
  .trip-organizer-logo {
    width: 40px;
  }
  
  .trip-organizer-settings-icon {
    width: 35px;
    height: 35px;
  }
}

@media (max-width: 320px) {
  .trip-organizer-header {
    flex-direction: column;
    align-items: flex-start;
    gap: 0.5rem;
  }
  
  .trip-organizer-settings-icon {
    position: absolute;
    top: 1rem;
    right: 1rem;
  }
}
</style>