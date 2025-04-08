<template>
  <div class="documents-page">
    <div class="main-content">
      <div class="header">
        <div class="header-left">
          <div class="logo">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path d="M19.5 16.5V5.25C19.5 4.65326 19.2629 4.08097 18.841 3.65901C18.419 3.23705 17.8467 3 17.25 3H6.75C6.15326 3 5.58097 3.23705 5.15901 3.65901C4.73705 4.08097 4.5 4.65326 4.5 5.25V18.75C4.5 19.3467 4.73705 19.919 5.15901 20.341C5.58097 20.7629 6.15326 21 6.75 21H17.25" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
              <path d="M8.25 7.5H15.75" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
              <path d="M8.25 10.5H15.75" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
              <path d="M8.25 13.5H12" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
          </div>
          <h1 class="title">Documents</h1>
        </div>
      </div>

      <div class="action-bar">
        <button class="add-new-btn" @click="openFileDialog">
          <span class="btn-icon">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path d="M12 5V19" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
              <path d="M5 12H19" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
          </span>
          <span>Add New</span>
        </button>
        <input 
          type="file" 
          ref="fileInput" 
          @change="handleFileUpload" 
          style="display: none;" 
          multiple
        />
        <h2 class="section-title">{{ currentFilter }}</h2>
      </div>

      <div class="content-layout">
        <div class="sidebar">
          <div 
            class="sidebar-item" 
            :class="{ active: currentFilter === 'All Files' }" 
            @click="setFilter('All Files')"
          >
            <div class="sidebar-icon">
              <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M3 9L12 2L21 9V20C21 20.5304 20.7893 21.0391 20.4142 21.4142C20.0391 21.7893 19.5304 22 19 22H5C4.46957 22 3.96086 21.7893 3.58579 21.4142C3.21071 21.0391 3 20.5304 3 20V9Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                <path d="M9 22V12H15V22" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
              </svg>
            </div>
            <span>All Files</span>
          </div>
          <div 
            class="sidebar-item" 
            :class="{ active: currentFilter === 'Own files' }" 
            @click="setFilter('Own files')"
          >
            <div class="sidebar-icon">
              <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M20 12V20C20 20.5304 19.7893 21.0391 19.4142 21.4142C19.0391 21.7893 18.5304 22 18 22H6C5.46957 22 4.96086 21.7893 4.58579 21.4142C4.21071 21.0391 4 20.5304 4 20V4C4 3.46957 4.21071 2.96086 4.58579 2.58579C4.96086 2.21071 5.46957 2 6 2H14L20 8V12Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                <path d="M14 2V8H20" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
              </svg>
            </div>
            <span>Own files</span>
          </div>
          <div 
            class="sidebar-item" 
            :class="{ active: currentFilter === 'Shared' }" 
            @click="setFilter('Shared')"
          >
            <div class="sidebar-icon">
              <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M18 8C19.6569 8 21 6.65685 21 5C21 3.34315 19.6569 2 18 2C16.3431 2 15 3.34315 15 5C15 6.65685 16.3431 8 18 8Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                <path d="M6 15C7.65685 15 9 13.6569 9 12C9 10.3431 7.65685 9 6 9C4.34315 9 3 10.3431 3 12C3 13.6569 4.34315 15 6 15Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                <path d="M18 22C19.6569 22 21 20.6569 21 19C21 17.3431 19.6569 16 18 16C16.3431 16 15 17.3431 15 19C15 20.6569 16.3431 22 18 22Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                <path d="M8.59 13.51L15.42 17.49" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                <path d="M15.41 6.51L8.59 10.49" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
              </svg>
            </div>
            <span>Shared</span>
          </div>
          <div 
            class="sidebar-item" 
            :class="{ active: currentFilter === 'Favourites' }" 
            @click="setFilter('Favourites')"
          >
            <div class="sidebar-icon">
              <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M19.9181 9.32636C19.8395 9.09698 19.7016 8.89358 19.5188 8.73928C19.336 8.58499 19.1152 8.48533 18.8831 8.45273L13.9331 7.82273L11.7031 3.33818C11.593 3.12345 11.4264 2.94481 11.222 2.82241C11.0175 2.70001 10.7835 2.63855 10.5456 2.64545C10.3077 2.65235 10.0781 2.72736 9.88147 2.86182C9.68485 2.99627 9.52929 3.18353 9.43311 3.40364L7.20311 7.87727L2.25311 8.50727C2.03252 8.54235 1.82495 8.6402 1.65111 8.79009C1.47728 8.93999 1.34516 9.13651 1.26971 9.35744C1.19426 9.57837 1.17823 9.81536 1.22346 10.0438C1.2687 10.2723 1.37363 10.4841 1.52493 10.6564L5.10674 14.14L4.35856 19.0691C4.31822 19.2905 4.34099 19.5182 4.42413 19.7273C4.50727 19.9364 4.64734 20.1184 4.8282 20.2545C5.00906 20.3906 5.22425 20.4756 5.44963 20.5007C5.67501 20.5258 5.90286 20.49 6.10583 20.3973L10.5713 18.0673L15.0185 20.3973C15.2214 20.4889 15.4486 20.5241 15.6733 20.4991C15.898 20.4741 16.1126 20.3897 16.293 20.2544C16.4734 20.1191 16.6133 19.9379 16.6966 19.7297C16.7798 19.5215 16.8031 19.2946 16.7635 19.0736L16.0153 14.14L19.6062 10.6582C19.759 10.4865 19.8654 10.2747 19.9118 10.0459C19.9581 9.81716 19.9426 9.57948 19.8674 9.35782L19.9181 9.32636Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
              </svg>
            </div>
            <span>Favourites</span>
          </div>
        </div>

        <div class="files-container">
          <div class="glass-morphism">
            <table class="files-table">
              <thead>
                <tr>
                  <th class="th-name">Name</th>
                  <th class="th-size">Size</th>
                  <th class="th-open">Open</th>
                  <th class="th-owner">Owner</th>
                  <th class="th-actions">Actions</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="file in filteredFiles" :key="file.id" class="file-row">
                  <td class="td-name">
                    <div class="file-name-wrapper">
                      <div class="file-icon">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                          <path d="M14 2H6C5.46957 2 4.96086 2.21071 4.58579 2.58579C4.21071 2.96086 4 3.46957 4 4V20C4 20.5304 4.21071 21.0391 4.58579 21.4142C4.96086 21.7893 5.46957 22 6 22H18C18.5304 22 19.0391 21.7893 19.4142 21.4142C19.7893 21.0391 20 20.5304 20 20V8L14 2Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                          <path d="M14 2V8H20" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                          <path d="M16 13H8" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                          <path d="M16 17H8" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                          <path d="M10 9H9H8" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                      </div>
                      <span class="file-name">{{ file.name }}</span>
                    </div>
                  </td>
                  <td class="td-size">{{ formatFileSize(file.size) }}</td>
                  <td class="td-open">{{ file.lastOpened }}</td>
                  <td class="td-owner">{{ file.owner }}</td>
                  <td class="td-actions">
                    <button class="action-btn favourite-btn" @click="toggleFavourite(file)" :title="file.isFavourite ? 'Remove from favorites' : 'Add to favorites'">
                      <div class="btn-icon-container">
                        <transition name="favorite">
                          <svg v-if="!file.isFavourite" class="icon-unfavorite" width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M19.9181 9.32636C19.8395 9.09698 19.7016 8.89358 19.5188 8.73928C19.336 8.58499 19.1152 8.48533 18.8831 8.45273L13.9331 7.82273L11.7031 3.33818C11.593 3.12345 11.4264 2.94481 11.222 2.82241C11.0175 2.70001 10.7835 2.63855 10.5456 2.64545C10.3077 2.65235 10.0781 2.72736 9.88147 2.86182C9.68485 2.99627 9.52929 3.18353 9.43311 3.40364L7.20311 7.87727L2.25311 8.50727C2.03252 8.54235 1.82495 8.6402 1.65111 8.79009C1.47728 8.93999 1.34516 9.13651 1.26971 9.35744C1.19426 9.57837 1.17823 9.81536 1.22346 10.0438C1.2687 10.2723 1.37363 10.4841 1.52493 10.6564L5.10674 14.14L4.35856 19.0691C4.31822 19.2905 4.34099 19.5182 4.42413 19.7273C4.50727 19.9364 4.64734 20.1184 4.8282 20.2545C5.00906 20.3906 5.22425 20.4756 5.44963 20.5007C5.67501 20.5258 5.90286 20.49 6.10583 20.3973L10.5713 18.0673L15.0185 20.3973C15.2214 20.4889 15.4486 20.5241 15.6733 20.4991C15.898 20.4741 16.1126 20.3897 16.293 20.2544C16.4734 20.1191 16.6133 19.9379 16.6966 19.7297C16.7798 19.5215 16.8031 19.2946 16.7635 19.0736L16.0153 14.14L19.6062 10.6582C19.759 10.4865 19.8654 10.2747 19.9118 10.0459C19.9581 9.81716 19.9426 9.57948 19.8674 9.35782L19.9181 9.32636Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                          </svg>
                          <svg v-else class="icon-favorite" width="20" height="20" viewBox="0 0 24 24" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                            <path d="M12 2L15.09 8.26L22 9.27L17 14.14L18.18 21.02L12 17.77L5.82 21.02L7 14.14L2 9.27L8.91 8.26L12 2Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                          </svg>
                        </transition>
                      </div>
                    </button>
                    <button class="action-btn delete-btn" @click="deleteFile(file)" title="Delete file">
                      <div class="btn-icon-container">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                          <path d="M3 6H5H21" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                          <path d="M8 6V4C8 3.46957 8.21071 2.96086 8.58579 2.58579C8.96086 2.21071 9.46957 2 10 2H14C14.5304 2 15.0391 2.21071 15.4142 2.58579C15.7893 2.96086 16 3.46957 16 4V6M19 6V20C19 20.5304 18.7893 21.0391 18.4142 21.4142C18.0391 21.7893 17.5304 22 17 22H7C6.46957 22 5.96086 21.7893 5.58579 21.4142C5.21071 21.0391 5 20.5304 5 20V6H19Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                          <path d="M10 11V17" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                          <path d="M14 11V17" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                      </div>
                    </button>
                  </td>
                </tr>
                <tr v-if="filteredFiles.length === 0" class="empty-state">
                  <td colspan="5">
                    <div class="empty-message">
                      <svg width="64" height="64" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M22 19V3C22 2.46957 21.7893 1.96086 21.4142 1.58579C21.0391 1.21071 20.5304 1 20 1H8C7.46957 1 6.96086 1.21071 6.58579 1.58579C6.21071 1.96086 6 2.46957 6 3V17M6 17C6 17.5304 6.21071 18.0391 6.58579 18.4142C6.96086 18.7893 7.46957 19 8 19H19.5C20.0304 19 20.5391 18.7893 20.9142 18.4142C21.2893 18.0391 21.5 17.5304 21.5 17V11.5M6 17V22C6 22.5304 6.21071 23.0391 6.58579 23.4142C6.96086 23.7893 7.46957 24 8 24H20C20.5304 24 21.0391 23.7893 21.4142 23.4142C21.7893 23.0391 22 22.5304 22 22V19" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M15 1V8L12 6L9 8V1" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                      </svg>
                      <p>No files found in this category</p>
                      <button class="empty-add-btn" @click="openFileDialog">Upload Files</button>
                    </div>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'Documents',
  data() {
    return {
      currentFilter: 'All Files',
      files: [
        {
          id: 1,
          name: 'Berechne das Ergebnis der logischen Operation.docx',
          size: 17.05 * 1024,
          lastOpened: 'Just now',
          owner: 'Piravinth Mylvaganam',
          isFavourite: false,
          isShared: false
        },
        {
          id: 2,
          name: 'AliceMessage.docx',
          size: 13.55 * 1024,
          lastOpened: 'Just now',
          owner: 'Piravinth Mylvaganam',
          isFavourite: false,
          isShared: false
        },
        {
          id: 3,
          name: 'AliceMessage.docx',
          size: 13.55 * 1024,
          lastOpened: 'Just now',
          owner: 'Piravinth Mylvaganam',
          isFavourite: false,
          isShared: false
        },
        {
          id: 4,
          name: 'Trip Florence',
          size: 532 * 1024 * 1024,
          lastOpened: '9 min ago',
          owner: 'Piravinth Mylvaganam',
          isFavourite: false,
          isShared: true
        },
        {
          id: 5,
          name: 'Activities Florence',
          size: 22 * 1024 * 1024,
          lastOpened: '2h ago',
          owner: 'Glenn van Wyl',
          isFavourite: false,
          isShared: false
        },
        {
          id: 6,
          name: 'Travel ticket',
          size: 175 * 1024 * 1024,
          lastOpened: '4h ago',
          owner: 'Piravinth Mylvaganam',
          isFavourite: false,
          isShared: true
        },
        {
          id: 7,
          name: 'Members',
          size: 43 * 1024 * 1024,
          lastOpened: 'Thu at 16:35',
          owner: 'Sandro Sliškovic',
          isFavourite: false,
          isShared: false
        },
        {
          id: 8,
          name: 'Map',
          size: 199 * 1024 * 1024,
          lastOpened: 'Thu at 10:15',
          owner: 'Raul Gheorghiu',
          isFavourite: false,
          isShared: false
        }
      ],
      currentUser: 'Piravinth Mylvaganam'
    };
  },
  computed: {
    filteredFiles() {
      switch (this.currentFilter) {
        case 'Own files':
          return this.files.filter(file => file.owner === this.currentUser);
        case 'Shared':
          return this.files.filter(file => file.isShared);
        case 'Favourites':
          return this.files.filter(file => file.isFavourite);
        default:
          return this.files;
      }
    }
  },
  methods: {
    setFilter(filter) {
      this.currentFilter = filter;
    },
    openFileDialog() {
      this.$refs.fileInput.click();
    },
    handleFileUpload(event) {
      const files = event.target.files;
      if (files.length === 0) return;

      for (let i = 0; i < files.length; i++) {
        const file = files[i];
        
        const newFile = {
          id: Date.now() + i,
          name: file.name,
          size: file.size,
          lastOpened: 'Just now',
          owner: this.currentUser,
          isFavourite: false,
          isShared: false
        };
        
        this.files.unshift(newFile);
      }
      
      event.target.value = '';
    },
    formatFileSize(bytes) {
      if (bytes === 0) return '0 Bytes';
      
      const sizes = ['Bytes', 'KB', 'MB', 'GB', 'TB'];
      const i = Math.floor(Math.log(bytes) / Math.log(1024));
      
      return parseFloat((bytes / Math.pow(1024, i)).toFixed(2)) + ' ' + sizes[i];
    },
    toggleFavourite(file) {
      file.isFavourite = !file.isFavourite;
    },
    deleteFile(file) {
      this.files = this.files.filter(f => f.id !== file.id);
    }
  }
};
</script>

<style>
.documents-page {
  display: flex;
  height: 100vh;
  background: linear-gradient(to bottom, #e0f2fe, #ffffff);
  font-family: 'Arial', sans-serif;
  color: #333;
  overflow: hidden;
}

.main-content {
  flex: 1;
  padding: 24px;
  display: flex;
  flex-direction: column;
  max-width: 1400px;
  margin: 0 auto;
  width: 100%;
}

.header {
  display: flex;
  align-items: center;
  margin-bottom: 24px;
}

.header-left {
  display: flex;
  align-items: center;
}

.logo {
  width: 48px;
  height: 48px;
  background-color: #4695FF;
  border-radius: 12px;
  display: flex;
  align-items: center;
  justify-content: center;
  margin-right: 16px;
  color: white;
  font-size: 22px;
  box-shadow: 0 4px 6px rgba(70, 149, 255, 0.2);
  transition: transform 0.2s, box-shadow 0.2s;
}

.logo:hover {
  transform: translateY(-2px);
  box-shadow: 0 6px 8px rgba(70, 149, 255, 0.3);
}

.title {
  font-size: 28px;
  font-weight: 700;
  color: #2d3748;
  letter-spacing: -0.5px;
}

.action-bar {
  display: flex;
  align-items: center;
  margin-bottom: 28px;
}

.add-new-btn {
  background-color: #4695FF;
  color: white;
  border: none;
  padding: 12px 24px;
  border-radius: 8px;
  font-size: 15px;
  font-weight: 600;
  cursor: pointer;
  margin-right: 24px;
  box-shadow: 0 4px 6px rgba(70, 149, 255, 0.2);
  transition: all 0.2s ease;
  display: flex;
  align-items: center;
  justify-content: center;
}

.add-new-btn:hover {
  background-color: #3a87ff;
  transform: translateY(-2px);
  box-shadow: 0 6px 8px rgba(70, 149, 255, 0.3);
}

.add-new-btn:active {
  transform: translateY(0);
  box-shadow: 0 2px 4px rgba(70, 149, 255, 0.2);
}

.section-title {
  font-size: 22px;
  font-weight: 600;
  color: #2d3748;
  letter-spacing: -0.5px;
}

.content-layout {
  display: flex;
  flex: 1;
  gap: 24px;
  overflow: hidden;
}

.sidebar {
  width: 220px;
  flex-shrink: 0;
  padding-right: 8px;
}

.sidebar-item {
  display: flex;
  align-items: center;
  padding: 14px 16px;
  border-radius: 10px;
  margin-bottom: 10px;
  color: #64748b;
  cursor: pointer;
  transition: all 0.2s ease;
  font-weight: 500;
}

.sidebar-item i {
  margin-right: 12px;
  font-size: 16px;
  width: 20px;
  text-align: center;
}

.sidebar-item.active {
  background-color: #e0f2ff;
  color: #4695FF;
  font-weight: 600;
  box-shadow: 0 2px 4px rgba(70, 149, 255, 0.1);
}

.sidebar-item:hover:not(.active) {
  background-color: #f8f9fa;
  color: #475569;
}

/* Files container */
.files-container {
  flex: 1;
  background-color: white;
  border-radius: 12px;
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
  overflow: auto;
}

/* Files table */
.files-table {
  width: 100%;
  border-collapse: separate;
  border-spacing: 0;
}

thead {
  position: sticky;
  top: 0;
  z-index: 10;
  background-color: #f8fafc;
  border-radius: 12px 12px 0 0;
}

th {
  padding: 16px 20px;
  text-align: left;
  color: #64748b;
  font-weight: 600;
  font-size: 14px;
  border-bottom: 1px solid #edf2f7;
}

.th-actions {
  text-align: center;
  width: 120px;
}

.th-size {
  width: 120px;
}

.th-open {
  width: 120px;
}

.th-owner {
  width: 200px;
}

.file-row {
  transition: background-color 0.15s;
}

.file-row:hover {
  background-color: #f8fafc;
}

td {
  padding: 16px 20px;
  color: #334155;
  font-size: 14px;
  border-bottom: 1px solid #f1f5f9;
}

.td-name {
  max-width: 400px;
  overflow: hidden;
  text-overflow: ellipsis;
  white-space: nowrap;
}

.file-name-wrapper {
  display: flex;
  align-items: center;
}

.file-icon {
  width: 36px;
  height: 36px;
  background-color: #f0f8ff;
  border-radius: 6px;
  display: flex;
  align-items: center;
  justify-content: center;
  margin-right: 12px;
  color: #4695FF;
}

.file-name {
  flex: 1;
  overflow: hidden;
  text-overflow: ellipsis;
  white-space: nowrap;
}

.td-actions {
  display: flex;
  justify-content: flex-end;
  gap: 12px;
}

.action-btn {
  background: none;
  border: none;
  cursor: pointer;
  padding: 8px;
  border-radius: 6px;
  transition: all 0.2s;
  display: flex;
  align-items: center;
  justify-content: center;
}

.action-btn:hover {
  background-color: #f1f5f9;
}

.favourite-btn {
  color: #94a3b8;
}

.favourite-btn:hover {
  color: #f59e0b;
}

.favourite-btn i.fa-heart {
  color: #f59e0b;
}

.delete-btn {
  color: #94a3b8;
}

.delete-btn:hover {
  color: #ef4444;
  background-color: #fee2e2;
}

/* Empty state */
.empty-state {
  height: 200px;
}

.empty-message {
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  padding: 40px;
  color: #94a3b8;
}

.empty-message i {
  font-size: 48px;
  margin-bottom: 16px;
  opacity: 0.5;
}

.empty-message p {
  font-size: 16px;
  opacity: 0.8;
}

/* Responsive adjustments */
@media (max-width: 1024px) {
  .th-open, .td-open {
    display: none;
  }
}

@media (max-width: 768px) {
  .content-layout {
    flex-direction: column;
  }
  
  .sidebar {
    width: 100%;
    display: flex;
    overflow-x: auto;
    padding-bottom: 16px;
  }
  
  .sidebar-item {
    flex-shrink: 0;
    margin-right: 8px;
    margin-bottom: 0;
  }
  
  .th-owner, .td-owner {
    display: none;
  }
}

@media (max-width: 480px) {
  .th-size, .td-size {
    display: none;
  }
  
  .logo {
    width: 40px;
    height: 40px;
    font-size: 18px;
  }
  
  .title {
    font-size: 22px;
  }
  
  .add-new-btn {
    padding: 10px 16px;
    font-size: 14px;
  }
}
</style>