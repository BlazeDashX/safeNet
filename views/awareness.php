<?php
session_start();

// 1. Session check
if (!isset($_SESSION['status'])) {
    header("Location: login.php");
    exit;
}

// 2. Dynamic Back Link
if ($_SESSION['type'] === 'admin') {
    $backLink = "admin_consultant/adminDashboard.php";
} elseif ($_SESSION['type'] === 'consultant') {
    $backLink = "admin_consultant/consultantDashboard.php";
} else {
    $backLink = "user/userDashboard.php";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>SAFENET - Awareness Hub</title>

  <!-- Styles -->
  <link rel="stylesheet" href="../assets/css/awareness.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
  <link rel="icon" href="https://img.icons8.com/fluency/48/shield.png">
</head>

<body>

  <!-- Top bar -->
  <header class="topbar">
    <div class="logo">SAFENET</div>
    <div class="user-info">
      <a href="<?php echo $backLink; ?>" style="color:white; text-decoration:underline;">
        &larr; Back to Dashboard
      </a>
    </div>
  </header>

  <!-- Main container -->
  <div class="container">
    <h2>🛡️ Cyber Safety Awareness Hub</h2>
    <p class="subtitle">Learn how to protect yourself and others online.</p>

    <!-- Video -->
    <div class="section-title">Featured Video</div>
    <div class="video-container">
      <iframe width="100%" height="400"
        src="https://www.youtube.com/embed/yrln8nyVBLU"
        title="Cyber Security Awareness"
        frameborder="0"
        allowfullscreen>
      </iframe>
    </div>

    <!-- Resources -->
    <div class="section-title">Read & Learn</div>
    <div class="resource-grid">

      <div class="resource-card"
           onclick="window.open('https://en.wikipedia.org/wiki/Cyberbullying','_blank')">
        <div class="icon-box"><i class="fa-solid fa-book-open"></i></div>
        <h3>Cyberbullying</h3>
        <p>Forms, impacts, and legal awareness.</p>
      </div>

      <div class="resource-card"
           onclick="window.open('https://en.wikipedia.org/wiki/Internet_safety','_blank')">
        <div class="icon-box"><i class="fa-solid fa-user-shield"></i></div>
        <h3>Internet Safety</h3>
        <p>Privacy, security, and safe online behavior.</p>
      </div>

      <div class="resource-card"
           onclick="window.open('https://en.wikipedia.org/wiki/Cyberstalking','_blank')">
        <div class="icon-box"><i class="fa-solid fa-eye"></i></div>
        <h3>Cyberstalking</h3>
        <p>Awareness of online stalking and harassment.</p>
      </div>

    </div>

    <!-- Quiz -->
    <div class="section-title">🧠 Test Your Knowledge</div>
    <div class="quiz-box">
      <form id="quizForm">

        <div class="question">
          <p>1. What should you do if a stranger asks for your password?</p>
          <label>
            <input type="radio" name="q1" value="wrong">
            Share it if they seem trustworthy
          </label><br>
          <label>
            <input type="radio" name="q1" value="correct">
            Never share it and block them
          </label>
        </div>

        <div class="question">
          <p>2. Is forwarding a mean message cyberbullying?</p>
          <label>
            <input type="radio" name="q2" value="correct">
            Yes, it spreads harm
          </label><br>
          <label>
            <input type="radio" name="q2" value="wrong">
            No, because I didn’t write it
          </label>
        </div>

        <button type="submit" class="quiz-btn">Check My Score</button>
        <p id="quizResult"></p>

      </form>
    </div>

  </div>

  <!-- Footer -->
  <footer class="bottombar">
    © 2025 SAFENET | All Rights Reserved
  </footer>

  <!-- Script -->
  <script src="../assets/js/awareness.js"></script>

</body>
</html>
