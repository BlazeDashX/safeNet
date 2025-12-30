<?php
session_start();

// 1. Security Check: If not logged in, go to login
if (!isset($_SESSION['status']) || $_SESSION['status'] !== true) {
    header("Location: ../../views/login.php");
    exit;
}

// 2. Role Check: If admin or consultant, send to ADMIN dashboard
if ($_SESSION['type'] === 'admin' || $_SESSION['type'] === 'consultant') {
    header("Location: ../admin_consultant/adminDashboard.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>User Dashboard - SAFENET</title>
  <link rel="stylesheet" href="../../assets/css/user_dashboard.css"/>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
  
  <header class="topbar">
    <div class="logo">SAFENET</div>
    <div class="user-info">
      <span>Welcome, <b><?php echo htmlspecialchars($_SESSION['username']); ?></b></span> 
      | <a id="logoutBtn">Logout</a>
    </div>
  </header>

  <div class="container">
    <div class="welcome-banner">
        <h2>👋 Hello, <?php echo htmlspecialchars($_SESSION['username']); ?></h2>
        <p>What would you like to do today?</p>
    </div>

    <div class="dashboard-grid">
      
      <a href="../report.php" class="dash-card">
        <div class="icon-box"><i class="fa-solid fa-shield-alt"></i></div>
        <h3>Report Incident</h3>
        <p>File a new complaint</p>
      </a>

      <a href="../track_reports.php" class="dash-card">
        <div class="icon-box"><i class="fa-solid fa-clipboard-list"></i></div>
        <h3>Track Reports</h3>
        <p>Check status of complaints</p>
      </a>

      <a href="../ai_chat.php" class="dash-card">
        <div class="icon-box"><i class="fa-solid fa-robot"></i></div>
        <h3>AI Support</h3>
        <p>Chat with our mental health bot</p>
      </a>

      <a href="../awareness.php" class="dash-card">
        <div class="icon-box"><i class="fa-solid fa-book-open"></i></div>
        <h3>Awareness Hub</h3>
        <p>Learn about cyber safety</p>
      </a>
      
      <a href="../profile.php" class="dash-card">
        <div class="icon-box"><i class="fa-solid fa-user-gear"></i></div>
        <h3>My Profile</h3>
        <p>View & Edit details</p>
      </a>

      <a href="../change_password.php" class="dash-card">
        <div class="icon-box"><i class="fa-solid fa-lock"></i></div>
        <h3>Security</h3>
        <p>Change Password</p>
      </a>

    </div>
  </div>

  <footer class="bottombar">
    © 2025 SAFENET by AIUB CS Students | All Rights Reserved
  </footer>

  <script src="../../assets/js/user_dashboard.js"></script>
</body>
</html>