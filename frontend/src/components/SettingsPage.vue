<template>
    <div class ="setting-container">
        <div class="logo-container">
            <img v-for="img in images" v-bind:src="img" class="logo" />
            <span class="logo-text">Settings</span>
        </div>
        <div class="rounded-box-left">
            <input type="text" placeholder="Search...">
            <a href="">
              <img src="../assets/user.png"/><h2>Account</h2></a>
            <a href="">
              <img src="../assets/shopping-cart.png"/><h2>Plans</h2></a>
            <a href="">
              <img src="../assets/info.png"/><h2>Help & Support</h2></a>
            <button class="box-left-logout">Log Out</button>

        </div>
        <div class ="rounded-box-right">
          <div class="box-right-register">
            <a href=""><h2 class="box-right-register-account">Account</h2></a>
            <a href=""><h2 class="box-right-register-payment">Payment</h2></a>
          </div>
            <div class ="box-right-line">
              <div class="box-right-profile">
              <h1>Your Profile</h1>
              <p>Update your profile settings here</p>
              <img src="../assets/account-symbol.png" class="profile-picture"/>
                <button class="box-right-edit-button">Edit</button>
                <button class="box-right-delete-button">Delete</button>
            </div>
          </div>
            
            <div class ="box-right-line2">
              <div class ="box-right-username">
              <h2>Username</h2>
              <input type="text">
            </div>
          </div>
            
            <div class ="box-right-line3">
              <div class ="box-right-email">
              <h2>E-Mail</h2>
              <input type="email">
            </div>
          </div>
          
            <div class ="box-right-line4">
              <div class ="box-right-password">
              <h2>Current Password</h2>
              <input type="password">
              <div class="box-right-new-password">
                <h2 class="box-right-password-new">New Password</h2>
                <input type="password"></div>
              <div class="box-right-confirm-password">
                <h2 class="box-right-password-confirm">Confirm Password</h2>
                <input type="password"></div>
            </div>
          </div>
            <div class="box-right-line6"></div>
            <div class="box-right-line5">
                <div class="box-right-notifications">
                <h2>Notifications</h2>
              </div>
              <div class="box-right-email-notification">
                  <label for="box-right-notification-checkbox"></label>
                  <span><input type="checkbox" class="box-right-notification-checkbox" /> E-Mail Notification</span>
                  <p>You will be notified with E-Mail when someone messages you.</p>
                </div>
                <div class="box-right-sound-notification">
                  <label for="box-right-box-notification-checkbox"></label>
                  <span><input type="checkbox" class="box-right-notification-checkbox" /> Sound Notification</span>
                  <p>You will be notified with Sound when someone messages you.</p>
                </div>
            </div>
            <div class="box-right-line7">
              <div class="box-right-button-container">
                <button class="box-right-cancel-button" onclick="">Cancel</button>
                <button class="box-right-save-button" onclick="">Save</button>


              </div>
            </div>

        </div>
    </div>
  </template>

<!-- <script>
import api from "./axios";

export default {
  data() {
    return {
      images: ["src/assets/TripBudLogo.png"],
      user: {
        username: "",
        email: "",
        currentPassword: "",
        newPassword: "",
        confirmPassword: "",
        emailNotifications: false,
        soundNotifications: false,
      },
      error: null,
    };
  },
  methods: {
    async saveChanges() {
      try {
        const response = await api.post("/update/user", this.user);
        console.log("User updated successfully:", response.data);
      } catch (error) {
        this.error = error.response?.data?.message || "Something went wrong!";
      }
    },
    async editProfile() {
      console.log("Edit profile clicked");
    },
    async deleteProfile() {
      try {
        await api.delete("/delete/user");
        console.log("User deleted successfully");
      } catch (error) {
        this.error = error.response?.data?.message || "Could not delete profile!";
      }
    },
    cancelChanges() {
      console.log("Changes canceled");
    },
  },
};
</script> -->

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

    position: fixed;
    
    margin-left: 1%;
    padding: 20px;
    box-sizing: border-box;
}

.rounded-box-left img {
  height: 30px;
  margin-right: 10px; /* Abstand zwischen Bild und Text */
  margin-bottom: 45px;
  margin-right: 15px;
}

.rounded-box-left a {
  text-decoration: none;
    color: inherit;
    cursor: pointer;
    display: flex;
    align-items: center; /* Bild und Text vertikal zentrieren */
    margin-bottom: 20px; /* Abstand zwischen den Links */
}

.box-left-logout {
  width: 100%;
  height: 6%;
  border-radius: 50px;
  background-color: rgb(105, 105, 105);
  border: none;
  color: white;
  font-size: 110%;
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

    overflow-y: auto;
    max-height: 85%;
}

.rounded-box-right a {
  text-decoration: none;
  color: inherit;
  cursor: pointer;
}

.box-right-register-account {
    margin-right: 55px; /* Abstand nach rechts */
    margin-left: 40px;
    font-weight: 700;
}

.box-right-register-payment {
    font-weight: 500;
    color: rgb(116, 116, 116);
}

.rounded-box-right > div h2 {
    margin-top: 35px; /* Abstand nach unten */
    display: inline-block; /* Damit margin funktioniert */
    font-weight: 500;
}

.box-right-buttons {
  display: flex;
  justify-content: flex-end;
  margin-right: 60px;
  align-items: center;
}

.box-right-profile img {
  height: 80px;
  margin-right: 50px;
  position: absolute;
  margin-top: 50px;
  top: 10%;
  right: 20%;

}

.profile-picture {
  width: 90px;
  border-radius: 50%;
  object-fit: cover;
}


.box-right-edit-button {
  background-color: #409FDB;
  border-radius: 50px;
  border: none;
  color: white;
  cursor: pointer;
  position: absolute;
  right: 15%;
  top: 10%;
  margin-top: 70px;
  margin-right: 10px;
  height: 4.5vh;
  width: 4vw;
  font-size: 105%;

}

.box-right-delete-button {
  background-color: #db4040;
  border-radius: 50px;
  border: none;
  color: white;
  cursor: pointer;
  position: absolute;
  top: 10%;
  right: 8%;
  margin-top: 70px;
  height: 4.5vh;
  width: 5vw;
  font-size: 105%;
}

.box-right-line {
    background-color: rgb(196, 196, 196);
    width: 100%;
    height: 1px;
    position: absolute;
    top: 12%;
    right: 1px;

}

.box-right-line2 {
    background-color: rgb(196, 196, 196);
    width: 93%;
    height: 1px;
    position: absolute;
    top: 35%;
    left: 0;
    right: 0;
    margin: auto; /* Automatische horizontale Zentrierung */
}

.box-right-line3 {
    background-color: rgb(196, 196, 196);
    width: 93%;
    height: 1px;
    position: absolute;
    top: 52%;
    left: 0;
    right: 0;
    margin: auto; /* Automatische horizontale Zentrierung */
}

.box-right-line4 {
    background-color: rgb(196, 196, 196);
    width: 93%;
    height: 1px;
    position: absolute;
    top: 69%;
    left: 0;
    right: 0;
    margin: auto; /* Automatische horizontale Zentrierung */
}
.box-right-line5 {
    background-color: rgb(196, 196, 196);
    width: 93%;
    height: 1px;
    position: absolute;
    top: 103%;
    left: 0;
    right: 0;
    margin: auto; /* Automatische horizontale Zentrierung */
}

.box-right-line6 {
    background-color: rgb(196, 196, 196);
    width: 93%;
    height: 1px;
    position: absolute;
    top: 101.5%;
    left: 0;
    right: 0;
    margin: auto; /* Automatische horizontale Zentrierung */
}

.box-right-line7 {
    background-color: rgb(196, 196, 196);
    width: 93%;
    height: 1px;
    position: absolute;
    top: 135%;
    left: 0;
    right: 0;
    margin: auto;
    display: flex;
    justify-content: flex-end;
}

.box-right-save-button,
.box-right-cancel-button {
  background-color: #409FDB;
  border-radius: 50px;
  border: none;
  color: white;
  margin-top: 25px;
  cursor: pointer;
  height: 4.5vh;
  width: 6vw;
  font-size: 105%;
}

.box-right-cancel-button {
  background-color: rgb(230, 230, 230);
  color: black;
  margin-right: 10px;
}

.box-right-button-container {
 padding-bottom: 85px;
}

.box-right-profile h1 {
  margin-top: 55px;
  margin-left: 60px;
  font-weight: 500;
}

.box-right-profile p {
  margin-top: 10px;
  margin-left: 60px;
  font-weight: 500;
  font-size: 140%;
  color: rgb(116, 116, 116);
}

.box-right-username {
  margin-top: 15px;
  margin-left: 70px;
}

.box-right-email {
  margin-top: 15px;
  margin-left: 70px;
}

.box-right-password {
  margin-top: 15px;
  margin-left: 70px;
}

.box-right-password input {
    position: absolute;
    right: 0;
    margin-right: 240px;
    margin-top: 28px;
    width: 49%;
    height: 50px;
    border-radius: 100px;
    border-width: 0.5px;
}

.box-right-email input {
  position: absolute;
    right: 0;
    margin-right: 240px;
    margin-top: 28px;
    width: 49%;
    height: 50px;
    border-radius: 100px;
    border-width: 0.5px;
}

.box-right-username input {
  position: absolute;
    right: 0;
    margin-right: 240px;
    margin-top: 28px;
    width: 49%;
    height: 50px;
    border-radius: 100px;
    border-width: 0.5px;
}

.box-right-notifications h2 {
  margin-top: 55px;
  margin-left: 70px;
  font-weight: 500;
}

.box-right-notifications span {
 font-size: 125%;
 margin-top: 120px;
 font-weight: 500;
}

.box-right-notifications {
  display: flex;
  align-items: flex-start;
  margin-right: 100px;
}

.box-right-email-notification,
.box-right-sound-notification {
  display: flex;
  flex-direction: column;
}

.box-right-email-notification span,
.box-right-sound-notification span {
  font-size: 125%;
  font-weight: 500;
  margin-top: 30px;
  margin-left: 70px;
}

.box-right-email-notification p,
.box-right-sound-notification p {
  margin-left: 112px;
}

.box-right-notification-checkbox {
  height: 1.5vh;
  margin-right: 25px;
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
    color: gray;
    font-size: 17px;
    padding-left: 10px;
    opacity: 1;
}

.rounded-box-right::-webkit-scrollbar {
    width: 10px;
}

.rounded-box-right::-webkit-scrollbar-track {
    background: transparent;
}

.rounded-box-right::-webkit-scrollbar-thumb {
    background: #aaa;
    border-radius: 10px;
}


</style>