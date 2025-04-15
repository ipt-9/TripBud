<template>
    <div class="whyus-container">
        <div class="whyus-img">
            <img v-for="(img, index) in whyusImages" :key="index" :src="img" class="whyus-image"/>
        </div>
        <div class="whyus-content">
            <h1>Why Choose Us</h1>
            <p>Enjoy unique experiences in every place you visit and discover new, affordable adventures.</p>
            <div class="features-box">
                <div class="feature-item" v-for="(feature, index) in features" :key="index" @mouseover="hoveredIndex = index" @mouseleave="hoveredIndex = null" :class="{ 'dimmed': hoveredIndex !== null && hoveredIndex !== index }">
                    <img :src="feature.icon" class="icon"/>
                    <div>
                        <h3>{{ feature.title }}</h3>
                        <p>{{ feature.description }}</p>
                    </div>
                </div>
            </div>
            <router-link to="/register" class="login-text">Create an account! ></router-link>
        </div>
    </div>
</template>

<script>
export default {
  data() {
    return {
      whyusImages: ['../assets/why-us-img.png'],
      features: [
        { icon: '../assets/download-symbol.png', title: 'In-App Storage', description: 'Store your travel documents for your trip directly in the app!' },
        { icon: '../assets/group-symbol.png', title: 'Plan Together', description: 'Invite your friends to the trip and exchange together!' },
        { icon: '../assets/document-symbol.png', title: 'Integrated Blog', description: 'Capture your journey and create an album!' }
      ],
      hoveredIndex: null
    };
  }
};
</script>

<style>
* {
  font-family: 'Outfit', sans-serif;
}

.whyus-container {
  display: flex;
  align-items: center;
  justify-content: center;
  height: 100vh;
}

.whyus-img {
  flex: 1;
  display: flex;
  justify-content: center;
}

.whyus-image {
  width: 400px;
  height: 400px;
  box-shadow: 0px 10px 20px rgba(0, 123, 255, 0.3);
  border-radius: 50%;
}

.whyus-content {
  flex: 1;
  max-width: 500px;
  text-align: left;
  margin-right: 230px;
}

.features-box {
  background: white;
  border-radius: 12px;
  box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
  padding: 20px;
  margin-top: 20px;
}

.feature-item {
  display: flex;
  align-items: center;
  margin-bottom: 15px;
  transition: transform 0.3s ease, background 0.3s ease;
}

.feature-item:hover {
  transform: scale(1.05);
}

.dimmed {
  opacity: 0.5;
  transition: opacity 0.3s ease;
}

.icon {
  width: 30px;
  height: 30px;
  margin-right: 10px;
}

.login-text {
  display: inline-block;
  margin-top: 20px;
  color: black;
  font-weight: bold;
  text-decoration: none;
}
</style>