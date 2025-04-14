<template>
  <div class="trip-organizer">
    <div class="header">
      <div class="logo-container">
        <img src="/src/assets/TripBudLogo.png" class="logo" />
        <h1 class="title">Trip Organizer</h1>
      </div>
      <img src="" class="settings-icon" @click="openSettings" />
    </div>

    <div class="content-layout">
      <div class="left-content">
        <div class="card trip-details-card">
          <div class="form-row">
            <div class="input-group">
              <label>Trip Name:</label>
              <input type="text" v-model="trip.name" placeholder="Enter trip name" class="input-field"/>
            </div>
            
            <div class="input-group">
              <label>Destination:</label>
              <input type="text" v-model="trip.destination" placeholder="Enter destination" class="input-field"/>
            </div>
          </div>

          <div class="input-group">
            <label>Invite Members:</label>
            <button class="generate-btn" @click="generateInviteLink">Generate Invite Link</button>
          </div>

          <div v-if="inviteLink" class="invite-link-row">
            <input type="text" v-model="inviteLink" readonly class="invite-link-field"/>
          </div>
        </div>

        <div class="card details-card">
          <div class="input-group description-group">
            <label>Description:</label>
            <textarea 
              v-model="trip.description" 
              ref="descriptionField" 
              @input="autoExpand" 
              placeholder="Add description..." 
              class="textarea-field">
            </textarea>
          </div>
          
          <div class="date-container">
            <div class="input-group">
              <label>From:</label>
              <input type="date" v-model="trip.fromDate" class="input-field"/>
            </div>
            <div class="input-group">
              <label>To:</label>
              <input type="date" v-model="trip.toDate" class="input-field"/>
            </div>
          </div>
        </div>
      </div>
      
      
      <div class="right-content">
        <div class="card budget-card">
          <h2 class="budget-title">Budget</h2>
          
          <div class="budget-item">
            <label>Transport ($):</label>
            <input type="number" v-model.number="trip.budget.transport" placeholder="0" class="budget-input"/>
          </div>
          
          <div class="budget-item">
            <label>Food ($):</label>
            <input type="number" v-model.number="trip.budget.food" placeholder="0" class="budget-input"/>
          </div>
          
          <div class="budget-item">
            <label>Activities ($):</label>
            <input type="number" v-model.number="trip.budget.activities" placeholder="0" class="budget-input"/>
          </div>
          
          <div class="budget-item">
            <label>Hotel ($):</label>
            <input type="number" v-model.number="trip.budget.hotel" placeholder="0" class="budget-input"/>
          </div>
          
          <div class="total-row">
            <span class="total-text">Total: ${{ calculateTotalFormatted }}</span>
          </div>
        </div>
        
        <button class="create-trip-btn" @click="createTrip">Create Trip</button>
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
      return this.calculateTotal.toLocaleString();
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
}

.trip-organizer {
  background: linear-gradient(to bottom, #e0f2fe, #ffffff);
  min-height: 100vh;
  padding: 20px;
}

.header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 30px;
  padding: 0 20px;
}

.logo-container {
  display: flex;
  align-items: center;
}

.logo {
  width: 40px;
  height: 40px;
  background-color: #409FDB;
  border-radius: 10px;
  padding: 8px;
  margin-right: 10px;
}

.title {
  font-size: 24px;
  font-weight: 600;
  color: #333;
  margin: 0;
}

.settings-icon {
  width: 24px;
  height: 24px;
  cursor: pointer;
}

.content-layout {
  display: flex;
  gap: 30px;
  flex-wrap: wrap;
  max-width: 1400px;
  margin: 0 auto;
}

.left-content {
  flex: 3;
  min-width: 300px;
  display: flex;
  flex-direction: column;
  gap: 20px;
}

.right-content {
  flex: 2;
  min-width: 300px;
  display: flex;
  flex-direction: column;
  align-items: center;
}

.card {
  background: white;
  border-radius: 10px;
  padding: 25px;
  box-shadow: 0 2px 10px rgba(0,0,0,0.05);
  margin-bottom: 10px;
}

.form-row {
  display: flex;
  justify-content: space-between;
  gap: 20px;
  margin-bottom: 20px;
}

.input-group {
  display: flex;
  flex-direction: column;
  flex: 1;
  margin-bottom: 15px;
}

.input-group label {
  margin-bottom: 8px;
  font-weight: 500;
  color: #333;
}

.input-field {
  padding: 10px 15px;
  border-radius: 5px;
  border: 1px solid #ddd;
  font-size: 14px;
  height: 40px;
}

.input-field:focus {
  outline: none;
  border-color: #409FDB;
  box-shadow: 0 0 0 3px rgba(64, 159, 219, 0.1);
}

.invite-link-row {
  margin-bottom: 15px;
}

.invite-link-field {
  width: 100%;
  padding: 10px 15px;
  border-radius: 5px;
  border: 1px solid #ddd;
  background-color: #f8f9fa;
  font-size: 14px;
}

.textarea-field {
  padding: 10px 15px;
  border-radius: 5px;
  border: 1px solid #ddd;
  font-size: 14px;
  min-height: 100px;
  resize: none;
}

.textarea-field:focus {
  outline: none;
  border-color: #409FDB;
  box-shadow: 0 0 0 3px rgba(64, 159, 219, 0.1);
}

.description-group {
  margin-bottom: 20px;
}

.date-container {
  display: flex;
  gap: 20px;
}

.generate-btn {
  background-color: #409FDB;
  color: white;
  border: none;
  border-radius: 5px;
  padding: 10px 15px;
  font-size: 14px;
  cursor: pointer;
  height: 40px;
  width: 100%;
}

.generate-btn:hover {
  background-color: #3588c7;
}

.budget-card {
  width: 100%;
  max-width: 500px;
}

.budget-title {
  font-size: 18px;
  font-weight: 600;
  color: #333;
  margin-top: 0;
  margin-bottom: 20px;
  position: relative;
  display: inline-block;
}

.budget-title:after {
  content: '';
  position: absolute;
  left: 0;
  bottom: -5px;
  width: 100%;
  height: 3px;
  background-color: #409FDB;
}

.budget-item {
  margin-bottom: 20px;
}

.budget-item label {
  display: block;
  margin-bottom: 8px;
  font-weight: 500;
  color: #333;
}

.budget-input {
  width: 100%;
  padding: 10px 15px;
  border-radius: 5px;
  border: 1px solid #ddd;
  font-size: 14px;
}

.budget-input:focus {
  outline: none;
  border-color: #409FDB;
  box-shadow: 0 0 0 3px rgba(64, 159, 219, 0.1);
}

.total-row {
  background-color: #f0f8ff;
  padding: 12px 20px;
  text-align: right;
  border-radius: 5px;
  margin-top: 20px;
}

.total-text {
  font-weight: 600;
  color: #409FDB;
  font-size: 16px;
}

.create-trip-btn {
  background-color: #409FDB;
  color: white;
  border: none;
  border-radius: 5px;
  padding: 12px 30px;
  font-size: 16px;
  font-weight: 500;
  cursor: pointer;
  width: 100%;
  max-width: 300px;
  margin-top: 20px;
}

.create-trip-btn:hover {
  background-color: #3588c7;
}

@media (max-width: 992px) {
  .content-layout {
    flex-direction: column;
  }
  
  .left-content, .right-content {
    width: 100%;
  }
  
  .form-row {
    flex-direction: column;
    gap: 15px;
  }
  
  .budget-card {
    max-width: none;
  }
}

@media (max-width: 768px) {
  .date-container {
    flex-direction: column;
    gap: 15px;
  }
}

@media (max-width: 480px) {
  .content-container {
    padding: 0 10px;
  }
  
  .card {
    padding: 15px;
  }
}
</style>