// PricingCard.vue
<template>
  <div 
    :class="['card', planType]" 
    @mouseover="isPremium && $emit('pause-pulse')" 
    @mouseleave="isPremium && $emit('resume-pulse')"
  >
    <h2>{{ plan.title }}</h2>
    <p class="price">{{ plan.price }}<span>/mo</span></p>
    <div class="plan-info">
      <p v-for="(feature, index) in plan.features" :key="index">{{ feature }}</p>
    </div>
    <button class="btn">{{ plan.buttonText }}</button>
  </div>
</template>

<script>
export default {
  name: 'PricingCard',
  props: {
    plan: {
      type: Object,
      required: true
    },
    planType: {
      type: String,
      required: true
    }
  },
  computed: {
    isPremium() {
      return this.planType === 'premium';
    }
  }
};
</script>

<style scoped>
.card {
  background-color: #fff;
  border-radius: 12px;
  padding: 2rem;
  text-align: center;
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
  width: 280px;
  position: relative;
  transition: transform 0.3s, box-shadow 0.3s;
  border: 1px solid rgba(0, 0, 0, 0.05);
  transform-origin: center bottom;
}

.card:hover {
  transform: translateY(-10px);
  box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
}

.card.premium {
  background: linear-gradient(135deg, #409FDB 0%, #3088c3 100%);
  color: white;
  box-shadow: 0 10px 25px rgba(64, 159, 219, 0.3);
  border: none;
  animation: pulse 2s infinite;
}

.card h2 {
  font-size: 1.8rem;
  margin-bottom: 1.5rem;
}

.price {
  font-size: 2.5rem;
  font-weight: bold;
  margin-bottom: 1.5rem;
}

.price span {
  font-size: 1.2rem;
  font-weight: normal;
}

.plan-info {
  margin-bottom: 2rem;
}

.plan-info p {
  margin-bottom: 0.75rem;
}

.card .btn {
  width: 100%;
  padding: 0.75rem 0;
  font-size: 1rem;
  background-color: #409FDB;
  color: white;
  border: none;
  border-radius: 8px;
  cursor: pointer;
  transition: all 0.3s cubic-bezier(0.165, 0.84, 0.44, 1);
  box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
}

.card .btn:hover {
  transform: translateY(-2px);
  box-shadow: 0 6px 20px rgba(0, 0, 0, 0.15);
}

.card.premium .btn {
  background-color: white;
  color: #409FDB;
}

@keyframes pulse {
  0% {
    transform: scale(1);
  }
  50% {
    transform: scale(1.05);
  }
  100% {
    transform: scale(1);
  }
}

@media (max-width: 992px) {
  .card {
    flex: 0 0 calc(50% - 20px);
    width: calc(50% - 20px);
    max-width: 280px;
  }
}

@media (max-width: 768px) {
  .card {
    width: 100%;
    max-width: 300px;
    margin-bottom: 1.5rem;
  }
}

@media (max-width: 576px) {
  .card {
    padding: 1.5rem;
  }
  
  .card h2 {
    font-size: 1.5rem;
    margin-bottom: 1rem;
  }
  
  .price {
    font-size: 2rem;
    margin-bottom: 1rem;
  }
}

@media (hover: none) {
  .card:hover {
    transform: none;
  }
}
</style>