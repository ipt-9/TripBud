<template>
    <header class="header">
      <div class="header-left">
        <div class="logo">
          <div class="logo-icon"></div>
          <h1 class="dashboard-title">Dashboard</h1>
        </div>
      </div>
      <div class="header-right">
        <div class="profile-icon" @click="toggleDropdown">
          <div class="dropdown-menu" v-show="showDropdown">
            <div class="dropdown-item">
              <i class="settings-icon"></i>
              <span>Settings</span>
            </div>
            <div class="dropdown-item" @click="logout">
              <i class="logout-icon"></i>
              <span>Logout</span>
            </div>
          </div>
        </div>
      </div>
    </header>
</template>