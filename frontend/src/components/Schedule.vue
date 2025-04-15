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
          <div class="sidebar-item" :class="{ active: activePage === 'blog' }" @click="navigate('blog')">
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
                  <input type="text" placeholder="00:00" v-model="newActivity.startTime" />
                </div>
              </div>
              
              <div class="form-group">
                <label>To:</label>
                <div class="time-input">
                  <input type="text" placeholder="00:00" v-model="newActivity.endTime" />
                </div>
              </div>
  
              <button class="add-activity-btn" @click="addActivity">Add Activity</button>
            </div>
          </div>
  
          <div class="calendar-section">
            <div class="calendar-header">
              <h3>{{ currentMonth }} {{ currentYear }}</h3>
              <div class="calendar-nav">
                <button @click="previousMonth"><i class="fas fa-chevron-left"></i></button>
                <button @click="nextMonth"><i class="fas fa-chevron-right"></i></button>
              </div>
            </div>
  
            <div class="calendar">
              <div class="calendar-days">
                <div class="weekday" v-for="day in weekdays" :key="day">{{ day }}</div>
                <div 
                  v-for="date in calendarDays" 
                  :key="date.day + date.month + date.year" 
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
    </div>
  </template>
  
  <script>
  export default {
    name: 'Schedule',
    data() {
      return {
        trip: {
          id: '1',
          title: 'Trip Florence',
          startDate: '24.02.2025',
          endDate: '28.02.2025',
          color: '#9896d8'
        },
        selectedDate: new Date(2025, 1, 24),
        currentDate: new Date(2025, 1, 19),
        currentViewDate: new Date(2025, 1, 15),
        weekdays: ['S', 'M', 'T', 'W', 'T', 'F', 'S'],
        months: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
        newActivity: {
          title: '',
          startTime: '',
          endTime: '',
          icon: null
        },
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
      }
    },
    methods: {
      previousMonth() {
        this.currentViewDate = new Date(
          this.currentViewDate.getFullYear(),
          this.currentViewDate.getMonth() - 1,
          1
        );
      },
      nextMonth() {
        this.currentViewDate = new Date(
          this.currentViewDate.getFullYear(),
          this.currentViewDate.getMonth() + 1,
          1
        );
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
      addActivity() {
        if (!this.newActivity.title || !this.newActivity.startTime || !this.newActivity.endTime) {
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
    }
  };
  </script>
  
  <style scoped>
  * {
    font-family: 'Outfit', sans-serif;
  }
  
  .schedule-container {
    display: flex;
    flex-direction: column;
    min-height: 100vh;
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
    margin-top: 1rem;
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
  
  .calendar-header h3 {
    margin: 0;
    font-size: 1.2rem;
    color: #24292e;
  }
  
  .calendar-nav {
    display: flex;
    gap: 0.5rem;
  }
  
  .calendar-nav button {
    background: none;
    border: none;
    font-size: 1rem;
    color: #6e7681;
    cursor: pointer;
  }
  
  .calendar {
    margin-bottom: 1.5rem;
  }
  
  .calendar-days {
    display: grid;
    grid-template-columns: repeat(7, 1fr);
    text-align: center;
  }
  
  .weekday {
    padding: 0.7rem;
    font-weight: bold;
    color: #24292e;
    background-color: #f6f8fa;
  }
  
  .calendar-day {
    padding: 0.7rem;
    cursor: pointer;
    color: #6e7681;
    border-bottom: 1px solid #f6f8fa;
    border-right: 1px solid #f6f8fa;
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
  }
  </style>