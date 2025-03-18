<template>
    <div class="trip-organizer">
      <div class="logo-container">
        <img v-for="img in images" v-bind:src="img" class="logo" />
        <h1>Trip Organizer</h1>
      </div>
      
      <div class="form-container">
        <div class="form-group">
          <label>Trip Name:</label>
          <input type="text" v-model="trip.name" />
        </div>
        
        <div class="form-group">
          <label>Description:</label>
          <textarea v-model="trip.description" ref="descriptionField" @input="autoExpand" style="resize: none; height: 100px; width: 100%;"></textarea>
        </div>
        
        <div class="form-group">
          <label>From:</label>
          <input type="date" v-model="trip.fromDate" />
        </div>
        
        <div class="form-group">
          <label>To:</label>
          <input type="date" v-model="trip.toDate" />
        </div>
        
        <div class="form-group">
          <label>Destination:</label>
          <input type="text" v-model="trip.destination" @input="searchDestination" />
          <ul v-if="destinationResults.length">
            <li v-for="result in destinationResults" :key="result" @click="selectDestination(result)">{{ result }}</li>
          </ul>
        </div>
        
        <div class="form-group">
          <label>Invite Members:</label>
          <input type="email" v-model="trip.inviteEmail" />
          <button @click="inviteMember">Send</button>
        </div>
        
        
        <div class="budget">
          <label>Budget</label>
          <div class="budget-container">
            <div class="budget-fields">
              <div class="form-group">
                <label>Transport ($):</label>
                <input type="number" v-model.number="trip.budget.transport"/>
              </div>
              <div class="form-group">
                <label>Food ($):</label>
                <input type="number" v-model.number="trip.budget.food"/>
              </div>
              <div class="form-group">
                <label>Activities ($):</label>
                <input type="number" v-model.number="trip.budget.activities"/>
              </div>
              <div class="form-group">
                <label>Hotel ($):</label>
                <input type="number" v-model.number="trip.budget.hotel"/>
              </div>
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
        images:['src/assets/TripBudLogo.png'],
      };
    },
    methods: {
    //   searchDestination() {
    //     // Simulierte Suchergebnisse
    //     this.destinationResults = ['Luzern', 'Luzern Kantonalbank', 'Luzern Kanton', 'Luzern Kantonsspital'];
    //   },
      selectDestination(result) {
        this.trip.destination = result;
        this.destinationResults = [];
      },
      inviteMember() {
        const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!this.trip.inviteEmail) {
          alert("Please enter an email address.");
          return;
        }
        if (!emailPattern.test(this.trip.inviteEmail)) {
          alert("Please enter a valid email address.");
          return;
        }
        alert(`Invitation sent to ${this.trip.inviteEmail}`);
        this.trip.inviteEmail = "";
      },
      createTrip() {
        if (!this.trip.name || !this.trip.description || !this.trip.fromDate || !this.trip.toDate || !this.trip.destination || !this.trip.inviteEmail) {
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
  }
  
  .logo-container {
  position: absolute;
  top: 20px;
  left: 20px;
  display: flex;
  align-items: center;
}
  
  .logo {
    width: 40px;
    margin-right: 10px;
  }
  
  .form-container {
  }
  
  .form-group {
    margin-bottom: 15px;
  }
  
  .budget-fields input {
    display: block;
    margin-bottom: 10px;
    width: 100%;
    padding: 5px;
  }

  .budget-fields input::-webkit-outer-spin-button,
  .budget-fields input::-webkit-inner-spin-button {
    -webkit-appearance: none;
    margin: 0;
}

/* Entfernt die Pfeile für Firefox */
.budget-fields input[type=number] {
    -moz-appearance: textfield;
}
  
.create-trip {
  background: #409FDB;
  color: white;
  cursor: pointer;
  border: none;
  margin-top: 1rem;
  margin-bottom: 1rem;
}

.create-trip:hover {
  background: #368BD1;
}
</style>
  