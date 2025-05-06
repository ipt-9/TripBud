// DashboardPage.vue
<template>
  <AuthenticatedLayout activePage="dashboard">
    <!-- Custom header for Dashboard -->
    <template #header>
      <header class="dashboard-header">
        <div class="logo-container">
          <img :src="logoSrc" class="logo" alt="TripBud Logo" />
          <h1>Dashboard</h1>
        </div>
        <img 
          :src="profileSrc" 
          class="settings-icon" 
          @click="openSettings" 
          alt="Settings" 
        />
      </header>
    </template>
    
    <!-- Dashboard content -->
    <div class="dashboard-content">
      <ChatSection 
        :messages="messages" 
        :loading="loading"
        :error="error"
        :isSending="isSending"
        :newMessage="newMessage"
        @update:newMessage="newMessage = $event"
        @send-message="sendMessage"
        @format-time="formatMessageTime"
      />
      <CalendarSection />
      <FavoritesSection />
      <BudgetSection 
        :activeTab="activeTab"
        :activeDateTab="activeDateTab"
        @set-active-tab="setActiveTab"
        @set-active-date-tab="setActiveDateTab"
      />
    </div>
  </AuthenticatedLayout>
</template>
  
<script>
import axios from 'axios';
import AuthenticatedLayout from '@/components/layout/AuthenticatedLayout.vue';
import ChatSection from '@/components/dashboard/ChatSection.vue';
import CalendarSection from '@/components/dashboard/CalendarSection.vue';
import FavoritesSection from '@/components/dashboard/FavoritesSection.vue';
import BudgetSection from '@/components/dashboard/BudgetSection.vue';
import logoImg from '@/assets/TripBudLogo.png';
import profileImg from '@/assets/default.png';

export default {
  name: 'DashboardPage',
  components: {
    AuthenticatedLayout,
    ChatSection,
    CalendarSection,
    FavoritesSection,
    BudgetSection
  },
  data() {
    return {
      logoSrc: logoImg,
      profileSrc: profileImg,
      activeTab: 'day',
      activeDateTab: 'today',
      
      messages: [],
      newMessage: '',
      loading: false,
      error: null,
      isSending: false,

      apiUrl: 'https://api.tripbud-bmsd22a.bbzwinf.ch/api/messages',
      bearerToken: null,
      userId: null,
      
      pollInterval: null
    }
  },
  created() {
    this.bearerToken = localStorage.getItem('bearerToken');
    this.userId = localStorage.getItem('userId') || '3';
  },
  mounted() {
    this.fetchMessages();
   
    this.pollInterval = setInterval(() => {
      this.fetchMessages();
    }, 30000);
  },
  beforeUnmount() {
    clearInterval(this.pollInterval);
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
        text: messageText.trim(),
        user_id: this.userId,
        sender: 'You',
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

        const response = await axios.post(this.apiUrl, messageData, {
          headers: {
            'Authorization': `Bearer ${this.bearerToken}`,
            'Content-Type': 'application/json'
          }
        });
       
        console.log('Message sent successfully:', response.data);

        this.messages.push(messageData);

        this.newMessage = '';

        this.$nextTick(() => {
          this.scrollToBottom();
        });
        await this.fetchMessages();
      } catch (err) {
        console.error('Error sending message:', err);

        if (err.response && err.response.status === 401) {
          this.error = 'Authentication failed. Please log in again.';
          localStorage.removeItem('bearerToken');
          this.$router.push('/login');
        } else {
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
      const container = document.querySelector('.chat-messages');
      if (container) {
        container.scrollTop = container.scrollHeight;
      }
    },
   
    setActiveTab(tab) {
      this.activeTab = tab;
    },
    
    setActiveDateTab(tab) {
      this.activeDateTab = tab;
    },
    
    openSettings() {
      this.$router.push('/settings');
    }
  }
}
</script>
  
<style scoped>
.dashboard-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 1rem;
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
 
.settings-icon {
  width: 40px;
  height: 40px;
  border-radius: 50%;
  cursor: pointer;
  transition: transform 0.2s ease;
}

.settings-icon:hover {
  transform: scale(1.05);
}

.dashboard-content {
  display: grid;
  grid-template-columns: repeat(2, 1fr);
  gap: 1.5rem;
  grid-auto-rows: min-content;
}

@media (max-width: 1200px) {
  .dashboard-content {
    grid-template-columns: 1fr;
  }
}

@media (max-width: 768px) {
  .dashboard-header {
    padding: 0.75rem;
  }
  
  h1 {
    font-size: 1.2rem;
  }
  
  .logo {
    width: 40px;
  }
  
  .settings-icon {
    width: 35px;
    height: 35px;
  }
}

@media (max-width: 320px) {
  .dashboard-header {
    flex-direction: column;
    align-items: flex-start;
    gap: 0.5rem;
  }
  
  .settings-icon {
    position: absolute;
    top: 1rem;
    right: 1rem;
  }
}
</style>