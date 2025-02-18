<template>
    <div class="trip-organizer">
      <div class="header">
        <img src="C:\Users\schus\TripBud\TripBud\frontend\src\assets\TripBudLogo.png" alt="Logo" class="logo" />
        <h1>Trip Organizer</h1>
      </div>
      
      <div class="form-container">
        <div class="form-group">
          <label>Trip Name:</label>
          <input type="text" v-model="trip.name" />
        </div>
        
        <div class="form-group">
          <label>Description:</label>
          <textarea v-model="trip.description"></textarea>
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
        <div class="budget-fields">
          <label>Transport ($):</label>
          <input type="number" placeholder="0" v-model.number="trip.budget.transport" min="0" step="0.01" />
          <label>Food ($):</label>
          <input type="number" placeholder="0" v-model.number="trip.budget.food" min="0" step="0.01" />
          <label>Activities ($):</label>
          <input type="number" placeholder="0" v-model.number="trip.budget.activities" min="0" step="0.01" />
          <label>Hotel ($):</label>
          <input type="number" placeholder="0" v-model.number="trip.budget.hotel" min="0" step="0.01" />
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
        destinationResults: []
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
        alert(`Invitation sent to ${this.trip.inviteEmail}`);
      },
      createTrip() {
        alert('Trip Created!');
      }
    }
  };
  </script>
  
  <style scoped>
  .trip-organizer {
    font-family: Arial, sans-serif;
    background: #e6f7ff;
    padding: 20px;
    border-radius: 10px;
    width: 600px;
    margin: auto;
  }
  
  .header {
    display: flex;
    align-items: center;
  }
  
  .logo {
    width: 40px;
    margin-right: 10px;
  }
  
  .form-container {
    display: flex;
    flex-direction: column;
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
  
  .create-trip {
    background: blue;
    color: white;
    padding: 10px;
    border-radius: 5px;
    cursor: pointer;
  }
  </style>
  