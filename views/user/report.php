<?php
session_start();

// Session check
if (!isset($_SESSION['status'])) {
    header("Location: login.php");
    exit;
}

// Back link based on role
$backLink = ($_SESSION['type'] == 'admin')
    ? "admin_consultant/adminDashboard.php"
    : "user/userDashboard.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>SAFENET - Report Incident</title>
  <link rel="stylesheet" href="../../assets/css/report.css">
  <link rel="icon" href="https://img.icons8.com/fluency/48/shield.png">
  <style>
    .error-text { color: red; font-size: 12px; display: none; margin-top: 5px; }
    input.error-border, textarea.error-border, select.error-border { border-color: red; }
  </style>
</head>
<body>

<header class="topbar">
  <div class="logo">SAFENET</div>
  <div class="user-info">
    <a href="<?php echo $backLink; ?>" style="color: white; text-decoration: underline;">
      &larr; Back to Dashboard
    </a>
  </div>
</header>

<div class="container">
  <h2>Report Cyberbullying</h2>

  <form id="reportForm" class="card" enctype="multipart/form-data">
    <!-- Description -->
    <label>Describe the Incident</label>
    <textarea id="desc" name="description" placeholder="What happened? Please be detailed..."></textarea>
    <span id="err-desc" class="error-text"></span>

    <!-- Relationship -->
    <label>Relationship</label>
    <select id="rel" name="relationship">
      <option value="">Select Relationship</option>
      <option value="Friend">Friend / Classmate</option>
      <option value="Stranger">Unknown / Stranger</option>
      <option value="Family">Family Member</option>
      <option value="Other">Other</option>
    </select>
    <span id="err-rel" class="error-text"></span>

    <!-- Type -->
    <label>Incident Type</label>
    <select id="type" name="type">
      <option value="">Select Type</option>
      <option value="Harassment">Harassment</option>
      <option value="Threats">Threats</option>
      <option value="Doxxing">Doxxing</option>
      <option value="Hate Speech">Hate Speech</option>
    </select>
    <span id="err-type" class="error-text"></span>

    <!-- Evidence -->
    <label>Evidence Upload</label>
    <input type="file" id="evidence" name="evidence" accept="image/*">
    <span id="err-file" class="error-text"></span>

    <!-- Submit -->
    <button type="submit">Submit Report</button>
    <p id="generalError" class="error-text" style="text-align:center;"></p>
  </form>
</div>

<footer class="bottombar">
  © 2025 SAFENET | All Rights Reserved
</footer>

<script src="../../assets/js/report.js"></script>
</body>
</html>
