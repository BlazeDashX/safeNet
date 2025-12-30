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
  <title>SAFENET - Awareness Hub</title>
  <link rel="stylesheet" href="../assets/css/awareness.css"/>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
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
    <h2>🛡️ Cyber Safety Awareness Hub</h2>
    <p class="subtitle">Learn how to protect yourself and others online.</p>

    <div class="section-title">Featured Video</div>
    <div class="video-container">
        <iframe width="100%" height="400" src="https://www.youtube.com/embed/yrln8nyVBLU" title="Cyber Security Awareness" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
    </div>

    <div class="section-title">Read & Learn (Wikipedia)</div>
    <div class="resource-grid">
      
      <div class="resource-card" onclick="window.open('https://en.wikipedia.org/wiki/Cyberbullying', '_blank')">
        <div class="icon-box"><i class="fa-solid fa-book-open"></i></div>
        <h3>Cyberbullying</h3>
        <p>Understand the definition, forms, and laws regarding online harassment.</p>
      </div>
      
      <div class="resource-card" onclick="window.open('https://en.wikipedia.org/wiki/Internet_safety', '_blank')">
        <div class="icon-box"><i class="fa-solid fa-user-shield"></i></div>
        <h3>Internet Safety</h3>
        <p>Learn about computer security, privacy, and safe online behavior.</p>
      </div>

      <div class="resource-card" onclick="window.open('https://en.wikipedia.org/wiki/Cyberstalking', '_blank')">
        <div class="icon-box"><i class="fa-solid fa-eye"></i></div>
        <h3>Cyberstalking</h3>
        <p>Read about the use of internet to stalk or harass an individual.</p>
      </div>
    </div>

    <div class="section-title">🧠 Test Your Knowledge</div>
    <div class="quiz-box">
        <form id="quizForm">
            <div class="question">
                <p>1. What should you do if a stranger asks for your password?</p>
                <label><input type="radio" name="q1" value="wrong"> Give it to them if they look nice.</label><br>
                <label><input type="radio" name="q1" value="correct"> Never share it and block them.</label>
            </div>

            <div class="question">
                <p>2. Is forwarding a mean message considered cyberbullying?</p>
                <label><input type="radio" name="q2" value="correct"> Yes, you are spreading the harm.</label><br>
                <label><input type="radio" name="q2" value="wrong"> No, because I didn't write it.</label>
            </div>

            <button type="submit" class="quiz-btn">Check My Score</button>
            <p id="quizResult"></p>
        </form>
    </div>

  </div>

  <footer class="bottombar">
    © 2025 SAFENET by AIUB CS Students | All Rights Reserved
  </footer>

  <script src="../assets/js/awareness.js"></script>
</body>
</html>