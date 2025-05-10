<template>
  <div class="destination-container" id="destinations">
    <h1>Popular Destinations</h1>
    <img src="@/assets/destinations.svg" alt="popular destinations" class="destinationImg">
  </div>
</template>

<script>
export default {
  name: 'DestinationsSection'
};
</script>

<style scoped>
.destination-container {
  padding: 4rem;
  text-align: center;
}

.destinationImg {
  padding: 2rem;
  filter: drop-shadow(0 10px 20px rgba(0, 0, 0, 0.1));
}

@media (max-width: 768px) {
  .destination-container {
    padding: 2rem 1rem;
  }
}

@media (max-width: 576px) {
  .destination-container h1 {
    font-size: 1.8rem;
    margin-bottom: 1.5rem;
  }
  
  .destinationImg {
    padding: 0;
    width: 100%;
  }
}
</style>