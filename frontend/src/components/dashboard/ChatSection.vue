// ChatSection.vue
<template>
  <section class="section chat-section">
    <h2 class="section-title">Chat</h2>
    <div class="chat-container">
      <div class="chat-messages">
        <div v-if="loading" class="loading-messages">Loading messages...</div>
        <div v-else-if="error" class="error-messages">{{ error }}</div>
        <div v-else-if="messages.length === 0" class="no-messages">No messages yet.</div>
        <div v-else v-for="(message, index) in messages" :key="index" class="chat-message">
          <div class="chat-avatar"></div>
          <div class="message-content">
            <div class="message-header">
              <span class="message-sender">{{ message.sender }}</span>
              <span class="message-time">{{ formatTime(message.timestamp) }}</span>
            </div>
            <div class="message-text">{{ message.text || message.message }}</div>
          </div>
        </div>
      </div>
      <div class="chat-input-container">
        <input
          type="text"
          class="chat-input"
          placeholder="Type a message..."
          :value="newMessage"
          @input="$emit('update:newMessage', $event.target.value)"
          @keyup.enter="$emit('send-message')"
        />
        <button 
          class="send-button" 
          @click="$emit('send-message')" 
          :disabled="isSending"
        >
          {{ isSending ? 'Sending...' : 'Send' }}
        </button>
      </div>
    </div>
  </section>
</template>

<script>
export default {
  name: 'ChatSection',
  props: {
    messages: {
      type: Array,
      required: true
    },
    loading: {
      type: Boolean,
      default: false
    },
    error: {
      type: String,
      default: null
    },
    isSending: {
      type: Boolean,
      default: false
    },
    newMessage: {
      type: String,
      required: true
    }
  },
  methods: {
    formatTime(timestamp) {
      return this.$emit('format-time', timestamp);
    }
  }
}
</script>

<style scoped>
.chat-section {
  grid-column: 1;
  grid-row: 1;
}

.section {
  background-color: white;
  border-radius: 15px;
  padding: 1.5rem;
  box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
}
 
.section-title {
  font-size: 1.5rem;
  font-weight: 600;
  margin-bottom: 1rem;
}
 
.chat-container {
  display: flex;
  flex-direction: column;
  height: 300px;
}
 
.chat-messages {
  flex: 1;
  overflow-y: auto;
  margin-bottom: 1rem;
  padding: 0.5rem;
}
 
.chat-message {
  display: flex;
  margin-bottom: 1rem;
}
 
.chat-avatar {
  width: 36px;
  height: 36px;
  border-radius: 50%;
  background-color: #e0e0e0;
  margin-right: 0.75rem;
  flex-shrink: 0;
}
 
.message-content {
  flex: 1;
}
 
.message-header {
  display: flex;
  justify-content: space-between;
  margin-bottom: 0.25rem;
}
 
.message-sender {
  font-weight: 500;
  color: #333;
}
 
.message-time {
  font-size: 0.75rem;
  color: #999;
}
 
.message-text {
  color: #444;
  line-height: 1.4;
}
 
.chat-input-container {
  display: flex;
  gap: 0.5rem;
}
 
.chat-input {
  flex: 1;
  padding: 0.75rem;
  border: 1px solid #e0e0e0;
  border-radius: 10px;
  font-size: 0.9rem;
}
 
.send-button {
  padding: 0.75rem 1rem;
  background-color: #4a90e2;
  color: white;
  border: none;
  border-radius: 10px;
  cursor: pointer;
  font-weight: 500;
  transition: background-color 0.2s, transform 0.2s;
}

.send-button:hover:not(:disabled) {
  background-color: #3a7bc8;
  transform: translateY(-2px);
}
 
.send-button:disabled {
  background-color: #9fc4ee;
  cursor: not-allowed;
}

.loading-messages, .error-messages, .no-messages {
  text-align: center;
  padding: 1rem;
  color: #666;
}
 
.error-messages {
  color: #e53935;
}

@media (max-width: 1200px) {
  .chat-section {
    grid-column: 1;
    grid-row: 1;
  }
}

@media (max-width: 480px) {
  .section {
    padding: 1rem;
    margin-bottom: 1rem;
  }
  
  .section-title {
    font-size: 1.2rem;
    margin-bottom: 0.75rem;
  }
  
  .chat-avatar {
    width: 30px;
    height: 30px;
  }
  
  .chat-input-container {
    gap: 0.25rem;
  }
  
  .chat-input {
    padding: 0.5rem;
  }
  
  .send-button {
    padding: 0.5rem 0.75rem;
    font-size: 0.9rem;
  }
}
</style>