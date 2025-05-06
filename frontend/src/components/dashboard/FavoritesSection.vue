// FavoritesSection.vue
<template>
  <section class="section favourites-section">
    <h2 class="section-title">Favourites</h2>
    <div class="favourites-list">
      <div class="favourites-header">
        <div class="fav-col name-col">Name</div>
        <div class="fav-col size-col">Size</div>
        <div class="fav-col owner-col">Owner</div>
      </div>
      <div class="favourites-items">
        <div 
          v-for="(item, index) in favoriteItems" 
          :key="index"
          class="fav-item"
        >
          <div class="fav-col name-col">
            <div :class="['fav-icon', item.iconType + '-icon']"></div>
            <span class="fav-name">{{ item.name }}</span>
            <button class="fav-heart" :class="{ active: item.isFavorite }" @click="toggleFavorite(index)">❤</button>
          </div>
          <div class="fav-col size-col">{{ item.size }}</div>
          <div class="fav-col owner-col">{{ item.owner }}</div>
        </div>
      </div>
    </div>
  </section>
</template>

<script>
export default {
  name: 'FavoritesSection',
  data() {
    return {
      favoriteItems: [
        {
          name: 'Trip Florence',
          iconType: 'doc',
          size: '532 MB',
          owner: 'Piravinth Mylvaganam',
          isFavorite: true
        },
        {
          name: 'Travel ticket',
          iconType: 'img',
          size: '22 MB',
          owner: 'Piravinth Mylvaganam',
          isFavorite: true
        },
        {
          name: 'Plane ticket',
          iconType: 'img',
          size: '175 MB',
          owner: 'Sandro Sliskovic',
          isFavorite: true
        }
      ]
    };
  },
  methods: {
    toggleFavorite(index) {
      this.favoriteItems[index].isFavorite = !this.favoriteItems[index].isFavorite;
    }
  }
}
</script>

<style scoped>
.favourites-section {
  grid-column: 2;
  grid-row: 1;
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
 
.favourites-header {
  display: flex;
  border-bottom: 1px solid #f0f0f0;
  padding-bottom: 0.75rem;
  margin-bottom: 0.75rem;
  font-weight: 500;
  color: #777;
}
 
.favourites-items {
  display: flex;
  flex-direction: column;
}
 
.fav-item {
  display: flex;
  align-items: center;
  padding: 0.75rem 0;
  border-bottom: 1px solid #f9f9f9;
}
 
.name-col {
  display: flex;
  align-items: center;
  flex: 2;
}
 
.size-col {
  flex: 1;
  text-align: center;
  color: #666;
}
 
.owner-col {
  flex: 2;
  text-align: right;
  color: #666;
  font-size: 0.9rem;
}
 
.fav-icon {
  width: 30px;
  height: 30px;
  border-radius: 5px;
  margin-right: 0.75rem;
  display: flex;
  align-items: center;
  justify-content: center;
}
 
.doc-icon {
  background-color: #e3f2fd;
}
 
.img-icon {
  background-color: #e8f5e9;
}
 
.fav-name {
  font-weight: 500;
}
 
.fav-heart {
  background: none;
  border: none;
  cursor: pointer;
  margin-left: 0.75rem;
  color: #ccc;
  font-size: 0.9rem;
  transition: color 0.2s ease;
}

.fav-heart.active {
  color: #ff5252;
}

@media (max-width: 1200px) {
  .favourites-section {
    grid-column: 1;
    grid-row: 3;
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

  .favourites-header, .fav-item {
    font-size: 0.9rem;
  }
 
  .size-col {
    display: none;
  }
 
  .name-col {
    flex: 1;
  }
 
  .owner-col {
    flex: 1;
  }
}

@media (max-width: 320px) {
  .favourites-section .owner-col {
    display: none;
  }
}
</style>