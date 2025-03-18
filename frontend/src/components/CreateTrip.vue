<template>
  <div class="trip-organizer">
    <div class="header">
      <div class="logo-container">
        <img v-for="img in images" :src="img" class="logo" />
        <h1>Trip Organizer</h1>
      </div>
      <button class="settings-btn">
        <img src="" alt="Settings" />
      </button>
    </div>

    <div class="form-container">
      <div class="form-group">
        <label>Trip Name:</label>
        <input type="text" v-model="trip.name" placeholder="Enter trip name" />
      </div>
      
      <div class="form-group">
        <label>Description:</label>
        <textarea v-model="trip.description" ref="descriptionField" @input="autoExpand" placeholder="Add details..."></textarea>
      </div>
      
      <div class="date-container">
        <div class="form-group">
          <label>From:</label>
          <input type="date" v-model="trip.fromDate" />
        </div>
        <div class="form-group">
          <label>To:</label>
          <input type="date" v-model="trip.toDate" />
        </div>
      </div>
      
      <div class="form-group">
        <label>Destination:</label>
        <input type="text" v-model="trip.destination" placeholder="Search destination..." />
        <ul v-if="destinationResults.length" class="dropdown">
          <li v-for="result in destinationResults" :key="result" @click="selectDestination(result)">{{ result }}</li>
        </ul>
      </div>
      
      <div class="form-group">
        <label>Invite Members:</label>
        <div class="invite-container">
          <input type="email" v-model="trip.inviteEmail" placeholder="Enter email" />
          <button class="send-btn" @click="inviteMember">Send</button>
        </div>
      </div>

      <div class="budget-container">
        <h3>Budget</h3>
        <div class="budget-fields">
          <div class="form-group">
            <label>Transport ($):</label>
            <input type="number" v-model.number="trip.budget.transport" />
          </div>
          <div class="form-group">
            <label>Food ($):</label>
            <input type="number" v-model.number="trip.budget.food" />
          </div>
          <div class="form-group">
            <label>Activities ($):</label>
            <input type="number" v-model.number="trip.budget.activities" />
          </div>
          <div class="form-group">
            <label>Hotel ($):</label>
            <input type="number" v-model.number="trip.budget.hotel" />
          </div>
        </div>
      </div>
      
      <button class="create-trip" @click="createTrip">Create Trip</button>
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
        inviteEmail: '',
        budget: { transport: 0, food: 0, activities: 0, hotel: 0 }
      },
      destinationResults: [],
      images: ['src/assets/TripBudLogo.png'],
    };
  },
  methods: {
    selectDestination(result) {
      this.trip.destination = result;
      this.destinationResults = [];
    },
    inviteMember() {
      if (!this.trip.inviteEmail) {
        alert("Please enter an email address.");
        return;
      }
      alert(`Invitation sent to ${this.trip.inviteEmail}`);
      this.trip.inviteEmail = "";
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
  padding: 20px;
  border-radius: 10px;
}

.header {
  display: flex;
  justify-content: space-between;
  align-items: center;
}

.logo-container {
  display: flex;
  align-items: center;
}

.logo {
  width: 40px;
  margin-right: 10px;
}

.settings-btn img {
  width: 24px;
  cursor: pointer;
}

.form-container {
  display: flex;
  flex-direction: column;
  gap: 15px;
}

.form-group {
  display: flex;
  flex-direction: column;
  gap: 5px;
}

.date-container {
  display: flex;
  gap: 15px;
}

.invite-container {
  display: flex;
  gap: 10px;
}

.send-btn {
  background: #409FDB;
  color: white;
  border: none;
  padding: 8px 12px;
  cursor: pointer;
  border-radius: 5px;
}

.create-trip {
  background: #409FDB;
  color: white;
  border: none;
  padding: 10px;
  border-radius: 5px;
  cursor: pointer;
  text-align: center;
}

.create-trip:hover {
  background: #368BD1;
}
</style>
