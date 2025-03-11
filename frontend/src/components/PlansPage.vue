<template>
    <div class="pricing-container">
      <h1 class="title">Plans</h1>
      <div class="cards">
        <div class="card">
          <h2>Free</h2>
          <p class="price">$0<span>/mo</span></p>
          <div class="plan-info">
            <p>2 saved trips</p>
            <p>Up to 2 buddies per trip</p>
            <p>Up to 1 GB trip storage</p>
          </div>
          <button class="btn">Start Free</button>
        </div>
        <div class="card premium" @mouseover="pausePulse" @mouseleave="resumePulse">
          <h2>Premium</h2>
          <p class="price">$8.99<span>/mo</span></p>
          <div class="plan-info">
            <p>10 saved trips</p>
            <p>Up to 5 buddies per trip</p>
            <p>Up to 5 GB trip storage</p>
          </div>
          <button class="btn white-btn">Get Premium</button>
          <div class="badge">Best Deal</div>
        </div>
        <div class="card">
          <h2>Business</h2>
          <p class="price">$24.99<span>/mo</span></p>
          <div class="plan-info">
            <p>Unlimited saved trips</p>
            <p>Unlimited buddies per trip</p>
            <p>Unlimited trip storage</p>
          </div>
          <button class="btn">Get Business</button>
        </div>
      </div>
    </div>
  </template>
  
  <script>
  export default {
    methods: {
      pausePulse(event) {
        event.target.style.animationPlayState = "paused"; // Pause the pulse on hover
      },
      resumePulse(event) {
        event.target.style.animationPlayState = "running"; // Resume pulse when mouse leaves
      }
    }
  };
  
  </script>
  
  <style scoped>
  @import url('https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;700&display=swap');
  
  * {
    font-family: 'Outfit', sans-serif;
  }
  
  .pricing-container {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    height: 100vh;
    background: linear-gradient(to bottom, #e0f2fe, #ffffff);
  }
  
  .title {
    font-size: 2.5rem;
    font-weight: 700;
    margin-bottom: 20px;
  }
  
  .cards {
    display: flex;
    justify-content: center;
    gap: 30px;
  }
  
  .card {
    background: white;
    padding: 30px;
    border-radius: 15px;
    box-shadow: 0 6px 15px rgba(0, 0, 0, 0.1);
    text-align: center;
    width: 300px;
    transition: transform 0.3s ease, background 0.3s ease;
  }
  

  
  .card:hover {
    background: #409FDB;
    color: white;
    transform: scale(1.05);
  }
  
  .card:hover .btn {
    background: white;
    color: #409FDB;
  }
  
  .premium {
    background: #4F9BFC; /* Keep the color fixed on the middle card */
    color: white;
    transform: scale(1.05); /* Slightly bigger */
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.2);
    position: relative;
    z-index: 2;
    border: 2px solid #409FDB; /* Border to make it more distinct */
    animation: pulse 1.5s infinite; /* Pulse animation to grab attention */
    animation-play-state: running; /* Start pulse automatically */
  }
  
  .premium .btn.white-btn {
    background: white; /* White button for the premium card */
    color: #409FDB; /* Matching button text color */
  }
  
  .premium .badge {
    position: absolute;
    top: 10px;
    right: 10px;
    background: #0077cc;
    color: white;
    padding: 5px 15px;
    border-radius: 50px;
    font-weight: 700;
    font-size: 1.2rem;
  }
  
  @keyframes pulse {
    0% {
      transform: scale(1.05);
    }
    50% {
      transform: scale(1.1);
    }
    100% {
      transform: scale(1.05);
    }
  }
  
  .price {
    font-size: 1.8rem;
    font-weight: 600;
  }
  
  .plan-info {
    text-align: left;
    margin-top: 15px;
  }
  
  .plan-info p {
    font-size: 1rem;
    margin: 5px 0;
  }
  
  .btn {
    background: #409FDB;
    color: white;
    border: none;
    padding: 12px 20px;
    border-radius: 5px;
    cursor: pointer;
    margin-top: 15px;
    font-size: 1rem;
    transition: background 0.3s ease, color 0.3s ease;
  }
  
  .card:hover:not(.premium) {
    background: #3498db; /* A slightly different blue for non-premium cards */
  }
  </style>
  