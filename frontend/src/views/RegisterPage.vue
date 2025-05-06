// RegisterPage.vue
<template>
  <div class="register-page">
    <Header />
    
    <div class="register-container">
      <RegisterForm @registration-error="handleError" />
    </div>
    
  </div>
</template>

<script>
import Header from '@/components/layout/Header.vue';
import Footer from '@/components/layout/Footer.vue';
import RegisterForm from '@/components/auth/RegisterForm.vue';

export default {
  name: 'RegisterPage',
  components: {
    Header,
    Footer,
    RegisterForm
  },
  methods: {
    handleError(errorMessage) {
      console.error('Registration error:', errorMessage);
    }
  }
};
</script>

<style scoped>
.register-page {
  min-height: 100vh;
  display: flex;
  flex-direction: column;
  background: linear-gradient(to bottom, #e0f2fe, #ffffff);
}

.register-container {
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  flex: 1;
  padding: 2rem;
  margin-top: 60px; /* Space for fixed header */
}
</style>