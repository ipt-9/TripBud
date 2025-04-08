<template>
    <div class="chat-container">
    <h1>Chat</h1>
    <!-- Messages display area -->
    <div class="messages-container">
    <div 
            v-for="message in messages" 
            :key="message.id" 
            class="message"
            :class="{ 'my-message': message.user.id === user.id }"
    >
    <strong>{{ message.user.name }}:</strong>
    <p>{{ message.message }}</p>
    <small>{{ formatTime(message.created_at) }}</small>
    </div>
    </div>
    <!-- Message input form -->
    <div class="input-container">
    <input 
            type="text" 
            v-model="newMessage" 
            placeholder="Type your message here..." 
            @keyup.enter="sendMessage"
          />
    <button @click="sendMessage">Send</button>
    </div>
    </div>
    </template>
     
    <script>
    export default {
      data() {
        return {
          messages: [],
          newMessage: '',
          user: {}, // Will be populated with the current authenticated user
          loading: false
        }
      },
      mounted() {
        this.fetchMessages();
        this.getAuthUser();
        this.listenForMessages();
      },
      methods: {
        // Get current authenticated user
        async getAuthUser() {
          try {
            // Replace with your actual user endpoint
            const response = await axios.get('/api/user');
            this.user = response.data;
          } catch (error) {
            console.error('Failed to fetch user:', error);
          }
        },
        // Fetch all messages from the server
        async fetchMessages() {
          this.loading = true;
          try {
            const response = await axios.get('/messages');
            this.messages = response.data;
          } catch (error) {
            console.error('Failed to fetch messages:', error);
          } finally {
            this.loading = false;
          }
        },
        // Send a new message
        async sendMessage() {
          if (!this.newMessage.trim()) return;
          try {
            const response = await axios.post('/messages', {
              message: this.newMessage
            });
            // Add the message to the local messages array
            // Note: The actual message object might come from the response
            // or be received via the WebSocket
            this.messages.push({
              id: Date.now(), // Temporary ID until we receive the real message
              user: this.user,
              message: this.newMessage,
              created_at: new Date()
            });
            // Clear the input field
            this.newMessage = '';
          } catch (error) {
            console.error('Failed to send message:', error);
          }
        },
        // Format timestamp to a readable format
        formatTime(timestamp) {
          return new Date(timestamp).toLocaleTimeString();
        },
        // Listen for incoming messages via WebSockets
        listenForMessages() {
          // Make sure Echo is properly initialized in your bootstrap.js file
          Echo.private('chat')
            .listen('MessageSent', (e) => {
              // Add the new message to our messages array
              this.messages.push({
                id: e.message.id,
                message: e.message.message,
                user: e.user,
                created_at: e.message.created_at
              });
            });
        }
      }
    }
    </script>
     
    <style scoped>
    .chat-container {
      max-width: 600px;
      margin: 0 auto;
      padding: 20px;
    }
     
    .messages-container {
      height: 400px;
      overflow-y: auto;
      border: 1px solid #ccc;
      padding: 10px;
      margin-bottom: 20px;
    }
     
    .message {
      margin-bottom: 10px;
      padding: 8px 12px;
      border-radius: 4px;
      background-color: #f1f1f1;
    }
     
    .my-message {
      background-color: #dcf8c6;
      text-align: right;
    }
     
    .input-container {
      display: flex;
    }
     
    input {
      flex-grow: 1;
      padding: 8px;
      border: 1px solid #ccc;
      border-radius: 4px 0 0 4px;
    }
     
    button {
      padding: 8px 16px;
      background-color: #4caf50;
      color: white;
      border: none;
      border-radius: 0 4px 4px 0;
      cursor: pointer;
    }
     
    button:hover {
      background-color: #45a049;
    }
    </style>