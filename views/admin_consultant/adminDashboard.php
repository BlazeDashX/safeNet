<?php
session_start();

// 1. Security Check
if (!isset($_SESSION['status']) || $_SESSION['status'] !== true) {
    header("Location: ../../views/login.php");
    exit;
}

// 2. Role Check
if ($_SESSION['type'] === 'admin' || $_SESSION['type'] === 'consultant') {
    header("Location: ../admin_consultant/adminDashboard.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>SAFENET - User Dashboard</title>
  <link rel="stylesheet" href="../../assets/css/user_dashboard.css"/>
  <link rel="icon" href="https://img.icons8.com/fluency/48/shield.png"/>
</head>
<body>
  <header class="topbar">
    <div class="logo">SAFENET</div>
    <div class="moto">Report. Protect. Educate.</div>
    <div class="user-info">
      <span>Welcome, <b><?php echo htmlspecialchars($_SESSION['username']); ?></b></span> 
      | <a href="#" id="logoutBtn">Logout</a>
    </div>
  </header>

  <div class="container">
    <h2>User Dashboard</h2>
    <div class="dashboard-grid">
      <div class="dash-card"><a href="../report.php"><h3>Report Cyberbullying</h3></a></div>
      <div class="dash-card" onclick="alert('Your reports: 2 pending, 1 resolved')"><h3>Track Reports</h3></div>
      <div class="dash-card"><a href="../ai_chat.php"><h3>AI Mental Support Chat</h3></a></div>
      <div class="dash-card"><a href="../awareness.php"><h3>Awareness Hub</h3></a></div>
      
      <div class="dash-card"><a href="../profile.php"><h3>View Profile</h3></a></div>
      <div class="dash-card"><a href="../profile_edit.php"><h3>Edit Profile</h3></a></div>
      
    </div>
  </div>

  <footer class="bottombar">
    © 2025 SAFENET by AIUB CS Students | All Rights Reserved
  </footer>

  <script src="../../assets/js/user_dashboard.js"></script>
</body>
</html>