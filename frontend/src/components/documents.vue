<template>
    <div class="documents-container">
      <!-- Sidebar -->
      <div class="sidebar">
        <div class="sidebar-item" @click="toggleFilter('all')">
          <i class="fas fa-home"></i>
          <span>Alle Dateien</span>
        </div>
        <div class="sidebar-item" @click="toggleFilter('own')">
          <i class="fas fa-folder"></i>
          <span>Eigene Dateien</span>
        </div>
        <div class="sidebar-item" @click="toggleFilter('shared')">
          <i class="fas fa-share-alt"></i>
          <span>Geteilt</span>
        </div>
        <div class="sidebar-item" @click="toggleFilter('favorite')">
          <i class="fas fa-star"></i>
          <span>Favoriten</span>
        </div>
      </div>
  
      <!-- Hauptinhalt -->
      <div class="content">
        <!-- Header -->
        <div class="header">
          <h1>Dokumente</h1>
          <div class="add-new-btn-container">
            <label for="file-input" class="add-new-btn">+ Neue Datei</label>
            <input type="file" id="file-input" @change="addNewFile" style="display: none;">
          </div>
        </div>
  
        <!-- Dateiliste als Tabelle -->
        <table class="file-table">
          <thead>
            <tr>
              <th>Name</th>
              <th>Size</th>
              <th>Open</th>
              <th>Owner</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="file in filteredFiles" :key="file.id">
              <td>{{ file.name }}</td>
              <td>{{ formatFileSize(file.size) }}</td>
              <td>
                <i class="fas fa-external-link-alt" @click="openFile(file)"></i>
              </td>
              <td>{{ file.owner }}</td>
              <td>
                <button class="action-btn favorite-btn" @click="toggleFavorite(file)">
                  <i class="fas" :class="{ 'fa-star': file.isFavorite, 'fa-star-o': !file.isFavorite }"></i>
                </button>
                <button class="action-btn delete-btn" @click="deleteFile(file)">
                  <i class="fas fa-trash"></i>
                </button>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </template>
  
  <script>
  export default {
    name: 'Documents',
    data() {
      return {
        files: [
          {
            id: 1,
            name: 'Ogilvy_useful_info.docx',
            size: 1.83 * 1024 * 1024, // 1.83 MB
            createdAt: new Date('2025-03-25T16:29:00'),
            owner: 'Du',
            isFavorite: false,
            url: '#'
          },
          {
            id: 2,
            name: 'Trip_Florence.pdf',
            size: 532 * 1024 * 1024, // 532 MB
            createdAt: new Date('2025-03-25T15:52:00'),
            owner: 'Piravinth Mylvaganam',
            isFavorite: true,
            url: '#'
          }
        ],
        filterBy: 'all',
        nextFileId: 3
      };
    },
    computed: {
      filteredFiles() {
        return this.files.filter(file => {
          switch (this.filterBy) {
            case 'own':
              return file.owner === 'Du';
            case 'shared':
              return file.owner !== 'Du';
            case 'favorite':
              return file.isFavorite;
            default:
              return true;
          }
        });
      }
    },
    methods: {
      addNewFile(event) {
        const file = event.target.files[0];
        if (file) {
          const newFile = {
            id: this.nextFileId++,
            name: file.name,
            size: file.size,
            createdAt: new Date(),
            owner: 'Du',
            isFavorite: false,
            url: URL.createObjectURL(file)
          };
          this.files.push(newFile);
        }
      },
      openFile(file) {
        window.open(file.url, '_blank');
      },
      toggleFavorite(file) {
        file.isFavorite = !file.isFavorite;
      },
      deleteFile(file) {
        this.files = this.files.filter(f => f.id !== file.id);
      },
      toggleFilter(filterBy) {
        this.filterBy = filterBy;
      },
      formatFileSize(size) {
        const units = ['B', 'KB', 'MB', 'GB', 'TB'];
        let i = 0;
        while (size >= 1024 && i < units.length - 1) {
          size /= 1024;
          i++;
        }
        return `${size.toFixed(2)} ${units[i]}`;
      }
    }
  };
  </script>
  
  <style scoped>
  .documents-container {
    display: flex;
    height: 100vh;
    background: linear-gradient(to bottom, #e0f2fe, #ffffff);
  }
  
  .sidebar {
    background-color: #f1f1f1;
    padding: 20px;
    width: 200px;
  }
  
  .sidebar-item {
    display: flex;
    align-items: center;
    padding: 10px;
    cursor: pointer;
  }
  
  .sidebar-item i {
    margin-right: 10px;
  }
  
  .content {
    flex: 1;
    padding: 20px;
  }
  
  .header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 20px;
  }
  
  .add-new-btn-container {
    position: relative;
  }
  
  .add-new-btn {
    background-color: #4695FF;
    color: white;
    border: none;
    padding: 10px 20px;
    border-radius: 5px;
    cursor: pointer;
  }
  
  .file-table {
    width: 100%;
    border-collapse: collapse;
  }
  
  .file-table th,
  .file-table td {
    padding: 10px;
    text-align: left;
    border-bottom: 1px solid #ddd;
  }
  
  .file-table th {
    background-color: #f1f1f1;
  }
  
  .file-table td i {
    font-size: 18px;
    cursor: pointer;
    color: #4695FF;
  }
  
  .action-btn {
    background: none;
    border: none;
    cursor: pointer;
    padding: 5px;
    margin: 0 2px;
  }
  
  .favorite-btn i {
    color: #FFD700; /* Gold für Favoriten */
  }
  
  .delete-btn i {
    color: #FF0000; /* Rot für Löschen */
  }
  </style>
  