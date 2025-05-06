// LandingPage.vue
<template>
  <div class="start-page">
    <Header />
    
    <main>
      <HeroSection />
      <WhyUsSection />
      <DestinationsSection />
      <PricingSection />
    </main>

    <Footer />
  </div>
</template>

<script>
import Header from '@/components/layout/Header.vue';
import Footer from '@/components/layout/Footer.vue';
import HeroSection from '@/components/sections/HeroSection.vue';
import WhyUsSection from '@/components/sections/WhyUsSection.vue';
import DestinationsSection from '@/components/sections/DestinationsSection.vue';
import PricingSection from '@/components/sections/PricingSection.vue';

export default {
  name: 'LandingPage',
  components: {
    Header,
    Footer,
    HeroSection,
    WhyUsSection,
    DestinationsSection,
    PricingSection
  },
  mounted() {
    window.addEventListener('scroll', this.handleScroll);
    this.handleScroll();
  },
  beforeDestroy() {
    window.removeEventListener('scroll', this.handleScroll);
  },
  methods: {
    handleScroll() {
      // Header shrink effect
      const header = document.querySelector('header');
      if (window.scrollY > 100) {
        header.classList.add('header-scrolled');
      } else {
        header.classList.remove('header-scrolled');
      }
      
      // Reveal sections when scrolled into view
      const sections = document.querySelectorAll('.hero, .whyus-container, .pricing-container');
      sections.forEach(section => {
        const sectionTop = section.getBoundingClientRect().top;
        if (sectionTop < window.innerHeight - 100) {
          section.classList.add('show-section');
        }
      });
    }
  }
};
</script>

<style>
@import url('https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;700&display=swap');

* {
  font-family: 'Outfit', sans-serif;
  box-sizing: border-box;
}

.start-page {
  color: #333;
  background: linear-gradient(135deg, #e0f2fe 0%, #d3eeff 40%, #ffffff 100%);
  min-height: 100vh;
  display: flex;
  flex-direction: column;
  transition: opacity 0.5s ease-in-out;
}

/* Hero, WhyUs, Pricing section animations */
.hero, .whyus-container, .pricing-container {
  opacity: 0;
  transform: translateY(20px);
  transition: opacity 0.6s ease, transform 0.6s ease;
}

.show-section {
  opacity: 1;
  transform: translateY(0);
}

/* Custom scrollbar */
::-webkit-scrollbar {
  width: 12px;
}

::-webkit-scrollbar-track {
  background: #f5f5f5;
}

::-webkit-scrollbar-thumb {
  background: #409FDB;
  border-radius: 6px;
  border: 3px solid #f5f5f5;
}

::-webkit-scrollbar-thumb:hover {
  background: #3088c3;
}

html {
  scroll-behavior: smooth;
}
</style>