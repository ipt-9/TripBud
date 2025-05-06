// CalendarSection.vue
<template>
  <section class="section calendar-section">
    <h2 class="section-title">Calendar</h2>
    <div class="calendar-header">
      <div class="calendar-month">
        <span>{{ currentMonth }}</span>
        <button class="dropdown-arrow">▼</button>
      </div>
      <div class="calendar-nav">
        <button class="prev-month" @click="previousMonth">◀</button>
        <button class="next-month" @click="nextMonth">▶</button>
      </div>
    </div>
    <div class="calendar">
      <div class="calendar-weekdays">
        <div v-for="day in weekdays" :key="day" class="weekday">{{ day }}</div>
      </div>
      <div class="calendar-days">
        <div 
          v-for="(day, index) in calendarDays" 
          :key="index" 
          class="day" 
          :class="getDayClass(day)"
          @click="selectDay(day)"
        >
          {{ day.day }}
        </div>
      </div>
    </div>
  </section>
</template>

<script>
export default {
  name: 'CalendarSection',
  data() {
    return {
      weekdays: ['S', 'M', 'T', 'W', 'T', 'F', 'S'],
      currentDate: new Date(2025, 1, 16), // Hardcoded Feb 2025 for demo
      selectedDays: [24, 25, 26, 27, 28], // Example selected days
      highlightedDays: [19], // Example highlighted day
      inactiveDays: [9, 10, 11, 12, 13] // Example inactive days
    }
  },
  computed: {
    currentMonth() {
      const options = { month: 'short', year: 'numeric' };
      return this.currentDate.toLocaleDateString('en-US', options);
    },
    calendarDays() {
      const year = this.currentDate.getFullYear();
      const month = this.currentDate.getMonth();
      
      // Get first day of month and last day of month
      const firstDay = new Date(year, month, 1);
      const lastDay = new Date(year, month + 1, 0);
      
      // Array to hold all days to display
      const days = [];
      
      // Get days from previous month to fill first week
      const firstDayOfWeek = firstDay.getDay();
      if (firstDayOfWeek > 0) {
        const prevMonth = new Date(year, month, 0);
        const daysInPrevMonth = prevMonth.getDate();
        
        for (let i = 0; i < firstDayOfWeek; i++) {
          const day = daysInPrevMonth - firstDayOfWeek + i + 1;
          days.push({
            day: day,
            month: 'prev',
            date: new Date(year, month - 1, day)
          });
        }
      }
      
      // Current month days
      const daysInMonth = lastDay.getDate();
      for (let i = 1; i <= daysInMonth; i++) {
        days.push({
          day: i,
          month: 'current',
          date: new Date(year, month, i)
        });
      }
      
      // Get days from next month to fill last week
      const lastDayOfWeek = lastDay.getDay();
      if (lastDayOfWeek < 6) {
        const daysToAdd = 6 - lastDayOfWeek;
        for (let i = 1; i <= daysToAdd; i++) {
          days.push({
            day: i,
            month: 'next',
            date: new Date(year, month + 1, i)
          });
        }
      }
      
      return days;
    }
  },
  methods: {
    previousMonth() {
      this.currentDate = new Date(
        this.currentDate.getFullYear(),
        this.currentDate.getMonth() - 1,
        1
      );
    },
    nextMonth() {
      this.currentDate = new Date(
        this.currentDate.getFullYear(),
        this.currentDate.getMonth() + 1,
        1
      );
    },
    selectDay(day) {
      // For demo purposes, just log the selected day
      console.log('Selected day:', day);
    },
    getDayClass(day) {
      const classes = [];
      
      // Add class based on month
      if (day.month === 'prev' || day.month === 'next') {
        classes.push(day.month + '-month');
      }
      
      // Current day
      if (day.month === 'current' && day.day === 16) {
        classes.push('current');
      }
      
      // Selected days
      if (day.month === 'current' && this.selectedDays.includes(day.day)) {
        classes.push('selected');
      }
      
      // Highlighted days
      if (day.month === 'current' && this.highlightedDays.includes(day.day)) {
        classes.push('highlight');
      }
      
      // Inactive days
      if (day.month === 'current' && this.inactiveDays.includes(day.day)) {
        classes.push('inactive');
      }
      
      return classes;
    }
  }
}
</script>

<style scoped>
.calendar-section {
  grid-column: 1;
  grid-row: 2;
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
 
.day.next-month, .day.prev-month {
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

@media (max-width: 1200px) {
  .calendar-section {
    grid-column: 1;
    grid-row: 2;
  }
}

@media (max-width: 480px) {
  .section {
    padding: 1rem;
    margin-bottom: 1rem;
  }
  
  .section-title {
    font-size: 1.2rem;
    margin-bottom: 0.75rem;
  }
  
  .calendar-days {
    grid-template-columns: repeat(7, 1fr);
    gap: 0.1rem;
  }
 
  .day {
    width: 25px;
    height: 25px;
    font-size: 0.8rem;
  }
}
</style>