// TripItem.vue
<template>
  <div class="trip-item" @click="$emit('click')">
    <div class="trip-item-info">
      <span class="trip-item-name">{{ trip.name }}</span>
    </div>
    <div class="trip-item-actions">
      <img 
        :src="trashIconSrc" 
        class="trip-delete-icon" 
        @click.stop="$emit('delete')" 
        alt="Delete trip"
      />
    </div>
  </div>
</template>

<script>
// Import trash icon directly
import trashIcon from '@/assets/trash-symbol.png';

export default {
  name: 'TripItem',
  props: {
    trip: {
      type: Object,
      required: true
    }
  },
  data() {
    return {
      trashIconSrc: trashIcon
    };
  }
};
</script>

<style scoped>
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

.trip-item-info {
  display: flex;
  align-items: center;
  gap: 10px;
}

.trip-item-name {
  font-size: 16px;
}

.trip-delete-icon {
  width: 20px;
  height: 20px;
  cursor: pointer;
  filter: grayscale(100%);
  transition: filter 0.3s ease, transform 0.3s ease;
}

.trip-delete-icon:hover {
  filter: grayscale(0%);
  transform: scale(1.2);
  filter: hue-rotate(-10deg) saturate(1000%) brightness(90%);
}

.trip-item-actions {
  opacity: 0;
  transition: opacity 0.3s ease;
}

.trip-item:hover .trip-item-actions {
  opacity: 1;
}
</style>