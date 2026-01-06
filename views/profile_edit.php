<?php
session_start();
// Security: Redirect if not logged in
if (!isset($_SESSION['status'])) { 
    header("Location: login.php"); 
    exit; 
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>SAFENET - Edit Profile</title>

  <!-- CSS -->
  <link rel="stylesheet" href="../assets/css/profile_edit.css"/>
  <style>
      /* Inline error styles */
      .error-text { color: red; font-size: 12px; display: none; margin-top: 5px; }
      input.error-border { border-color: red; }
      input[readonly] { background-color: #e9ecef; color: #6c757d; cursor: not-allowed; }
  </style>
</head>
<body>

  <!-- Header -->
  <header class="topbar">
    <div class="logo">SAFENET</div>
    <div class="user-info">
        <!-- Back to Profile -->
        <a href="profile.php" style="color: white; text-decoration: underline;">Cancel</a>
    </div>
  </header>
  
  <div class="container">
    <h2>Edit Profile</h2>
    
    <!-- Profile Edit Form -->
    <form id="editForm" class="card" novalidate>
      
      <!-- Role Display -->
      <div class="form-group">
          <label>My Role</label>
          <input type="text" id="editType" readonly />
      </div>

      <!-- Full Name -->
      <div class="form-group">
          <label>Full Name</label>
          <input type="text" id="editName" placeholder="Name" />
          <span id="err-name" class="error-text">Name cannot be empty</span> <!-- Error -->
      </div>
      
      <!-- Email -->
      <div class="form-group">
          <label>Email</label>
          <input type="email" id="editEmail" placeholder="Email" />
          <span id="err-email" class="error-text">Invalid email address</span> <!-- Error -->
      </div>

      <!-- Date of Birth -->
      <div class="form-group">
          <label>Date of Birth</label>
          <input type="date" id="editDob" />
          <span id="err-dob" class="error-text">You must be at least 14 years old</span> <!-- Error -->
      </div>

      <!-- General error message -->
      <p id="generalError" class="error-text" style="text-align:center; font-size:14px;"></p>

      <!-- Hidden Gender field -->
      <input type="hidden" id="editGender">

      <!-- Submit -->
      <button type="submit">Save Changes</button>
    </form>
  </div>

  <!-- JS -->
  <script src="../assets/js/profile_edit.js"></script>
</body>
</html>
