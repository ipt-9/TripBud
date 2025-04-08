<template>
  <div class="setting-container">
    <!-- Background Image Container -->
    <div class="background-image-container"></div>
    
    <header class="header">
      <div class="logo-container">
        <img src="../assets/TripBudLogo.png" class="logo" alt="Logo">
        <span class="logo-text">Settings</span>
      </div>
      <button class="menu-toggle" id="menu-toggle">☰</button>
    </header>
    
    <div class="content-wrapper">
      <!-- Regular Sidebar (Desktop) -->
      <div class="sidebar">
        <div class="search-box">
          <input type="text" placeholder="Search...">
        </div>
        
        <div class="nav-links">
          <a href="#" class="nav-link active">
            <img src="../assets/user.png" alt="User icon">
            <h2>Account</h2>
          </a>
          
          <a href="#" class="nav-link">
            <img src="../assets/shopping-cart.png" alt="Cart icon">
            <h2>Plans</h2>
          </a>
          
          <a href="#" class="nav-link">
            <img src="../assets/info.png" alt="Info icon">
            <h2>Help & Support</h2>
          </a>
        </div>
        
        <div class="sidebar-footer">
          <div class="user-profile-sidebar">
            <img src="../assets/account-symbol.png" class="user-avatar-small" alt="User avatar">
            <div class="user-info">
              <div class="user-name">Piravinth Mylvaganam</div>
              <span class="membership-badge">Premium</span>
            </div>
          </div>
          
          <button class="logout-btn">Log Out</button>
        </div>
      </div>
      
      <!-- Main Content -->
      <div class="main-content">
        <div class="tab-header">
          <a href="#" class="tab-link active">Account</a>
          <a href="#" class="tab-link">Payment</a>
        </div>
        
        <div class="section">
          <div class="profile-header">
            <div class="profile-title">
              <h1 class="section-title">Your Profile</h1>
              <p class="section-subtitle">Update your profile settings here</p>
            </div>
            
            <div class="profile-picture-container">
              <img src="../assets/account-symbol.png" class="profile-picture" alt="Profile picture">
              <div class="button-group">
                <button class="btn btn-primary">Edit</button>
                <button class="btn btn-danger">Delete</button>
              </div>
            </div>
          </div>
        </div>
        
        <div class="form-group">
          <label class="form-label" for="username">Username</label>
          <input type="text" id="username" class="form-control">
        </div>
        
        <div class="form-group">
          <label class="form-label" for="email">E-Mail</label>
          <input type="email" id="email" class="form-control">
        </div>
        
        <div class="form-group password-section">
          <div>
            <label class="form-label" for="current-password">Current Password</label>
            <div class="password-input-wrapper">
              <input type="password" id="current-password" class="form-control password-input">
              <img src="../assets/hide.png" class="toggle-password" alt="Toggle password visibility" @click="togglePasswordVisibility('current-password')">
            </div>
          </div>
          
          <div>
            <label class="form-label" for="new-password">New Password</label>
            <div class="password-input-wrapper">
              <input type="password" id="new-password" class="form-control password-input">
              <img src="../assets/hide.png" class="toggle-password" alt="Toggle password visibility" @click="togglePasswordVisibility('new-password')">
            </div>
          </div>
          
          <div>
            <label class="form-label" for="confirm-password">Confirm Password</label>
            <div class="password-input-wrapper">
              <input type="password" id="confirm-password" class="form-control password-input">
              <img src="../assets/hide.png" class="toggle-password" alt="Toggle password visibility" @click="togglePasswordVisibility('confirm-password')">
            </div>
          </div>
        </div>
        
        <div class="form-group">
          <h2 class="form-label">Notifications</h2>
          
          <div class="checkbox-group">
            <input type="checkbox" id="email-notification">
            <label for="email-notification">E-Mail Notification</label>
          </div>
          <p class="checkbox-description">You will be notified with E-Mail when someone messages you.</p>
          
          <div class="checkbox-group">
            <input type="checkbox" id="sound-notification">
            <label for="sound-notification">Sound Notification</label>
          </div>
          <p class="checkbox-description">You will be notified with Sound when someone messages you.</p>
        </div>
        
        <div class="action-buttons">
          <button class="btn btn-light">Cancel</button>
          <button class="btn btn-primary">Save</button>
        </div>
      </div>
    </div>
  </div>
  
  <!-- Mobile Menu Overlay -->
  <div class="overlay" id="overlay"></div>
  
  <!-- Mobile Sidebar -->
  <div class="mobile-sidebar" id="mobile-sidebar">
    <div class="mobile-sidebar-header">
      <div class="logo-container">
        <img src="../assets/TripBudLogo.png" class="logo" alt="Logo">
        <span class="logo-text">Menu</span>
      </div>
      <button class="close-menu" id="close-menu">×</button>
    </div>
    
    <div class="search-box">
      <input type="text" placeholder="Search...">
    </div>
    
    <div class="mobile-nav-links">
      <a href="#" class="nav-link active">
        <img src="../assets/user.png" alt="User icon">
        <h2>Account</h2>
      </a>
      
      <a href="#" class="nav-link">
        <img src="../assets/shopping-cart.png" alt="Cart icon">
        <h2>Plans</h2>
      </a>
      
      <a href="#" class="nav-link">
        <img src="../assets/info.png" alt="Info icon">
        <h2>Help & Support</h2>
      </a>
    </div>
    
    <div class="sidebar-footer">
      <div class="user-profile-sidebar">
        <img src="../assets/account-symbol.png" class="user-avatar-small" alt="User avatar">
        <div class="user-info">
          <div class="user-name">John Doe</div>
          <span class="membership-badge">Premium</span>
        </div>
      </div>
      
      <button class="logout-btn">Log Out</button>
    </div>
  </div>
</template>

<script>
export default {
  name: 'SettingsPage',
  mounted() {
    // Mobile menu functionality
    const menuToggle = document.getElementById('menu-toggle');
    const closeMenu = document.getElementById('close-menu');
    const overlay = document.getElementById('overlay');
    const mobileSidebar = document.getElementById('mobile-sidebar');
    
    menuToggle.addEventListener('click', function() {
      mobileSidebar.classList.add('active');
      overlay.style.display = 'block';
      document.body.style.overflow = 'hidden';
    });
    
    function closeNav() {
      mobileSidebar.classList.remove('active');
      overlay.style.display = 'none';
      document.body.style.overflow = 'auto';
    }
    
    closeMenu.addEventListener('click', closeNav);
    overlay.addEventListener('click', closeNav);
    
    // Close menu when clicking on a link (for demo purposes)
    const mobileNavLinks = mobileSidebar.querySelectorAll('.nav-link');
    mobileNavLinks.forEach(link => {
      link.addEventListener('click', function(e) {
        // In a real app, you might not want to prevent default if navigating
        // e.preventDefault();
        closeNav();
      });
    });
  },
  methods: {
    togglePasswordVisibility(inputId) {
      const passwordInput = document.getElementById(inputId);
      const toggleIcon = passwordInput.nextElementSibling;
      
      if (passwordInput.type === 'password') {
        passwordInput.type = 'text';
        // You could also switch the icon here if you have a "show" icon
        // toggleIcon.src = "../assets/show.png";
      } else {
        passwordInput.type = 'password';
        // toggleIcon.src = "../assets/hide.png";
      }
    }
  }
}
</script>

<style>
@import url('https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;700&display=swap');

* {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
  font-family: 'Outfit', sans-serif;
}

body {
  background: linear-gradient(to bottom, #e0f2fe, #ffffff);
  min-height: 100vh;
  overflow-x: hidden;
  position: relative;
}

/* Background Image Container */
.background-image-container {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background-image: url('../assets/lines.png');
  background-repeat: no-repeat;
  background-size: cover;
  background-position: center;
  z-index: -1;
  opacity: 0.8; /* Adjust opacity as needed */
}

.setting-container {
  display: flex;
  flex-direction: column;
  padding: 20px;
  max-width: 1400px;
  margin: 0 auto;
  min-height: calc(100vh - 40px); /* Account for padding */
  position: relative;
  z-index: 1;
}

.header {
  display: flex;
  align-items: center;
  justify-content: space-between;
  margin-bottom: 30px;
}

.logo-container {
  display: flex;
  align-items: center;
}

.logo {
  height: 40px;
  margin-right: 10px;
}

.logo-text {
  font-size: 28px;
  font-weight: bold;
  color: #333;
}

.menu-toggle {
  display: none;
  background: none;
  border: none;
  font-size: 24px;
  cursor: pointer;
  width: 40px;
  height: 40px;
  border-radius: 50%;
  background-color: white;
  box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
  color: #333;
}

.content-wrapper {
  display: flex;
  gap: 20px;
  flex: 1;
  position: relative;
  min-height: calc(100vh - 100px); /* Adjust based on header height */
}

.sidebar {
  background-color: rgba(255, 255, 255, 0.9); /* Semi-transparent to show background */
  border-radius: 16px;
  box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
  padding: 20px;
  width: 280px;
  flex-shrink: 0;
  position: sticky;
  top: 20px;
  height: calc(100vh - 100px); /* Match content wrapper height */
  display: flex;
  flex-direction: column;
  backdrop-filter: blur(5px); /* Adds a blur effect to background */
}

.search-box {
  position: relative;
  margin-bottom: 30px;
}

.search-box input {
  width: 100%;
  height: 44px;
  border-radius: 22px;
  border: 1px solid #e0e0e0;
  padding: 0 15px;
  font-size: 15px;
  transition: all 0.3s ease;
}

.search-box input:focus {
  outline: none;
  border-color: #409FDB;
  box-shadow: 0 0 0 2px rgba(64, 159, 219, 0.1);
}

.nav-links {
  flex: 1;
  overflow-y: auto;
  margin-bottom: 20px;
}

.nav-link {
  display: flex;
  align-items: center;
  padding: 12px 10px;
  margin-bottom: 10px;
  text-decoration: none;
  color: #555;
  border-radius: 12px;
  transition: all 0.2s ease;
}

.nav-link:hover {
  background-color: #f5f9ff;
}

.nav-link.active {
  background-color: #f0f7ff;
  color: #409FDB;
}

.nav-link img {
  width: 20px;
  height: 20px;
  margin-right: 12px;
}

.nav-link h2 {
  font-size: 16px;
  font-weight: 500;
}

.sidebar-footer {
  margin-top: auto;
}

.user-profile-sidebar {
  padding: 15px 0;
  border-top: 1px solid #eee;
  margin-bottom: 20px;
  display: flex;
  align-items: center;
}

.user-avatar-small {
  width: 40px;
  height: 40px;
  border-radius: 50%;
  object-fit: cover;
  margin-right: 12px;
  background-color: #f0f0f0;
}

.user-info {
  flex: 1;
}

.user-name {
  font-weight: 600;
  font-size: 14px;
  margin-bottom: 2px;
}

.membership-badge {
  font-size: 12px;
  color: #409FDB;
  background-color: #e6f3fc;
  padding: 2px 8px;
  border-radius: 10px;
  display: inline-block;
}

.logout-btn {
  width: 100%;
  height: 44px;
  border-radius: 22px;
  background-color: #6c757d;
  border: none;
  color: white;
  font-size: 16px;
  cursor: pointer;
  transition: all 0.2s ease;
}

.logout-btn:hover {
  background-color: #5a6268;
}

.main-content {
  background-color: rgba(255, 255, 255, 0.9); /* Semi-transparent to show background */
  border-radius: 16px;
  box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
  padding: 30px;
  flex: 1;
  overflow-y: auto;
  max-height: calc(100vh - 100px); /* Match sidebar height */
  backdrop-filter: blur(5px); /* Adds a blur effect to background */
}

.tab-header {
  display: flex;
  margin-bottom: 30px;
  border-bottom: 1px solid #eee;
}

.tab-link {
  padding: 12px 20px;
  margin-right: 15px;
  text-decoration: none;
  color: #777;
  position: relative;
  font-weight: 500;
  font-size: 16px;
}

.tab-link.active {
  color: #333;
  font-weight: 600;
}

.tab-link.active::after {
  content: '';
  position: absolute;
  bottom: -1px;
  left: 0;
  right: 0;
  height: 3px;
  background-color: #409FDB;
  border-radius: 3px 3px 0 0;
}

.section {
  margin-bottom: 36px;
}

.section-title {
  font-size: 22px;
  font-weight: 500;
  margin-bottom: 8px;
}

.section-subtitle {
  color: #777777;
  margin-bottom: 24px;
  font-size: 16px;
}

.profile-header {
  display: flex;
  align-items: center;
  justify-content: space-between;
  margin-bottom: 30px;
}

.profile-title {
  flex: 1;
}

.profile-picture-container {
  display: flex;
  align-items: center;
  gap: 15px;
}

.profile-picture {
  width: 80px;
  height: 80px;
  border-radius: 50%;
  object-fit: cover;
  background-color: #f0f0f0;
}

.button-group {
  display: flex;
  gap: 10px;
}

.btn {
  padding: 8px 20px;
  border-radius: 20px;
  font-size: 14px;
  cursor: pointer;
  border: none;
  transition: all 0.2s ease;
}

.btn-primary {
  background-color: #409FDB;
  color: white;
}

.btn-primary:hover {
  background-color: #3089c3;
}

.btn-danger {
  background-color: #dc3545;
  color: white;
}

.btn-danger:hover {
  background-color: #c82333;
}

.btn-light {
  background-color: #e9ecef;
  color: #333;
}

.btn-light:hover {
  background-color: #dde2e6;
}

.form-group {
  margin-bottom: 24px;
  border-bottom: 1px solid #eee;
  padding-bottom: 24px;
}

.form-group:last-of-type {
  border-bottom: none;
}

.form-label {
  display: block;
  font-weight: 500;
  margin-bottom: 10px;
  color: #333;
}

.form-control {
  width: 100%;
  max-width: 500px;
  height: 44px;
  border-radius: 22px;
  border: 1px solid #bebdbd;
  padding: 0 15px;
  font-size: 15px;
  transition: all 0.3s ease;
}

.password-input-wrapper {
  position: relative;
  max-width: 500px;
}

.password-input {
  padding-right: 40px; /* Make room for the icon */
}

.toggle-password {
  position: absolute;
  right: 15px;
  top: 50%;
  transform: translateY(-50%);
  width: 20px;
  height: 20px;
  cursor: pointer;
  opacity: 0.7;
  transition: opacity 0.2s ease;
}

.toggle-password:hover {
  opacity: 1;
}

.form-control:focus {
  outline: none;
  border-color: #409FDB;
  box-shadow: 0 0 0 2px rgba(64, 159, 219, 0.1);
}

.password-section {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
  gap: 20px;
}

.checkbox-group {
  display: flex;
  align-items: center;
  margin-bottom: 8px;
}

.checkbox-group input[type="checkbox"] {
  width: 18px;
  height: 18px;
  margin-right: 12px;
  cursor: pointer;
}

.checkbox-group label {
  font-weight: 500;
}

.checkbox-description {
  color: #777;
  margin-left: 30px;
  margin-bottom: 16px;
  font-size: 14px;
}

.action-buttons {
  display: flex;
  justify-content: flex-end;
  margin-top: 40px;
  gap: 12px;
}

.overlay {
  display: none;
  position: fixed;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background-color: rgba(0, 0, 0, 0.5);
  z-index: 999;
}

.mobile-sidebar {
  position: fixed;
  top: 0;
  left: -280px;
  width: 280px;
  height: 100%;
  background-color: rgba(255, 255, 255, 0.9);
  z-index: 1000;
  transition: left 0.3s ease;
  padding: 20px;
  overflow-y: auto;
  box-shadow: 2px 0 10px rgba(0, 0, 0, 0.1);
  display: flex;
  flex-direction: column;
  backdrop-filter: blur(5px);
}

.mobile-sidebar.active {
  left: 0;
}

.close-menu {
  position: absolute;
  top: 20px;
  right: 20px;
  background: none;
  border: none;
  font-size: 24px;
  cursor: pointer;
  color: #333;
}

.mobile-sidebar-header {
  display: flex;
  align-items: center;
  margin-bottom: 30px;
  padding-bottom: 15px;
  border-bottom: 1px solid #eee;
}

.mobile-nav-links {
  flex: 1;
  overflow-y: auto;
  margin-bottom: 20px;
}

/* Custom scrollbar */
.sidebar::-webkit-scrollbar,
.main-content::-webkit-scrollbar,
.mobile-sidebar::-webkit-scrollbar {
  width: 6px;
}

.sidebar::-webkit-scrollbar-track,
.main-content::-webkit-scrollbar-track,
.mobile-sidebar::-webkit-scrollbar-track {
  background: transparent;
}

.sidebar::-webkit-scrollbar-thumb,
.main-content::-webkit-scrollbar-thumb,
.mobile-sidebar::-webkit-scrollbar-thumb {
  background: #ccc;
  border-radius: 6px;
}

/* Responsive styles */
@media (max-width: 992px) {
  .sidebar {
    width: 240px;
  }
}

@media (max-width: 768px) {
  .setting-container {
    padding: 15px;
  }
  
  .header {
    margin-bottom: 20px;
  }
  
  .logo-text {
    font-size: 22px;
  }
  
  .main-content {
    padding: 20px;
    max-height: none;
    height: auto;
  }
  
  .sidebar {
    display: none;
  }
  
  .menu-toggle {
    display: block;
  }
  
  .tab-header {
    overflow-x: auto;
    white-space: nowrap;
    padding-bottom: 10px;
    margin-bottom: 20px;
  }
  
  .tab-link {
    padding: 10px 15px;
    font-size: 14px;
  }
  
  .section-title {
    font-size: 20px;
  }
  
  .profile-header {
    flex-direction: column;
    align-items: flex-start;
    gap: 15px;
  }
  
  .profile-picture-container {
    width: 100%;
    justify-content: space-between;
  }
  
  .password-section {
    grid-template-columns: 1fr;
  }
  
  .action-buttons {
    flex-direction: column;
    width: 100%;
  }
  
  .btn {
    width: 100%;
  }
}

@media (max-width: 480px) {
  .logo {
    height: 30px;
  }
  
  .logo-text {
    font-size: 18px;
  }
  
  .form-control {
    max-width: 100%;
  }
  
  .button-group {
    flex-direction: column;
    gap: 8px;
    width: 100%;
  }
  
  .button-group .btn {
    width: 100%;
  }
  
  .nav-link h2 {
    font-size: 14px;
  }
}
</style>