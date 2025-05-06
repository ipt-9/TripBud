// FeatureItem.vue
<template>
  <div 
    class="feature-item"
    @mouseover="$emit('hover', index)" 
    @mouseleave="$emit('leave')"
    :class="{ 'dimmed': isDimmed }"
  >
    <img :src="feature.icon" class="icon" alt="Feature icon" />
    <div>
      <h3>{{ feature.title }}</h3>
      <p>{{ feature.description }}</p>
    </div>
  </div>
</template>

<script>
export default {
  name: 'FeatureItem',
  props: {
    feature: {
      type: Object,
      required: true
    },
    index: {
      type: Number,
      required: true
    },
    isDimmed: {
      type: Boolean,
      default: false
    }
  }
};
</script>

<style scoped>
.feature-item {
  display: flex;
  align-items: center;
  text-align: left;
  cursor: pointer;
  transition: all 0.3s ease;
  margin-bottom: 2rem;
  padding: 15px;
  border-radius: 10px;
}

.feature-item.dimmed {
  opacity: 0.5;
}

.feature-item:hover {
  transform: translateX(10px) scale(1.02);
  background-color: rgba(255, 255, 255, 0.8);
  box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
}

.feature-item .icon {
  width: 30px;
  height: 30px;
  margin-right: 1.5rem;
}

.feature-item h3 {
  font-size: 1.1rem;
  margin-bottom: 0.5rem;
}

.feature-item p {
  font-size: 0.9rem;
  color: #666;
}

@media (max-width: 576px) {
  .feature-item {
    margin-bottom: 1.5rem;
  }
  
  .feature-item .icon {
    width: 24px;
    height: 24px;
    margin-right: 1rem;
  }
}

@media (max-width: 375px) {
  .feature-item {
    margin-bottom: 1rem;
  }
}

@media (hover: none) {
  .feature-item:hover {
    transform: none;
    background-color: transparent;
    box-shadow: none;
  }
}
</style>