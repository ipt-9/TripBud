<template>
  <section class="section budget-section">
    <h2 class="section-title">Budget</h2>
    <div class="budget-tabs">
      <button 
        v-for="tab in tabs" 
        :key="tab"
        class="budget-tab" 
        :class="{ active: activeTab === tab }" 
        @click="$emit('set-active-tab', tab)"
      >
        {{ tab.charAt(0).toUpperCase() + tab.slice(1) }}
      </button>
    </div>
    <div class="budget-days">
      <div 
        v-for="tab in dateTabs" 
        :key="tab.value"
        class="day-tab" 
        :class="{ active: activeDateTab === tab.value }" 
        @click="$emit('set-active-date-tab', tab.value)"
      >
        {{ tab.label }}
      </div>
    </div>
    <div class="budget-cards">
      <div 
        v-for="(card, index) in budgetCards" 
        :key="index"
        :class="['budget-card', card.color]"
      >
        <div :class="['budget-icon', card.icon + '-icon']"></div>
        <div class="budget-amount">
          <div class="amount-main">{{ card.amount }}</div>
          <div class="amount-diff">{{ card.difference }}</div>
        </div>
      </div>
    </div>
  </section>
</template>

<script>
export default {
  name: 'BudgetSection',
  props: {
    activeTab: {
      type: String,
      required: true
    },
    activeDateTab: {
      type: String,
      required: true
    }
  },
  data() {
    return {
      tabs: ['day', 'month', 'year'],
      dateTabs: [
        { value: '01.02', label: '01.02' },
        { value: '02.02', label: '02.02' },
        { value: '03.02', label: '03.02' },
        { value: 'today', label: 'Today' }
      ],
      budgetCards: [
        {
          color: 'purple',
          icon: 'hotel',
          amount: '470 CHF',
          difference: '- 130 CHF'
        },
        {
          color: 'pink',
          icon: 'building',
          amount: '480 CHF',
          difference: '- 120 CHF'
        },
        {
          color: 'teal',
          icon: 'transport',
          amount: '170 CHF',
          difference: '- 30 CHF'
        },
        {
          color: 'yellow',
          icon: 'entertainment',
          amount: '250 CHF',
          difference: '- 50 CHF'
        }
      ]
    };
  }
}
</script>

<style scoped>
.budget-section {
  grid-column: 2;
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
 
.budget-tabs {
  display: flex;
  gap: 0.5rem;
  margin-bottom: 1.5rem;
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
 
.budget-days {
  display: flex;
  gap: 0.5rem;
  margin-bottom: 1.5rem;
  overflow-x: auto;
  padding-bottom: 0.5rem;
}
 
.day-tab {
  padding: 0.5rem 1rem;
  border-radius: 20px;
  background-color: #f0f0f0;
  cursor: pointer;
  white-space: nowrap;
  transition: all 0.2s;
}
 
.day-tab:hover {
  background-color: #e5e5e5;
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
  width: 32px;
  height: 32px;
  border-radius: 8px;
  margin-right: 1rem;
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

@media (max-width: 1200px) {
  .budget-section {
    grid-column: 1;
    grid-row: 4;
  }
}

@media (max-width: 768px) {
  .budget-cards {
    grid-template-columns: 1fr;
  }
}

@media (max-width: 480px) {
  .budget-tabs, .budget-days {
    flex-wrap: wrap;
  }
  
  .section {
    padding: 1rem;
    margin-bottom: 1rem;
  }
  
  .section-title {
    font-size: 1.2rem;
    margin-bottom: 0.75rem;
  }
}

@media (max-width: 320px) {
  .budget-cards {
    grid-template-columns: 1fr;
  }
}
</style>