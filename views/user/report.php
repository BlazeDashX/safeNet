<?php
session_start();

// Session check
if (!isset($_SESSION['status'])) {
    header("Location: login.php");
    exit;
}

// Dashboard link
$backLink = ($_SESSION['type'] == 'admin')
    ? "admin_consultant/adminDashboard.php"
    : "userDashboard.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>SAFENET - Report Incident</title>

  <!-- Styles -->
  <link rel="stylesheet" href="../../assets/css/report.css">
  <link rel="icon" href="https://img.icons8.com/fluency/48/shield.png">
</head>

<body>

  <!-- Top bar -->
  <header class="topbar">
    <div class="logo">SAFENET</div>
    <div class="user-info">
      <a href="<?php echo $backLink; ?>" style="color: white; text-decoration: underline;">
        &larr; Back to Dashboard
      </a>
    </div>
  </header>

  <!-- Report form -->
  <div class="container">
    <h2>Report Cyberbullying</h2>

    <form id="reportForm" class="card" enctype="multipart/form-data">

      <label>Describe the Incident</label>
      <textarea id="desc" name="description" placeholder="What happened? Please be detailed..."></textarea>

      <label>Relationship</label>
      <select id="rel" name="relationship">
        <option value="">Select Relationship</option>
        <option value="Friend">Friend / Classmate</option>
        <option value="Stranger">Unknown / Stranger</option>
        <option value="Family">Family Member</option>
        <option value="Other">Other</option>
      </select>

      <label>Incident Type</label>
      <select id="type" name="type">
        <option value="">Select Type</option>
        <option value="Harassment">Harassment</option>
        <option value="Threats">Threats</option>
        <option value="Doxxing">Doxxing</option>
        <option value="Hate Speech">Hate Speech</option>
      </select>

      <label>Evidence Upload</label>
      <input type="file" id="evidence" name="evidence" accept="image/*">

      <button type="submit">Submit Report</button>
    </form>
  </div>

  <!-- Footer -->
  <footer class="bottombar">
    © 2025 SAFENET | All Rights Reserved
  </footer>

  <!-- Scripts -->
  <script src="../../assets/js/report.js"></script>

</body>
</html>
