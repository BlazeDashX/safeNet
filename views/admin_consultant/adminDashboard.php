<?php
session_start();

// 1. Security Check
if (!isset($_SESSION['status']) || $_SESSION['status'] !== true) {
    header("Location: ../../views/login.php");
    exit;
}

// 2. Role Check (Kick Users out)
if ($_SESSION['type'] !== 'admin' && $_SESSION['type'] !== 'consultant') {
    header("Location: ../user/userDashboard.php");
    exit;
}

// Helper to show role nicely
$roleLabel = ucfirst($_SESSION['type']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>SAFENET - <?php echo $roleLabel; ?> Dashboard</title>
  <link rel="stylesheet" href="../../assets/css/admin_dashboard.css"/>
  <link rel="icon" href="https://img.icons8.com/fluency/48/shield.png"/>
</head>
<body>
  <header class="topbar">
    <div class="logo">SAFENET</div>
    <div class="moto">Report. Protect. Educate.</div>
    <div class="user-info">
      <span><?php echo htmlspecialchars($_SESSION['username']); ?> (<?php echo $roleLabel; ?>)</span> 
      | <a href="#" id="logoutBtn">Logout</a>
    </div>
  </header>

  <div class="container">
    <h2><?php echo $roleLabel; ?> Dashboard</h2>
    <div class="dashboard-grid">
      <div class="dash-card" onclick="alert('5 New Reports')"><h3>Real-time Reports</h3></div>
      <div class="dash-card" onclick="alert('AI Results: 3 High Risk')"><h3>AI Detection Results</h3></div>
      <div class="dash-card" onclick="alert('342 Active Users')"><h3>User Statistics</h3></div>
      <div class="dash-card" onclick="alert('Next: 10 AM Tomorrow')"><h3>Consultation Schedule</h3></div>
      <div class="dash-card"><a href="../awareness.php"><h3>Awareness Hub</h3></a></div>
      <div class="dash-card"><a href="../profile.php"><h3>View Profile</h3></a></div>
      <div class="dash-card"><a href="../profile.php"><h3>Edit Profile</h3></a></div>
      <div class="dash-card"><a href="../change_password.php"><h3>Change Password</h3></a></div>
    </div>
  </div>

  <footer class="bottombar">
    © 2025 SAFENET by AIUB CS Students | All Rights Reserved
  </footer>

  <script src="../../assets/js/admin_dashboard.js"></script>
</body>
</html>