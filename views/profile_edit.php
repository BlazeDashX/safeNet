<?php
session_start();
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
    <link rel="stylesheet" href="../assets/css/profile_edit.css"/>
    <style>
        .error-text { color: red; font-size: 12px; display: none; margin-top: 5px; }
        input.error-border { border-color: red; }
        input[readonly] { background-color: #e9ecef; color: #6c757d; cursor: not-allowed; }
    </style>
</head>
<body>

<header class="topbar">
    <div class="logo">SAFENET</div>
    <div class="user-info">
        <a href="profile.php" style="color:white; text-decoration: underline;">Cancel</a>
    </div>
</header>

<div class="container">
    <h2>Edit Profile</h2>

    <form id="editForm" class="card">
        <div class="form-group">
            <label>My Role</label>
            <input type="text" id="editType" readonly />
        </div>

        <div class="form-group">
            <label>Full Name</label>
            <input type="text" id="editName" name="name" placeholder="Name" />
            <span id="err-name" class="error-text"></span>
        </div>

        <div class="form-group">
            <label>Email</label>
            <input type="email" id="editEmail" name="email" placeholder="Email" />
            <span id="err-email" class="error-text"></span>
        </div>

        <div class="form-group">
            <label>Date of Birth</label>
            <input type="date" id="editDob" name="dob" />
            <span id="err-dob" class="error-text"></span>
        </div>

        <input type="hidden" id="editGender" name="gender">
        <p id="generalError" class="error-text" style="text-align:center; font-size:14px;"></p>
        <button type="submit">Save Changes</button>
    </form>
</div>

<script src="../assets/js/profile_edit.js"></script>
</body>
</html>
