<template>
  <div class="trip-organizer">
    <div class="header">
      <div class="logo-container">
        <img v-for="img in images" :src="img" class="logo" />
        <h1>Trip Organizer</h1>
      </div>
      <img :src="accountImages" class="settings-icon" @click="openSettings" />
    </div>

    <div class="form-layout">
      <div class="form-column">
        <div class="form-group">
          <label>Trip Name:</label>
          <input type="text" v-model="trip.name" placeholder="Enter trip name" class="input-field"/>
        </div>
        
        <div class="form-group">
          <label>Description:</label>
          <textarea v-model="trip.description" ref="descriptionField" @input="autoExpand" placeholder="Add description..." class="textarea-field"></textarea>
        </div>
      
        <div class="date-container">
          <div class="form-group">
            <label>From:</label>
            <input type="date" v-model="trip.fromDate" class="input-field"/>
          </div>
          <div class="form-group">
            <label>To:</label>
            <input type="date" v-model="trip.toDate" class="input-field"/>
          </div>
        </div>
      </div>
      
      <div class="form-column">
        <div class="form-group">
          <label>Destination:</label>
          <input type="text" v-model="trip.destination" placeholder="Enter destination..." class="input-field"/>
          <ul v-if="destinationResults.length" class="dropdown">
            <li v-for="result in destinationResults" :key="result" @click="selectDestination(result)">{{ result }}</li>
          </ul>
        </div>
      </div>
      
      <div class="form-column">
        <div class="form-group">
          <label>Invite Members:</label>
          <div class="invite-container">
            <input type="email" v-model="trip.inviteEmail" placeholder="Enter email" class="input-field"/>
            <div class="send-btn-container">
              <button class="send-btn" @click="inviteMember">Send Email</button>
            </div>
          </div>
        </div>
      </div>
  </div>

      <div class="budget-container">
        <h3>Budget</h3>
        <div class="budget-fields">
          <div class="form-group">
            <label>Transport ($):</label>
            <input type="number" v-model.number="trip.budget.transport" class="budget-input"/>
          </div>
          <div class="form-group">
            <label>Food ($):</label>
            <input type="number" v-model.number="trip.budget.food" class="budget-input"/>
          </div>
          <div class="form-group">
            <label>Activities ($):</label>
            <input type="number" v-model.number="trip.budget.activities" class="budget-input"/>
          </div>
          <div class="form-group">
            <label>Hotel ($):</label>
            <input type="number" v-model.number="trip.budget.hotel" class="budget-input"/>
          </div>
        </div>
      </div>
      
      <button class="create-trip" @click="createTrip">Create Trip</button>
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
        inviteEmail: '',
        budget: { transport: 0, food: 0, activities: 0, hotel: 0 }
      },
      destinationResults: [],
      images: ['../assets/TripBudLogo.png'],
      accountImages: ['../assets/account-symbol.png']
    };
  },
  methods: {
    selectDestination(result) {
      this.trip.destination = result;
      this.destinationResults = [];
    },
    inviteMember() {
      const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
      if (!this.trip.inviteEmail || !emailRegex.test(this.trip.inviteEmail)) {
        alert("Please enter a valid email address.");
        return;
      }
      const subject = encodeURIComponent("Trip Invitation");
      const body = encodeURIComponent(`Hey, join my trip: ${this.trip.name} from ${this.trip.fromDate} to ${this.trip.toDate} at ${this.trip.destination}.`);
      window.location.href = `mailto:${this.trip.inviteEmail}?subject=${subject}&body=${body}`;
    },
    createTrip() {
      if (!this.trip.name || !this.trip.description || !this.trip.fromDate || !this.trip.toDate || !this.trip.destination) {
        alert("Please fill out all fields before creating the trip.");
        return;
      }
      alert('Trip Created!');
    },
    autoExpand() {
      const field = this.$refs.descriptionField;
      field.style.height = 'auto';
      field.style.height = field.scrollHeight + 'px';
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
  padding: 30px;
  margin: auto;
}

.header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 3%;
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

.form-layout {
  display: flex;
  justify-content: space-between;
  gap: 2rem;
}

.form-column {
  flex: 1;
  display: flex;
  flex-direction: column;
  gap: 1rem;
}

.invite-container {
  display: flex;
  flex-direction: column;
  gap: 10px;
}

.send-btn-container {
  display: flex;
  justify-content: flex-end;
}

.form-group {
  display: flex;
  flex-direction: column;
  gap: 5px;
  margin-top: 1%;
}

.budget-container {
  margin-top: 3%;
}

.send-btn {
  background: #409FDB;
  color: white;
  border: none;
  padding: 1%;
  border-radius: 10px;
  width: 30%;
  cursor: pointer;
  font-size: 16px;
}

.send-:hover {
  background: #368BD1;
}

.input-field {
  padding: 8px;
  border-radius: 10px;
  border: 1px solid #ccc;
}

.textarea-field {
  resize: none;
  overflow-y: hidden;
  padding: 8px;
  border-radius: 10px;
  border: 1px solid #ccc;
}

.budget-fields {
  display: flex;
  gap: 11rem;
}

.budget-input {
  padding: 8px;
  border-radius: 10px;
  border: 1px solid #ccc;
  width: 170%;
}

.create-trip {
  display: block;
  background: #409FDB;
  color: white;
  border: none;
  padding: 12px;
  border-radius: 10px;
  cursor: pointer;
  font-size: 16px;
  width: 30%;
  margin: 30px auto;
}

.create-trip:hover {
  background: #368BD1;
}
</style>
