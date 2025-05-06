<template>
  <div class="setting-container">
    <!-- Background Image Container -->
    <div class="background-image-container"></div>
   
    <header class="header">
      <div class="logo-container">
        <img src="../assets/TripBudLogo.png" class="logo" alt="Logo">
        <span class="logo-text">Settings</span>
      </div>
      <button class="menu-toggle" id="menu-toggle" @click="toggleMobileMenu">☰</button>
    </header>
   
    <div class="content-wrapper">
      <!-- Regular Sidebar (Desktop) -->
      <div class="sidebar-settings">
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
                  <img :src="getProfileImageUrl()" class="profile-picture" alt="Profile picture">
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
              <label class="form-label" for="name">Name</label>
              <input type="text" id="name" class="form-control" v-model="userProfile.name">
            </div>
            
            <div class="form-group">
              <label class="form-label" for="username">Username</label>
              <input type="text" id="username" class="form-control" v-model="userProfile.username">
            </div>
           
            <div class="form-group">
              <label class="form-label" for="email">E-Mail</label>
              <input type="email" id="email" class="form-control" v-model="userProfile.email">
            </div>
           
            <div class="form-group password-section">
              <div class="password-field">
                <label class="form-label" for="current-password">Current Password</label>
                <div class="password-input-wrapper">
                  <input :type="passwordVisibility.current ? 'text' : 'password'" 
                         id="current-password" 
                         class="form-control password-input"
                         v-model="passwords.current">
                  <img :src="passwordVisibility.current ? '../assets/show.png' : '../assets/hide.png'" 
                       class="toggle-password" 
                       alt="Toggle password visibility" 
                       @click="togglePasswordVisibility('current')">
                </div>
              </div>
             
              <div class="password-field">
                <label class="form-label" for="new-password">New Password</label>
                <div class="password-input-wrapper">
                  <input :type="passwordVisibility.new ? 'text' : 'password'" 
                         id="new-password" 
                         class="form-control password-input"
                         v-model="passwords.new">
                  <img :src="passwordVisibility.new ? '../assets/show.png' : '../assets/hide.png'" 
                       class="toggle-password" 
                       alt="Toggle password visibility" 
                       @click="togglePasswordVisibility('new')">
                </div>
              </div>
             
              <div class="password-field">
                <label class="form-label" for="confirm-password">Confirm Password</label>
                <div class="password-input-wrapper">
                  <input :type="passwordVisibility.confirm ? 'text' : 'password'" 
                         id="confirm-password" 
                         class="form-control password-input"
                         v-model="passwords.confirm">
                  <img :src="passwordVisibility.confirm ? '../assets/show.png' : '../assets/hide.png'" 
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
                <input type="checkbox" id="notifications" v-model="user.notifications">
                <label for="notifications">Enable Notifications</label>
              </div>
              <p class="checkbox-description">You will receive notifications when there are updates to your account.</p>
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
              <div class="support-details" v-if="supportInfo">
                <p>Email: {{ supportInfo.support_email }}</p>
                <p>Phone: {{ supportInfo.support_phone }}</p>
              </div>
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
                  <textarea id="message" class="form-control textarea" v-model="supportRequest.message" rows="5" required></textarea>
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
                  <textarea id="bugDescription" class="form-control textarea" v-model="bugReport.description" rows="5" required></textarea>
                </div>
                
                <div class="form-group">
                  <label class="form-label" for="steps">Steps to Reproduce</label>
                  <textarea id="steps" class="form-control textarea" v-model="bugReport.steps" rows="3" placeholder="1. Go to...\n2. Click on...\n3. Observe..."></textarea>
                </div>
                
                <div class="form-group">
                  <label class="checkbox-group">
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
  <div class="overlay" :class="{ 'active': isMobileMenuOpen }" @click="closeMobileMenu"></div>
 
  <!-- Mobile Sidebar -->
  <div class="mobile-sidebar" :class="{ 'active': isMobileMenuOpen }">
    <div class="mobile-sidebar-header">
      <div class="logo-container">
        <img src="../assets/TripBudLogo.png" class="logo" alt="Logo">
        <span class="logo-text">Menu</span>
      </div>
      <button class="close-menu" @click="closeMobileMenu">×</button>
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
import apiService from '../services/api';

export default {
  data() {
    return {
      activeTab: 'account',
      activeSubTab: 'profile',
      searchQuery: '',
      isMobileMenuOpen: false,
      message: null,
      
      // User data that will be loaded from API
      user: {
        name: '',
        username: '',
        email: '',
        language: 'en',
        theme: 'light',
        notifications: true,
        profile_image: 'assets/default.png',
        subscription_plan: 'free',
        payment_method: null,
        payment_method_details: null
      },
      
      // Copy of user data for editing
      userProfile: {
        name: '',
        username: '',
        email: ''
      },
      
      profileImageUrl: '',
      
      passwordVisibility: {
        current: false,
        new: false,
        confirm: false
      },
      
      passwords: {
        current: '',
        new: '',
        confirm: ''
      },
      
      showPaymentForm: false,
      paymentMethod: null,
      
      editingPaymentMethod: {
        cardNumber: '',
        expMonth: 1,
        expYear: new Date().getFullYear(),
        cvv: '',
        cardholderName: ''
      },
      
      years: Array.from({ length: 10 }, (_, i) => new Date().getFullYear() + i),
      
      // Initialize plans with pricing information
      plans: [
        {
          id: 'free',
          name: 'Free',
          price: '$0/mo',
          features: [
            '2 saved trips',
            'Up to 2 buddies per trip',
            'Up to 1 GB trip storage'
          ]
        },
        {
          id: 'premium',
          name: 'Premium',
          price: '$8.99/mo',
          features: [
            '10 saved trips',
            'Up to 5 buddies per trip',
            'Up to 5 GB trip storage'
          ]
        },
        {
          id: 'business',
          name: 'Business',
          price: '$24.99/mo',
          features: [
            'Unlimited saved trips',
            'Unlimited buddies per trip',
            'Unlimited trip storage'
          ]
        }
      ],
      
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
      },

      // Support information
      supportInfo: {
        support_email: '',
        support_phone: '',
        faq_url: ''
      }
    };
  },
  
  created() {
    // Try to restore the previous tab state
    const savedTab = localStorage.getItem('settings_active_tab');
    if (savedTab) {
      this.activeTab = savedTab;
    }
    
    const savedSubTab = localStorage.getItem('settings_active_subtab');
    if (savedSubTab) {
      this.activeSubTab = savedSubTab;
    }
    
    // Then load the data
    this.loadUserSettings();
    this.loadPlans();
    this.loadSupportInfo();
  },
  
  methods: {
    // NAVIGATION METHODS
    setActiveTab(tab) {
      console.log('Setting active tab to:', tab);
      this.activeTab = tab;
      
      // Set default subtab when switching to account tab
      if (tab === 'account') {
        this.activeSubTab = 'profile';
      }
      
      // Store the active tab in localStorage to maintain state
      localStorage.setItem('settings_active_tab', tab);
      
      // Close mobile menu if open
      if (this.isMobileMenuOpen) {
        this.closeMobileMenu();
      }
      
      // Add debugging for tab switching issues
      console.log('Active tab is now:', this.activeTab);
    },
    
    setActiveSubTab(subTab) {
      console.log('Setting active sub-tab to:', subTab);
      this.activeSubTab = subTab;
      
      // Store the active subtab in localStorage
      localStorage.setItem('settings_active_subtab', subTab);
    },
    
    handleTabClick(tab) {
      console.log('Tab clicked:', tab);
      // Check if we need to load any additional data for this tab
      this.setActiveTab(tab);
      
      // You might want to load specific data for each tab
      if (tab === 'payment' && !this.paymentMethod) {
        console.log('Loading payment data...');
        // Additional payment data loading if needed
      } else if (tab === 'plans' && (!this.plans || this.plans.length === 0)) {
        console.log('Loading plans data...');
        this.loadPlans();
      } else if (tab === 'support' && !this.supportInfo) {
        console.log('Loading support data...');
        this.loadSupportInfo();
      }
    },
    
    // API METHODS
    async loadUserSettings() {
      try {
        console.log('Fetching user settings...');
        const response = await apiService.getUserSettings();
        
        if (response.data && response.data.settings) {
          this.user = response.data.settings;
          
          // Update userProfile with the loaded data
          this.userProfile = {
            name: this.user.name,
            username: this.user.username,
            email: this.user.email
          };
          
          // Set profile image URL
          this.updateProfileImageUrl();
          
          // Parse payment method details if available
          if (this.user.payment_method && this.user.payment_method_details) {
            try {
              const paymentDetails = typeof this.user.payment_method_details === 'string' 
                ? JSON.parse(this.user.payment_method_details) 
                : this.user.payment_method_details;
                
              this.paymentMethod = {
                type: this.user.payment_method === 'credit_card' ? this.getCardType(paymentDetails.last4 || '4242') : this.user.payment_method,
                last4: paymentDetails.last4 || '****',
                expMonth: paymentDetails.expMonth || 12,
                expYear: paymentDetails.expYear || new Date().getFullYear()
              };
            } catch (e) {
              console.error('Error parsing payment details:', e);
            }
          }
        }
      } catch (error) {
        this.showMessage('Error loading settings. Please try again.', 'error');
        console.error('Error loading settings:', error);
      }
    },
    
    async loadPlans() {
      try {
        console.log('Loading subscription plans...');
        
        // Store current plans to restore in case of error
        const currentPlans = [...this.plans];
        
        const response = await apiService.getPlans();
        console.log('API response for plans:', response.data);
        
        if (response.data && response.data.available_plans && response.data.available_plans.length > 0) {
          // Map the plans to include features and prices from API
          this.plans = response.data.available_plans.map(plan => {
            // Find matching plan in our predefined plans
            const existingPlan = currentPlans.find(p => p.id === plan.id);
            
            // Merge the API data with our predefined data, prioritizing price and features from predefined
            return {
              ...plan,
              price: (existingPlan && existingPlan.price) || plan.price || '',
              features: (existingPlan && existingPlan.features) || plan.features || []
            };
          });
        }
        
        console.log('Plans loaded:', this.plans);
      } catch (error) {
        console.error('Error loading plans:', error);
        // If there's an error, we keep using the existing plans
      }
    },
    
    async loadSupportInfo() {
      try {
        console.log('Loading support information...');
        const response = await apiService.getSupportInfo();
        if (response.data) {
          this.supportInfo = response.data;
        }
      } catch (error) {
        console.error('Error loading support info:', error);
      }
    },
    
    async saveProfileChanges() {
      // Simple password validation
      if (this.passwords.new && this.passwords.new !== this.passwords.confirm) {
        this.showMessage('Passwords do not match', 'error');
        return;
      }
      
      try {
        // Prepare the data to send
        const updateData = {
          name: this.userProfile.name,
          username: this.userProfile.username,
          email: this.userProfile.email
        };
        
        // Send the update request
        const response = await apiService.updateUserSettings(updateData);
        
        if (response.data && response.data.settings) {
          // Update the user data with the response
          this.user = response.data.settings;
          
          // Reset password fields
          this.passwords.current = '';
          this.passwords.new = '';
          this.passwords.confirm = '';
          
          this.showMessage('Profile updated successfully', 'success');
        }
      } catch (error) {
        this.showMessage('Error updating profile. Please try again.', 'error');
        console.error('Error updating profile:', error);
      }
    },
    
    async saveNotificationSettings() {
      try {
        console.log('Saving notification settings, current value:', this.user.notifications);
        
        // Use the checkbox value directly from user object
        const updateData = {
          notifications: this.user.notifications
        };
        
        console.log('Sending notification data:', updateData);
        
        const response = await apiService.updateUserSettings(updateData);
        
        if (response.data && response.data.settings) {
          // Update user data with the response
          this.user = response.data.settings;
          this.showMessage('Notification settings updated', 'success');
          
          // Log the updated value
          console.log('Updated notification value:', this.user.notifications);
        }
      } catch (error) {
        this.showMessage('Error updating notification settings. Please try again.', 'error');
        console.error('Error updating notification settings:', error);
      }
    },
    
    async cancelChanges() {
      try {
        const response = await apiService.cancelChanges();
        
        if (response.data && response.data.settings) {
          // If we get full settings back
          if (response.data.settings.name) {
            this.user = response.data.settings;
            
            // Reset userProfile
            this.userProfile = {
              name: this.user.name,
              username: this.user.username,
              email: this.user.email
            };
            
            // Reset password fields
            this.passwords.current = '';
            this.passwords.new = '';
            this.passwords.confirm = '';
            
            // Update profile image URL
            this.updateProfileImageUrl();
          } 
          // If we only get partial settings (like just the profile_image)
          else if (response.data.settings.profile_image) {
            this.user.profile_image = response.data.settings.profile_image;
            this.updateProfileImageUrl();
          }
          
          this.showMessage('Changes cancelled', 'success');
        }
      } catch (error) {
        this.showMessage('Error cancelling changes. Please try again.', 'error');
        console.error('Error cancelling changes:', error);
      }
    },
    
    async handleImageUpload(event) {
      const file = event.target.files[0];
      if (!file) return;
      
      // Validate file size and type
      if (file.size > 2 * 1024 * 1024) {
        this.showMessage('Image size should be less than 2MB', 'error');
        return;
      }
      
      const validTypes = ['image/jpeg', 'image/png', 'image/jpg', 'image/gif'];
      if (!validTypes.includes(file.type)) {
        this.showMessage('Please select a valid image file (JPEG, PNG, JPG, GIF)', 'error');
        return;
      }
      
      try {
        // Create form data for the file upload
        const formData = new FormData();
        formData.append('profile_image', file);
        
        // Send the image to the server
        const response = await apiService.uploadProfileImage(formData);
        
        if (response.data && response.data.image) {
          // Update the profile image path
          this.user.profile_image = response.data.image;
          this.updateProfileImageUrl();
          this.showMessage('Profile picture updated temporarily. Click Save to apply changes.', 'success');
        }
      } catch (error) {
        this.showMessage('Error uploading image. Please try again.', 'error');
        console.error('Error uploading image:', error);
      }
    },
    
    async deleteProfileImage() {
      try {
        const response = await apiService.deleteProfileImage();
        
        if (response.data && response.data.image) {
          // Update the profile image path
          this.user.profile_image = response.data.image;
          this.updateProfileImageUrl();
          this.showMessage('Profile picture marked for deletion. Click Save to apply changes.', 'success');
        }
      } catch (error) {
        this.showMessage('Error deleting image. Please try again.', 'error');
        console.error('Error deleting image:', error);
      }
    },
    
    async savePaymentMethod() {
      // Simple validation
      if (this.editingPaymentMethod.cardNumber.replace(/\s/g, '').length !== 16) {
        this.showMessage('Please enter a valid card number', 'error');
        return;
      }
      
      try {
        // Format payment details for the API
        const paymentData = {
          payment_method: 'credit_card',
          payment_method_details: JSON.stringify({
            last4: this.editingPaymentMethod.cardNumber.slice(-4),
            expMonth: this.editingPaymentMethod.expMonth,
            expYear: this.editingPaymentMethod.expYear,
            cardholderName: this.editingPaymentMethod.cardholderName
          })
        };
        
        // Send the update request
        const response = await apiService.updateUserSettings(paymentData);
        
        if (response.data && response.data.settings) {
          // Update the user data with the response
          this.user = response.data.settings;
          
          // Update payment method display
          this.paymentMethod = {
            type: this.getCardType(this.editingPaymentMethod.cardNumber),
            last4: this.editingPaymentMethod.cardNumber.slice(-4),
            expMonth: this.editingPaymentMethod.expMonth,
            expYear: this.editingPaymentMethod.expYear
          };
          
          this.showPaymentForm = false;
          this.showMessage('Payment method saved successfully', 'success');
        }
      } catch (error) {
        this.showMessage('Error saving payment method. Please try again.', 'error');
        console.error('Error saving payment method:', error);
      }
    },
    
    async deletePaymentMethod() {
      try {
        // Send empty payment method data to delete
        const paymentData = {
          payment_method: null,
          payment_method_details: null
        };
        
        // Send the update request
        const response = await apiService.updateUserSettings(paymentData);
        
        if (response.data && response.data.settings) {
          // Update the user data with the response
          this.user = response.data.settings;
          
          // Clear payment method display
          this.paymentMethod = null;
          
          this.showMessage('Payment method deleted', 'success');
        }
      } catch (error) {
        this.showMessage('Error deleting payment method. Please try again.', 'error');
        console.error('Error deleting payment method:', error);
      }
    },
    
    async changePlan(planId) {
      try {
        const updateData = {
          subscription_plan: planId
        };
        
        const response = await apiService.updateUserSettings(updateData);
        
        if (response.data && response.data.settings) {
          // Update the user data with the response
          this.user = response.data.settings;
          
          const planName = this.plans.find(p => p.id === planId)?.name || planId;
          this.showMessage(`Subscription updated to ${planName}`, 'success');
        }
      } catch (error) {
        this.showMessage('Error changing subscription plan. Please try again.', 'error');
        console.error('Error changing subscription plan:', error);
      }
    },
    
    async logout() {
      try {
        await apiService.auth.logout();
        // Redirect to login page or home page
        window.location.href = '/login';
      } catch (error) {
        console.error('Error during logout:', error);
        // Still redirect even if there's an error
        window.location.href = '/login';
      }
    },
    
    // UI METHODS
    updateProfileImageUrl() {
      // Check if the profile image is an absolute URL or a relative path
      if (this.user.profile_image && this.user.profile_image.startsWith('http')) {
        this.profileImageUrl = this.user.profile_image;
      } else if (this.user.profile_image) {
        // For relative paths, prepend the storage URL
        this.profileImageUrl = `/storage/${this.user.profile_image}`;
      } else {
        this.profileImageUrl = '';
      }
    },
    
    getProfileImageUrl() {
      return this.profileImageUrl || '/assets/default-avatar.png';
    },
    
    toggleMobileMenu() {
      this.isMobileMenuOpen = !this.isMobileMenuOpen;
      document.body.style.overflow = this.isMobileMenuOpen ? 'hidden' : '';
    },
    
    closeMobileMenu() {
      this.isMobileMenuOpen = false;
      document.body.style.overflow = '';
    },
    
    togglePasswordVisibility(field) {
      this.passwordVisibility[field] = !this.passwordVisibility[field];
    },
    
    getCardType(cardNumber) {
      // Very basic card type detection
      const first = cardNumber.charAt(0);
      if (first === '4') return 'Visa';
      if (first === '5') return 'MasterCard';
      if (first === '3') return 'Amex';
      if (first === '6') return 'Discover';
      return 'Card';
    },
    
    submitSupportRequest() {
      // In a real app, you would submit to backend here
      this.showContactForm = false;
      this.showMessage('Support request submitted successfully', 'success');
      
      // Reset form
      this.supportRequest = {
        subject: '',
        message: '',
        priority: 'medium'
      };
    },
    
    submitBugReport() {
      // In a real app, you would submit to backend here
      this.showBugReportForm = false;
      this.showMessage('Bug report submitted successfully', 'success');
      
      // Reset form
      this.bugReport = {
        title: '',
        description: '',
        steps: '',
        includeSystemInfo: true
      };
    },
    
    showMessage(text, type) {
      this.message = { text, type };
      
      // Clear message after 3 seconds
      setTimeout(() => {
        this.message = null;
      }, 3000);
    }
  }
};
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
   opacity: 0.8;
 }
  
 .setting-container {
   display: flex;
   flex-direction: column;
   padding: 20px;
   max-width: 1400px;
   margin: 0 auto;
   min-height: calc(100vh - 40px);
   position: relative;
   z-index: 1;
 }
  
 /* Header styles */
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
 
 /* Menu toggle button (only visible on mobile) */
 .menu-toggle {
   display: none;
   background: none;
   border: none;
   font-size: 24px;
   cursor: pointer;
   color: #333;
 }
 
 /* Content wrapper */
 .content-wrapper {
   display: flex;
   flex: 1;
   gap: 30px;
 }
 
 /* Sidebar styles */
 .sidebar-settings {
   width: 280px;
   flex-shrink: 0;
   background-color: rgba(255, 255, 255, 0.9);
   border-radius: 12px;
   box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
   padding: 20px;
   display: flex;
   flex-direction: column;
   height: fit-content;
 }
 
 .search-box {
   margin-bottom: 20px;
 }
 
 .search-box input {
   width: 100%;
   padding: 10px 15px;
   border: 1px solid #ddd;
   border-radius: 8px;
   font-size: 14px;
   outline: none;
   transition: border-color 0.3s;
 }
 
 .search-box input:focus {
   border-color: #3498db;
 }
 
 .nav-links {
   display: flex;
   flex-direction: column;
   gap: 10px;
   margin-bottom: 20px;
 }
 
 .nav-link {
   display: flex;
   align-items: center;
   padding: 12px 15px;
   border-radius: 8px;
   text-decoration: none;
   color: #555;
   transition: background-color 0.3s, color 0.3s;
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
 
 .nav-link:hover {
   background-color: #f0f9ff;
 }
 
 .nav-link.active {
   background-color: #e1f5fe;
   color: #0288d1;
   font-weight: 600;
 }
 
 .sidebar-footer {
   margin-top: auto;
   border-top: 1px solid #eee;
   padding-top: 15px;
 }
 
 .user-profile-sidebar {
   display: flex;
   align-items: center;
   margin-bottom: 15px;
 }
 
 .user-avatar-small {
   width: 40px;
   height: 40px;
   border-radius: 50%;
   object-fit: cover;
   margin-right: 10px;
 }
 
 .user-info {
   flex: 1;
 }
 
 .user-name {
   font-weight: 500;
   margin-bottom: 2px;
 }
 
 .membership-badge {
   font-size: 12px;
   background-color: #e1f5fe;
   color: #0288d1;
   padding: 2px 8px;
   border-radius: 12px;
 }
 
 .logout-btn {
   width: 100%;
   padding: 10px;
   border: none;
   border-radius: 8px;
   background-color: #f5f5f5;
   color: #333;
   font-weight: 500;
   cursor: pointer;
   transition: background-color 0.3s;
 }
 
 .logout-btn:hover {
   background-color: #e0e0e0;
 }
 
 /* Main content styles */
 .main-content {
   flex: 1;
   background-color: rgba(255, 255, 255, 0.9);
   border-radius: 12px;
   box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
   padding: 30px;
   min-height: 500px;
 }
 
 /* Alert message */
 .alert {
   padding: 12px 16px;
   border-radius: 8px;
   margin-bottom: 20px;
   font-weight: 500;
 }
 
 .alert.success {
   background-color: #e8f5e9;
   color: #2e7d32;
 }
 
 .alert.error {
   background-color: #ffebee;
   color: #c62828;
 }
 
 /* Tab header */
 .tab-header {
   display: flex;
   border-bottom: 1px solid #eee;
   margin-bottom: 25px;
 }
 
 .tab-link {
   padding: 12px 20px;
   border-bottom: 2px solid transparent;
   margin-right: 10px;
   text-decoration: none;
   color: #666;
   font-weight: 500;
   transition: color 0.3s, border-color 0.3s;
 }
 
 .tab-link:hover {
   color: #333;
 }
 
 .tab-link.active {
   color: #0288d1;
   border-bottom-color: #0288d1;
 }
 
 /* Section styling */
 .section {
   margin-bottom: 30px;
 }
 
 .section-title {
   font-size: 24px;
   margin-bottom: 5px;
   color: #333;
 }
 
 .section-subtitle {
   color: #666;
   margin-bottom: 20px;
 }
 
 /* Profile section */
 .profile-header {
   display: flex;
   justify-content: space-between;
   align-items: center;
   margin-bottom: 25px;
 }
 
 .profile-title {
   flex: 1;
 }
 
 .profile-picture-container {
   display: flex;
   flex-direction: column;
   align-items: center;
 }
 
 .profile-picture {
   width: 100px;
   height: 100px;
   border-radius: 50%;
   object-fit: cover;
   margin-bottom: 10px;
   border: 3px solid white;
   box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
 }
 
 .button-group {
   display: flex;
   gap: 10px;
 }
 
 /* Form styling */
 .form-group {
   margin-bottom: 20px;
 }
 
 .form-label {
   display: block;
   margin-bottom: 8px;
   font-weight: 500;
   color: #333;
 }
 
 .form-control {
   width: 100%;
   padding: 12px 15px;
   border: 1px solid #ddd;
   border-radius: 8px;
   font-size: 15px;
   transition: border-color 0.3s;
 }
 
 .form-control:focus {
   border-color: #0288d1;
   outline: none;
 }
 
 .password-section {
   display: grid;
   grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
   gap: 20px;
 }
 
 .password-input-wrapper {
   position: relative;
 }
 
 .password-input {
   padding-right: 40px;
 }
 
 .toggle-password {
   position: absolute;
   right: 15px;
   top: 50%;
   transform: translateY(-50%);
   width: 20px;
   height: 20px;
   cursor: pointer;
 }
 
 .action-buttons {
   display: flex;
   justify-content: flex-end;
   gap: 15px;
   margin-top: 30px;
 }
 
 /* Button styles */
 .btn {
   padding: 10px 20px;
   border: none;
   border-radius: 8px;
   font-weight: 500;
   cursor: pointer;
   transition: background-color 0.3s, transform 0.1s;
 }
 
 .btn:active {
   transform: translateY(1px);
 }
 
 .btn-primary {
   background-color: #0288d1;
   color: white;
 }
 
 .btn-primary:hover {
   background-color: #0277bd;
 }
 
 .btn-primary:disabled {
   background-color: #b3e5fc;
   cursor: not-allowed;
 }
 
 .btn-secondary {
   background-color: #f0f9ff;
   color: #0288d1;
   border: 1px solid #b3e5fc;
 }
 
 .btn-secondary:hover {
   background-color: #e1f5fe;
 }
 
 .btn-light {
   background-color: #f5f5f5;
   color: #333;
 }
 
 .btn-light:hover {
   background-color: #e0e0e0;
 }
 
 .btn-danger {
   background-color: #ffebee;
   color: #c62828;
 }
 
 .btn-danger:hover {
   background-color: #ffcdd2;
 }
 
 /* Form row for payment form */
 .form-row {
   display: grid;
   grid-template-columns: repeat(auto-fit, minmax(120px, 1fr));
   gap: 15px;
 }
 
 /* Checkbox styling */
 .checkbox-group {
   display: flex;
   align-items: center;
   margin-bottom: 5px;
 }
 
 .checkbox-group input[type="checkbox"] {
   margin-right: 10px;
   width: 18px;
   height: 18px;
 }
 
 .checkbox-description {
   font-size: 14px;
   color: #666;
   margin-left: 28px;
   margin-bottom: 15px;
 }
 
 /* Payment methods */
 .payment-method-card {
   display: flex;
   justify-content: space-between;
   align-items: center;
   background-color: #f9f9f9;
   border-radius: 10px;
   padding: 20px;
   margin-bottom: 20px;
 }
 
 .card-info {
   flex: 1;
 }
 
 .card-type {
   font-weight: 600;
   margin-bottom: 5px;
 }
 
 .card-number {
   color: #666;
   margin-bottom: 5px;
 }
 
 .card-expiry {
   font-size: 14px;
   color: #888;
 }
 
 .card-actions {
   display: flex;
   gap: 10px;
 }
 
 .no-payment-method {
   text-align: center;
   padding: 30px;
   color: #666;
 }
 
 /* Plans styling */
 .plans-container {
   display: grid;
   grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
   gap: 20px;
   margin-top: 20px;
 }
 
 .plan-card {
   background-color: #f9f9f9;
   border-radius: 12px;
   padding: 25px;
   transition: transform 0.3s, box-shadow 0.3s;
 }
 
 .plan-card:hover {
   transform: translateY(-5px);
   box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
 }
 
 .plan-card.current-plan {
   border: 2px solid #0288d1;
   background-color: #f0f9ff;
 }
 
 .plan-header {
   margin-bottom: 20px;
 }
 
 .plan-header h3 {
   font-size: 20px;
   margin-bottom: 10px;
 }
 
 .plan-price {
   font-size: 24px;
   font-weight: 600;
   color: #0288d1;
 }
 
 .plan-features {
   margin-bottom: 25px;
 }
 
 .plan-features ul {
   list-style-position: inside;
   color: #555;
 }
 
 .plan-features li {
   margin-bottom: 10px;
   position: relative;
   padding-left: 5px;
 }
 
 .plan-action {
   text-align: center;
 }
 
 /* Support styles */
 .support-options {
   display: grid;
   grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
   gap: 20px;
 }
 
 .support-card {
   background-color: #f9f9f9;
   border-radius: 12px;
   padding: 25px;
   text-align: center;
 }
 
 .support-card h3 {
   margin-bottom: 15px;
 }
 
 .support-card p {
   color: #666;
   margin-bottom: 20px;
 }
 
 /* Modal styling */
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
   z-index: 100;
 }
 
 .modal-content {
   background-color: white;
   border-radius: 12px;
   padding: 30px;
   width: 90%;
   max-width: 500px;
   box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
 }
 
 .modal-content h3 {
   margin-bottom: 20px;
 }
 
 .textarea {
   resize: vertical;
   min-height: 100px;
 }
 
 /* Overlay for mobile menu */
 .overlay {
   position: fixed;
   top: 0;
   left: 0;
   width: 100%;
   height: 100%;
   background-color: rgba(0, 0, 0, 0.5);
   z-index: 98;
   opacity: 0;
   visibility: hidden;
   transition: opacity 0.3s, visibility 0.3s;
 }
 
 .overlay.active {
   opacity: 1;
   visibility: visible;
 }
 
 /* Mobile sidebar */
 .mobile-sidebar {
   position: fixed;
   top: 0;
   left: -300px;
   width: 280px;
   height: 100%;
   background-color: white;
   z-index: 99;
   padding: 20px;
   box-shadow: 2px 0 10px rgba(0, 0, 0, 0.1);
   transition: left 0.3s ease;
   overflow-y: auto;
   display: flex;
   flex-direction: column;
 }
 
 .mobile-sidebar.active {
   left: 0;
 }
 
 .mobile-sidebar-header {
   display: flex;
   justify-content: space-between;
   align-items: center;
   margin-bottom: 20px;
 }
 
 .close-menu {
   background: none;
   border: none;
   font-size: 30px;
   cursor: pointer;
   color: #333;
 }
 
 .mobile-nav-links {
   display: flex;
   flex-direction: column;
   gap: 10px;
   margin-bottom: 30px;
 }
 
 /* Responsive styles */
 @media (max-width: 991px) {
   .content-wrapper {
     flex-direction: column;
   }
   
   .sidebar-settings {
     width: 100%;
     margin-bottom: 20px;
   }
 }
 
 @media (max-width: 768px) {
   .menu-toggle {
     display: block;
   }
   
   .sidebar-settings {
     display: none;
   }
   
   .profile-header {
     flex-direction: column;
     align-items: flex-start;
   }
   
   .profile-picture-container {
     margin-top: 20px;
     align-self: center;
     width: 100%;
   }
   
   .password-section {
     grid-template-columns: 1fr;
   }
   
   .payment-method-card {
     flex-direction: column;
     align-items: flex-start;
   }
   
   .card-info {
     margin-bottom: 15px;
   }
   
   .plans-container {
     grid-template-columns: 1fr;
   }
   
   .action-buttons {
     flex-direction: column;
     gap: 10px;
   }
   
   .btn {
     width: 100%;
   }
 }
 
 @media (max-width: 480px) {
   .setting-container {
     padding: 15px;
   }
   
   .main-content {
     padding: 20px;
   }
   
   .section-title {
     font-size: 20px;
   }
   
   .tab-header {
     overflow-x: auto;
     white-space: nowrap;
     -webkit-overflow-scrolling: touch;
     padding-bottom: 5px;
   }
   
   .tab-link {
     padding: 10px 15px;
   }
   
   .form-row {
     grid-template-columns: 1fr;
   }
   
   .support-options {
     grid-template-columns: 1fr;
   }
   
   .modal-content {
     padding: 20px;
   }
   
   .profile-picture {
     width: 80px;
     height: 80px;
   }
 }
 
 /* Custom styles for specific form elements */
 .form-group.password-field {
   position: relative;
 }
 
 .user-profile-sidebar img {
   object-fit: cover;
 }
</style>