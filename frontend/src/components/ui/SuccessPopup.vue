<template>
  <transition name="fade">
    <div class="popup-overlay" @click="$emit('close')">
      <div class="popup-content" @click.stop>
        <div class="popup-icon">
          <svg width="40" height="40" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M22 11.0857V12.0057C21.9988 14.1621 21.3005 16.2604 20.0093 17.9875C18.7182 19.7147 16.9033 20.9782 14.8354 21.5896C12.7674 22.201 10.5573 22.1276 8.53447 21.3803C6.51168 20.633 4.78465 19.2518 3.61096 17.4428C2.43727 15.6338 1.87979 13.4938 2.02168 11.342C2.16356 9.19029 2.99721 7.14205 4.39828 5.5028C5.79935 3.86354 7.69279 2.72111 9.79619 2.24587C11.8996 1.77063 14.1003 1.98806 16.07 2.86572" stroke="#409FDB" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            <path d="M22 4L12 14.01L9 11.01" stroke="#409FDB" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
          </svg>
        </div>
        <h3 class="popup-title">Welcome back!</h3>
        <p class="popup-message">{{ message }}</p>
        <button class="popup-button" @click="$emit('close')">Continue</button>
      </div>
    </div>
  </transition>
</template>

<script>
export default {
  name: 'SuccessPopup',
  props: {
    message: {
      type: String,
      required: true
    }
  }
};
</script>

<style scoped>
.popup-overlay {
  position: fixed;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background-color: rgba(0, 0, 0, 0.5);
  display: flex;
  justify-content: center;
  align-items: center;
  z-index: 1000;
}

.popup-content {
  background-color: white;
  border-radius: 10px;
  padding: 2rem;
  max-width: 400px;
  width: 90%;
  text-align: center;
  box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
  animation: popup-appear 0.3s ease-out;
}

.popup-icon {
  margin: 0 auto 1.5rem;
  width: 60px;
  height: 60px;
  background-color: rgba(64, 159, 219, 0.1);
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
}

.popup-title {
  color: #333;
  font-size: 1.5rem;
  margin-bottom: 0.75rem;
}

.popup-message {
  color: #666;
  margin-bottom: 1.5rem;
  line-height: 1.5;
}

.popup-button {
  background: #409FDB;
  color: white;
  border: none;
  border-radius: 5px;
  padding: 0.75rem 2rem;
  font-size: 1rem;
  cursor: pointer;
  transition: background-color 0.2s, transform 0.2s;
}

.popup-button:hover {
  background: #368BD1;
  transform: translateY(-2px);
}

.fade-enter-active, .fade-leave-active {
  transition: opacity 0.3s;
}

.fade-enter, .fade-leave-to {
  opacity: 0;
}

@keyframes popup-appear {
  from {
    opacity: 0;
    transform: scale(0.9);
  }
  to {
    opacity: 1;
    transform: scale(1);
  }
}
</style>