// AppNavigation.vue
<template>
  <div class="app-navigation">
    <!-- Desktop Sidebar -->
    <nav class="sidebar desktop-sidebar">
      <div 
        v-for="(item, index) in menuItems" 
        :key="index"
        class="sidebar-item" 
        :class="{ active: activePage === item.route }" 
        @click="navigateTo(item.route)"
      >
        <img :src="item.icon" class="sidebar-icons" :alt="item.label" />
      </div>
    </nav>
    
    <!-- Mobile Bottom Navigation Bar -->
    <div class="bottom-nav">
      <div 
        v-for="(item, index) in menuItems" 
        :key="index"
        class="bottom-nav-item" 
        :class="{ active: activePage === item.route }" 
        @click="navigateTo(item.route)"
      >
        <img :src="item.icon" class="bottom-nav-icon" :alt="item.label" />
      </div>
    </div>
  </div>
</template>

<script>
// Import icons directly - use relative paths if needed
import dashboardIcon from '../../assets/dashboard-symbol.png';
import chatIcon from '../../assets/chat-symbol.png';
import documentsIcon from '../../assets/document-symbol2.png';
import scheduleIcon from '../../assets/schedule-symbol.png';
import walletIcon from '../../assets/wallet-symbol.png';
import blogIcon from '../../assets/blog-symbol.png';

export default {
  name: 'AppNavigation',
  props: {
    activePage: {
      type: String,
      required: true
    }
  },
  data() {
    return {
      menuItems: [
        { route: 'dashboard', icon: dashboardIcon, label: 'Dashboard' },
        { route: 'chat', icon: chatIcon, label: 'Chat' },
        { route: 'documents', icon: documentsIcon, label: 'Documents' },
        { route: 'schedule', icon: scheduleIcon, label: 'Schedule' },
        { route: 'budgetplaner', icon: walletIcon, label: 'Budget Planner' },
        { route: 'travelblog', icon: blogIcon, label: 'Travel Blog' }
      ]
    };
  },
  methods: {
    navigateTo(route) {
      if (this.activePage !== route) {
        this.$router.push('/' + route);
      }
    }
  }
}
</script>

<style scoped>
/* Desktop Sidebar */
.desktop-sidebar {
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
  position: sticky;
  top: 1rem;
  align-self: flex-start;
}

/* Bottom Navigation Bar for mobile */
.bottom-nav {
  display: none; /* Hidden by default on desktop */
  position: fixed;
  bottom: 0;
  left: 0;
  right: 0;
  height: 60px;
  background-color: white;
  box-shadow: 0 -2px 10px rgba(0, 0, 0, 0.1);
  border-top: 1px solid #eaeaea;
  z-index: 1000;
  padding: 0.5rem 1rem;
  justify-content: space-around;
  align-items: center;
}

.bottom-nav-item {
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  cursor: pointer;
  height: 100%;
  flex: 1;
}

.bottom-nav-icon {
  width: 24px;
  height: 24px;
  transition: all 0.3s ease;
  filter: grayscale(100%) opacity(0.4);
}

.bottom-nav-item.active .bottom-nav-icon {
  filter: none;
  transform: scale(1.2);
}

/* Common sidebar item styles */
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

@media (max-width: 768px) {
  /* Hide desktop sidebar on mobile */
  .desktop-sidebar {
    display: none;
  }
  
  /* Show mobile sidebar */
  .bottom-nav {
    display: flex;
  }
}
</style>