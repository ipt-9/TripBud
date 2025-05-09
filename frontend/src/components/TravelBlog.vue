<!-- TravelBlog.vue -->
<template>
  <div class="tb-blog-container">
    <header class="tb-header">
      <div class="tb-logo-container">
        <img v-for="img in images" :key="img" :src="img" class="tb-logo" />
        <h1>Travel Blog</h1>
      </div>
      <img :src="accountImages" class="tb-settings-icon" @click="openSettings" />
    </header>
   
    <div class="tb-main-layout">
      <nav class="tb-sidebar">
        <div class="tb-sidebar-item" :class="{ 'tb-active': activePage === 'dashboard' }" @click="navigate('dashboard')">
          <img :src="dashboardImages[0]" class="tb-sidebar-icons"/>
        </div>
        <div class="tb-sidebar-item" :class="{ 'tb-active': activePage === 'chat' }" @click="navigate('chat')">
          <img :src="chatImages[0]" class="tb-sidebar-icons"/>
        </div>
        <div class="tb-sidebar-item" :class="{ 'tb-active': activePage === 'documents' }" @click="navigate('documents')">
          <img :src="documentsImages[0]" class="tb-sidebar-icons"/>
        </div>
        <div class="tb-sidebar-item" :class="{ 'tb-active': activePage === 'schedule' }" @click="navigate('schedule')">
          <img :src="scheduleImages[0]" class="tb-sidebar-icons"/>
        </div>
        <div class="tb-sidebar-item" :class="{ 'tb-active': activePage === 'budgetplaner' }" @click="navigate('budgetplaner')">
          <img :src="budgetplanerImages[0]" class="tb-sidebar-icons"/>
        </div>
        <div class="tb-sidebar-item" :class="{ 'tb-active': activePage === 'travelblog' }" @click="navigate('travelblog')">
          <img :src="blogImages[0]" class="tb-sidebar-icons"/>
        </div>
      </nav>
      
      <div class="tb-blog-content">
        <div class="tb-blog-sidebar">
          <div class="tb-trip-selection">
            <h3>My Trips</h3>
            <div class="tb-trip-select">
              <select v-model="selectedTrip" @change="changeTrip">
                <option v-for="(trip, index) in trips" :key="index" :value="trip.id">{{ trip.name }}</option>
              </select>
            </div>
          </div>
          
          <div class="tb-day-navigation">
            <div 
              v-for="day in days" 
              :key="day.id" 
              class="tb-day-nav-item" 
              :class="{ 'tb-active': day.id === selectedDay }"
              @click="selectDay(day.id)"
            >
              <div class="tb-day-title">{{ day.title }}</div>
              <div class="tb-day-date">{{ day.date }}</div>
            </div>
          </div>
          
          <div class="tb-blog-actions">
            <button class="tb-action-button tb-create-new" @click="createNewDay">
              <span class="tb-icon">+</span> New Day
            </button>
            <button class="tb-action-button tb-export" @click="exportBlog">
              <span class="tb-icon">↓</span> Export
            </button>
          </div>
        </div>
        
        <div class="tb-blog-editor">
          <div class="tb-blog-header">
            <input 
              type="text" 
              class="tb-day-title-input" 
              v-model="currentDayTitle" 
              placeholder="Day Title"
            />
            <div class="tb-blog-header-actions">
              <div class="tb-date-picker">
                <input type="date" v-model="currentDayDate" />
              </div>
              <button class="tb-save-button" @click="saveDay">Save</button>
            </div>
          </div>
          
          <div class="tb-content-editor">
            <div class="tb-section-editor">
              <input 
                type="text" 
                class="tb-section-title-input" 
                v-model="currentSectionTitle" 
                placeholder="Section Title"
              />
              <textarea 
                v-model="currentSectionContent" 
                class="tb-section-content-textarea"
                placeholder="Write about your adventures..."
              ></textarea>
            </div>
            
            <div class="tb-media-section">
              <h3>Photos & Media</h3>
              <div class="tb-media-gallery">
                <div v-for="(photo, index) in currentDayPhotos" :key="index" class="tb-media-item">
                  <img :src="photo.url" alt="Travel photo" />
                  <div class="tb-media-overlay">
                    <button class="tb-delete-media" @click="removePhoto(index)">×</button>
                  </div>
                </div>
                <div class="tb-upload-photo-container" @click="openUploadDialog">
                  <div class="tb-upload-icon">+</div>
                  <div>Add Photos</div>
                  <input 
                    type="file" 
                    ref="fileUpload" 
                    style="display: none" 
                    accept="image/*" 
                    multiple 
                    @change="handleFileUpload"
                  />
                </div>
              </div>
            </div>
            
            <div class="tb-rating-section">
              <h3>Rate This Day</h3>
              <div class="tb-star-rating">
                <span 
                  v-for="n in 5" 
                  :key="n" 
                  class="tb-star" 
                  :class="{ 'tb-active': n <= currentDayRating }"
                  @click="setRating(n)"
                >★</span>
              </div>
            </div>
            
            <div class="tb-expense-section">
              <h3>Expenses</h3>
              <div class="tb-expense-list">
                <div v-for="(expense, index) in currentDayExpenses" :key="index" class="tb-expense-item">
                  <input 
                    type="text" 
                    v-model="expense.description" 
                    placeholder="Description"
                    class="tb-expense-description"
                  />
                  <input 
                    type="number" 
                    v-model="expense.amount" 
                    placeholder="Amount"
                    class="tb-expense-amount"
                  />
                  <select v-model="expense.category" class="tb-expense-category">
                    <option value="food">Food</option>
                    <option value="transport">Transport</option>
                    <option value="accommodation">Accommodation</option>
                    <option value="entertainment">Entertainment</option>
                    <option value="shopping">Shopping</option>
                    <option value="other">Other</option>
                  </select>
                  <button class="tb-delete-expense" @click="removeExpense(index)">×</button>
                </div>
                <button class="tb-add-expense" @click="addExpense">+ Add Expense</button>
              </div>
              <div class="tb-total-expense">
                Total: {{ calculateTotalExpense() }} CHF
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
 
<script>
export default {
  name: 'TravelBlog',
  data() {
    return {
      activePage: 'travelblog',
      images: ['src/assets/TripBudLogo.png'],
      accountImages: 'src/assets/default.png',
      dashboardImages: ['src/assets/dashboard-symbol.png'],
      chatImages: ['src/assets/chat-symbol.png'],
      documentsImages: ['src/assets/document-symbol2.png'],
      scheduleImages: ['src/assets/schedule-symbol.png'],
      budgetplanerImages: ['src/assets/wallet-symbol.png'],
      blogImages: ['src/assets/blog-symbol.png'],
      
      // Trips data
      trips: [
        { id: 1, name: 'Florence Trip' },
        { id: 2, name: 'Paris Weekend' },
        { id: 3, name: 'Swiss Alps Hiking' }
      ],
      selectedTrip: 1,
      
      // Days data
      days: [
        { id: 1, title: 'Day 1', date: 'July 2nd, 2022' },
        { id: 2, title: 'Day 2', date: 'July 3rd, 2022' },
        { id: 3, title: 'Day 3', date: 'July 4th, 2022' },
        { id: 4, title: 'Day 4', date: 'July 5th, 2022' },
        { id: 5, title: 'Day 5', date: 'July 6th, 2022' },
        { id: 6, title: 'Day 6', date: 'July 7th, 2022' }
      ],
      selectedDay: 1,
      
      // Current day content
      currentDayTitle: 'Day 1',
      currentDayDate: '2022-07-02',
      currentSectionTitle: 'Bike Trip',
      currentSectionContent: 'Lorem ipsum dolor sit amet. Et deleniti amet qui accusantium autem et nulla voluptas et similique adipisci. Quo cupiditate deserunt qui maiores molestiae qui voluptatem accusamus quo neque unde aut enim quia sit fugit totam. Id repellat voluptatem quo laudantium dolor quo natus dicta. Qui quidem alias est dolor aliquam qui iusto galisum ut harum deleniti. Ut harum quia ab dolorem placeat 33 molestiae laboriosam sed inventore tenetur. Vel laudantium voluptatibus et odio voluptates eum voluptates iusto vel facere laudantium? Ea necessitatibus beatae et temporibus nobis id quaerat maxime nam consequatur voluptas rem dolor voluptatem? Ut reiciendis voluptatum et impedit dignissimos sit sequi quia.',
      currentDayRating: 4,
      currentDayPhotos: [
        { url: '/api/placeholder/400/300', id: 1 },
        { url: '/api/placeholder/400/300', id: 2 },
        { url: '/api/placeholder/400/300', id: 3 }
      ],
      currentDayExpenses: [
        { description: 'Lunch at Trattoria', amount: 45, category: 'food' },
        { description: 'Bike rental', amount: 20, category: 'transport' },
        { description: 'Museum tickets', amount: 35, category: 'entertainment' }
      ]
    }
  },
  methods: {
    navigate(page) {
      this.activePage = page;
      this.$router.push('/' + page);
    },
    openSettings() {
      this.$router.push('/settings');
    },
    changeTrip() {
      // Logic to change the trip would go here
      console.log('Changed to trip:', this.selectedTrip);
      // Normally would load days for the selected trip
    },
    selectDay(dayId) {
      this.selectedDay = dayId;
      // This would normally load the day content from API
      const day = this.days.find(d => d.id === dayId);
      if (day) {
        this.currentDayTitle = day.title;
        this.currentDayDate = this.formatDateForInput(day.date);
      }
    },
    formatDateForInput(dateString) {
      // Convert displayed date format to input date format
      // This is a simple implementation - production code would use a proper date library
      if (dateString.includes('July')) {
        const day = dateString.match(/\d+/)[0];
        return `2022-07-${day.padStart(2, '0')}`;
      }
      return '2022-07-01';
    },
    createNewDay() {
      const newId = Math.max(...this.days.map(d => d.id)) + 1;
      const today = new Date();
      const formattedDate = today.toLocaleDateString('en-US', { 
        month: 'long', 
        day: 'numeric', 
        year: 'numeric' 
      });
      
      this.days.push({
        id: newId,
        title: `Day ${newId}`,
        date: formattedDate
      });
      
      this.selectDay(newId);
      this.currentSectionTitle = '';
      this.currentSectionContent = '';
      this.currentDayRating = 0;
      this.currentDayPhotos = [];
      this.currentDayExpenses = [];
    },
    saveDay() {
      // Save current day logic would go here
      alert('Day saved successfully!');
    },
    exportBlog() {
      // Export logic would go here
      alert('Blog export started. Your PDF will be ready shortly.');
    },
    openUploadDialog() {
      this.$refs.fileUpload.click();
    },
    handleFileUpload(event) {
      const files = event.target.files;
      if (!files.length) return;
      
      // For demo purposes, we'll just create placeholder images
      // In a real app, you would upload these to a server
      Array.from(files).forEach(file => {
        this.currentDayPhotos.push({
          url: '/api/placeholder/400/300',
          id: Date.now() + Math.floor(Math.random() * 1000)
        });
      });
      
      // Reset file input
      this.$refs.fileUpload.value = '';
    },
    removePhoto(index) {
      this.currentDayPhotos.splice(index, 1);
    },
    setRating(rating) {
      this.currentDayRating = rating;
    },
    addExpense() {
      this.currentDayExpenses.push({
        description: '',
        amount: null,
        category: 'other'
      });
    },
    removeExpense(index) {
      this.currentDayExpenses.splice(index, 1);
    },
    calculateTotalExpense() {
      return this.currentDayExpenses.reduce((total, expense) => {
        return total + (parseFloat(expense.amount) || 0);
      }, 0);
    }
  }
}

</script>
 
<style>
* {
  font-family: 'Outfit', sans-serif;
}

.tb-blog-container {
  display: flex;
  flex-direction: column;
  background: linear-gradient(to bottom, #e0f2fe, #ffffff);
  background-image: url('~@/assets/lines.png');
  background-size: cover;
  min-height: 100vh;
  position: relative; /* Added to position the fixed sidebar relative to this container */
  padding-bottom: 70px; /* Add padding at the bottom to prevent content from being hidden behind the fixed sidebar */
}
 
.tb-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 1%;
  margin-bottom: 1%;
}
 
.tb-logo {
  width: 50px;
  margin-right: 15px;
  height: 40px;
}

.tb-logo-container {
  display: flex;
}
 
.tb-settings-icon {
  width: 40px;
  height: 40px;
  border-radius: 50%;
  background-color: #333;
  position: relative;
  cursor: pointer;
}
 
.tb-main-layout {
  display: flex;
  flex: 1;
  padding: 0 2rem 2rem;
  gap: 2rem;
}

.tb-sidebar {
  width: 60px;
  background-color: white;
  border-radius: 15px;
  padding: 1.5rem 0;
  display: flex;
  flex-direction: column;
  align-items: center;
  gap: 1.5rem;
  box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
  align-self: flex-start;
}

.tb-sidebar-item {
  width: 40px;
  height: 40px;
  border-radius: 10px;
  display: flex;
  align-items: center;
  justify-content: center;
  cursor: pointer;
  transition: all 0.3s ease;
}
 
.tb-sidebar-item:hover {
  background-color: #e0f2fe;
  transform: scale(1.1);
}
 
.tb-sidebar-icons {
  height: 24px;
  width: 24px;
  transition: all 0.3s ease;
  filter: grayscale(100%) opacity(0.4);
}
 
.tb-sidebar-item.tb-active {
  background-color: #e0f2fe;
}
 
.tb-sidebar-item.tb-active .tb-sidebar-icons {
  filter: none;
  transform: scale(1.2);
}

.tb-blog-content {
  flex: 1;
  display: flex;
  gap: 2rem;
}

.tb-blog-sidebar {
  width: 250px;
  background: white;
  border-radius: 15px;
  padding: 1.5rem;
  display: flex;
  flex-direction: column;
  box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
  height: fit-content;
}

.tb-trip-selection {
  margin-bottom: 2rem;
}

.tb-trip-selection h3 {
  margin-bottom: 0.75rem;
  font-size: 1.2rem;
  font-weight: 600;
  color: #333;
}

.tb-trip-select select {
  width: 100%;
  padding: 0.75rem;
  border-radius: 10px;
  border: 1px solid #e0e0e0;
  background-color: #f9f9f9;
  font-size: 0.9rem;
  cursor: pointer;
}

.tb-day-navigation {
  flex: 1;
  margin-bottom: 2rem;
  overflow-y: auto;
  max-height: 400px;
}

.tb-day-nav-item {
  padding: 1rem;
  border-radius: 10px;
  margin-bottom: 0.5rem;
  cursor: pointer;
  transition: all 0.2s;
  background-color: #f9f9f9;
}

.tb-day-nav-item:hover {
  background-color: #f0f0f0;
}

.tb-day-nav-item.tb-active {
  background-color: #e0f2fe;
}

.tb-day-title {
  font-weight: 600;
  margin-bottom: 0.25rem;
}

.tb-day-date {
  font-size: 0.8rem;
  color: #777;
}

.tb-blog-actions {
  display: flex;
  flex-direction: column;
  gap: 0.75rem;
}

.tb-action-button {
  padding: 0.8rem;
  border-radius: 10px;
  border: none;
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 0.5rem;
  font-weight: 500;
  cursor: pointer;
  transition: all 0.2s;
}

.tb-create-new {
  background-color: #4a90e2;
  color: white;
}

.tb-create-new:hover {
  background-color: #3a80d2;
}

.tb-export {
  background-color: #f0f0f0;
  color: #333;
}

.tb-export:hover {
  background-color: #e0e0e0;
}

.tb-icon {
  font-size: 1.2rem;
}

.tb-blog-editor {
  flex: 1;
  background: white;
  border-radius: 15px;
  display: flex;
  flex-direction: column;
  box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
  overflow: hidden;
}

.tb-blog-header {
  padding: 1.5rem;
  display: flex;
  justify-content: space-between;
  align-items: center;
  border-bottom: 1px solid #f0f0f0;
}

.tb-day-title-input {
  font-size: 1.8rem;
  font-weight: 600;
  border: none;
  width: 60%;
  padding: 0.5rem;
  border-radius: 5px;
}

.tb-day-title-input:focus {
  outline: none;
  background-color: #f9f9f9;
}

.tb-blog-header-actions {
  display: flex;
  align-items: center;
  gap: 1rem;
}

.tb-date-picker input {
  padding: 0.6rem;
  border-radius: 8px;
  border: 1px solid #e0e0e0;
}

.tb-save-button {
  padding: 0.6rem 1.2rem;
  border-radius: 8px;
  border: none;
  background-color: #4a90e2;
  color: white;
  font-weight: 500;
  cursor: pointer;
}

.tb-save-button:hover {
  background-color: #3a80d2;
}

.tb-content-editor {
  flex: 1;
  padding: 1.5rem;
  overflow-y: auto;
}

.tb-section-editor {
  margin-bottom: 2rem;
}

.tb-section-title-input {
  width: 100%;
  font-size: 1.4rem;
  font-weight: 500;
  padding: 0.75rem;
  margin-bottom: 1rem;
  border: 1px solid #e0e0e0;
  border-radius: 8px;
}

.tb-section-content-textarea {
  width: 100%;
  min-height: 200px;
  padding: 1rem;
  line-height: 1.6;
  border: 1px solid #e0e0e0;
  border-radius: 8px;
  resize: vertical;
}

.tb-media-section, .tb-rating-section, .tb-expense-section {
  margin-top: 2rem;
  padding-top: 2rem;
  border-top: 1px solid #f0f0f0;
}

.tb-media-section h3, .tb-rating-section h3, .tb-expense-section h3 {
  margin-bottom: 1rem;
  font-size: 1.2rem;
  font-weight: 600;
}

.tb-media-gallery {
  display: flex;
  gap: 1rem;
  flex-wrap: wrap;
}

.tb-media-item {
  width: 150px;
  height: 150px;
  border-radius: 10px;
  overflow: hidden;
  position: relative;
}

.tb-media-item img {
  width: 100%;
  height: 100%;
  object-fit: cover;
}

.tb-media-overlay {
  position: absolute;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background: rgba(0, 0, 0, 0.2);
  opacity: 0;
  transition: opacity 0.2s;
  display: flex;
  align-items: flex-start;
  justify-content: flex-end;
}

.tb-media-item:hover .tb-media-overlay {
  opacity: 1;
}

.tb-delete-media {
  background: white;
  border: none;
  width: 24px;
  height: 24px;
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 1rem;
  font-weight: bold;
  margin: 0.5rem;
  cursor: pointer;
}

.tb-upload-photo-container {
  width: 150px;
  height: 150px;
  border-radius: 10px;
  border: 2px dashed #e0e0e0;
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  cursor: pointer;
  transition: all 0.2s;
  color: #777;
}

.tb-upload-photo-container:hover {
  border-color: #4a90e2;
  color: #4a90e2;
}

.tb-upload-icon {
  font-size: 2rem;
  margin-bottom: 0.5rem;
}

.tb-star-rating {
  display: flex;
  gap: 0.5rem;
}

.tb-star {
  font-size: 2rem;
  color: #ddd;
  cursor: pointer;
  transition: color 0.2s;
}

.tb-star:hover, .tb-star.tb-active {
  color: #ffc107;
}

.tb-expense-list {
  display: flex;
  flex-direction: column;
  gap: 0.75rem;
  margin-bottom: 1rem;
}

.tb-expense-item {
  display: flex;
  gap: 0.75rem;
  align-items: center;
}

.tb-expense-description {
  flex: 2;
  padding: 0.6rem;
  border-radius: 8px;
  border: 1px solid #e0e0e0;
}

.tb-expense-amount {
  width: 100px;
  padding: 0.6rem;
  border-radius: 8px;
  border: 1px solid #e0e0e0;
}

.tb-expense-category {
  width: 150px;
  padding: 0.6rem;
  border-radius: 8px;
  border: 1px solid #e0e0e0;
  background-color: white;
}

.tb-delete-expense {
  width: 30px;
  height: 30px;
  border-radius: 50%;
  border: none;
  background-color: #f0f0f0;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 1rem;
  font-weight: bold;
  cursor: pointer;
}

.tb-add-expense {
  padding: 0.6rem;
  border-radius: 8px;
  border: 1px dashed #e0e0e0;
  background-color: #f9f9f9;
  color: #777;
  cursor: pointer;
  transition: all 0.2s;
}

.tb-add-expense:hover {
  border-color: #4a90e2;
  color: #4a90e2;
}

.tb-total-expense {
  font-weight: 600;
  text-align: right;
  padding: 1rem 0;
  font-size: 1.1rem;
}

@media (max-width: 1200px) {
  .tb-blog-content {
    flex-direction: column;
  }
  
  .tb-blog-sidebar {
    width: 100%;
  }
}

@media (max-width: 768px) {
  .tb-sidebar {
    display: flex;
    flex-direction: row; /* Explicitly set to horizontal layout */
    justify-content: space-around;
    align-items: center;
    background-color: white;
    box-shadow: 0 -1px 5px rgba(0, 0, 0, 0.1);
    height: 60px;
    position: fixed;
    bottom: 0;
    left: 0;
    right: 0;
    width: 100%;
    z-index: 100;
    padding: 0 2rem;
  }
  
  /* Style for the items inside the navbar */
  .tb-sidebar > * {
    margin: 0 5px; /* Add some spacing between items */
  }
}

@media (max-width: 480px) {
  .tb-expense-item {
    flex-direction: column;
    align-items: stretch;
  }
  
  .tb-expense-description, .tb-expense-amount, .tb-expense-category {
    width: 100%;
  }
  
  .tb-delete-expense {
    align-self: flex-end;
  }
  
  .tb-blog-header-actions {
    flex-direction: column;
    align-items: stretch;
    width: 100%;
  }
  
  /* Make the sidebar more compact on very small screens */
  .tb-sidebar {
    padding: 0 0.5rem;
  }
  
  .tb-sidebar-item {
    width: 35px;
    height: 35px;
  }
}
</style>