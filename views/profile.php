<?php
session_start();

// 1. Security Check
if (!isset($_SESSION['status']) || $_SESSION['status'] !== true) {
    header("Location: login.php");
    exit;
}

// 2. Dynamic Back Button Logic
// If Admin/Consultant -> Go to Admin Dashboard
// If User -> Go to User Dashboard
$backLink = "";
if ($_SESSION['type'] === 'admin' || $_SESSION['type'] === 'consultant') {
    $backLink = "admin_consultant/adminDashboard.php";
} else {
    $backLink = "user/userDashboard.php";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>SAFENET - View Profile</title>
  <link rel="stylesheet" href="../assets/css/profile_view.css"/>
  <link rel="icon" href="https://img.icons8.com/fluency/48/shield.png"/>
</head>
<body>

  <header class="topbar">
    <div class="logo">SAFENET</div>
    <div class="moto">Report. Protect. Educate.</div>
    <div class="user-info">
        <a href="<?php echo $backLink; ?>" style="color: white; text-decoration: underline; font-weight: bold;">
            &larr; Back to Dashboard
        </a>
    </div>
  </header>
  
  <div class="container">
    <h2>My Profile</h2>
    <div class="card">
      <table id="profileTable">
        <tr>
            <td class="label-col">Full Name</td>
            <td id="pName">Loading...</td>
        </tr>
        <tr>
            <td class="label-col">Username</td>
            <td id="pUsername">Loading...</td>
        </tr>
        <tr>
            <td class="label-col">Email</td>
            <td id="pEmail">Loading...</td>
        </tr>
        <tr>
            <td class="label-col">Gender</td>
            <td id="pGender">Loading...</td>
        </tr>
        <tr>
            <td class="label-col">Date of Birth</td>
            <td id="pDob">Loading...</td>
        </tr>
        <tr>
            <td class="label-col">User Role</td>
            <td id="pType" style="font-weight: bold; color: #1a3b5d;">Loading...</td>
        </tr>
      </table>
      
      <button onclick="window.location.href='profile_edit.php'">Edit Profile</button>
    </div>
  </div>

  <footer class="bottombar">
    © 2025 SAFENET by AIUB CS Students | All Rights Reserved
  </footer>

  <script src="../assets/js/profile_view.js"></script>
</body>
</html>