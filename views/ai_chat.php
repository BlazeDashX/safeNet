<?php
session_start();
// 1. Security Check
if (!isset($_SESSION['status'])) { header("Location: login.php"); exit; }

// 2. Dynamic Back Link
$backLink = ($_SESSION['type'] == 'admin' || $_SESSION['type'] == 'consultant') 
                 ? "admin_consultant/adminDashboard.php" 
                 : "user/userDashboard.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>SAFENET - AI Support</title>
  <link rel="stylesheet" href="../assets/css/ai_chat.css"/>
  <link rel="icon" href="https://img.icons8.com/fluency/48/shield.png"/>
</head>
<body>
  
  <header class="topbar">
    <div class="logo">SAFENET</div>
    <div class="user-info">
      <a href="<?php echo $backLink; ?>" style="color: white; text-decoration: underline;">&larr; Back to Dashboard</a>
    </div>
  </header>

  <div class="container">
    <h2>🤖 AI Mental Support</h2>
    <p style="text-align:center; color:#666; margin-bottom:10px;">I am a virtual assistant. How can I help you today?</p>

    <div class="chat-box" id="chatBox">
        <div class="message bot-msg">Hello! I'm here to listen. You can type a message or click a topic below.</div>
    </div>

    <div class="suggestions" id="suggestionBox">
        <button class="chip" onclick="sendQuickMsg('I am being bullied')">I am being bullied</button>
        <button class="chip" onclick="sendQuickMsg('How do I report?')">How do I report?</button>
        <button class="chip" onclick="sendQuickMsg('Is this anonymous?')">Is this anonymous?</button>
        <button class="chip" onclick="sendQuickMsg('I feel anxious')">I feel anxious</button>
    </div>

    <div class="chat-input">
      <input type="text" id="chatInput" placeholder="Type a message..." onkeypress="handleEnter(event)"/>
      <button onclick="sendMessage()">Send</button>
    </div>

  </div>

  <footer class="bottombar">
    © 2025 SAFENET by AIUB CS Students | All Rights Reserved
  </footer>

  <script src="../assets/js/ai_chat.js"></script>
</body>
</html>