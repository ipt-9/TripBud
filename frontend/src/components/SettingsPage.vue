<template>
    <div class ="setting-container">
        <div class="logo-container">
            <img v-for="img in images" v-bind:src="img" class="logo" />
            <span class="logo-text">Settings</span>
        </div>
        <div class="rounded-box-left">
            <input type="text" placeholder="Search...">
            <h2>Account</h2>
            <h2>Plans</h2>
            <h2>Help & Support</h2>

        </div>
        <div class ="rounded-box-right">
            <div class ="box-right-line"></div>
        </div>
    </div>




  </template>

<script>
export default {
  data() {
    return {
      images:['src/assets/TripBudLogo.png'],
  }}}
</script>

<style>
* {
  font-family: 'Outfit', sans-serif;
}

.setting-container {
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;;
  height: 100vh;
  background: linear-gradient(to bottom, #e0f2fe, #ffffff)
}

.logo-container {
  position: absolute;
  top: 20px;
  left: 20px;
  display: flex;
  align-items: center;
}

.logo-container img {
  height: 50px;
  margin-right: 10px;
}

.logo-container span {
  font-size: 32px;
  font-weight: bold;
  color: #000000;
}

.rounded-box-left {
    width: 20%; /* Anpassbare Breite für verschiedene Bildschirmgrößen */
    height: 85%;
    background-color: white;
    border-radius: 20px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    
    position: absolute;
    left: 0;
    top:14%;
    
    margin-left: 1%;
    padding: 20px;
    box-sizing: border-box;
}

.rounded-box-right {
    width: 75%; /* Anpassbare Breite für verschiedene Bildschirmgrößen */
    height: 85%;
    background-color: white;
    border-radius: 20px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    
    position: absolute;
    right: 0;
    top:14%;
    
    margin-right: 3%;
    padding: 20px;
    box-sizing: border-box;
}

.box-right-line {
    background-color: rgb(196, 196, 196);
    width: 100%;
    height: 1px;
    position: absolute;
    top: 12%;
    right: 1px;

}

.rounded-box-left h2 {
    margin-bottom: 17%;
    font-weight: 500;
}

.rounded-box-left input {
    width: 95%;
    height: 5%;
    border-radius: 100px;
    margin-bottom: 30%;
    margin-top: 8%;
    border-width: 0.5px;
}

input::placeholder {
    color: gray; /* Farbe anpassen */
    font-size: 17px; /* Größe ändern */
    padding-left: 10px;
    opacity: 1; /* Falls der Placeholder zu blass ist */
}



</style>