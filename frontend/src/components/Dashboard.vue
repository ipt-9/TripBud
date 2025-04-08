<!-- Dashboard.vue -->
<template>
    <div class="dashboard-container">
      <!-- Top Navigation -->
      <header class="header">
        <div class="header-left">
          <button class="back-button">
            <span class="back-icon">←</span>
          </button>
          <div class="logo">
            <div class="logo-icon">
              <img src="" alt="Logo" />
            </div>
            <h1 class="dashboard-title">Dashboard</h1>
          </div>
        </div>
        <div class="header-right">
          <div class="profile-icon">
            <img src="" alt="Profile" />
            <div class="dropdown-menu">
              <div class="dropdown-item">
                <i class="icon-settings"></i>
                <span>Settings</span>
              </div>
              <div class="dropdown-item">
                <i class="icon-logout"></i>
                <span>Logout</span>
              </div>
            </div>
          </div>
        </div>
      </header>
      
      <div class="main-content">
        <!-- Left Sidebar Navigation -->
        <nav class="sidebar">
          <div class="sidebar-menu">
            <div class="sidebar-item active">
              <div class="sidebar-icon stats-icon"></div>
            </div>
            <div class="sidebar-item">
              <div class="sidebar-icon chat-icon"></div>
            </div>
            <div class="sidebar-item">
              <div class="sidebar-icon files-icon"></div>
            </div>
            <div class="sidebar-item">
              <div class="sidebar-icon time-icon"></div>
            </div>
            <div class="sidebar-item">
              <div class="sidebar-icon folder-icon"></div>
            </div>
            <div class="sidebar-item">
              <div class="sidebar-icon profile-icon"></div>
            </div>
          </div>
        </nav>
        
        <!-- Main Content Area -->
        <div class="content">
          <!-- Recent Chats Section -->
          <section class="recent-chats">
            <h2 class="section-title">Recent Chats</h2>
            <div class="people-section">
              <h3 class="subsection-title">People</h3>
              <div class="chat-list">
                <div class="chat-item">
                  <div class="chat-avatar">
                    <img src="" alt="Glenn" />
                  </div>
                  <div class="chat-info">
                    <div class="chat-name">Glenn</div>
                    <div class="chat-dots">...</div>
                  </div>
                  <div class="chat-meta">
                    <div class="chat-time">Today, 9:52pm</div>
                    <div class="chat-badge">1</div>
                  </div>
                </div>
                <div class="chat-item">
                  <div class="chat-avatar">
                    <img src="" alt="Sandro" />
                  </div>
                  <div class="chat-info">
                    <div class="chat-name">Sandro</div>
                    <div class="chat-dots">...</div>
                  </div>
                  <div class="chat-meta">
                    <div class="chat-time">Today, 12:11pm</div>
                    <div class="chat-badge">1</div>
                  </div>
                </div>
              </div>
            </div>
          </section>
          
          <!-- Calendar Section -->
          <section class="calendar-section">
            <h2 class="section-title">Calendar</h2>
            <div class="calendar-header">
              <div class="calendar-month">
                <span>Feb 2025</span>
                <button class="dropdown-arrow">
                  <i class="icon-chevron-down"></i>
                </button>
              </div>
              <div class="calendar-nav">
                <button class="prev-month">
                  <i class="icon-chevron-left"></i>
                </button>
                <button class="next-month">
                  <i class="icon-chevron-right"></i>
                </button>
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
        </div>
        
        <!-- Right Content Area -->
        <div class="right-content">
          <!-- Favourites Section -->
          <section class="favourites-section">
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
                    <button class="fav-heart active"></button>
                  </div>
                  <div class="fav-col size-col">532 MB</div>
                  <div class="fav-col owner-col">Piravinth Mylvaganam</div>
                </div>
                <div class="fav-item">
                  <div class="fav-col name-col">
                    <div class="fav-icon img-icon"></div>
                    <span class="fav-name">Travel ticket</span>
                    <button class="fav-heart active"></button>
                  </div>
                  <div class="fav-col size-col">22 MB</div>
                  <div class="fav-col owner-col">Piravinth Mylvaganam</div>
                </div>
                <div class="fav-item">
                  <div class="fav-col name-col">
                    <div class="fav-icon img-icon"></div>
                    <span class="fav-name">Plane ticket</span>
                    <button class="fav-heart active"></button>
                  </div>
                  <div class="fav-col size-col">175 MB</div>
                  <div class="fav-col owner-col">Sandro Sliskovic</div>
                </div>
              </div>
            </div>
          </section>
          
          <!-- Budget Section -->
          <section class="budget-section">
            <h2 class="section-title">Budget</h2>
            <div class="budget-tabs">
              <button class="budget-tab active">Day</button>
              <button class="budget-tab">Month</button>
              <button class="budget-tab">Year</button>
            </div>
            <div class="budget-days">
              <div class="day-tab">01.02</div>
              <div class="day-tab">02.02</div>
              <div class="day-tab">03.02</div>
              <div class="day-tab active">Today</div>
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
  export default {
    name: 'Dashboard',
    data() {
      return {
        // Data would go here in a real implementation
      }
    },
    methods: {
      // Methods would go here in a real implementation
    }
  }
  </script>
  
  <style scoped>
  .dashboard-container {
    display: flex;
    flex-direction: column;
    min-height: 100vh;
    background-color: #f0f8ff;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
  }
  
  /* Header Styles */
  .header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 1rem 2rem;
    background-color: transparent;
  }
  
  .header-left {
    display: flex;
    align-items: center;
  }
  
  .back-button {
    background: none;
    border: none;
    cursor: pointer;
    margin-right: 1rem;
    font-size: 1.5rem;
  }
  
  .logo {
    display: flex;
    align-items: center;
  }
  
  .logo-icon {
    background-color: #4a90e2;
    width: 40px;
    height: 40px;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-right: 1rem;
  }
  
  .dashboard-title {
    font-size: 1.8rem;
    font-weight: 600;
    margin: 0;
  }
  
  .profile-icon {
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
    padding: 1rem;
    display: none;
  }
  
  .profile-icon:hover .dropdown-menu {
    display: block;
  }
  
  .dropdown-item {
    display: flex;
    align-items: center;
    padding: 0.5rem 0;
  }
  
  /* Main Content Styles */
  .main-content {
    display: flex;
    flex: 1;
    padding: 0 1rem;
  }
  
  /* Sidebar Styles */
  .sidebar {
    width: 60px;
    background-color: white;
    border-radius: 15px;
    padding: 1rem 0;
    margin-right: 1rem;
    display: flex;
    flex-direction: column;
    align-items: center;
  }
  
  .sidebar-menu {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 1rem;
  }
  
  .sidebar-item {
    width: 40px;
    height: 40px;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: background-color 0.3s;
  }
  
  .sidebar-item.active {
    background-color: #edf2f7;
  }
  
  .sidebar-icon {
    width: 24px;
    height: 24px;
    background-color: #ccc;
    /* Replace with actual icons */
  }
  
  /* Content Area Styles */
  .content {
    flex: 1;
    padding: 1rem;
    display: flex;
    flex-direction: column;
    gap: 2rem;
  }
  
  .section-title {
    font-size: 1.5rem;
    font-weight: 600;
    margin-bottom: 1rem;
  }
  
  /* Recent Chats Section */
  .recent-chats {
    background-color: white;
    border-radius: 15px;
    padding: 1.5rem;
  }
  
  .subsection-title {
    font-size: 1.2rem;
    margin-bottom: 1rem;
  }
  
  .chat-list {
    display: flex;
    flex-direction: column;
    gap: 1rem;
  }
  
  .chat-item {
    display: flex;
    align-items: center;
    padding: 0.5rem 0;
    border-bottom: 1px solid #f0f0f0;
  }
  
  .chat-avatar {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    overflow: hidden;
    margin-right: 1rem;
  }
  
  .chat-info {
    flex: 1;
  }
  
  .chat-name {
    font-weight: 500;
  }
  
  .chat-dots {
    color: #999;
  }
  
  .chat-meta {
    text-align: right;
  }
  
  .chat-time {
    font-size: 0.8rem;
    color: #999;
  }
  
  .chat-badge {
    display: inline-block;
    width: 20px;
    height: 20px;
    background-color: #ff5252;
    color: white;
    border-radius: 50%;
    text-align: center;
    line-height: 20px;
    font-size: 0.75rem;
    margin-top: 0.25rem;
  }
  
  /* Calendar Section */
  .calendar-section {
    background-color: white;
    border-radius: 15px;
    padding: 1.5rem;
  }
  
  .calendar-header {
    display: flex;
    justify-content: space-between;
    margin-bottom: 1rem;
  }
  
  .calendar-month {
    display: flex;
    align-items: center;
  }
  
  .calendar-nav {
    display: flex;
    gap: 0.5rem;
  }
  
  .prev-month, .next-month {
    width: 30px;
    height: 30px;
    border-radius: 50%;
    border: 1px solid #eee;
    background: none;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
  }
  
  .calendar-weekdays {
    display: grid;
    grid-template-columns: repeat(7, 1fr);
    text-align: center;
    margin-bottom: 0.5rem;
  }
  
  .weekday {
    padding: 0.5rem;
    font-weight: 500;
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
  }
  
  .day.inactive {
    color: #ccc;
  }
  
  .day.next-month {
    color: #ccc;
  }
  
  .day.current {
    border: 1px solid #ccc;
  }
  
  .day.selected {
    background-color: #e0e8ff;
    color: #4a90e2;
  }
  
  .day.highlight {
    background-color: #81d4fa;
    color: white;
  }
  
  /* Right Content Area */
  .right-content {
    width: 35%;
    padding: 1rem;
    display: flex;
    flex-direction: column;
    gap: 2rem;
  }
  
  /* Favourites Section */
  .favourites-section {
    background-color: white;
    border-radius: 15px;
    padding: 1.5rem;
  }
  
  .favourites-header {
    display: flex;
    border-bottom: 1px solid #f0f0f0;
    padding-bottom: 0.5rem;
    margin-bottom: 1rem;
    font-weight: 500;
  }
  
  .favourites-items {
    display: flex;
    flex-direction: column;
    gap: 1rem;
  }
  
  .fav-item {
    display: flex;
    align-items: center;
    padding: 0.5rem 0;
  }
  
  .name-col {
    display: flex;
    align-items: center;
    flex: 2;
  }
  
  .size-col {
    flex: 1;
    text-align: center;
  }
  
  .owner-col {
    flex: 2;
    text-align: right;
  }
  
  .fav-icon {
    width: 30px;
    height: 30px;
    border-radius: 5px;
    margin-right: 0.5rem;
    /* Replace with actual icons */
  }
  
  .doc-icon {
    background-color: #f0f0f0;
  }
  
  .img-icon {
    background-color: #f0f0f0;
  }
  
  .fav-heart {
    width: 24px;
    height: 24px;
    background: none;
    border: none;
    cursor: pointer;
    margin-left: 0.5rem;
    color: #ccc;
  }
  
  .fav-heart.active {
    color: #ff5252;
  }
  
  /* Budget Section */
  .budget-section {
    background-color: white;
    border-radius: 15px;
    padding: 1.5rem;
  }
  
  .budget-tabs {
    display: flex;
    gap: 1rem;
    margin-bottom: 1rem;
  }
  
  .budget-tab {
    background: none;
    border: none;
    padding: 0.5rem 1rem;
    border-radius: 20px;
    cursor: pointer;
  }
  
  .budget-tab.active {
    background-color: #f0f0f0;
    font-weight: 500;
  }
  
  .budget-days {
    display: flex;
    gap: 0.5rem;
    margin-bottom: 1rem;
  }
  
  .day-tab {
    padding: 0.5rem 1rem;
    border-radius: 20px;
    background-color: #f0f0f0;
    cursor: pointer;
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
    background-color: #f8f9fa;
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
    width: 40px;
    height: 40px;
    border-radius: 10px;
    margin-right: 1rem;
    /* Replace with actual icons */
  }
  
  .hotel-icon, .building-icon, .transport-icon, .entertainment-icon {
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
  
  /* Responsive adjustments would be added here */
  @media (max-width: 1200px) {
    .main-content {
      flex-direction: column;
    }
    
    .right-content {
      width: 100%;
    }
  }
  
  @media (max-width: 768px) {
    .header {
      padding: 1rem;
    }
    
    .dashboard-title {
      font-size: 1.5rem;
    }
    
    .sidebar {
      width: 50px;
    }
    
    .budget-cards {
      grid-template-columns: 1fr;
    }
  }
  </style>