<template>
  <div class="schedule-container">
    <header class="header">
      <div class="logo-container">
        <img v-for="img in images" :key="img" :src="img" class="logo" />
        <h1>Schedule</h1>
      </div>
      <img :src="accountImages" class="settings-icon" @click="openSettings" />
    </header>

    <div class="main-layout">
      <!-- Desktop sidebar - hidden on mobile -->
      <nav class="sidebar">
        <div class="sidebar-item" :class="{ active: activePage === 'dashboard' }" @click="navigate('dashboard')">
          <img :src="dashboardImages" class="sidebar-icons"/>
        </div>
        <div class="sidebar-item" :class="{ active: activePage === 'chat' }" @click="navigate('chat')">
          <img :src="chatImages" class="sidebar-icons"/>
        </div>
        <div class="sidebar-item" :class="{ active: activePage === 'documents' }" @click="navigate('documents')">
          <img :src="documentsImages" class="sidebar-icons"/>
        </div>
        <div class="sidebar-item" :class="{ active: activePage === 'schedule' }" @click="navigate('schedule')">
          <img :src="scheduleImages" class="sidebar-icons"/>
        </div>
        <div class="sidebar-item" :class="{ active: activePage === 'budgetplaner' }" @click="navigate('budgetplaner')">
          <img :src="budgetplanerImages" class="sidebar-icons"/>
        </div>
        <div class="sidebar-item" :class="{ active: activePage === 'travelblog' }" @click="navigate('travelblog')">
          <img :src="blogImages" class="sidebar-icons"/>
        </div>
      </nav>

      <div class="content">
        <div class="trip-info-panel">
          <div class="trip-info">
            <h2>Trip Florence</h2>
            <p>{{ trip.startDate }} - {{ trip.endDate }}</p>
          </div>

          <h2 class="activities-title">Activities</h2>

          <div class="activity-form">
            <div class="form-group">
              <label>Activity:</label>
              <input type="text" placeholder="..." v-model="newActivity.title" />
            </div>
            
            <div class="form-group">
              <label>From:</label>
              <div class="time-input">
                <input 
                  type="text" 
                  placeholder="00:00" 
                  v-model="newActivity.startTime" 
                  @input="validateStartTime"
                  ref="startTimeInput"
                />
              </div>
            </div>
            
            <div class="form-group">
              <label>To:</label>
              <div class="time-input">
                <input 
                  type="text" 
                  placeholder="00:00" 
                  v-model="newActivity.endTime" 
                  @input="validateEndTime"
                  ref="endTimeInput"
                />
              </div>
            </div>

            <button 
              class="add-activity-btn" 
              @click="addActivity" 
              :disabled="!isValidTimeInput"
            >Add Activity</button>
          </div>
        </div>

        <div class="calendar-section">
          <div class="calendar-header">
            <div class="date-navigation">
              <button @click="previousYear" class="year-nav-btn"><i class="fas fa-angle-double-left"></i></button>
              <button @click="previousMonth" class="month-nav-btn"><i class="fas fa-angle-left"></i></button>
              
              <div class="calendar-date-selector">
                <div class="month-selector" @click="toggleMonthSelector">
                  <span>{{ currentMonth }}</span>
                  <div v-if="showMonthSelector" class="month-dropdown">
                    <div 
                      v-for="(month, index) in months" 
                      :key="month" 
                      @click="selectMonth(index)"
                      :class="{ 'selected-option': index === currentViewDate.getMonth() }"
                    >
                      {{ month }}
                    </div>
                  </div>
                </div>
                
                <div class="year-selector" @click="toggleYearSelector">
                  <span>{{ currentYear }}</span>
                  <div v-if="showYearSelector" class="year-dropdown">
                    <div 
                      v-for="year in yearRange" 
                      :key="year" 
                      @click="selectYear(year)"
                      :class="{ 'selected-option': year === currentViewDate.getFullYear() }"
                    >
                      {{ year }}
                    </div>
                  </div>
                </div>
              </div>
              
              <button @click="nextMonth" class="month-nav-btn"><i class="fas fa-angle-right"></i></button>
              <button @click="nextYear" class="year-nav-btn"><i class="fas fa-angle-double-right"></i></button>
            </div>
          </div>

          <div class="calendar">
            <div class="calendar-days">
              <div class="weekday" v-for="day in weekdays" :key="day">{{ day }}</div>
              <div 
                v-for="date in calendarDays" 
                :key="date.day + '-' + date.month + '-' + date.year" 
                :class="[
                  'calendar-day', 
                  { 'current-month': date.currentMonth },
                  { 'today': date.isToday },
                  { 'in-trip': date.inTrip },
                  { 'trip-start': date.isTripStart },
                  { 'trip-end': date.isTripEnd },
                  { 'selected': date.isSelected }
                ]"
                @click="selectDate(date)"
              >
                {{ date.day }}
              </div>
            </div>
          </div>

          <div class="selected-day-activities" v-if="selectedDateFormatted">
            <h3>{{ selectedDateFormatted }}</h3>
            <div class="activity-list">
              <div class="activity-item" v-for="(activity, index) in activitiesForSelectedDate" :key="index">
                <div class="activity-time">{{ activity.startTime }} - {{ activity.endTime }}</div>
                <div class="activity-content">
                  <div class="activity-title">{{ activity.title }}</div>
                  <div class="activity-icon" v-if="activity.icon">
                    <img :src="activity.icon" alt="" class="activity-icon-img" v-if="activity.icon.includes('/')">
                    <i :class="activity.icon" v-else></i>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    
    <!-- Bottom Navigation Bar - Only shows on mobile -->
    <nav class="mobile-nav">
      <div class="mobile-nav-item" :class="{ active: activePage === 'dashboard' }" @click="navigate('dashboard')">
        <img :src="dashboardImages" class="mobile-nav-icon"/>
      </div>
      <div class="mobile-nav-item" :class="{ active: activePage === 'chat' }" @click="navigate('chat')">
        <img :src="chatImages" class="mobile-nav-icon"/>
      </div>
      <div class="mobile-nav-item" :class="{ active: activePage === 'documents' }" @click="navigate('documents')">
        <img :src="documentsImages" class="mobile-nav-icon"/>
      </div>
      <div class="mobile-nav-item" :class="{ active: activePage === 'schedule' }" @click="navigate('schedule')">
        <img :src="scheduleImages" class="mobile-nav-icon"/>
      </div>
      <div class="mobile-nav-item" :class="{ active: activePage === 'budgetplaner' }" @click="navigate('budgetplaner')">
        <img :src="budgetplanerImages" class="mobile-nav-icon"/>
      </div>
      <div class="mobile-nav-item" :class="{ active: activePage === 'travelblog' }" @click="navigate('travelblog')">
        <img :src="blogImages" class="mobile-nav-icon"/>
      </div>
    </nav>
  </div>
</template>

<script>
export default {
  name: 'Schedule',
  data() {
    const today = new Date();
    const currentYear = today.getFullYear();
    
    return {
      trip: {
        id: '1',
        title: 'Trip Florence',
        startDate: '24.02.2025',
        endDate: '28.02.2025',
        color: '#9896d8'
      },
      selectedDate: today,
      currentDate: today,
      currentViewDate: today,
      weekdays: ['S', 'M', 'T', 'W', 'T', 'F', 'S'],
      months: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
      showMonthSelector: false,
      showYearSelector: false,
      yearRange: Array.from({ length: 21 }, (_, i) => currentYear - 10 + i),
      newActivity: {
        title: '',
        startTime: '',
        endTime: '',
        icon: null
      },
      timeError: '',
      activities: [
        {
          date: '24.02.2025',
          startTime: '08:00',
          endTime: '09:00',
          title: 'having breakfast together',
          icon: 'fas fa-coffee'
        },
        {
          date: '24.02.2025',
          startTime: '09:00',
          endTime: '11:00',
          title: 'Bicycle tour',
          icon: 'fas fa-bicycle'
        },
        {
          date: '24.02.2025',
          startTime: '11:00',
          endTime: '13:00',
          title: 'independent lunch',
          icon: 'fas fa-cloud'
        }
      ],
      activePage: 'schedule',
      images: ['src/assets/TripBudLogo.png'],
      accountImages: 'src/assets/default.png',
      dashboardImages: 'src/assets/dashboard-symbol.png',
      chatImages: 'src/assets/chat-symbol.png',
      documentsImages: 'src/assets/document-symbol2.png',
      scheduleImages: 'src/assets/schedule-symbol.png',
      budgetplanerImages: 'src/assets/wallet-symbol.png',
      blogImages: 'src/assets/blog-symbol.png'
    };
  },
  computed: {
    currentMonth() {
      return this.months[this.currentViewDate.getMonth()];
    },
    currentYear() {
      return this.currentViewDate.getFullYear();
    },
    calendarDays() {
      const year = this.currentViewDate.getFullYear();
      const month = this.currentViewDate.getMonth();
      
      const firstDay = new Date(year, month, 1);
      const lastDay = new Date(year, month + 1, 0);
      
      const firstWeekday = firstDay.getDay();
      
      const daysInMonth = lastDay.getDate();
      
      const daysFromPrevMonth = firstWeekday;
      
      const lastDayPrevMonth = new Date(year, month, 0).getDate();
      
      const days = [];
      
      const tripStartDate = this.parseDateString(this.trip.startDate);
      const tripEndDate = this.parseDateString(this.trip.endDate);
      
      for (let i = daysFromPrevMonth - 1; i >= 0; i--) {
        const day = lastDayPrevMonth - i;
        const date = new Date(year, month - 1, day);
        const inTrip = date >= tripStartDate && date <= tripEndDate;
        days.push({
          day: day,
          month: month - 1,
          year: year,
          currentMonth: false,
          isToday: this.isToday(date),
          date: date,
          inTrip: inTrip,
          isTripStart: this.isSameDate(date, tripStartDate),
          isTripEnd: this.isSameDate(date, tripEndDate),
          isSelected: this.isSameDate(date, this.selectedDate)
        });
      }
      
      for (let day = 1; day <= daysInMonth; day++) {
        const date = new Date(year, month, day);
        const inTrip = date >= tripStartDate && date <= tripEndDate;
        days.push({
          day: day,
          month: month,
          year: year,
          currentMonth: true,
          isToday: this.isToday(date),
          date: date,
          inTrip: inTrip,
          isTripStart: this.isSameDate(date, tripStartDate),
          isTripEnd: this.isSameDate(date, tripEndDate),
          isSelected: this.isSameDate(date, this.selectedDate)
        });
      }
      
      const remainingDays = 42 - days.length;
      
      for (let day = 1; day <= remainingDays; day++) {
        const date = new Date(year, month + 1, day);
        const inTrip = date >= tripStartDate && date <= tripEndDate;
        days.push({
          day: day,
          month: month + 1,
          year: year,
          currentMonth: false,
          isToday: this.isToday(date),
          date: date,
          inTrip: inTrip,
          isTripStart: this.isSameDate(date, tripStartDate),
          isTripEnd: this.isSameDate(date, tripEndDate),
          isSelected: this.isSameDate(date, this.selectedDate)
        });
      }
      
      return days;
    },
    selectedDateFormatted() {
      if (!this.selectedDate) return null;
      
      const day = this.selectedDate.getDate().toString().padStart(2, '0');
      const month = (this.selectedDate.getMonth() + 1).toString().padStart(2, '0');
      const year = this.selectedDate.getFullYear();
      
      return `${day}.${month}.${year}`;
    },
    activitiesForSelectedDate() {
      if (!this.selectedDateFormatted) return [];
      
      return this.activities.filter(activity => activity.date === this.selectedDateFormatted);
    },
    isValidTimeInput() {
      if (!this.newActivity.startTime || !this.newActivity.endTime) {
        return false;
      }
      
      const startTimeParts = this.newActivity.startTime.split(':');
      const endTimeParts = this.newActivity.endTime.split(':');
      
      if (startTimeParts.length !== 2 || endTimeParts.length !== 2) {
        return false;
      }
      
      const startHour = parseInt(startTimeParts[0], 10);
      const startMinute = parseInt(startTimeParts[1], 10);
      const endHour = parseInt(endTimeParts[0], 10);
      const endMinute = parseInt(endTimeParts[1], 10);
      
      if (isNaN(startHour) || isNaN(startMinute) || isNaN(endHour) || isNaN(endMinute)) {
        return false;
      }
      
      if (startHour < 0 || startHour > 24 || startMinute < 0 || startMinute > 59) {
        return false;
      }
      
      if (endHour < 0 || endHour > 24 || endMinute < 0 || endMinute > 59) {
        return false;
      }
      
      if (endHour < startHour) {
        return false;
      }
      
      if (endHour === startHour && endMinute <= startMinute) {
        return false;
      }
      
      return true;
    }
  },
  methods: {
    previousMonth() {
      this.closeSelectors();
      this.currentViewDate = new Date(
        this.currentViewDate.getFullYear(),
        this.currentViewDate.getMonth() - 1,
        1
      );
    },
    nextMonth() {
      this.closeSelectors();
      this.currentViewDate = new Date(
        this.currentViewDate.getFullYear(),
        this.currentViewDate.getMonth() + 1,
        1
      );
    },
    previousYear() {
      this.closeSelectors();
      this.currentViewDate = new Date(
        this.currentViewDate.getFullYear() - 1,
        this.currentViewDate.getMonth(),
        1
      );
    },
    nextYear() {
      this.closeSelectors();
      this.currentViewDate = new Date(
        this.currentViewDate.getFullYear() + 1,
        this.currentViewDate.getMonth(),
        1
      );
    },
    toggleMonthSelector() {
      this.showMonthSelector = !this.showMonthSelector;
      this.showYearSelector = false;
    },
    toggleYearSelector() {
      this.showYearSelector = !this.showYearSelector;
      this.showMonthSelector = false;
    },
    selectMonth(monthIndex) {
      this.currentViewDate = new Date(
        this.currentViewDate.getFullYear(),
        monthIndex,
        1
      );
      this.closeSelectors();
    },
    selectYear(year) {
      this.currentViewDate = new Date(
        year,
        this.currentViewDate.getMonth(),
        1
      );
      this.closeSelectors();
    },
    closeSelectors() {
      this.showMonthSelector = false;
      this.showYearSelector = false;
    },
    isToday(date) {
      return this.isSameDate(date, this.currentDate);
    },
    isSameDate(date1, date2) {
      return date1.getDate() === date2.getDate() &&
             date1.getMonth() === date2.getMonth() &&
             date1.getFullYear() === date2.getFullYear();
    },
    selectDate(dateObj) {
      this.selectedDate = dateObj.date;
      this.closeSelectors();
    },
    parseDateString(dateStr) {
      const [day, month, year] = dateStr.split('.').map(Number);
      return new Date(year, month - 1, day);
    },
    formatDateString(date) {
      const day = date.getDate().toString().padStart(2, '0');
      const month = (date.getMonth() + 1).toString().padStart(2, '0');
      const year = date.getFullYear();
      return `${day}.${month}.${year}`;
    },
    validateStartTime() {
      this.formatTimeInput('startTimeInput', 'startTime');
    },
    validateEndTime() {
      this.formatTimeInput('endTimeInput', 'endTime');
    },
    formatTimeInput(inputRef, timeProperty) {
      const input = this.$refs[inputRef];
      let value = input.value.replace(/[^\d:]/g, '');
      
      if (value.length > 0) {
        const parts = value.split(':');
        
        if (parts.length > 1) {
          let hours = parts[0].substring(0, 2);
          let minutes = parts[1].substring(0, 2);
          
          if (hours.length === 2) {
            const hoursNum = parseInt(hours, 10);
            if (hoursNum > 24) {
              hours = '24';
            }
          }
          
          if (minutes.length === 2) {
            const minutesNum = parseInt(minutes, 10);
            if (minutesNum > 59) {
              minutes = '59';
            }
          }
          
          value = `${hours}:${minutes}`;
        } else {
          if (value.length > 2) {
            const hours = value.substring(0, 2);
            const minutes = value.substring(2, 4);
            value = `${hours}:${minutes}`;
          } else if (value.length === 2) {
            const hoursNum = parseInt(value, 10);
            if (hoursNum > 24) {
              value = '24:';
            } else {
              value = `${value}:`;
            }
          }
        }
      }
      
      this.newActivity[timeProperty] = value;
      
      if (this.newActivity.startTime && this.newActivity.endTime && 
          this.newActivity.startTime.match(/^\d{2}:\d{2}$/) && 
          this.newActivity.endTime.match(/^\d{2}:\d{2}$/)) {
        
        const [startHours, startMinutes] = this.newActivity.startTime.split(':').map(Number);
        const [endHours, endMinutes] = this.newActivity.endTime.split(':').map(Number);
        
        const startTotalMinutes = startHours * 60 + startMinutes;
        const endTotalMinutes = endHours * 60 + endMinutes;
        
        if (endTotalMinutes <= startTotalMinutes) {
          let newEndHours = startHours;
          let newEndMinutes = startMinutes + 30;
          
          if (newEndMinutes >= 60) {
            newEndHours += Math.floor(newEndMinutes / 60);
            newEndMinutes %= 60;
          }
          
          if (newEndHours > 24) {
            newEndHours = 24;
            newEndMinutes = 0;
          }
          
          this.newActivity.endTime = `${String(newEndHours).padStart(2, '0')}:${String(newEndMinutes).padStart(2, '0')}`;
        }
      }
    },
    addActivity() {
      if (!this.newActivity.title || !this.isValidTimeInput) {
        return;
      }
      
      const newActivity = {
        date: this.selectedDateFormatted,
        startTime: this.newActivity.startTime,
        endTime: this.newActivity.endTime,
        title: this.newActivity.title,
        icon: ''
      };
      
      this.activities.push(newActivity);
      
      this.newActivity = {
        title: '',
        startTime: '',
        endTime: '',
        icon: null
      };
    },
    navigate(page) {
      this.activePage = page;
      this.$router.push('/' + page);
    },
    openSettings() {
      this.$router.push('/settings');
    }
  },
  mounted() {
    document.addEventListener('click', (e) => {
      const monthSelector = document.querySelector('.month-selector');
      const yearSelector = document.querySelector('.year-selector');
      
      if (monthSelector && !monthSelector.contains(e.target) && 
          yearSelector && !yearSelector.contains(e.target)) {
        this.closeSelectors();
      }
    });
  },
  beforeDestroy() {
    document.removeEventListener('click', this.closeSelectors);
  }
};
</script>
  
<style>
* {
  font-family: 'Outfit', sans-serif;
  box-sizing: border-box;
}

.schedule-container {
  display: flex;
  flex-direction: column;
  min-height: 100vh;
  background: linear-gradient(to bottom, #e0f2fe, #ffffff);
  background-image: url('~@/assets/lines.png');
  background-size: cover;
  padding-bottom: 0;
  position: relative;
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

.settings-icon {
  width: 40px;
  height: 40px;
  border-radius: 50%;
  cursor: pointer;
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
  align-self: flex-start;
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

.content {
  flex: 1;
  display: flex;
  gap: 1.5rem;
}

.trip-info-panel {
  width: 350px;
  background-color: white;
  border-radius: 15px;
  padding: 1.5rem;
  box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
  height: fit-content;
}

.trip-info {
  margin-bottom: 2rem;
}

.trip-info h2 {
  margin: 0;
  font-size: 1.5rem;
  color: #24292e;
}

.trip-info p {
  margin: 0.5rem 0 0;
  color: #6e7681;
}

.activities-title {
  margin-top: 0;
  margin-bottom: 1.5rem;
  font-size: 1.5rem;
  color: #24292e;
}

.activity-form {
  display: flex;
  flex-direction: column;
  gap: 1rem;
}

.form-group {
  display: flex;
  flex-direction: column;
  gap: 0.5rem;
}

.form-group label {
  font-size: 0.9rem;
  color: #24292e;
}

.form-group input {
  padding: 0.6rem;
  border: 1px solid #e1e4e8;
  border-radius: 4px;
  font-size: 0.9rem;
}

.time-input {
  position: relative;
}

.add-activity-btn {
  padding: 0.7rem;
  background-color: #0366d6;
  color: white;
  border: none;
  border-radius: 4px;
  font-size: 0.9rem;
  cursor: pointer;
  transition: background-color 0.2s;
}

.add-activity-btn:hover {
  background-color: #0258b8;
}

.add-activity-btn:disabled {
  background-color: #a0aec0;
  cursor: not-allowed;
}

.calendar-section {
  flex: 1;
  background-color: white;
  border-radius: 15px;
  padding: 1.5rem;
  box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
}

.calendar-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 1rem;
}

.date-navigation {
  display: flex;
  align-items: center;
  gap: 0.5rem;
  width: 100%;
}

.month-nav-btn, .year-nav-btn {
  background: none;
  border: none;
  font-size: 1rem;
  color: #6e7681;
  cursor: pointer;
  padding: 0.25rem 0.5rem;
  border-radius: 4px;
  transition: background-color 0.2s;
}

.month-nav-btn:hover, .year-nav-btn:hover {
  background-color: #f6f8fa;
}

.calendar-date-selector {
  display: flex;
  gap: 0.5rem;
  align-items: center;
  flex: 1;
  justify-content: center;
}

.month-selector, .year-selector {
  position: relative;
  cursor: pointer;
  padding: 0.25rem 0.5rem;
  border-radius: 4px;
  font-weight: 500;
  transition: background-color 0.2s;
}

.month-selector:hover, .year-selector:hover {
  background-color: #f6f8fa;
}

.month-dropdown, .year-dropdown {
  position: absolute;
  top: 100%;
  left: 0;
  background-color: white;
  border-radius: 4px;
  box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
  z-index: 10;
  max-height: 200px;
  overflow-y: auto;
  width: 120px;
}

.year-dropdown {
  width: 80px;
}

.month-dropdown div, .year-dropdown div {
  padding: 0.5rem;
  cursor: pointer;
  transition: background-color 0.2s;
}

.month-dropdown div:hover, .year-dropdown div:hover {
  background-color: #f6f8fa;
}

.selected-option {
  background-color: #e0f2fe;
  font-weight: 600;
}

.calendar {
  margin-bottom: 1.5rem;
}

.calendar-days {
  display: grid;
  grid-template-columns: repeat(7, 1fr);
  text-align: center;
  gap: 2px;
}

.weekday {
  padding: 0.5rem;
  font-weight: bold;
  color: #24292e;
  background-color: #f6f8fa;
  font-size: 0.9rem;
}

.calendar-day {
  padding: 0.4rem;
  cursor: pointer;
  color: #6e7681;
  border-bottom: 1px solid #f6f8fa;
  border-right: 1px solid #f6f8fa;
  display: flex;
  align-items: center;
  justify-content: center;
  aspect-ratio: 1;
  font-size: 0.9rem;
  width: 36px;
  height: 36px;
  margin: 0 auto;
}

.calendar-day.current-month {
  color: #24292e;
}

.calendar-day.today {
  background-color: #58a6ff;
  color: white;
  border-radius: 50%;
}

.calendar-day.in-trip {
  background-color: rgba(152, 150, 216, 0.2);
}

.calendar-day.trip-start {
  background-color: #9896d8;
  color: white;
  border-radius: 50%;
}

.calendar-day.trip-end {
  background-color: #9896d8;
  color: white;
  border-radius: 50%;
}

.calendar-day.selected {
  background-color: #0366d6;
  color: white;
  border-radius: 50%;
}

.selected-day-activities {
  background-color: #f6f8fa;
  border-radius: 8px;
  padding: 1.5rem;
}

.selected-day-activities h3 {
  margin-top: 0;
  margin-bottom: 1.5rem;
  font-size: 1.2rem;
  color: #24292e;
}

.activity-list {
  display: flex;
  flex-direction: column;
  gap: 1rem;
}

.activity-item {
  display: flex;
  flex-direction: column;
  padding-bottom: 1rem;
  border-bottom: 1px solid #f0f0f0;
}

.activity-time {
  font-size: 0.8rem;
  color: #6e7681;
  margin-bottom: 0.5rem;
}

.activity-content {
  display: flex;
  justify-content: space-between;
  align-items: center;
}

.activity-title {
  font-size: 0.9rem;
  color: #24292e;
}

.activity-icon {
  width: 24px;
  height: 24px;
  display: flex;
  align-items: center;
  justify-content: center;
  border-radius: 50%;
  background-color: #f6f8fa;
  color: #6e7681;
}

.activity-icon-img {
  width: 100%;
  height: 100%;
  object-fit: contain;
}

.time-error {
  color: #e53e3e;
  font-size: 0.8rem;
  margin-top: 0.25rem;
}

/* Mobile Navigation Bar */
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

@media (max-width: 992px) {
  .content {
    flex-direction: column;
  }

  .trip-info-panel {
    width: 100%;
  }
}

@media (max-width: 768px) {
  .main-layout {
    padding: 0 1rem 1rem;
    padding-bottom: 70px; /* Add padding for bottom nav */
  }
  
  .sidebar {
    display: none; /* Hide desktop sidebar on mobile */
  }
  
  .mobile-nav {
    display: flex; /* Show mobile nav on small screens */
  }

  .header {
    padding: 1rem;
  }
  
  .content {
    flex-direction: column;
  }
  
  .trip-info-panel {
    width: 100%;
  }
}

@media (max-width: 480px) {
  .header {
    padding: 16px;
  }
  
  .logo {
    width: 40px;
  }
  
  h1 {
    font-size: 24px;
  }
  
  .form-group input {
    padding: 0.5rem;
  }
  
  .add-activity-btn {
    padding: 0.6rem;
  }
  
  .calendar-day {
    width: 32px;
    height: 32px;
    padding: 0.3rem;
    font-size: 0.8rem;
  }
  
  .weekday {
    padding: 0.4rem;
    font-size: 0.8rem;
  }
}
</style>