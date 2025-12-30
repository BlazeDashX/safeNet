<?php
session_start();
if (!isset($_SESSION['status'])) { header("Location: login.php"); exit; }

// Dynamic Back Link
$backLink = ($_SESSION['type'] == 'admin') ? "admin_consultant/adminDashboard.php" : "user/userDashboard.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>SAFENET - Report Incident</title>
  <link rel="stylesheet" href="../assets/css/report.css"/>
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
    <h2>Report Cyberbullying</h2>
    
    <form id="reportForm" class="card" enctype="multipart/form-data">
      
      <label>Describe the Incident</label>
      <textarea id="desc" name="description" placeholder="What happened? Please be detailed..." required></textarea>
      
      <label>Relationship with Aggressor</label>
      <select id="rel" name="relationship" required>
        <option value="">Select Relationship</option>
        <option value="Friend">Friend / Classmate</option>
        <option value="Stranger">Unknown / Stranger</option>
        <option value="Family">Family Member</option>
        <option value="Other">Other</option>
      </select>
      
      <label>Type of Bullying</label>
      <select id="type" name="type" required>
        <option value="">Select Type</option>
        <option value="Harassment">Harassment</option>
        <option value="Threats">Threats</option>
        <option value="Doxxing">Doxxing (Leaking private info)</option>
        <option value="Hate Speech">Hate Speech</option>
      </select>

      <label>Upload Evidence (Screenshot/Image)</label>
      <input type="file" id="evidence" name="evidence" accept="image/*">

      <button type="submit">Submit Report</button>
    </form>
  </div>

  <footer class="bottombar">
    © 2025 SAFENET by AIUB CS Students | All Rights Reserved
  </footer>

  <script src="../assets/js/report.js"></script>
</body>
</html>