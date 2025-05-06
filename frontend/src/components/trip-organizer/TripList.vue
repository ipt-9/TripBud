// TripList.vue
<template>
  <div class="trip-list-container">
    <h2 class="trip-list-title">Ongoing Trips</h2>
    <div class="trip-list-card">
      <TripItem 
        v-for="(trip, index) in trips" 
        :key="index"
        :trip="trip"
        @click="$emit('view-trip', trip)"
        @delete="$emit('delete-trip', index)"
      />
      <div v-if="trips.length === 0" class="no-trips-message">
        No trips found. Create a new trip to get started!
      </div>
    </div>
  </div>
</template>

<script>
import TripItem from '@/components/trip-organizer/TripItem.vue';

export default {
  name: 'TripList',
  components: {
    TripItem
  },
  props: {
    trips: {
      type: Array,
      required: true
    }
  }
};
</script>

<style scoped>
.trip-list-container {
  width: 100%;
  display: flex;
  flex-direction: column;
  align-items: flex-start;
}

.trip-list-title {
  margin-bottom: 10px;
  font-size: 1.5rem;
}

.trip-list-card {
  background: white;
  padding: 2rem;
  border-radius: 10px;
  box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
  text-align: left;
  width: 100%;
  min-height: 200px;
}

.no-trips-message {
  color: #666;
  text-align: center;
  padding: 2rem 0;
  font-style: italic;
}

@media (max-width: 576px) {
  .trip-list-card {
    padding: 1rem;
  }
  
  .trip-list-title {
    font-size: 1.3rem;
  }
}
</style>