<template>
  <div class="trip-organizer">
    <div class="header">
      <div class="logo-container">
        <img v-for="img in images" :src="img" class="logo" />
        <h1>Trip Organizer</h1>
      </div>
      <img :src="accountImages" class="settings-icon" @click="openSettings" />
    </div>

    <div class="triporganizer-content">
      <h2 class="triporganizer-title">Ongoing Trips</h2>
      <div class="triporganizer-card">
        <div v-for="(trip, index) in trips" :key="index" class="trip-item" @click="viewTrip(trip)">
          <div class="trip-info">
            <span class="trip-name">{{ trip.name }}</span>
          </div>
          <div class="trip-actions">
            <img v-for="(img, i) in trashImages" :key="i" :src="img" class="delete-icon" @click.stop="confirmDelete(index)"/>
          </div>
        </div>        
      </div>
      <button type="submit" class="newtrip-button" @click="createNewTrip">Create New Trip</button>
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
      images:['src/assets/TripBudLogo.png'],
      accountImages: ['src/assets/account-symbol.png'],
      trashImages:['src/assets/trash-symbol.png']
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

.trip-organizer {
  background: linear-gradient(to bottom, #e0f2fe, #ffffff); 
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  height: 100vh;
}

.header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 3%;
  width: 90%;
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
  position: absolute;
  top: 4%;
  right: 2%;
  height: 6%;
  cursor: pointer;
}

.triporganizer-content {
  width: 70%;
  display: flex;
  flex-direction: column;
  align-items: flex-start;
}

.triporganizer-title {
  margin-bottom: 10px;
}

.triporganizer-card {
  background: white;
  padding: 2rem;
  border-radius: 10px;
  box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
  text-align: left;
  width: 100%;
  min-height: 200px;
}

.trip-info {
  display: flex;
  align-items: center;
  gap: 10px;
}

.trip-name {
  font-size: 16px;
}

.delete-icon {
  width: 20px;
  height: 20px;
  cursor: pointer;
  filter: grayscale(100%);
  transition: filter 0.3s ease;
}

.delete-icon:hover {
  filter: grayscale(0%);
  transform: scale(1.2);
  filter: hue-rotate(-10deg) saturate(1000%) brightness(90%);
}

.trip-item {
  display: flex;
  align-items: center;
  justify-content: space-between;
  padding: 10px;
  border-bottom: 1px solid #ddd;
  cursor: pointer;
  transition: all 0.3s ease;
}

.trip-item:hover {
  background-color: #f1f1f1;
  transform: translateX(5px);
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

.trip-actions {
  opacity: 0;
  transition: opacity 0.3s ease;
}

.trip-item:hover .trip-actions {
  opacity: 1;
}

.newtrip-button {
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

.newtrip-button:hover {
  background: #368BD1;
}
</style>