<!-- Dashboard.vue (Updated) -->
<template>
  <div class="dashboard-container">
    <header class="header">
      <header class="header">
      <div class="logo-container">
        <img v-for="img in images" :src="img" class="logo" />
        <h1>Dashboard</h1>
      </div>
      <img :src="accountImages" class="settings-icon" @click="openSettings" />
    </header>
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
     
      <div class="content-container">
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
                    <span class="message-time">{{ formatMessageTime(message.timestamp) }}</span>
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
                v-model="newMessage"
                @keyup.enter="sendMessage"
              />
              <button class="send-button" @click="sendMessage" :disabled="isSending">
                {{ isSending ? 'Sending...' : 'Send' }}
              </button>
            </div>
          </div>
        </section>

        <section class="section calendar-section">
          <h2 class="section-title">Calendar</h2>
          <div class="calendar-header">
            <div class="calendar-month">
              <span>Feb 2025</span>
              <button class="dropdown-arrow">▼</button>
            </div>
            <div class="calendar-nav">
              <button class="prev-month">◀</button>
              <button class="next-month">▶</button>
            </div>
          </div>
          <div class="calendar">
            <div class="calendar-weekdays">
              <div class="weekday">S</div>
              <div class="weekday">M</div>
              <div class="weekday">T</div>
              <div class="weekday">W</div>
              <div class="weekday">T</div>
              <div class="weekday">F</div>
              <div class="weekday">S</div>
            </div>
            <div class="calendar-days">
              <div class="day">1</div>
              <div class="day">2</div>
              <div class="day">3</div>
              <div class="day">4</div>
              <div class="day">5</div>
              <div class="day">6</div>
              <div class="day">7</div>
              <div class="day">8</div>
              <div class="day inactive">9</div>
              <div class="day inactive">10</div>
              <div class="day inactive">11</div>
              <div class="day inactive">12</div>
              <div class="day inactive">13</div>
              <div class="day">14</div>
              <div class="day">15</div>
              <div class="day current">16</div>
              <div class="day">17</div>
              <div class="day">18</div>
              <div class="day highlight">19</div>
              <div class="day">20</div>
              <div class="day">21</div>
              <div class="day">22</div>
              <div class="day">23</div>
              <div class="day selected">24</div>
              <div class="day selected">25</div>
              <div class="day selected">26</div>
              <div class="day selected">27</div>
              <div class="day selected">28</div>
              <div class="day">29</div>
              <div class="day">30</div>
              <div class="day">31</div>
              <div class="day next-month">1</div>
              <div class="day next-month">2</div>
              <div class="day next-month">3</div>
              <div class="day next-month">4</div>
            </div>
          </div>
        </section>
 
        <section class="section favourites-section">
          <h2 class="section-title">Favourites</h2>
          <div class="favourites-list">
            <div class="favourites-header">
              <div class="fav-col name-col">Name</div>
              <div class="fav-col size-col">Size</div>
              <div class="fav-col owner-col">Owner</div>
            </div>
            <div class="favourites-items">
              <div class="fav-item">
                <div class="fav-col name-col">
                  <div class="fav-icon doc-icon"></div>
                  <span class="fav-name">Trip Florence</span>
                  <button class="fav-heart active">❤</button>
                </div>
                <div class="fav-col size-col">532 MB</div>
                <div class="fav-col owner-col">Piravinth Mylvaganam</div>
              </div>
              <div class="fav-item">
                <div class="fav-col name-col">
                  <div class="fav-icon img-icon"></div>
                  <span class="fav-name">Travel ticket</span>
                  <button class="fav-heart active">❤</button>
                </div>
                <div class="fav-col size-col">22 MB</div>
                <div class="fav-col owner-col">Piravinth Mylvaganam</div>
              </div>
              <div class="fav-item">
                <div class="fav-col name-col">
                  <div class="fav-icon img-icon"></div>
                  <span class="fav-name">Plane ticket</span>
                  <button class="fav-heart active">❤</button>
                </div>
                <div class="fav-col size-col">175 MB</div>
                <div class="fav-col owner-col">Sandro Sliskovic</div>
              </div>
            </div>
          </div>
        </section>

        <section class="section budget-section">
          <h2 class="section-title">Budget</h2>
          <div class="budget-tabs">
            <button class="budget-tab active" @click="setActiveTab('day')">Day</button>
            <button class="budget-tab" @click="setActiveTab('month')">Month</button>
            <button class="budget-tab" @click="setActiveTab('year')">Year</button>
          </div>
          <div class="budget-days">
            <div class="day-tab" @click="setActiveDateTab('01.02')">01.02</div>
            <div class="day-tab" @click="setActiveDateTab('02.02')">02.02</div>
            <div class="day-tab" @click="setActiveDateTab('03.02')">03.02</div>
            <div class="day-tab active" @click="setActiveDateTab('today')">Today</div>
          </div>
          <div class="budget-cards">
            <div class="budget-card purple">
              <div class="budget-icon hotel-icon"></div>
              <div class="budget-amount">
                <div class="amount-main">470 CHF</div>
                <div class="amount-diff">- 130 CHF</div>
              </div>
            </div>
            <div class="budget-card pink">
              <div class="budget-icon building-icon"></div>
              <div class="budget-amount">
                <div class="amount-main">480 CHF</div>
                <div class="amount-diff">- 120 CHF</div>
              </div>
            </div>
            <div class="budget-card teal">
              <div class="budget-icon transport-icon"></div>
              <div class="budget-amount">
                <div class="amount-main">170 CHF</div>
                <div class="amount-diff">- 30 CHF</div>
              </div>
            </div>
            <div class="budget-card yellow">
              <div class="budget-icon entertainment-icon"></div>
              <div class="budget-amount">
                <div class="amount-main">250 CHF</div>
                <div class="amount-diff">- 50 CHF</div>
              </div>
            </div>
          </div>
        </section>
      </div>
    </div>
  </div>
</template>
 
<script>
import axios from 'axios';
 
export default {
  name: 'Dashboard',
  data() {
    return {
      activeTab: 'day',
      activeDateTab: 'today',
      activePage: 'dashboard',
      showDropdown: false,

      images: ['src/assets/TripBudLogo.png'],
      accountImages: ['src/assets/default.png'],
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
      userId: null
    }
  },
  created() {
    this.bearerToken = localStorage.getItem('bearerToken');
    this.userId = localStorage.getItem('userId') || '3';
   
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
   
    navigate(page) {
      this.activePage = page;
      this.$router.push('/' + page);
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
   
    handleOutsideClick(event) {
      const profileIcon = document.querySelector('.profile-icon');
      if (profileIcon && !profileIcon.contains(event.target) && this.showDropdown) {
        this.showDropdown = false;
      }
    },
   
    logout() {
      localStorage.removeItem('bearerToken');
      localStorage.removeItem('userId');
      this.$router.push('/login');
    },

    setActiveTab(tab) {
      this.activeTab = tab;
    },
    setActiveDateTab(tab) {
      this.activeDateTab = tab;
    },
    toggleDropdown() {
      this.showDropdown = !this.showDropdown;
    },
    openSettings() {
      this.$router.push('/settings');
    }
  }
}
</script>
 
<style>
* {
  font-family: 'Outfit', sans-serif;
}

.dashboard-container {
  display: flex;
  flex-direction: column;
  background: linear-gradient(to bottom, #e0f2fe, #ffffff);
  background-image: url('~@/assets/lines.png');
  background-size: cover;
}
 
.header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 1%;
  margin-bottom: 1%;
}
 
.logo {
  width: 50px;
  margin-right: 15px;
}
 
.dashboard-title {
  margin-bottom: 10px;
}
 
.settings-icon {
  width: 40px;
  height: 40px;
  border-radius: 50%;
  background-color: #333;
  position: relative;
  cursor: pointer;
}
 
.dropdown-menu {
  position: absolute;
  top: 50px;
  right: 0;
  background-color: white;
  border-radius: 10px;
  box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
  padding: 0.75rem;
  z-index: 10;
  min-width: 150px;
}
 
.dropdown-item {
  display: flex;
  align-items: center;
  padding: 0.5rem;
  border-radius: 6px;
  cursor: pointer;
}
 
.dropdown-item:hover {
  background-color: #f5f5f5;
}
 
.main-layout {
  display: flex;
  flex: 1;
  padding: 0 2rem 2rem;
  gap: 2rem;
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

.content-container {
  flex: 1;
  display: grid;
  grid-template-columns: repeat(2, 1fr);
  gap: 1.5rem;
  grid-auto-rows: min-content;
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

.chat-section {
  grid-column: 1;
  grid-row: 1;
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

.calendar-section {
  grid-column: 1;
  grid-row: 2;
}
 
.calendar-header {
  display: flex;
  justify-content: space-between;
  margin-bottom: 1.5rem;
}
 
.calendar-month {
  display: flex;
  align-items: center;
  font-weight: 500;
}
 
.dropdown-arrow {
  background: none;
  border: none;
  cursor: pointer;
  margin-left: 0.5rem;
  font-size: 0.7rem;
  color: #777;
}
 
.calendar-nav {
  display: flex;
  gap: 0.5rem;
}
 
.prev-month, .next-month {
  width: 24px;
  height: 24px;
  border-radius: 50%;
  border: 1px solid #eee;
  background: none;
  display: flex;
  align-items: center;
  justify-content: center;
  cursor: pointer;
  font-size: 0.7rem;
  color: #777;
}
 
.calendar-weekdays {
  display: grid;
  grid-template-columns: repeat(7, 1fr);
  text-align: center;
  margin-bottom: 0.75rem;
}
 
.weekday {
  padding: 0.5rem;
  font-weight: 500;
  color: #777;
}
 
.calendar-days {
  display: grid;
  grid-template-columns: repeat(7, 1fr);
  gap: 0.25rem;
  text-align: center;
}
 
.day {
  padding: 0.5rem;
  border-radius: 50%;
  cursor: pointer;
  width: 30px;
  height: 30px;
  display: flex;
  align-items: center;
  justify-content: center;
  margin: 0 auto;
  transition: background-color 0.2s;
  font-size: 0.9rem;
}
 
.day:hover {
  background-color: #f0f0f0;
}
 
.day.inactive {
  color: #ccc;
}
 
.day.next-month {
  color: #ccc;
}
 
.day.current {
  border: 1px solid #ddd;
}
 
.day.selected {
  background-color: #e0e8ff;
  color: #4a90e2;
}
 
.day.highlight {
  background-color: #81d4fa;
  color: white;
}

.favourites-section {
  grid-column: 2;
  grid-row: 1;
}
 
.favourites-header {
  display: flex;
  border-bottom: 1px solid #f0f0f0;
  padding-bottom: 0.75rem;
  margin-bottom: 0.75rem;
  font-weight: 500;
  color: #777;
}
 
.favourites-items {
  display: flex;
  flex-direction: column;
}
 
.fav-item {
  display: flex;
  align-items: center;
  padding: 0.75rem 0;
  border-bottom: 1px solid #f9f9f9;
}
 
.name-col {
  display: flex;
  align-items: center;
  flex: 2;
}
 
.size-col {
  flex: 1;
  text-align: center;
  color: #666;
}
 
.owner-col {
  flex: 2;
  text-align: right;
  color: #666;
  font-size: 0.9rem;
}
 
.fav-icon {
  width: 30px;
  height: 30px;
  border-radius: 5px;
  margin-right: 0.75rem;
  display: flex;
  align-items: center;
  justify-content: center;
  background-color: #e5effc;
}
 
.doc-icon {
  background-color: #e3f2fd;
}
 
.img-icon {
  background-color: #e8f5e9;
}
 
.fav-name {
  font-weight: 500;
}
 
.fav-heart {
  background: none;
  border: none;
  cursor: pointer;
  margin-left: 0.75rem;
  color: #ff5252;
  font-size: 0.9rem;
}

.budget-section {
  grid-column: 2;
  grid-row: 2;
}
 
.budget-tabs {
  display: flex;
  gap: 0.5rem;
  margin-bottom: 1.5rem;
}
 
.budget-tab {
  background: none;
  border: none;
  padding: 0.5rem 1rem;
  border-radius: 20px;
  cursor: pointer;
  transition: all 0.2s;
  font-weight: normal;
}
 
.budget-tab:hover {
  background-color: #f5f5f5;
}
 
.budget-tab.active {
  background-color: #f0f0f0;
  font-weight: 500;
}
 
.budget-days {
  display: flex;
  gap: 0.5rem;
  margin-bottom: 1.5rem;
  overflow-x: auto;
  padding-bottom: 0.5rem;
}
 
.day-tab {
  padding: 0.5rem 1rem;
  border-radius: 20px;
  background-color: #f0f0f0;
  cursor: pointer;
  white-space: nowrap;
  transition: all 0.2s;
}
 
.day-tab:hover {
  background-color: #e5e5e5;
}
 
.day-tab.active {
  background-color: #333;
  color: white;
}
 
.budget-cards {
  display: grid;
  grid-template-columns: repeat(2, 1fr);
  gap: 1rem;
}
 
.budget-card {
  border-radius: 15px;
  padding: 1rem;
  display: flex;
  align-items: center;
}
 
.budget-card.purple {
  background-color: #f3e5f5;
}
 
.budget-card.pink {
  background-color: #ffebee;
}
 
.budget-card.teal {
  background-color: #e0f2f1;
}
 
.budget-card.yellow {
  background-color: #fff8e1;
}
 
.budget-icon {
  width: 32px;
  height: 32px;
  border-radius: 8px;
  margin-right: 1rem;
  background-color: white;
}
 
.budget-amount {
  flex: 1;
}
 
.amount-main {
  font-weight: 600;
  font-size: 1.1rem;
}
 
.amount-diff {
  color: #ff5252;
  font-size: 0.9rem;
}

@media (max-width: 1200px) {
  .content-container {
    grid-template-columns: 1fr;
  }
 
  .chat-section, .calendar-section, .favourites-section, .budget-section {
    grid-column: 1;
  }
 
  .chat-section {
    grid-row: 1;
  }
 
  .calendar-section {
    grid-row: 2;
  }
 
  .favourites-section {
    grid-row: 3;
  }
 
  .budget-section {
    grid-row: 4;
  }
}
 
@media (max-width: 768px) {
  .main-layout {
    padding: 0 1rem 1rem;
    flex-direction: column;
  }
 
  .sidebar {
    width: 100%;
    flex-direction: row;
    padding: 1rem;
    justify-content: space-between;
    margin-bottom: 1rem;
  }
 
  .header {
    padding: 1rem;
  }
 
  .dashboard-title {
    font-size: 1.5rem;
  }
 
  .budget-cards {
    grid-template-columns: 1fr;
  }
}
 
@media (max-width: 480px) {
  .calendar-days {
    grid-template-columns: repeat(7, 1fr);
    gap: 0.1rem;
  }
 
  .day {
    width: 25px;
    height: 25px;
    font-size: 0.8rem;
  }
 
  .favourites-header, .fav-item {
    font-size: 0.9rem;
  }
 
  .size-col {
    display: none;
  }
 
  .name-col {
    flex: 1;
  }
 
  .owner-col {
    flex: 1;
  }
 
  .budget-tabs, .budget-days {
    flex-wrap: wrap;
  }
}
</style>