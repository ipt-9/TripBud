// PricingSection.vue
<template>
  <div class="pricing-container" id="pricing">
    <h1>Plans</h1>
    <div class="cards-container">
      <PricingCard 
        v-for="(plan, index) in plans" 
        :key="index"
        :plan="plan"
        :planType="plan.type"
        @pause-pulse="pausePulse"
        @resume-pulse="resumePulse"
      />
    </div>
  </div>
</template>

<script>
import PricingCard from '@/components/ui/PricingCard.vue';

export default {
  name: 'PricingSection',
  components: {
    PricingCard
  },
  data() {
    return {
      plans: [
        {
          title: 'Free',
          price: '$0',
          type: 'free',
          buttonText: 'Start Free',
          features: [
            '2 saved trips',
            'Up to 2 buddies per trip',
            'Up to 1 GB trip storage'
          ]
        },
        {
          title: 'Premium',
          price: '$8.99',
          type: 'premium',
          buttonText: 'Get Premium',
          features: [
            '10 saved trips',
            'Up to 5 buddies per trip',
            'Up to 5 GB trip storage'
          ]
        },
        {
          title: 'Business',
          price: '$24.99',
          type: 'business',
          buttonText: 'Get Business',
          features: [
            'Unlimited saved trips',
            'Unlimited buddies per trip',
            'Unlimited trip storage'
          ]
        }
      ]
    };
  },
  methods: {
    pausePulse(event) {
      if (event && event.target) {
        event.target.style.animationPlayState = 'paused';
      }
    },
    resumePulse(event) {
      if (event && event.target) {
        event.target.style.animationPlayState = 'running';
      }
    }
  }
};
</script>

<style scoped>
.pricing-container {
  padding: 4rem;
  text-align: center;
}

.pricing-container h1 {
  font-size: 2rem;
  margin-bottom: 3rem;
}

.cards-container {
  display: flex;
  justify-content: center;
  gap: 24px;
  padding-bottom: 5rem;
}

@media (max-width: 992px) {
  .cards-container {
    flex-wrap: wrap;
    gap: 20px;
  }
}

@media (max-width: 768px) {
  .pricing-container {
    padding: 2rem 1rem;
  }
  
  .cards-container {
    flex-direction: column;
    align-items: center;
    gap: 24px;
  }
}

@media (max-width: 576px) {
  .pricing-container h1 {
    font-size: 1.8rem;
    margin-bottom: 1.5rem;
  }
}
</style>