<?php
session_start();
include '../../includes/db.php';
include '../../includes/functions.php';

if (!isLoggedIn()) {
    redirect('../../index.php');
}

$community_id = $_GET['community_id'];
$community_name = $_GET['community_name'];
$username = $_SESSION['username'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?php echo $community_name;?> Chat</title>
  <style>
    
    @import url('https://fonts.googleapis.com/css2?family=Comic+Neue:ital,wght@0,300;0,400;0,700;1,300;1,400;1,700&family=Open+Sans:ital,wght@0,401;1,401&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap');
    

    @import url('https://fonts.googleapis.com/css2?family=Comic+Neue:ital,wght@0,300;0,400;0,700;1,300;1,400;1,700&family=Open+Sans:ital,wght@0,401;1,401&display=swap');

    body {
    
      margin: 0;
      padding: 0;
      background: white;
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      height: 100%;
    }
    #title_container, #chat_container {
      width: 100%;
      max-width: 800px;
      padding: 0 0 10 10px;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
      background: #fff;
      border-radius: 8px;
      margin-bottom: 10px;
      margin-top: 5px;
      margin-bottom:5px;
      background-color:red;
    }
    #title_container p {
      text-align: center;
      color: #333;
      font-size: 20px;
      font-family:Poppins;
      margin-bottom: 5px;
     
    }
    #chat_input_container {
      display: flex;
      gap: 10px;
      align-items: center;
    }
    #chat_input {
      flex-grow: 1;
      padding: 10px;
      border: 1px solid #ccc;
      border-radius: 4px;
    }
    #chat_input_send, #chat_logout {
      padding: 10px 20px;
      background: #007bff;
      color: #fff;
      border: none;
      border-radius: 4px;
      cursor: pointer;
      transition: background 0.3s ease;
    }
    #chat_input_send:hover, #chat_logout:hover {
      background: #0056b3;
    }
    .message_container {
      font-family: "Poppins", serif;
      font-size: 16px;
      padding: 10px;
      margin-bottom: 10px;
      border: 1px solid #ddd;
      border-radius: 4px;
      background: #f9f9f9;
    }
    .message_user {
      font-weight: bold;
      margin-bottom: 5px;
      color:rgb(196, 24, 208);
    }
    .message_text {
      margin: 0;
      font-family: "Comic Neue", cursive;
      font-size: 20px;
      word-spacing: 1px;
      letter-spacing: 0.5px;
      font-weight: 550;
     
      color: #333;
    }
    #chat_messages {
      max-height: 570px;
      overflow-y: auto;
      margin-bottom: 10px;
    }
    .creadit {
      text-align: right;
      
    }
  </style>
</head>
<body>
  <div id="title_container">
    <p>Welcome to the <?php echo $community_name;?> Chat, <span id="user_name"></span></p>
  </div>
  <div id="chat_container">
    <div id="chat_messages"></div>
    <div id="chat_input_container">
      <input id="chat_input" type="text" placeholder="Type your message">
      <button id="chat_input_send" disabled>Send</button>
  </div>
  <!-- </div>
  <div class="creadit">
  <p>Powered by GroupAE and Firebase</p>
  <p>Copyright &copy; 2024 GroupAE. All rights reserved.</p>
  <p>Manuja Demin 😎</p>
  </div> -->
  <script type="module">
    import { initializeApp } from "https://www.gstatic.com/firebasejs/9.15.0/firebase-app.js";
    import { getDatabase, ref, push, onValue } from "https://www.gstatic.com/firebasejs/9.15.0/firebase-database.js";

    const firebaseConfig = {
      apiKey: "AIzaSyADKIObzHtPYSmySSCqXNCEWY4X4GdNB2k",
      authDomain: "grpae-aecc7.firebaseapp.com",
      databaseURL: "https://grpae-aecc7-default-rtdb.firebaseio.com",
      projectId: "grpae-aecc7",
      storageBucket: "grpae-aecc7.firebasestorage.app",
      messagingSenderId: "363177740692",
      appId: "1:363177740692:web:b35068e58d8130b8bd6781"
    };
    

    const app = initializeApp(firebaseConfig);
    const db = getDatabase(app);
    // meken thama firebase ekata names id yanne
    const username = "<?php echo addslashes($_SESSION['username']); ?>";
    const communityId = "<?php echo addslashes($_GET['community_id']); ?>";
    document.getElementById("user_name").textContent = username;
   //meka thama e class eka chat app  ara 4 15 watune  methanin 
    class ChatApp {
      constructor(username, communityId) {  
        this.username = username;
        this.communityId = communityId;
        this.init();
      }

      init() {
        this.loadChat();
      }

      loadChat() {
        const chatInput = document.getElementById("chat_input");
        const sendButton = document.getElementById("chat_input_send");
       
        const chatMessages = document.getElementById("chat_messages");

        chatInput.addEventListener("input", () => {
          sendButton.disabled = !chatInput.value.trim();
        });

        chatInput.addEventListener("keypress", (event) => {
          if (event.key === "Enter" && chatInput.value.trim()) {
            this.sendMessage(chatInput.value.trim());
            chatInput.value = "";
            sendButton.disabled = true;
          }
        });

        sendButton.addEventListener("click", () => {
          const message = chatInput.value.trim();
          if (message) {
            this.sendMessage(message);
            chatInput.value = "";
            sendButton.disabled = true;
          }
        });
    
        this.refreshChat(chatMessages);
      }
            
      sendMessage(message) {
        const messagesRef = ref(db, chats/${this.communityId});
        push(messagesRef, {
          name: this.username,
          message: message,
          timestamp: Date.now()
        });
      }

      refreshChat(chatMessages) {
        const messagesRef = ref(db, chats/${this.communityId});
        onValue(messagesRef, (snapshot) => {
          chatMessages.innerHTML = "";
          const messages = snapshot.val();
          if (messages) {
            Object.values(messages)
              .sort((a, b) => a.timestamp - b.timestamp)
              .forEach((msg) => {
                const messageEl = document.createElement("div");
                messageEl.className = "message_container";
                messageEl.innerHTML = `
                  <p class="message_user">${msg.name}</p>
                  <p class="message_text">${msg.message}</p>
                `;
                chatMessages.appendChild(messageEl);
              });

            chatMessages.scrollTop = chatMessages.scrollHeight;
          }
        });
      }
    }
 
    new ChatApp(username, communityId);
  </script>
</body>
</html>