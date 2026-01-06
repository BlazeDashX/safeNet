<?php
session_start();

// 1. Session check
if (!isset($_SESSION['status'])) {
    header("Location: login.php");
    exit;
}

// 2. Back link by role
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
  <title>SAFENET - Change Password</title>

  <!-- Styles -->
  <link rel="stylesheet" href="../assets/css/change_password.css"/>
  <link rel="icon" href="https://img.icons8.com/fluency/48/shield.png"/>

  <style>
    /* Inline Error */
    .error-text { color: red; font-size: 12px; display: none; margin-top: -8px; margin-bottom: 10px; }
    input.error-border { border-color: red; background-color: #fff6f6; }
  </style>
</head>
<body>

  <!-- Top bar -->
  <header class="topbar">
    <div class="logo">SAFENET</div>
    <div class="user-info">
      <span>Logged in as <?php echo htmlspecialchars($_SESSION['username']); ?></span>
      |
      <a href="<?php echo $backLink; ?>" style="color:#f1f3f5; margin-left:10px;">Back to Dashboard</a>
    </div>
  </header>

  <!-- Main container -->
  <div class="container">
    <h2>Change Password</h2>

    <form id="changePassForm" class="card" novalidate>

      <!-- Hidden dashboard URL -->
      <input type="hidden" id="dashboardUrl" value="<?php echo $backLink; ?>">

      <!-- Current password -->
      <label>Current Password</label>
      <input type="password" name="currentPass" id="currentPass" placeholder="Enter current password">
      <small id="err-current" class="error-text"></small>

      <!-- New password -->
      <label>New Password</label>
      <input type="password" name="newPass" id="newPass" placeholder="Min. 8 characters">
      <small id="err-new" class="error-text"></small>

      <!-- Confirm password -->
      <label>Confirm New Password</label>
      <input type="password" name="confirmPass" id="confirmPass" placeholder="Re-enter new password">
      <small id="err-confirm" class="error-text"></small>

      <button type="submit">Update Password</button>
      <p id="msg" style="text-align:center; margin-top:10px; font-weight:bold;"></p>
    </form>
  </div>

  <!-- Footer -->
  <footer class="bottombar">
    © 2025 SAFENET | All Rights Reserved
  </footer>

  <!-- Script -->
  <script src="../assets/js/change_password.js"></script>
</body>
</html>
