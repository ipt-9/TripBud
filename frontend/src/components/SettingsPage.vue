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
          <input type="text" placeholder="Search..." v-model="searchQuery">
        </div>
       
        <div class="nav-links">
          <a href="#" 
             class="nav-link" 
             :class="{ active: activeTab === 'account' }" 
             @click.prevent="setActiveTab('account')">
            <img src="../assets/user.png" alt="User icon">
            <h2>Account</h2>
          </a>
         
          <a href="#" 
             class="nav-link" 
             :class="{ active: activeTab === 'payment' }" 
             @click.prevent="setActiveTab('payment')">
            <img src="../assets/creditcard.png" alt="Payment icon">
            <h2>Payment</h2>
          </a>
         
          <a href="#" 
             class="nav-link" 
             :class="{ active: activeTab === 'plans' }" 
             @click.prevent="setActiveTab('plans')">
            <img src="../assets/shopping-cart.png" alt="Cart icon">
            <h2>Plans</h2>
          </a>
         
          <a href="#" 
             class="nav-link" 
             :class="{ active: activeTab === 'support' }" 
             @click.prevent="setActiveTab('support')">
            <img src="../assets/info.png" alt="Info icon">
            <h2>Help & Support</h2>
          </a>
        </div>
       
        <div class="sidebar-footer">
          <div class="user-profile-sidebar">
            <img :src="getProfileImageUrl()" class="user-avatar-small" alt="User avatar">
            <div class="user-info">
              <div class="user-name">{{ user.name }}</div>
              <span class="membership-badge">{{ user.subscription_plan }}</span>
            </div>
          </div>
         
          <button class="logout-btn" @click="logout">Log Out</button>
        </div>
      </div>
     
      <!-- Main Content -->
      <div class="main-content">
        <div v-if="message" class="alert" :class="message.type">
          {{ message.text }}
        </div>
        
        <!-- Account Tab -->
        <div v-if="activeTab === 'account'">
          <div class="tab-header">
            <a href="#" 
               class="tab-link" 
               :class="{ active: activeSubTab === 'profile' }"
               @click.prevent="setActiveSubTab('profile')">Profile</a>
            <a href="#" 
               class="tab-link" 
               :class="{ active: activeSubTab === 'notifications' }"
               @click.prevent="setActiveSubTab('notifications')">Notifications</a>
          </div>
          
          <!-- Profile Sub-Tab -->
          <div v-if="activeSubTab === 'profile'">
            <div class="section">
              <div class="profile-header">
                <div class="profile-title">
                  <h1 class="section-title">Your Profile</h1>
                  <p class="section-subtitle">Update your profile settings here</p>
                </div>
               
                <div class="profile-picture-container">
                  <img :src="profileImageUrl" class="profile-picture" alt="Profile picture">
                  <div class="button-group">
                    <label for="profile-image-upload" class="btn btn-primary">Edit</label>
                    <input 
                      type="file" 
                      id="profile-image-upload" 
                      style="display: none"
                      @change="handleImageUpload"
                      accept="image/*">
                    <button class="btn btn-danger" @click="deleteProfileImage">Delete</button>
                  </div>
                </div>
              </div>
            </div>
           
            <div class="form-group">
              <label class="form-label" for="username">Username</label>
              <input type="text" id="username" class="form-control" v-model="userProfile.name">
            </div>
           
            <div class="form-group">
              <label class="form-label" for="email">E-Mail</label>
              <input type="email" id="email" class="form-control" v-model="userProfile.email">
            </div>
           
            <div class="form-group password-section">
              <div>
                <label class="form-label" for="current-password">Current Password</label>
                <div class="password-input-wrapper">
                  <input :type="passwordVisibility.current ? 'text' : 'password'" 
                         id="current-password" 
                         class="form-control password-input"
                         v-model="passwords.current">
                  <img :src="passwordVisibility.current ? 'src/assets/show.png' : 'src/assets/hide.png'" 
                       class="toggle-password" 
                       alt="Toggle password visibility" 
                       @click="togglePasswordVisibility('current')">
                </div>
              </div>
             
              <div>
                <label class="form-label" for="new-password">New Password</label>
                <div class="password-input-wrapper">
                  <input :type="passwordVisibility.new ? 'text' : 'password'" 
                         id="new-password" 
                         class="form-control password-input"
                         v-model="passwords.new">
                  <img :src="passwordVisibility.new ? 'src/assets/show.png' : 'src/assets/hide.png'" 
                       class="toggle-password" 
                       alt="Toggle password visibility" 
                       @click="togglePasswordVisibility('new')">
                </div>
              </div>
             
              <div>
                <label class="form-label" for="confirm-password">Confirm Password</label>
                <div class="password-input-wrapper">
                  <input :type="passwordVisibility.confirm ? 'text' : 'password'" 
                         id="confirm-password" 
                         class="form-control password-input"
                         v-model="passwords.confirm">
                  <img :src="passwordVisibility.confirm ? 'src/assets/show.png' : 'src/assets/hide.png'" 
                       class="toggle-password" 
                       alt="Toggle password visibility" 
                       @click="togglePasswordVisibility('confirm')">
                </div>
              </div>
            </div>
            
            <div class="action-buttons">
              <button class="btn btn-light" @click="cancelChanges">Cancel</button>
              <button class="btn btn-primary" @click="saveProfileChanges">Save</button>
            </div>
          </div>
          
          <!-- Notifications Sub-Tab -->
          <div v-if="activeSubTab === 'notifications'">
            <div class="section">
              <div class="profile-title">
                <h1 class="section-title">Notification Settings</h1>
                <p class="section-subtitle">Manage how you receive notifications</p>
              </div>
            </div>
            
            <div class="form-group">
              <h2 class="form-label">Notifications</h2>
             
              <div class="checkbox-group">
                <input type="checkbox" id="email-notification" v-model="settings.notifications.email">
                <label for="email-notification">E-Mail Notification</label>
              </div>
              <p class="checkbox-description">You will be notified with E-Mail when someone messages you.</p>
              
              <div class="checkbox-group">
                <input type="checkbox" id="push-notification" v-model="settings.notifications.push">
                <label for="push-notification">Push Notification</label>
              </div>
              <p class="checkbox-description">You will receive push notifications on your device.</p>
            </div>
            
            <div class="action-buttons">
              <button class="btn btn-light" @click="cancelChanges">Cancel</button>
              <button class="btn btn-primary" @click="saveNotificationSettings">Save</button>
            </div>
          </div>
        </div>
        
        <!-- Payment Tab -->
        <div v-if="activeTab === 'payment'">
          <div class="section">
            <div class="profile-title">
              <h1 class="section-title">Payment Methods</h1>
              <p class="section-subtitle">Manage your payment methods</p>
            </div>
          </div>
          
          <div v-if="paymentMethod" class="payment-method-card">
            <div class="card-info">
              <div class="card-type">{{ paymentMethod.type }}</div>
              <div class="card-number">**** **** **** {{ paymentMethod.last4 }}</div>
              <div class="card-expiry">Expires: {{ paymentMethod.expMonth }}/{{ paymentMethod.expYear }}</div>
            </div>
            <div class="card-actions">
              <button class="btn btn-primary" @click="showPaymentForm = true">Edit</button>
              <button class="btn btn-danger" @click="deletePaymentMethod">Delete</button>
            </div>
          </div>
          
          <div v-else-if="!showPaymentForm" class="no-payment-method">
            <p>No payment method added yet.</p>
            <button class="btn btn-primary" @click="showPaymentForm = true">Add Payment Method</button>
          </div>
          
          <form v-if="showPaymentForm" @submit.prevent="savePaymentMethod" class="payment-form">
            <div class="form-group">
              <label class="form-label" for="cardNumber">Card Number</label>
              <input type="text" id="cardNumber" class="form-control" v-model="editingPaymentMethod.cardNumber" placeholder="1234 5678 9012 3456">
            </div>
            
            <div class="form-row">
              <div class="form-group">
                <label class="form-label" for="expMonth">Expiration Month</label>
                <select id="expMonth" class="form-control" v-model="editingPaymentMethod.expMonth">
                  <option v-for="month in 12" :key="month" :value="month">{{ month }}</option>
                </select>
              </div>
              
              <div class="form-group">
                <label class="form-label" for="expYear">Expiration Year</label>
                <select id="expYear" class="form-control" v-model="editingPaymentMethod.expYear">
                  <option v-for="year in years" :key="year" :value="year">{{ year }}</option>
                </select>
              </div>
              
              <div class="form-group">
                <label class="form-label" for="cvv">CVV</label>
                <input type="text" id="cvv" class="form-control" v-model="editingPaymentMethod.cvv" placeholder="123">
              </div>
            </div>
            
            <div class="form-group">
              <label class="form-label" for="cardholderName">Cardholder Name</label>
              <input type="text" id="cardholderName" class="form-control" v-model="editingPaymentMethod.cardholderName" placeholder="John Doe">
            </div>
            
            <div class="action-buttons">
              <button type="button" class="btn btn-light" @click="showPaymentForm = false">Cancel</button>
              <button type="submit" class="btn btn-primary">Save</button>
            </div>
          </form>
        </div>
        
        <!-- Plans Tab -->
        <div v-if="activeTab === 'plans'">
          <div class="section">
            <div class="profile-title">
              <h1 class="section-title">Subscription Plans</h1>
              <p class="section-subtitle">Choose the plan that works best for you</p>
            </div>
          </div>
          
          <div class="plans-container">
            <div 
              v-for="plan in plans" 
              :key="plan.id"
              :class="['plan-card', user.subscription_plan === plan.id ? 'current-plan' : '']"
            >
              <div class="plan-header">
                <h3>{{ plan.name }}</h3>
                <div class="plan-price">{{ plan.price }}</div>
              </div>
              
              <div class="plan-features">
                <ul>
                  <li v-for="(feature, index) in plan.features" :key="index">
                    {{ feature }}
                  </li>
                </ul>
              </div>
              
              <div class="plan-action">
                <button 
                  v-if="user.subscription_plan === plan.id"
                  class="btn btn-primary" 
                  disabled
                >
                  Current Plan
                </button>
                <button 
                  v-else
                  class="btn btn-secondary" 
                  @click="changePlan(plan.id)"
                >
                  Switch to {{ plan.name }}
                </button>
              </div>
            </div>
          </div>
        </div>
        
        <!-- Support Tab -->
        <div v-if="activeTab === 'support'">
          <div class="section">
            <div class="profile-title">
              <h1 class="section-title">Help & Support</h1>
              <p class="section-subtitle">We're here to help you</p>
            </div>
          </div>
          
          <div class="support-options">            
            <div class="support-card">
              <h3>Contact Support</h3>
              <p>Can't find what you're looking for? Contact our support team.</p>
              <button class="btn btn-primary" @click="showContactForm = true">Contact Support</button>
            </div>
            
            <div class="support-card">
              <h3>Report a Bug</h3>
              <p>Found a problem with our platform? Let us know so we can fix it.</p>
              <button class="btn btn-secondary" @click="showBugReportForm = true">Report Bug</button>
            </div>
          </div>
          
          <div v-if="showContactForm" class="modal">
            <div class="modal-content">
              <h3>Contact Support</h3>
              <form @submit.prevent="submitSupportRequest">
                <div class="form-group">
                  <label class="form-label" for="subject">Subject</label>
                  <input type="text" id="subject" class="form-control" v-model="supportRequest.subject" required>
                </div>
                
                <div class="form-group">
                  <label class="form-label" for="message">Message</label>
                  <textarea id="message" class="form-control" v-model="supportRequest.message" rows="5" required></textarea>
                </div>
                
                <div class="form-group">
                  <label class="form-label" for="priority">Priority</label>
                  <select id="priority" class="form-control" v-model="supportRequest.priority">
                    <option value="low">Low</option>
                    <option value="medium">Medium</option>
                    <option value="high">High</option>
                  </select>
                </div>
                
                <div class="action-buttons">
                  <button type="button" class="btn btn-light" @click="showContactForm = false">Cancel</button>
                  <button type="submit" class="btn btn-primary">Submit</button>
                </div>
              </form>
            </div>
          </div>
          
          <div v-if="showBugReportForm" class="modal">
            <div class="modal-content">
              <h3>Report a Bug</h3>
              <form @submit.prevent="submitBugReport">
                <div class="form-group">
                  <label class="form-label" for="bugTitle">Title</label>
                  <input type="text" id="bugTitle" class="form-control" v-model="bugReport.title" required>
                </div>
                
                <div class="form-group">
                  <label class="form-label" for="bugDescription">Description</label>
                  <textarea id="bugDescription" class="form-control" v-model="bugReport.description" rows="5" required></textarea>
                </div>
                
                <div class="form-group">
                  <label class="form-label" for="steps">Steps to Reproduce</label>
                  <textarea id="steps" class="form-control" v-model="bugReport.steps" rows="3" placeholder="1. Go to...\n2. Click on...\n3. Observe..."></textarea>
                </div>
                
                <div class="form-group">
                  <label>
                    <input type="checkbox" v-model="bugReport.includeSystemInfo">
                    Include system information (browser, OS)
                  </label>
                </div>
                
                <div class="action-buttons">
                  <button type="button" class="btn btn-light" @click="showBugReportForm = false">Cancel</button>
                  <button type="submit" class="btn btn-primary">Submit</button>
                </div>
              </form>
            </div>
          </div>
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
      <input type="text" placeholder="Search..." v-model="searchQuery">
    </div>
   
    <div class="mobile-nav-links">
      <a href="#" 
         class="nav-link" 
         :class="{ active: activeTab === 'account' }"
         @click.prevent="setActiveTab('account'); closeMobileMenu()">
        <img src="../assets/user.png" alt="User icon">
        <h2>Account</h2>
      </a>
      
      <a href="#" 
         class="nav-link" 
         :class="{ active: activeTab === 'payment' }"
         @click.prevent="setActiveTab('payment'); closeMobileMenu()">
        <img src="../assets/creditcard.png" alt="Payment icon">
        <h2>Payment</h2>
      </a>
     
      <a href="#" 
         class="nav-link" 
         :class="{ active: activeTab === 'plans' }"
         @click.prevent="setActiveTab('plans'); closeMobileMenu()">
        <img src="../assets/shopping-cart.png" alt="Cart icon">
        <h2>Plans</h2>
      </a>
     
      <a href="#" 
         class="nav-link" 
         :class="{ active: activeTab === 'support' }"
         @click.prevent="setActiveTab('support'); closeMobileMenu()">
        <img src="../assets/info.png" alt="Info icon">
        <h2>Help & Support</h2>
      </a>
    </div>
   
    <div class="sidebar-footer">
      <div class="user-profile-sidebar">
        <img :src="getProfileImageUrl()" class="user-avatar-small" alt="User avatar">
        <div class="user-info">
          <div class="user-name">{{ user.name }}</div>
          <span class="membership-badge">{{ user.subscription_plan }}</span>
        </div>
      </div>
     
      <button class="logout-btn" @click="logout">Log Out</button>
    </div>
  </div>
</template>
 
<script>
import axios from 'axios';

export default {
  name: 'SettingsPage',
  data() {
    return {
      // API endpoints
      apiBaseUrl: '/api',
      
      // User data
      user: {
        name: 'John Doe',
        email: 'john@example.com',
        subscription_plan: 'premium',
        profile_image: 'default'
      },
      
      // UI state
      activeTab: 'account',
      activeSubTab: 'profile',
      searchQuery: '',
      message: null,
      
      // Profile data
      userProfile: {
        name: '',
        email: '',
        bio: ''
      },
      
      // Password data - added to fix the error
      passwords: {
        current: '',
        new: '',
        confirm: ''
      },
      
      passwordVisibility: {
        current: false,
        new: false,
        confirm: false
      },
      
      // Settings data
      settings: {
        language: 'en',
        timezone: 'UTC',
        notifications: {
          email: false,
          push: true
        }
      },
      
      // Payment data
      paymentMethod: null,
      showPaymentForm: false,
      editingPaymentMethod: {
        cardNumber: '',
        expMonth: 1,
        expYear: new Date().getFullYear(),
        cvv: '',
        cardholderName: ''
      },
      years: [],
      
      // Profile image URL
      profileImageUrl: '/default.png',
      
      // Plans data
      plans: [
        {
          id: 'free',
          name: 'Free',
          price: '$0/month',
          features: [
            '2 saved trips',
            'Up to 2 buddies per trip',
            'Up to 1 GB trip storage'
          ]
        },
        {
          id: 'premium',
          name: 'Premium',
          price: '$8.99/month',
          features: [
            '2 saved trips',
            'Up to 5 buddies per trip',
            'Up to 5 GB trip storage',
          ]
        },
        {
          id: 'business',
          name: 'Business',
          price: '$24.99/month',
          features: [
            'Unlimited saved trips',
            'Unlimited buddies per trip',
            'Unlimited trip storage',
          ]
        }
      ],
      
      // Support data
      showContactForm: false,
      showBugReportForm: false,
      supportRequest: {
        subject: '',
        message: '',
        priority: 'medium'
      },
      bugReport: {
        title: '',
        description: '',
        steps: '',
        includeSystemInfo: true
      }
    };
  },
  created() {
    // Generate years for payment form
    const currentYear = new Date().getFullYear();
    this.years = Array.from({length: 10}, (_, i) => currentYear + i);
  },
  mounted() {
    // Mobile menu functionality
    const menuToggle = document.getElementById('menu-toggle');
    const closeMenu = document.getElementById('close-menu');
    const overlay = document.getElementById('overlay');
    const mobileSidebar = document.getElementById('mobile-sidebar');
   
    menuToggle.addEventListener('click', () => {
      mobileSidebar.classList.add('active');
      overlay.style.display = 'block';
      document.body.style.overflow = 'hidden';
    });
   
    const closeNav = () => {
      mobileSidebar.classList.remove('active');
      overlay.style.display = 'none';
      document.body.style.overflow = 'auto';
    };
   
    closeMenu.addEventListener('click', closeNav);
    overlay.addEventListener('click', closeNav);
    
    // Fetch initial data
    this.fetchUserData();
    this.fetchSettings();
    this.fetchPaymentMethod();
  },
  methods: {
    // Profile image URL method
    getProfileImageUrl() {
      const baseUrl = 'https://api.tripbud-bmsd22a.bbzwinf.ch/';
      // Handle different profile image values
      if (!this.user.profile_image || this.user.profile_image === 'default') {
        // Return path to your default image
        return `${baseUrl}assets/images/default.png`;
      } else if (this.user.profile_image.startsWith('http')) {
        // If it's already a full URL, return it directly
        return this.user.profile_image;
      } else if (this.user.profile_image.startsWith('profile_images/')) {
        // If it's a storage path, prepend the storage URL
        return `${baseUrl}storage/${this.user.profile_image}`;
      } else {
        // Otherwise, just use the path as is
        return `${baseUrl}${this.user.profile_image}`;
      }
    },
    
    // Navigation methods
    setActiveTab(tab) {
      this.activeTab = tab;
      
      // Set default sub-tab for account
      if (tab === 'account') {
        this.activeSubTab = 'profile';
      }
      
      // Clear any messages when switching tabs
      this.message = null;
    },
    
    setActiveSubTab(subTab) {
      this.activeSubTab = subTab;
      this.message = null;
    },
    
    closeMobileMenu() {
      const mobileSidebar = document.getElementById('mobile-sidebar');
      const overlay = document.getElementById('overlay');
      
      mobileSidebar.classList.remove('active');
      overlay.style.display = 'none';
      document.body.style.overflow = 'auto';
    },
    
    // API methods
    async fetchUserData() {
      try {
        const response = await axios.get(`${this.apiBaseUrl}/settings/account/profile`);
        this.user = response.data;
        this.userProfile = {
          name: response.data.name,
          email: response.data.email,
          bio: response.data.bio || ''
        };
        
        if (response.data.profile_image) {
          this.profileImageUrl = this.getProfileImageUrl();
        }
      } catch (error) {
        console.error('Error fetching user data:', error);
      }
    },
    
    async fetchSettings() {
      try {
        const response = await axios.get(`${this.apiBaseUrl}/settings`);
        
        if (response.data.settings) {
          this.settings = response.data.settings;
        }
      } catch (error) {
        console.error('Error fetching settings:', error);
      }
    },
    
    async saveProfileChanges() {
      try {
        // Check if passwords match
        if (this.passwords.new && this.passwords.new !== this.passwords.confirm) {
          this.message = { type: 'error', text: 'New password and confirm password do not match.' };
          return;
        }
        
        // Prepare profile data
        const profileData = {
          name: this.userProfile.name,
          email: this.userProfile.email,
          bio: this.userProfile.bio
        };
        
        // Add password update if provided
        if (this.passwords.current && this.passwords.new) {
          profileData.current_password = this.passwords.current;
          profileData.new_password = this.passwords.new;
        }
        
        // Update profile
        await axios.put(`${this.apiBaseUrl}/settings/updateChanges`, profileData);
        
        this.message = { type: 'success', text: 'Profile updated successfully!' };
        
        // Clear password fields
        this.passwords.current = '';
        this.passwords.new = '';
        this.passwords.confirm = '';
      } catch (error) {
        console.error('Error updating profile:', error);
        this.message = { type: 'error', text: 'Failed to update profile. Please try again.' };
      }
    },
    
    async saveNotificationSettings() {
      try {
        await axios.put(`${this.apiBaseUrl}/settings/updateChanges`, {
          notifications: this.settings.notifications
        });
        
        this.message = { type: 'success', text: 'Notification settings updated successfully!' };
      } catch (error) {
        console.error('Error updating notification settings:', error);
        this.message = { type: 'error', text: 'Failed to update notification settings. Please try again.' };
      }
    },
    
    async cancelChanges() {
      try {
        await axios.get(`${this.apiBaseUrl}/settings/cancelChanges`);
        
        // Refresh data
        await this.fetchUserData();
        await this.fetchSettings();
        
        this.message = { type: 'success', text: 'Changes canceled. Settings reverted to previous state.' };
      } catch (error) {
        console.error('Error canceling changes:', error);
        this.message = { type: 'error', text: 'No previous changes to revert.' };
      }
    },
    
    // Profile image methods - Updated to use temporary endpoints
    async handleImageUpload(event) {
      const file = event.target.files[0];
      if (!file) return;
      
      const formData = new FormData();
      formData.append('profile_image', file);
      
      try {
        const response = await axios.put(`${this.apiBaseUrl}/settings/account/profile/tempUpdateImage`, formData, {
          headers: {
            'Content-Type': 'multipart/form-data'
          }
        });
        
        if (response.data && response.data.image) {
          this.user.profile_image = response.data.image;
          this.profileImageUrl = this.getProfileImageUrl();
          this.message = { type: 'success', text: 'Profile image updated. Click Save to apply changes.' };
        }
      } catch (error) {
        console.error('Error uploading image:', error);
        this.message = { type: 'error', text: 'Failed to upload profile image. Please try again.' };
      }
    },
    
    async deleteProfileImage() {
      try {
        await axios.delete(`${this.apiBaseUrl}/settings/account/profile/tempDeleteImage`);
        
        this.user.profile_image = 'default';
        this.profileImageUrl = this.getProfileImageUrl();
        this.message = { type: 'success', text: 'Profile image removed. Click Save to apply changes.' };
      } catch (error) {
        console.error('Error deleting profile image:', error);
        this.message = { type: 'error', text: 'Failed to delete profile image. Please try again.' };
      }
    },
    
    // Password methods
    togglePasswordVisibility(field) {
      this.passwordVisibility[field] = !this.passwordVisibility[field];
    },
    
    // Payment methods
    async fetchPaymentMethod() {
      try {
        const response = await axios.get(`${this.apiBaseUrl}/settings/account/payment`);
        
        if (response.data && response.data.payment_method) {
          this.paymentMethod = {
            type: response.data.payment_method,
            ...response.data.payment_method_details
          };
        } else {
          this.paymentMethod = null;
        }
      } catch (error) {
        console.error('Error fetching payment method:', error);
        this.paymentMethod = null;
      }
    },
    
    async savePaymentMethod() {
      try {
        // In a real app, you would use a secure payment processor
        // and only send tokenized payment data to your server
        const paymentInfo = {
          payment_method: 'credit_card',
          payment_method_details: {
            last4: this.editingPaymentMethod.cardNumber.slice(-4),
            expMonth: this.editingPaymentMethod.expMonth,
            expYear: this.editingPaymentMethod.expYear,
            cardholderName: this.editingPaymentMethod.cardholderName
          }
        };
        
        await axios.put(`${this.apiBaseUrl}/settings/account/payment/editMethod`, paymentInfo);
        
        // Refresh payment data
        await this.fetchPaymentMethod();
        
        this.message = { type: 'success', text: 'Payment method saved successfully!' };
        this.showPaymentForm = false;
        
        // Reset form
        this.editingPaymentMethod = {
          cardNumber: '',
          expMonth: 1,
          expYear: new Date().getFullYear(),
          cvv: '',
          cardholderName: ''
        };
      } catch (error) {
        console.error('Error saving payment method:', error);
        this.message = { type: 'error', text: 'Failed to save payment method. Please try again.' };
      }
    },
    
    async deletePaymentMethod() {
      try {
        await axios.delete(`${this.apiBaseUrl}/settings/account/payment/deleteMethod`);
        
        this.paymentMethod = null;
        this.message = { type: 'success', text: 'Payment method deleted successfully.' };
      } catch (error) {
        console.error('Error deleting payment method:', error);
        this.message = { type: 'error', text: 'Failed to delete payment method. Please try again.' };
      }
    },
    
    // Plan methods
    async changePlan(planId) {
      try {
        await axios.put(`${this.apiBaseUrl}/settings/plans/changePlan`, { plan: planId });
        
        // Update local user data
        this.user.subscription_plan = planId;
        
        this.message = { type: 'success', text: `Successfully switched to ${this.plans.find(p => p.id === planId).name}` };
      } catch (error) {
        console.error('Error changing plan:', error);
        this.message = { type: 'error', text: 'Failed to change subscription plan. Please try again.' };
      }
    },
    
    submitSupportRequest() {
      // In a real app, this would connect to your support API
      // For demo purposes, we'll just show a success message
      setTimeout(() => {
        this.message = { 
          type: 'success', 
          text: 'Support request submitted successfully. Our team will get back to you soon.' 
        };
        this.showContactForm = false;
        this.supportRequest = {
          subject: '',
          message: '',
          priority: 'medium'
        };
      }, 1000);
    },
    
    submitBugReport() {
      // In a real app, this would connect to your bug reporting system
      // For demo purposes, we'll just show a success message
      setTimeout(() => {
        this.message = { 
          type: 'success', 
          text: 'Bug report submitted successfully. Thank you for helping us improve!' 
        };
        this.showBugReportForm = false;
        this.bugReport = {
          title: '',
          description: '',
          steps: '',
          includeSystemInfo: true
        };
      }, 1000);
    },
    
    // Auth methods
    async logout() {
      try {
        // Call the logout API endpoint
        await axios.post('/logout');
        
        // Remove the auth token from localStorage
        localStorage.removeItem('auth_token');
        
        // Redirect to login page
        window.location.href = '/login';
      } catch (error) {
        console.error('Logout failed:', error);
        
        // Even if the API call fails, still remove token and redirect
        // This ensures the user is logged out on the client side
        localStorage.removeItem('auth_token');
        window.location.href = '/login';
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
  background-image: url('src/assets/lines.png');
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

/* Alert styles */
.alert {
  padding: 12px 20px;
  border-radius: 8px;
  margin-bottom: 20px;
  font-weight: 500;
}

.alert.success {
  background-color: #d4edda;
  color: #155724;
  border: 1px solid #c3e6cb;
}

.alert.error {
  background-color: #f8d7da;
  color: #721c24;
  border: 1px solid #f5c6cb;
}

/* Payment method card */
.payment-method-card {
  display: flex;
  justify-content: space-between;
  padding: 20px;
  border: 1px solid #e0e0e0;
  border-radius: 8px;
  margin-bottom: 20px;
  background-color: #f8f9fa;
}

.card-info {
  display: flex;
  flex-direction: column;
  gap: 5px;
}

.card-type {
  font-weight: 600;
  text-transform: uppercase;
}

.card-number {
  font-size: 16px;
}

.card-expiry {
  font-size: 14px;
  color: #6c757d;
}

.card-actions {
  display: flex;
  flex-direction: column;
  gap: 10px;
}

.no-payment-method {
  text-align: center;
  padding: 30px;
  background-color: #f8f9fa;
  border-radius: 8px;
  margin-bottom: 20px;
}

.payment-form {
  border: 1px solid #e0e0e0;
  border-radius: 8px;
  padding: 20px;
  margin-top: 20px;
}

.form-row {
  display: flex;
  gap: 15px;
  flex-wrap: wrap;
}

.form-row .form-group {
  flex: 1;
  min-width: 120px;
  border-bottom: none;
}

/* Plans styles */
.plans-container {
  display: flex;
  flex-wrap: wrap;
  gap: 20px;
  margin-top: 20px;
}

.plan-card {
  flex: 1;
  min-width: 250px;
  border: 1px solid #e0e0e0;
  border-radius: 8px;
  padding: 20px;
  display: flex;
  flex-direction: column;
  background-color: white;
  transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.plan-card:hover {
  transform: translateY(-5px);
  box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
}

.current-plan {
  border-color: #409FDB;
  box-shadow: 0 0 10px rgba(64, 159, 219, 0.3);
}

.plan-header {
  margin-bottom: 20px;
  text-align: center;
}

.plan-price {
  font-size: 1.5em;
  font-weight: bold;
  color: #409FDB;
}

.plan-features {
  flex: 1;
  margin-bottom: 20px;
}

.plan-features ul {
  padding-left: 20px;
  margin: 0;
}

.plan-features li {
  margin-bottom: 10px;
}

.plan-action {
  text-align: center;
}

/* Support styles */
.support-options {
  display: flex;
  flex-wrap: wrap;
  gap: 20px;
  margin-top: 20px;
}

.support-card {
  flex: 1;
  min-width: 250px;
  border: 1px solid #e0e0e0;
  border-radius: 8px;
  padding: 20px;
  display: flex;
  flex-direction: column;
  height: 200px;
  background-color: white;
}

.support-card h3 {
  margin-top: 0;
  margin-bottom: 10px;
}

.support-card p {
  flex: 1;
  margin-bottom: 15px;
}

/* Modal styles */
.modal {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background-color: rgba(0, 0, 0, 0.5);
  display: flex;
  justify-content: center;
  align-items: center;
  z-index: 1000;
}

.modal-content {
  background-color: white;
  padding: 30px;
  border-radius: 8px;
  width: 500px;
  max-width: 90%;
  max-height: 90%;
  overflow-y: auto;
}

.modal-content h3 {
  margin-top: 0;
  margin-bottom: 20px;
}

/* Mobile menu styles */
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
  
  .form-row {
    flex-direction: column;
    gap: 10px;
  }
  
  .plans-container {
    flex-direction: column;
  }
  
  .support-options {
    flex-direction: column;
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