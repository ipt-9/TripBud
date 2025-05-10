<template>
  <div class="chat-page-container">
    <header class="header">
      <div class="logo-container">
        <img v-for="img in images" :key="img" :src="img" class="logo" />
        <h1>Chat</h1>
      </div>
      <img :src="accountImages" class="settings-icon" @click="openSettings" />
    </header>
   
    <div class="main-layout">
      <nav class="sidebar">
        <div class="sidebar-item" :class="{ active: activePage === 'dashboard' }" @click="navigate('dashboard')">
          <img :src="dashboardImages[0]" class="sidebar-icons"/>
        </div>
        <div class="sidebar-item" :class="{ active: activePage === 'chat' }" @click="navigate('chat')">
          <img :src="chatImages[0]" class="sidebar-icons"/>
        </div>
        <div class="sidebar-item" :class="{ active: activePage === 'documents' }" @click="navigate('documents')">
          <img :src="documentsImages[0]" class="sidebar-icons"/>
        </div>
        <div class="sidebar-item" :class="{ active: activePage === 'schedule' }" @click="navigate('schedule')">
          <img :src="scheduleImages[0]" class="sidebar-icons"/>
        </div>
        <div class="sidebar-item" :class="{ active: activePage === 'budgetplaner' }" @click="navigate('budgetplaner')">
          <img :src="budgetplanerImages[0]" class="sidebar-icons"/>
        </div>
        <div class="sidebar-item" :class="{ active: activePage === 'blog' }" @click="navigate('travelblog')">
          <img :src="blogImages[0]" class="sidebar-icons"/>
        </div>
      </nav>
      
      <div class="main-chat-container">
        <div class="chat-header">
          <div class="chat-info">
            <h2 class="chat-title">TripBud Group Chat</h2>
            <p class="chat-subtitle">Group - Everyone</p>
          </div>
          <div class="chat-actions">
            <button class="action-btn call-btn">
              <i class="call-icon"></i>
            </button>
            <button class="action-btn video-btn">
              <i class="video-icon"></i>
            </button>
            <button class="action-btn more-btn">
              <i class="more-icon"></i>
            </button>
          </div>
        </div>
        
        <div class="chat-content">
          <div class="messages-container" ref="messagesContainer">
            <div v-if="loading" class="loading-messages">
              <div class="loading-spinner"></div>
              <p>Loading messages...</p>
            </div>
            <div v-else-if="error" class="error-messages">
              <p>{{ error }}</p>
              <button @click="fetchMessages" class="retry-btn">Retry</button>
            </div>
            <div v-else-if="messages.length === 0" class="no-messages">
              <p>No messages yet. Be the first to say hello!</p>
            </div>
            <template v-else>
              <div v-for="(message, index) in messages" 
                  :key="message.id || index" 
                  class="message-item" 
                  :class="{ 'my-message': isCurrentUser(message) }">
                <div class="message-avatar" v-if="!isCurrentUser(message)">
                  <div class="avatar-placeholder"></div>
                </div>
                <div class="message-content">
                  <div class="message-header">
                    <span class="message-sender">{{ getUserUsername(message) }}</span>
                    <span class="message-time">{{ formatMessageTime(message.created_at || message.timestamp) }}</span>
                  </div>
                  <div class="message-bubble">
                    <p>{{ message.message }}</p>
                  </div>
                </div>
              </div>
            </template>
          </div>
          
          <div class="message-input-area">
            <button class="attach-btn">
              <i class="attach-icon"></i>
            </button>
            <div class="input-wrapper">
              <input 
                type="text" 
                v-model="newMessage" 
                placeholder="Type your message here..." 
                @keyup.enter="sendMessage"
                :disabled="isSending"
              />
              <div class="input-actions">
                <button class="emoji-btn">
                  <i class="emoji-icon"></i>
                </button>
                <button class="media-btn">
                  <i class="media-icon"></i>
                </button>
              </div>
            </div>
            <button class="send-btn" @click="sendMessage" :disabled="isSending || !newMessage.trim()">
              <i class="send-icon"></i>
              <span v-if="isSending" class="sending-indicator"></span>
            </button>
          </div>
        </div>
      </div>
    </div>
    
    <nav class="mobile-nav">
      <div class="mobile-nav-item" :class="{ active: activePage === 'dashboard' }" @click="navigate('dashboard')">
        <img :src="dashboardImages[0]" class="mobile-nav-icon"/>
      </div>
      <div class="mobile-nav-item" :class="{ active: activePage === 'chat' }" @click="navigate('chat')">
        <img :src="chatImages[0]" class="mobile-nav-icon"/>
      </div>
      <div class="mobile-nav-item" :class="{ active: activePage === 'documents' }" @click="navigate('documents')">
        <img :src="documentsImages[0]" class="mobile-nav-icon"/>
      </div>
      <div class="mobile-nav-item" :class="{ active: activePage === 'schedule' }" @click="navigate('schedule')">
        <img :src="scheduleImages[0]" class="mobile-nav-icon"/>
      </div>
      <div class="mobile-nav-item" :class="{ active: activePage === 'budgetplaner' }" @click="navigate('budgetplaner')">
        <img :src="budgetplanerImages[0]" class="mobile-nav-icon"/>
      </div>
      <div class="mobile-nav-item" :class="{ active: activePage === 'blog' }" @click="navigate('travelblog')">
        <img :src="blogImages[0]" class="mobile-nav-icon"/>
      </div>
    </nav>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  name: 'ChatPage',
  data() {
    return {
      activePage: 'chat',
      showDropdown: false,
      unfollow: true,
      
      images: ['src/assets/TripBudLogo.png'],
      accountImages: 'src/assets/default.png',
      dashboardImages: ['src/assets/dashboard-symbol.png'],
      chatImages: ['src/assets/chat-symbol.png'],
      documentsImages: ['src/assets/document-symbol2.png'],
      scheduleImages: ['src/assets/schedule-symbol.png'],
      budgetplanerImages: ['src/assets/wallet-symbol.png'],
      blogImages: ['src/assets/blog-symbol.png'],

      messages: [],
      newMessage: '',
      loading: false,
      error: null,
      isSending: false,

      apiUrl: 'https://api.tripbud-bmsd22a.bbzwinf.ch/api/messages',
      bearerToken: null,
      userId: null,
      currentUsername: 'You'
    };
  },
  created() {
    this.bearerToken = localStorage.getItem('bearerToken');
    this.userId = localStorage.getItem('userId') || '3';
    this.currentUsername = localStorage.getItem('userUsername') || 'You';
    
    if (!this.bearerToken) {
      console.warn('No bearer token found. Redirecting to login...');
      this.$router.push('/login');
    }
  },
  mounted() {
    this.fetchMessages();
    
    this.pollInterval = setInterval(() => {
      this.fetchMessages();
    }, 30000);

    document.addEventListener('click', this.handleOutsideClick);
  },
  beforeUnmount() {
    clearInterval(this.pollInterval);
    document.removeEventListener('click', this.handleOutsideClick);
  },
  methods: {
    async fetchMessages() {
      if (!this.bearerToken) {
        this.error = 'Authentication token missing. Please log in again.';
        return;
      }
      
      this.loading = true;
      this.error = null;
      
      try {
        const response = await axios.get(this.apiUrl, {
          headers: {
            'Authorization': `Bearer ${this.bearerToken}`,
            'Accept': 'application/json'
          }
        });

        if (Array.isArray(response.data)) {
          this.messages = response.data;
        } else if (response.data.data && Array.isArray(response.data.data)) {
          this.messages = response.data.data;
        } else {
          console.warn('Unexpected response format:', response.data);
          this.messages = [];
        }

        this.$nextTick(() => {
          this.scrollToBottom();
        });
      } catch (err) {
        console.error('Error fetching messages:', err);
        
        if (err.response) {
          console.error('Response data:', err.response.data);
          console.error('Response status:', err.response.status);
          
          if (err.response.status === 401) {
            this.error = 'Authentication failed. Please log in again.';
            localStorage.removeItem('bearerToken');
            this.$router.push('/login');
          } else {
            this.error = `Failed to load messages: ${err.response.data.message || 'Server error'}`;
          }
        } else if (err.request) {
          this.error = 'No response from server. Please check your connection.';
        } else {
          this.error = `Error setting up request: ${err.message}`;
        }
      } finally {
        this.loading = false;
      }
    },
    
    formatMessageForSending(messageText) {
      return {
        message: messageText.trim(),
        user_id: this.userId,
        timestamp: new Date().toISOString()
      };
    },
    
    async sendMessage() {
      if (!this.newMessage.trim()) return;
      
      if (!this.bearerToken) {
        this.error = 'Authentication token missing. Please log in again.';
        return;
      }
      
      this.isSending = true;
      
      try {
        const messageData = this.formatMessageForSending(this.newMessage);

        const optimisticMessage = {
          ...messageData,
          user: {
            id: this.userId,
            username: this.currentUsername
          },
          created_at: new Date().toISOString()
        };
        
        this.messages.push(optimisticMessage);
        this.newMessage = '';
        this.scrollToBottom();

        const response = await axios.post(this.apiUrl, messageData, {
          headers: {
            'Authorization': `Bearer ${this.bearerToken}`,
            'Content-Type': 'application/json'
          }
        });
        
        console.log('Message sent successfully:', response.data);
  
        await this.fetchMessages();
      } catch (err) {
        console.error('Error sending message:', err);

        if (err.response && err.response.status === 401) {
          this.error = 'Authentication failed. Please log in again.';
          localStorage.removeItem('bearerToken');
          this.$router.push('/login');
        } else {
          this.messages.pop();
          
          if (err.response && err.response.data) {
            alert(`Failed to send message: ${err.response.data.message || JSON.stringify(err.response.data)}`);
          } else {
            alert('Failed to send message. Please try again.');
          }
        }
      } finally {
        this.isSending = false;
      }
    },
    
    getUserUsername(message) {
      if (this.isCurrentUser(message)) {
        return this.currentUsername || 'You';
      }

      if (message.user && message.user.username) {
        return message.user.username;
      }

      if (message.user && message.user.name) {
        return message.user.name;
      }

      if (message.sender) {
        return message.sender;
      }
      return 'Unknown User';
    },
    
    formatMessageTime(timestamp) {
      if (!timestamp) return '';
      
      const date = new Date(timestamp);
      const today = new Date();
      
      if (date.toDateString() === today.toDateString()) {
        return `Today, ${date.getHours()}:${date.getMinutes().toString().padStart(2, '0')}`;
      }
      
      const yesterday = new Date();
      yesterday.setDate(yesterday.getDate() - 1);
      if (date.toDateString() === yesterday.toDateString()) {
        return `Yesterday, ${date.getHours()}:${date.getMinutes().toString().padStart(2, '0')}`;
      }
      
      return `${date.toLocaleDateString()}, ${date.getHours()}:${date.getMinutes().toString().padStart(2, '0')}`;
    },
    
    scrollToBottom() {
      const container = this.$refs.messagesContainer;
      if (container) {
        container.scrollTop = container.scrollHeight;
      }
    },
    
    isCurrentUser(message) {
      return message.user_id == this.userId || 
             (message.user && message.user.id == this.userId);
    },
    
    navigate(page) {
      this.activePage = page;
      this.$router.push('/' + page);
    },
    
    handleOutsideClick(event) {
      const profileIcon = document.querySelector('.profile-icon');
      if (profileIcon && !profileIcon.contains(event.target) && this.showDropdown) {
        this.showDropdown = false;
      }
    },
    
    openSettings() {
      this.$router.push('/settings');
      this.showDropdown = false;
    }
  }
};
</script>

<style>
* {
  font-family: 'Outfit', sans-serif;
  box-sizing: border-box;
  margin: 0;
  padding: 0;
}

.chat-page-container {
  display: flex;
  flex-direction: column;
  height: 100vh;
  background: linear-gradient(to bottom, #e0f2fe, #ffffff);
  background-size: cover;
  padding-bottom: 0;
  position: relative;
  background-image: url('../assets/lines.png');
}

.header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 1%;
  margin-bottom: 1%;
}

.logo-container {
  display: flex;
  align-items: center;
}

.logo {
  width: 50px;
  margin-right: 15px;
}

.user-profile {
  position: relative;
}

.profile-icon {
  width: 40px;
  height: 40px;
  border-radius: 50%;
  cursor: pointer;
  background-color: #e0e0e0;
  object-fit: cover;
}

.main-layout {
  display: flex;
  flex: 1;
  padding: 0 2rem 2rem;
  gap: 2rem;
  overflow: hidden;
}

.sidebar {
  width: 60px;
  background-color: white;
  border-radius: 15px;
  padding: 1.5rem 0;
  display: flex;
  flex-direction: column;
  align-items: center;
  gap: 1.5rem;
  box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
  height: fit-content;
}

.sidebar-item {
  width: 40px;
  height: 40px;
  border-radius: 10px;
  display: flex;
  align-items: center;
  justify-content: center;
  cursor: pointer;
  transition: all 0.3s ease;
}

.sidebar-item:hover {
  background-color: #e0f2fe;
  transform: scale(1.1);
}

.sidebar-icons {
  height: 24px;
  width: 24px;
  transition: all 0.3s ease;
  filter: grayscale(100%) opacity(0.4);
}

.sidebar-item.active {
  background-color: #e0f2fe;
}

.sidebar-item.active .sidebar-icons {
  filter: none;
  transform: scale(1.2);
}

.main-chat-container {
  flex: 1;
  display: flex;
  flex-direction: column;
  background-color: white;
  border-radius: 15px;
  box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
  overflow: hidden;
}

.chat-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 15px 20px;
  border-bottom: 1px solid #f0f0f0;
}

.chat-info {
  display: flex;
  flex-direction: column;
}

.chat-title {
  font-size: 18px;
  font-weight: 600;
  margin: 0;
}

.chat-subtitle {
  font-size: 14px;
  color: #757575;
  margin: 0;
}

.chat-actions {
  display: flex;
  gap: 10px;
}

.action-btn {
  width: 40px;
  height: 40px;
  border-radius: 50%;
  border: none;
  background-color: #f5f5f5;
  cursor: pointer;
  transition: background-color 0.2s;
  display: flex;
  align-items: center;
  justify-content: center;
}

.action-btn:hover {
  background-color: #e0e0e0;
}

.call-icon::before {
  content: "📞";
  font-size: 18px;
}

.video-icon::before {
  content: "📹";
  font-size: 18px;
}

.more-icon::before {
  content: "⋮";
  font-size: 18px;
}

.chat-content {
  flex: 1;
  display: flex;
  flex-direction: column;
  overflow: hidden;
}

.messages-container {
  flex: 1;
  overflow-y: auto;
  padding: 20px;
  display: flex;
  flex-direction: column;
  gap: 15px;
}

.loading-messages, .error-messages, .no-messages {
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  height: 100%;
  color: #757575;
  text-align: center;
  padding: 20px;
}

.loading-spinner {
  width: 30px;
  height: 30px;
  border: 3px solid #f3f3f3;
  border-top: 3px solid #4a90e2;
  border-radius: 50%;
  animation: spin 1s linear infinite;
  margin-bottom: 10px;
}

@keyframes spin {
  0% { transform: rotate(0deg); }
  100% { transform: rotate(360deg); }
}

.retry-btn {
  background-color: #4a90e2;
  color: white;
  border: none;
  border-radius: 5px;
  padding: 8px 15px;
  margin-top: 10px;
  cursor: pointer;
}

.message-item {
  display: flex;
  gap: 10px;
  max-width: 80%;
}

.my-message {
  align-self: flex-end;
  flex-direction: row-reverse;
}

.message-avatar {
  width: 40px;
  height: 40px;
  border-radius: 50%;
  background-color: #e0e0e0;
  overflow: hidden;
}

.avatar-placeholder {
  width: 100%;
  height: 100%;
  background-color: #adb5bd;
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  color: white;
  font-weight: bold;
  font-size: 16px;
}

.message-content {
  display: flex;
  flex-direction: column;
  gap: 5px;
}

.message-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  font-size: 12px;
}

.my-message .message-header {
  flex-direction: row-reverse;
}

.message-sender {
  font-weight: 600;
  color: #424242;
}

.message-time {
  color: #9e9e9e;
}

.message-bubble {
  background-color: #f5f5f5;
  padding: 10px 15px;
  border-radius: 18px;
  border-top-left-radius: 4px;
  box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);
  word-break: break-word;
}

.my-message .message-bubble {
  background-color: #e3f2fd;
  border-top-left-radius: 18px;
  border-top-right-radius: 4px;
}

.message-bubble p {
  margin: 0;
  line-height: 1.4;
}

.unfollow-notification {
  align-self: center;
  display: flex;
  flex-direction: column;
  align-items: center;
  padding: 8px 16px;
  background-color: #f9f9f9;
  border-radius: 20px;
  color: #616161;
  margin: 10px 0;
}

.unfollow-time {
  font-size: 11px;
  color: #9e9e9e;
  margin-top: 3px;
}

.message-input-area {
  display: flex;
  align-items: center;
  padding: 15px;
  border-top: 1px solid #f0f0f0;
  gap: 10px;
}

.attach-btn {
  width: 40px;
  height: 40px;
  border-radius: 50%;
  border: none;
  background-color: #f5f5f5;
  cursor: pointer;
  display: flex;
  align-items: center;
  justify-content: center;
}

.attach-icon::before {
  content: "📎";
  font-size: 18px;
}

.input-wrapper {
  flex: 1;
  position: relative;
  display: flex;
  align-items: center;
  background-color: #f5f5f5;
  border-radius: 20px;
  padding: 0 15px;
}

.input-wrapper input {
  flex: 1;
  padding: 12px 15px;
  border: none;
  background: transparent;
  font-size: 14px;
  outline: none;
}

.input-actions {
  display: flex;
  gap: 5px;
}

.emoji-btn, .media-btn {
  background: none;
  border: none;
  cursor: pointer;
  padding: 5px;
  display: flex;
  align-items: center;
  justify-content: center;
}

.emoji-icon::before {
  content: "😊";
  font-size: 18px;
}

.media-icon::before {
  content: "🖼️";
  font-size: 18px;
}

.send-btn {
  width: 40px;
  height: 40px;
  border-radius: 50%;
  border: none;
  background-color: #4a90e2;
  color: white;
  cursor: pointer;
  display: flex;
  align-items: center;
  justify-content: center;
  position: relative;
}

.send-btn:disabled {
  background-color: #bdbdbd;
  cursor: not-allowed;
}

.send-icon::before {
  content: "➤";
  font-size: 16px;
  transform: rotate(90deg);
  display: inline-block;
}

.sending-indicator {
  position: absolute;
  width: 15px;
  height: 15px;
  border: 2px solid white;
  border-radius: 50%;
  border-top-color: transparent;
  animation: spin 1s linear infinite;
}

.mobile-nav {
  display: none;
  position: fixed;
  bottom: 0;
  left: 0;
  right: 0;
  background-color: white;
  box-shadow: 0 -2px 10px rgba(0, 0, 0, 0.1);
  padding: 10px 16px;
  z-index: 100;
  border-top: 1px solid #edf2f7;
  justify-content: space-between;
}

.mobile-nav-item {
  display: flex;
  flex-direction: column;
  align-items: center;
  padding: 8px 0;
  cursor: pointer;
  transition: all 0.2s;
}

.mobile-nav-icon {
  width: 24px;
  height: 24px;
  margin-bottom: 4px;
  filter: grayscale(100%) opacity(0.4);
  transition: all 0.2s;
}

.mobile-nav-item.active .mobile-nav-icon {
  filter: none;
}

@media (max-width: 768px) {
  .main-layout {
    padding: 0 1rem 1rem;
    padding-bottom: 70px;
  }
  
  .sidebar {
    display: none;
  }
  
  .mobile-nav {
    display: flex;
  }
  
  .message-item {
    max-width: 90%;
  }
  
  .chat-actions {
    gap: 5px;
  }
  
  .action-btn {
    width: 35px;
    height: 35px;
  }
}

@media (max-width: 576px) {
  .main-layout {
    padding: 0 0.5rem 0.5rem;
    padding-bottom: 70px;
  }
  
  .message-avatar {
    width: 30px;
    height: 30px;
  }
  
  .message-item {
    max-width: 100%;
  }
  
  .chat-info {
    max-width: 150px;
  }
  
  .chat-title {
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
  }
  
  .header {
    padding: 16px;
  }
  
  .logo {
    width: 40px;
  }
  h1 {
    font-size: 20px;
  }
  
  .message-input-area {
    padding: 10px;
  }
  
  .input-wrapper input {
    padding: 8px 10px;
  }
  
  .attach-btn, .send-btn {
    width: 36px;
    height: 36px;
  }
}
</style>