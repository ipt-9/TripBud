// LoginPage.vue
<template>
  <div class="login-page">
    <Header />
    
    <div class="login-container">
      <LoginForm 
        @login-success="handleLoginSuccess" 
        @show-error="handleError"
      />
      <SuccessPopup
        v-if="showPopup"
        :message="popupMessage"
        @close="closePopup"
      />
    </div>
  </div>
</template>

<script>
import Header from '@/components/layout/Header.vue';
import Footer from '@/components/layout/Footer.vue';
import LoginForm from '@/components/auth/LoginForm.vue';
import SuccessPopup from '@/components/ui/SuccessPopup.vue';

export default {
  name: 'LoginPage',
  components: {
    Header,
    Footer,
    LoginForm,
    SuccessPopup
  },
  data() {
    return {
      showPopup: false,
      popupMessage: '',
      username: ''
    };
  },
  methods: {
    handleLoginSuccess(username) {
      this.username = username;
      this.popupMessage = `Welcome back, ${username}! You've successfully logged in.`;
      this.showPopup = true;
    },
    handleError(errorMessage) {
      console.error('Login error:', errorMessage);
    },
    closePopup() {
      this.showPopup = false;
      this.$router.push('/dashboard');
    }
  }
};
</script>

<style scoped>
.login-page {
  min-height: 100vh;
  display: flex;
  flex-direction: column;
  background: linear-gradient(to bottom, #e0f2fe, #ffffff);
}

.login-container {
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  flex: 1;
  padding: 2rem;
  margin-top: 60px; /* Space for fixed header */
}

/* Transitions for popup */
.fade-enter-active, .fade-leave-active {
  transition: opacity 0.3s;
}

.fade-enter, .fade-leave-to {
  opacity: 0;
}
</style>