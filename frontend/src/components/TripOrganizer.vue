<template>
  <div class="trip-organizer-container">
    <header class="trip-organizer-header">
      <div class="trip-organizer-logo-wrapper">
        <img v-for="img in images" :src="img" class="trip-organizer-logo" />
        <h1>Trip Organizer</h1>
      </div>
      <img :src="accountImages" class="trip-organizer-settings-icon" @click="openSettings" />
    </header>

    <div class="trip-organizer-content-section">
      <h2 class="trip-organizer-section-title">Ongoing Trips</h2>
      <div class="trip-organizer-card-container">
        <div v-for="(trip, index) in trips" :key="index" class="trip-organizer-item" @click="viewTrip(trip)">
          <div class="trip-organizer-item-info">
            <span class="trip-organizer-item-name">{{ trip.name }}</span>
          </div>
          <div class="trip-organizer-item-actions">
            <img v-for="(img, index) in trashImages" :key="index" :src="img" class="trip-organizer-delete-icon" @click.stop="confirmDelete(index)"/>
          </div>
        </div>        
      </div>
      <button type="submit" class="trip-organizer-new-button" @click="createNewTrip">Create New Trip</button>
    </div>
  </div>
</template>
  
<script>
export default {
  data() {
    return {
      trips: [
        { name: "Florence" },
        { name: "Paris" },
        { name: "Tokyo" }
      ],
      images:['../assets/TripBudLogo.png'],
      accountImages: ['../assets/default.png'],
      trashImages:['../assets/trash-symbol.png']
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
  
<style>
* {
  font-family: 'Outfit', sans-serif;
}

.trip-organizer-container {
  background: linear-gradient(to bottom, #e0f2fe, #ffffff); 
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: flex-start;
  height: 100vh;
  padding-top: 20px;
}

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
}

.trip-organizer-content-section {
  width: 70%;
  display: flex;
  flex-direction: column;
  align-items: flex-start;
}

.trip-organizer-section-title {
  margin-bottom: 10px;
}

.trip-organizer-card-container {
  background: white;
  padding: 2rem;
  border-radius: 10px;
  box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
  text-align: left;
  width: 100%;
  min-height: 200px;
}

.trip-organizer-item-info {
  display: flex;
  align-items: center;
  gap: 10px;
}

.trip-organizer-item-name {
  font-size: 16px;
}

.trip-organizer-delete-icon {
  width: 20px;
  height: 20px;
  cursor: pointer;
  filter: grayscale(100%);
  transition: filter 0.3s ease;
}

.trip-organizer-delete-icon:hover {
  filter: grayscale(0%);
  transform: scale(1.2);
  filter: hue-rotate(-10deg) saturate(1000%) brightness(90%);
}

.trip-organizer-item {
  display: flex;
  align-items: center;
  justify-content: space-between;
  padding: 10px;
  border-bottom: 1px solid #ddd;
  cursor: pointer;
  transition: all 0.3s ease;
}

.trip-organizer-item:hover {
  background-color: #f1f1f1;
  transform: translateX(5px);
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

.trip-organizer-item-actions {
  opacity: 0;
  transition: opacity 0.3s ease;
}

.trip-organizer-item:hover .trip-organizer-item-actions {
  opacity: 1;
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
  transition: 0.3s;
}

.trip-organizer-new-button:hover {
  background: #368BD1;
}
</style>