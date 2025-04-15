<template>
  <div class="trip-organizer-container">
    <div class="trip-background-pattern"></div>
    
    <div class="trip-header">
      <div class="trip-logo-wrapper">
        <img src="/src/assets/TripBudLogo.png" class="trip-logo-image" />
        <h1 class="trip-page-title">Create Trip</h1>
      </div>
      <img src="" class="trip-settings-icon" @click="openSettings" />
    </div>

    <div class="trip-content-wrapper">
      <!-- Left column -->
      <div class="trip-left-column">
        <!-- First card -->
        <div class="trip-card trip-details-card">
          <div class="trip-field-wrapper">
            <label class="trip-field-label">Trip Name:</label>
            <input type="text" v-model="trip.name" placeholder="Enter trip name" class="trip-text-input"/>
          </div>
          
          <div class="trip-field-wrapper">
            <label class="trip-field-label">Destination:</label>
            <input type="text" v-model="trip.destination" placeholder="Enter destination" class="trip-text-input"/>
          </div>
          
          <div class="trip-field-wrapper">
            <label class="trip-field-label">Invite Members:</label>
            <button class="trip-btn-primary" @click="generateInviteLink">Generate Invite Link</button>
          </div>

          <div v-if="inviteLink" class="trip-field-wrapper">
            <input type="text" v-model="inviteLink" readonly class="trip-invite-link-field"/>
          </div>
        </div>

        <!-- Second card -->
        <div class="trip-card trip-description-card">
          <div class="trip-field-wrapper">
            <label class="trip-field-label">Description:</label>
            <textarea 
              v-model="trip.description" 
              ref="descriptionField" 
              @input="autoExpand" 
              placeholder="Add description..." 
              class="trip-textarea">
            </textarea>
          </div>
          
          <div class="trip-dates-row">
            <div class="trip-field-wrapper">
              <label class="trip-field-label">From:</label>
              <input type="date" v-model="trip.fromDate" class="trip-date-input"/>
            </div>
            <div class="trip-field-wrapper">
              <label class="trip-field-label">To:</label>
              <input type="date" v-model="trip.toDate" class="trip-date-input"/>
            </div>
          </div>
        </div>
      </div>
      
      <!-- Right column -->
      <div class="trip-right-column">
        <!-- Budget card -->
        <div class="trip-card trip-budget-card">
          <div class="trip-budget-header">
            <div class="trip-budget-title-wrapper">
              <span class="trip-budget-title">Budget</span>
            </div>
            <div class="trip-total-wrapper">
              <span class="trip-total-label">Total:</span>
              <span class="trip-total-amount">${{ calculateTotalFormatted }}</span>
            </div>
          </div>
          
          <div class="trip-budget-item">
            <label class="trip-field-label">Transport ($):</label>
            <input type="number" v-model.number="trip.budget.transport" placeholder="0" class="trip-number-input"/>
          </div>
          
          <div class="trip-budget-item">
            <label class="trip-field-label">Food ($):</label>
            <input type="number" v-model.number="trip.budget.food" placeholder="0" class="trip-number-input"/>
          </div>
          
          <div class="trip-budget-item">
            <label class="trip-field-label">Activities ($):</label>
            <input type="number" v-model.number="trip.budget.activities" placeholder="0" class="trip-number-input"/>
          </div>
          
          <div class="trip-budget-item">
            <label class="trip-field-label">Hotel ($):</label>
            <input type="number" v-model.number="trip.budget.hotel" placeholder="0" class="trip-number-input"/>
          </div>
        </div>
        
        <!-- Create button -->
        <button class="trip-create-button" @click="createTrip">Create Trip</button>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      trip: {
        name: '',
        description: '',
        fromDate: '',
        toDate: '',
        destination: '',
        budget: { 
          transport: null, 
          food: null, 
          activities: null, 
          hotel: null 
        }
      },
      inviteLink: '',
    };
  },
  computed: {
    calculateTotal() {
      const { transport, food, activities, hotel } = this.trip.budget;
      let total = 0;
      if (transport) total += transport;
      if (food) total += food;
      if (activities) total += activities;
      if (hotel) total += hotel;
      return total;
    },
    calculateTotalFormatted() {
      return this.calculateTotal > 0 ? this.calculateTotal.toLocaleString() : '0';
    }
  },
  methods: {
    generateInviteLink() {
      if (!this.trip.name) {
        alert("Please enter a trip name first.");
        return;
      }
      const baseUrl = window.location.origin;
      const tripId = Math.random().toString(36).substr(2, 9);
      this.inviteLink = `${baseUrl}/join-trip/${tripId}`;
    },
    createTrip() {
      if (!this.trip.name || !this.trip.fromDate || !this.trip.toDate || !this.trip.destination) {
        alert("Please fill out all required fields before creating the trip.");
        return;
      }
      alert('Trip Created!');
    },
    autoExpand() {
      const field = this.$refs.descriptionField;
      field.style.height = 'auto';
      field.style.height = field.scrollHeight + 'px';
    },
    openSettings() {
      alert('Settings feature coming soon!');
    }
  }
};
</script>

<style scoped>
* {
  box-sizing: border-box;
  font-family: 'Outfit', sans-serif;
  margin: 0;
  padding: 0;
}

.trip-organizer-container {
  position: relative;
  background: linear-gradient(to bottom, #e0f2fe, #ffffff);
  min-height: 100vh;
  padding: 20px;
  overflow: hidden;
}

.trip-background-pattern {
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background-image: url('/src/assets/lines.png');
  background-size: cover;
  background-position: center;
  opacity: 0.1;
  z-index: 0;
}

.trip-header {
  position: relative;
  z-index: 1;
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 30px;
}

.trip-logo-wrapper {
  display: flex;
  align-items: center;
}

.trip-logo-image {
  width: 36px;
  height: 36px;
  background-color: #409FDB;
  border-radius: 8px;
  padding: 6px;
  margin-right: 10px;
}

.trip-page-title {
  font-size: 22px;
  font-weight: 600;
  color: #333;
}

.trip-settings-icon {
  width: 24px;
  height: 24px;
  cursor: pointer;
}

.trip-content-wrapper {
  position: relative;
  z-index: 1;
  display: flex;
  justify-content: center;
  gap: 30px;
  max-width: 1200px;
  margin: 0 auto;
}

.trip-left-column {
  width: 50%;
  min-width: 300px;
  display: flex;
  flex-direction: column;
  gap: 20px;
}

.trip-right-column {
  width: 30%;
  min-width: 300px;
  display: flex;
  flex-direction: column;
  gap: 20px;
}

.trip-card {
  background: white;
  border-radius: 10px;
  padding: 20px;
  box-shadow: 0 2px 8px rgba(0,0,0,0.05);
}

.trip-field-wrapper {
  margin-bottom: 20px;
}

.trip-field-wrapper:last-child {
  margin-bottom: 0;
}

.trip-field-label {
  display: block;
  margin-bottom: 8px;
  font-weight: 500;
  color: #333;
}

.trip-text-input, 
.trip-date-input,
.trip-number-input {
  width: 100%;
  padding: 10px 12px;
  border: 1px solid #ddd;
  border-radius: 5px;
  font-size: 14px;
}

.trip-invite-link-field {
  width: 100%;
  padding: 10px 12px;
  border: 1px solid #ddd;
  border-radius: 5px;
  background-color: #f5f7fa;
  font-size: 14px;
}

.trip-textarea {
  width: 100%;
  padding: 10px 12px;
  border: 1px solid #ddd;
  border-radius: 5px;
  font-size: 14px;
  min-height: 100px;
  resize: none;
}

.trip-dates-row {
  display: flex;
  gap: 15px;
}

.trip-dates-row .trip-field-wrapper {
  flex: 1;
}

.trip-btn-primary {
  width: 100%;
  background-color: #409FDB;
  color: white;
  border: none;
  border-radius: 5px;
  padding: 10px;
  font-size: 14px;
  cursor: pointer;
  transition: background-color 0.2s;
  height: 40px;
}

.trip-btn-primary:hover {
  background-color: #3588c7;
}

.trip-budget-card {
  margin-bottom: 10px;
}

.trip-budget-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 20px;
}

.trip-budget-title-wrapper {
  position: relative;
}

.trip-budget-title {
  font-size: 18px;
  font-weight: 600;
  color: #333;
  position: relative;
  padding-bottom: 8px;
  display: inline-block;
}

.trip-budget-title:after {
  content: '';
  position: absolute;
  left: 0;
  bottom: 0;
  width: 100%;
  height: 3px;
  background-color: #409FDB;
}

.trip-total-wrapper {
  display: flex;
  align-items: center;
  gap: 5px;
}

.trip-total-label {
  font-weight: 500;
  color: #333;
}

.trip-total-amount {
  color: #409FDB;
  font-weight: 600;
}

.trip-budget-item {
  margin-bottom: 20px;
}

.trip-budget-item:last-child {
  margin-bottom: 0;
}

.trip-create-button {
  background-color: #409FDB;
  color: white;
  border: none;
  border-radius: 5px;
  padding: 12px;
  font-size: 16px;
  font-weight: 500;
  cursor: pointer;
  width: 100%;
  transition: background-color 0.2s;
  height: 48px;
}

.trip-create-button:hover {
  background-color: #3588c7;
}

@media (max-width: 1000px) {
  .trip-content-wrapper {
    flex-direction: column;
    align-items: center;
  }
  
  .trip-left-column, 
  .trip-right-column {
    width: 100%;
    max-width: 600px;
  }
}

@media (max-width: 768px) {
  .trip-dates-row {
    flex-direction: column;
  }
}

@media (max-width: 480px) {
  .trip-card {
    padding: 15px;
  }
  
  .trip-budget-header {
    flex-direction: column;
    align-items: flex-start;
  }
  
  .trip-total-wrapper {
    margin-top: 10px;
  }
}
</style>