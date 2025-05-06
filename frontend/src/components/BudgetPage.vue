<template>
  <div class="app-container">
    <!-- Main Content -->
    <div class="budget-planner">
      <header class="header">
        <div class="logo-container">
          <img v-for="img in images" :src="img" class="logo" />
          <h1>Budget Planer</h1>
        </div>
        <img :src="accountImages[0]" class="settings-icon" @click="openSettings" />
      </header>
      
      <section class="section budget-section">
        <div class="budget-header">
          <h2 class="section-title">Budget Overview</h2>
          <div class="total-budget">
            <span class="total-amount">{{ formatCurrency(totalBudget) }}</span>
            <span class="total-difference" :class="{ 'positive': totalDifference > 0, 'negative': totalDifference < 0 }">
              {{ totalDifference > 0 ? '+' : '' }}{{ formatCurrency(totalDifference) }}
            </span>
          </div>
        </div>
       
        <!-- Time Period Tabs -->
        <div class="budget-tabs">
          <button
            v-for="tab in timePeriodTabs"
            :key="tab.value"
            class="budget-tab"
            :class="{ active: activeTimePeriod === tab.value }"
            @click="setActiveTimePeriod(tab.value)"
          >
            {{ tab.label }}
          </button>
        </div>
       
        <!-- Date Selection -->
        <div class="budget-days" v-if="activeTimePeriod === 'day'">
          <div
            v-for="(date, index) in dateTabs"
            :key="index"
            class="day-tab"
            :class="{ active: activeDate === date.value }"
            @click="setActiveDate(date.value)"
          >
            {{ date.label }}
          </div>
          <div class="day-tab add-date" @click="showDatePicker = !showDatePicker">
            <span class="add-icon">+</span>
          </div>
        </div>
       
        <div v-if="showDatePicker" class="date-picker">
          <input type="date" v-model="selectedDate" @change="addCustomDate">
        </div>
       
        <!-- Month Selection -->
        <div class="budget-months" v-if="activeTimePeriod === 'month'">
          <div
            v-for="(month, index) in monthTabs"
            :key="index"
            class="month-tab"
            :class="{ active: activeMonth === month.value }"
            @click="setActiveMonth(month.value)"
          >
            {{ month.label }}
          </div>
        </div>
       
        <!-- Year Selection -->
        <div class="budget-years" v-if="activeTimePeriod === 'year'">
          <div
            v-for="(year, index) in yearTabs"
            :key="index"
            class="year-tab"
            :class="{ active: activeYear === year.value }"
            @click="setActiveYear(year.value)"
          >
            {{ year.label }}
          </div>
        </div>
       
        <!-- Budget Cards -->
        <div class="budget-cards">
          <div
            v-for="(category, index) in filteredCategories"
            :key="index"
            class="budget-card"
            :class="category.color"
          >
            <div class="budget-icon" :class="category.icon">
              <i :class="'fas ' + category.iconClass"></i>
            </div>
            <div class="budget-amount">
              <div class="amount-main">{{ formatCurrency(category.amount) }}</div>
              <div class="amount-diff" :class="{ 'positive': category.difference > 0 }">
                {{ category.difference > 0 ? '+' : '' }}{{ formatCurrency(category.difference) }}
              </div>
            </div>
            <div class="budget-category-name">{{ category.name }}</div>
          </div>
         
          <div class="budget-card add-category" @click="showAddCategoryModal = true">
            <div class="add-category-content">
              <span class="add-icon">+</span>
              <span class="add-text">Add Category</span>
            </div>
          </div>
        </div>
       
        <!-- Summary Section -->
        <div class="budget-summary">
          <div class="summary-header">
            <h3>Spending Summary</h3>
            <div class="summary-controls">
              <button class="summary-toggle" @click="summaryView = 'chart'" :class="{ active: summaryView === 'chart' }">Chart</button>
              <button class="summary-toggle" @click="summaryView = 'table'" :class="{ active: summaryView === 'table' }">Table</button>
            </div>
          </div>
         
          <div class="summary-content">
            <!-- Chart View -->
            <div class="summary-chart" v-if="summaryView === 'chart'">
              <div class="chart-container">
                <div class="pie-chart">
                  <div
                    v-for="(category, index) in filteredCategories"
                    :key="index"
                    class="pie-segment"
                    :style="{
                      '--segment-start': category.chartStart + 'deg',
                      '--segment-end': category.chartEnd + 'deg',
                      '--segment-color': category.chartColor
                    }"
                  ></div>
                </div>
                <div class="chart-legend">
                  <div
                    v-for="(category, index) in filteredCategories"
                    :key="index"
                    class="legend-item"
                  >
                    <div class="legend-color" :style="{ backgroundColor: category.chartColor }"></div>
                    <div class="legend-text">{{ category.name }}</div>
                    <div class="legend-percentage">{{ calculatePercentage(category.amount) }}%</div>
                  </div>
                </div>
              </div>
            </div>
           
            <!-- Table View -->
            <div class="summary-table" v-if="summaryView === 'table'">
              <table>
                <thead>
                  <tr>
                    <th>Category</th>
                    <th>Amount</th>
                    <th>% of Total</th>
                    <th>Change</th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="(category, index) in filteredCategories" :key="index">
                    <td>{{ category.name }}</td>
                    <td>{{ formatCurrency(category.amount) }}</td>
                    <td>{{ calculatePercentage(category.amount) }}%</td>
                    <td :class="{ 'positive': category.difference > 0, 'negative': category.difference < 0 }">
                      {{ category.difference > 0 ? '+' : '' }}{{ formatCurrency(category.difference) }}
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </section>
     
      <!-- Add Category Modal -->
      <div class="modal" v-if="showAddCategoryModal">
        <div class="modal-content">
          <div class="modal-header">
            <h3>Add New Budget Category</h3>
            <button class="close-btn" @click="showAddCategoryModal = false">&times;</button>
          </div>
          <div class="modal-body">
            <div class="form-group">
              <label for="categoryName">Category Name</label>
              <input type="text" id="categoryName" v-model="newCategory.name" placeholder="Enter category name">
            </div>
            <div class="form-group">
              <label for="categoryAmount">Amount (CHF)</label>
              <input type="number" id="categoryAmount" v-model="newCategory.amount" placeholder="Enter amount">
            </div>
            <div class="form-group">
              <label for="categoryDifference">Difference (CHF)</label>
              <input type="number" id="categoryDifference" v-model="newCategory.difference" placeholder="Enter difference">
            </div>
            <div class="form-group">
              <label>Color</label>
              <div class="color-options">
                <div
                  v-for="color in colorOptions"
                  :key="color.value"
                  class="color-option"
                  :class="[color.value, { selected: newCategory.color === color.value }]"
                  @click="newCategory.color = color.value"
                ></div>
              </div>
            </div>
            <div class="form-group">
              <label>Icon</label>
              <div class="icon-options">
                <div
                  v-for="icon in iconOptions"
                  :key="icon.value"
                  class="icon-option"
                  :class="{ selected: newCategory.icon === icon.value }"
                  @click="newCategory.icon = icon.value; newCategory.iconClass = icon.class"
                >
                  <i :class="'fas ' + icon.class"></i>
                </div>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button class="cancel-btn" @click="showAddCategoryModal = false">Cancel</button>
            <button class="save-btn" @click="addCategory">Save</button>
          </div>
        </div>
      </div>
    </div>
    
    <!-- Sidebar -->
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
      <div class="sidebar-item" :class="{ active: activePage === 'blog' }" @click="navigate('blog')">
        <img :src="blogImages[0]" class="sidebar-icons"/>
      </div>
    </nav>
  </div>
</template>

<script>
export default {
  name: 'BudgetPlanner',
  data() {
    return {
      // Sidebar data
      activePage: 'budgetplaner',
      images: ['src/assets/TripBudLogo.png'],
      accountImages: ['src/assets/account-symbol.png'],
      dashboardImages: ['src/assets/dashboard-symbol.png'],
      chatImages: ['src/assets/chat-symbol.png'],
      documentsImages: ['src/assets/document-symbol2.png'],
      scheduleImages: ['src/assets/schedule-symbol.png'],
      budgetplanerImages: ['src/assets/wallet-symbol.png'],
      blogImages: ['src/assets/blog-symbol.png'],
     
      // Budget planner data
      activeTimePeriod: 'day',
      activeDate: 'today',
      activeMonth: 'current',
      activeYear: '2025',
      showDatePicker: false,
      selectedDate: '',
      showAddCategoryModal: false,
      summaryView: 'chart',
     
      timePeriodTabs: [
        { label: 'Day', value: 'day' },
        { label: 'Month', value: 'month' },
        { label: 'Year', value: 'year' }
      ],
     
      dateTabs: [

      ],
     
      monthTabs: [
        { label: 'January', value: '2025-01' },
        { label: 'February', value: '2025-02' },
        { label: 'March', value: '2025-03' },
        { label: 'April', value: '2025-04' },
        { label: 'Current', value: 'current' }
      ],
     
      yearTabs: [
        { label: '2023', value: '2023' },
        { label: '2024', value: '2024' },
        { label: '2025', value: '2025' }
      ],
     
      categories: [
      ],
     
      newCategory: {
        name: '',
        amount: 0,
        difference: 0,
        color: 'purple',
        icon: 'hotel-icon',
        iconClass: 'fa-hotel',
        chartColor: '#9c27b0'
      },
     
      colorOptions: [
        { label: 'Purple', value: 'purple', color: '#9c27b0' },
        { label: 'Pink', value: 'pink', color: '#e91e63' },
        { label: 'Teal', value: 'teal', color: '#009688' },
        { label: 'Yellow', value: 'yellow', color: '#ffc107' },
        { label: 'Orange', value: 'orange', color: '#ff9800' },
        { label: 'Blue', value: 'blue', color: '#2196f3' },
        { label: 'Green', value: 'green', color: '#4caf50' },
        { label: 'Red', value: 'red', color: '#f44336' }
      ],
     
      iconOptions: [
        { label: 'Hotel', value: 'hotel-icon', class: 'fa-hotel' },
        { label: 'Building', value: 'building-icon', class: 'fa-building' },
        { label: 'Transport', value: 'transport-icon', class: 'fa-bus' },
        { label: 'Entertainment', value: 'entertainment-icon', class: 'fa-film' },
        { label: 'Food', value: 'food-icon', class: 'fa-utensils' },
        { label: 'Shopping', value: 'shopping-icon', class: 'fa-shopping-bag' },
        { label: 'Health', value: 'health-icon', class: 'fa-heartbeat' },
        { label: 'Education', value: 'education-icon', class: 'fa-graduation-cap' }
      ]
    };
  },
 
  computed: {
    totalBudget() {
      return this.filteredCategories.reduce((total, category) => total + category.amount, 0);
    },
   
    totalDifference() {
      return this.filteredCategories.reduce((total, category) => total + category.difference, 0);
    },
   
    filteredCategories() {
      // In a real app, you would filter based on selected time period
      // For this example, we'll just return all categories with updated chart angles
      let categories = [...this.categories];
      let total = categories.reduce((sum, cat) => sum + cat.amount, 0);
      let currentAngle = 0;
     
      // Calculate chart segments
      categories.forEach(category => {
        const percentage = (category.amount / total) * 100;
        const segmentDegrees = (percentage / 100) * 360;
       
        category.chartStart = currentAngle;
        category.chartEnd = currentAngle + segmentDegrees;
        currentAngle += segmentDegrees;
      });
     
      return categories;
    }
  },
 
  methods: {
    // Sidebar navigation
    navigate(page) {
      this.activePage = page;
      this.$router.push('/' + page);
    },
   
    // Budget planner methods
    setActiveTimePeriod(period) {
      this.activeTimePeriod = period;
    },
   
    setActiveDate(date) {
      this.activeDate = date;
    },
   
    setActiveMonth(month) {
      this.activeMonth = month;
    },
   
    setActiveYear(year) {
      this.activeYear = year;
    },
   
    addCustomDate() {
      if (this.selectedDate) {
        const date = new Date(this.selectedDate);
        const formattedDate = `${date.getDate().toString().padStart(2, '0')}.${(date.getMonth() + 1).toString().padStart(2, '0')}`;
       
        // Check if date already exists
        const existingDate = this.dateTabs.find(tab => tab.value === this.selectedDate);
        if (!existingDate) {
          this.dateTabs.push({
            label: formattedDate,
            value: this.selectedDate
          });
          this.setActiveDate(this.selectedDate);
        }
       
        this.showDatePicker = false;
      }
    },
   
    addCategory() {
      if (this.newCategory.name && this.newCategory.amount) {
        // Find matching color's chart color
        const colorObj = this.colorOptions.find(c => c.value === this.newCategory.color);
        if (colorObj) {
          this.newCategory.chartColor = colorObj.color;
        }
       
        // Add the new category
        this.categories.push({...this.newCategory});
       
        // Reset form
        this.newCategory = {
          name: '',
          amount: 0,
          difference: 0,
          color: 'purple',
          icon: 'hotel-icon',
          iconClass: 'fa-hotel',
          chartColor: '#9c27b0'
        };
       
        this.showAddCategoryModal = false;
      }
    },
   
    formatCurrency(value) {
      return `${value} CHF`;
    },
   
    calculatePercentage(amount) {
      const total = this.categories.reduce((sum, cat) => sum + cat.amount, 0);
      return Math.round((amount / total) * 100);
    },
    
    openSettings() {
      // In a real app, you would handle settings here
      console.log('Opening settings');
    }
  }
};
</script>

<style scoped>
/* Layout */
.app-container {
  display: flex;
  flex-direction: row-reverse;
  gap: 2rem;
  padding: 1.5rem;
  min-height: 100vh;
  background-image: url('../assets/lines.png');
}

/* Header Styles */
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

.settings-icon {
  width: 40px;
  height: 40px;
  border-radius: 50%;
  cursor: pointer;
}

/* Sidebar Styles */
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
  align-self: flex-start;
  margin-top: 80px;
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

/* Budget Planner Styles */
.budget-planner {
  flex: 1;
  font-family: Arial, sans-serif;
  max-width: 100%;
}

.section {
  padding: 1.5rem;
  background-color: #fff;
  border-radius: 15px;
  box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
}

.section-title {
  margin-top: 0;
  margin-bottom: 1.5rem;
  font-size: 1.5rem;
  font-weight: 600;
}

.budget-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 1rem;
}

.total-budget {
  text-align: right;
}

.total-amount {
  display: block;
  font-size: 1.5rem;
  font-weight: 600;
}

.total-difference {
  font-size: 1rem;
  color: #ff5252;
}

.total-difference.positive {
  color: #4caf50;
}

/* Tabs */
.budget-tabs {
  display: flex;
  gap: 0.5rem;
  margin-bottom: 1.5rem;
  flex-wrap: wrap;
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

/* Date Tabs */
.budget-days, .budget-months, .budget-years {
  display: flex;
  gap: 0.5rem;
  margin-bottom: 1.5rem;
  overflow-x: auto;
  padding-bottom: 0.5rem;
  flex-wrap: wrap;
}

.day-tab, .month-tab, .year-tab {
  padding: 0.5rem 1rem;
  border-radius: 20px;
  background-color: #f0f0f0;
  cursor: pointer;
  white-space: nowrap;
  transition: all 0.2s;
}

.day-tab:hover, .month-tab:hover, .year-tab:hover {
  background-color: #e5e5e5;
}

.day-tab.active, .month-tab.active, .year-tab.active {
  background-color: #333;
  color: white;
}

.add-date {
  background-color: #e0e0e0;
}

.add-icon {
  font-weight: bold;
  font-size: 1.1rem;
}

.date-picker {
  margin-bottom: 1rem;
}

.date-picker input {
  padding: 0.5rem;
  border: 1px solid #ddd;
  border-radius: 4px;
}

/* Budget Cards */
.budget-cards {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(240px, 1fr));
  gap: 1rem;
}

.budget-card {
  border-radius: 15px;
  padding: 1.25rem;
  display: flex;
  flex-direction: column;
  position: relative;
  min-height: 120px;
  transition: transform 0.2s, box-shadow 0.2s;
}

.budget-card:hover {
  transform: translateY(-3px);
  box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
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

.budget-card.orange {
  background-color: #fff3e0;
}

.budget-card.blue {
  background-color: #e3f2fd;
}

.budget-card.green {
  background-color: #e8f5e9;
}

.budget-card.red {
  background-color: #ffebee;
}

.budget-icon {
  width: 40px;
  height: 40px;
  border-radius: 10px;
  margin-bottom: 1rem;
  background-color: white;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 1.3rem;
  box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
}

.budget-amount {
  margin-bottom: 0.5rem;
}

.amount-main {
  font-weight: 600;
  font-size: 1.3rem;
}

.amount-diff {
  color: #ff5252;
  font-size: 1rem;
}

.amount-diff.positive {
  color: #4caf50;
}

.budget-category-name {
  font-weight: 500;
  margin-top: auto;
  color: #555;
}

.add-category {
  background-color: #f5f5f5;
  display: flex;
  align-items: center;
  justify-content: center;
  cursor: pointer;
  border: 2px dashed #ddd;
}

.add-category:hover {
  background-color: #f0f0f0;
  border-color: #ccc;
}

.add-category-content {
  display: flex;
  flex-direction: column;
  align-items: center;
  color: #777;
}

.add-category .add-icon {
  font-size: 2rem;
  margin-bottom: 0.5rem;
}

.add-text {
  font-weight: 500;
}

/* Summary Section */
.budget-summary {
  margin-top: 2rem;
}

.summary-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 1rem;
}

.summary-header h3 {
  margin: 0;
  font-size: 1.2rem;
}

.summary-controls {
  display: flex;
  gap: 0.5rem;
}

.summary-toggle {
  background: none;
  border: none;
  padding: 0.5rem 1rem;
  border-radius: 20px;
  cursor: pointer;
  transition: all 0.2s;
}

.summary-toggle:hover {
  background-color: #f5f5f5;
}

.summary-toggle.active {
  background-color: #f0f0f0;
  font-weight: 500;
}

.summary-content {
  min-height: 300px;
}

/* Chart View */
.chart-container {
  display: flex;
  align-items: flex-start;
  gap: 2rem;
}

.pie-chart {
  width: 200px;
  height: 200px;
  border-radius: 50%;
  position: relative;
  background-color: #f0f0f0;
  flex-shrink: 0;
}

.pie-segment {
  position: absolute;
  width: 100%;
  height: 100%;
  border-radius: 50%;
  clip-path: polygon(50% 50%, 50% 0%, calc(50% + 50% * cos(var(--segment-start))) calc(50% - 50% * sin(var(--segment-start))), calc(50% + 50% * cos(var(--segment-end))) calc(50% - 50% * sin(var(--segment-end))));
  background-color: var(--segment-color);
}

.chart-legend {
  flex-grow: 1;
}

.legend-item {
  display: flex;
  align-items: center;
  margin-bottom: 0.75rem;
}

.legend-color {
  width: 16px;
  height: 16px;
  border-radius: 4px;
  margin-right: 0.75rem;
}

.legend-text {
  flex-grow: 1;
  font-weight: 500;
}

.legend-percentage {
  font-weight: 600;
  width: 40px;
  text-align: right;
}

/* Table View */
.summary-table {
  overflow-x: auto;
}

table {
  width: 100%;
  border-collapse: collapse;
}

th, td {
  padding: 0.75rem;
  text-align: left;
  border-bottom: 1px solid #eee;
}

th {
  font-weight: 600;
  color: #555;
}

td.positive {
  color: #4caf50;
}

td.negative {
  color: #ff5252;
}

/* Modal */
.modal {
  position: fixed;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background-color: rgba(0, 0, 0, 0.5);
  display: flex;
  align-items: center;
  justify-content: center;
  z-index: 1000;
}

.modal-content {
  background-color: white;
  border-radius: 10px;
  width: 90%;
  max-width: 500px;
  max-height: 90vh;
  overflow-y: auto;
}

.modal-header {
  padding: 1rem 1.5rem;
  border-bottom: 1px solid #eee;
  display: flex;
  justify-content: space-between;
  align-items: center;
}

.modal-header h3 {
  margin: 0;
}

.close-btn {
  background: none;
  border: none;
  font-size: 1.5rem;
  cursor: pointer;
  color: #777;
}

.modal-body {
  padding: 1.5rem;
}

.form-group {
  margin-bottom: 1.5rem;
}

.form-group label {
  display: block;
  margin-bottom: 0.5rem;
  font-weight: 500;
}

.form-group input {
  width: 100%;
  padding: 0.75rem;
  border: 1px solid #ddd;
  border-radius: 5px;
}

.color-options, .icon-options {
  display: grid;
  grid-template-columns: repeat(4, 1fr);
  gap: 0.75rem;
}

.color-option {
  width: 30px;
  height: 30px;
  border-radius: 5px;
  cursor: pointer;
  border: 2px solid transparent;
}

.color-option.selected {
  border-color: #333;
}

.color-option.purple { background-color: #f3e5f5; }
.color-option.pink { background-color: #ffebee; }
.color-option.teal { background-color: #e0f2f1; }
.color-option.yellow { background-color: #fff8e1; }
.color-option.orange { background-color: #fff3e0; }
.color-option.blue { background-color: #e3f2fd; }
.color-option.green { background-color: #e8f5e9; }
.color-option.red { background-color: #ffebee; }

.icon-option {
  width: 40px;
  height: 40px;
  border-radius: 5px;
  background-color: #f5f5f5;
  display: flex;
  align-items: center;
  justify-content: center;
  cursor: pointer;
  border: 2px solid transparent;
}

.icon-option.selected {
  border-color: #333;
  background-color: #e0e0e0;
}

.modal-footer {
  padding: 1rem 1.5rem;
  border-top: 1px solid #eee;
  display: flex;
  justify-content: flex-end;
  gap: 1rem;
}

.cancel-btn, .save-btn {
  padding: 0.75rem 1.5rem;
  border-radius: 5px;
  cursor: pointer;
  font-weight: 500;
}

.cancel-btn {
  background-color: transparent;
  border: 1px solid #ddd;
}

.save-btn {
  background-color: #4caf50;
  border: none;
  color: white;
}

@media (max-width: 768px) {
  .sidebar {
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
  }
  
  .logo h1 {
    font-size: 24px;
  }
  
  /* Style for the items inside the navbar */
  .sidebar > * {
    margin: 0 5px; /* Add some spacing between items */
  }
}
</style>