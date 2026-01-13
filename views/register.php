<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>SAFENET - Register</title>

  <link rel="stylesheet" href="../assets/css/register.css"/>
  <link href="https://fonts.googleapis.com/css2?family=Segoe+UI:wght@400;600&display=swap" rel="stylesheet">
</head>
<body>

<div class="container">
  <div class="card">
    <h2>Create Account</h2>

    <form id="registerForm" novalidate>

      <div class="form-group">
        <label for="sName">Full Name</label>
        <input type="text" id="sName" />
        <small id="error-name" class="error-msg"></small>
      </div>

      <div class="form-group">
        <label for="sUsername">Username</label>
        <input type="text" id="sUsername" />
        <small id="error-username" class="error-msg"></small>
      </div>

      <div class="form-group">
        <label for="sEmail">Email Address</label>
        <input type="email" id="sEmail" />
        <small id="error-email" class="error-msg"></small>
      </div>

      <div class="form-group">
        <label for="sGender">Gender</label>
        <select id="sGender">
          <option value="">Select Gender</option>
          <option value="Male">Male</option>
          <option value="Female">Female</option>
          <option value="Other">Other</option>
        </select>
        <small id="error-gender" class="error-msg"></small>
      </div>

      <div class="form-group">
        <label for="sDob">Date of Birth</label>
        <input type="date" id="sDob" />
        <small id="error-dob" class="error-msg"></small>
      </div>

      <div class="form-group">
        <label for="sPassword">Password</label>
        <input type="password" id="sPassword" />
        <small id="error-password" class="error-msg"></small>
      </div>

      <div class="form-group">
        <label for="sRePassword">Confirm Password</label>
        <input type="password" id="sRePassword" />
        <small id="error-repassword" class="error-msg"></small>
      </div>

      <div class="form-group">
        <label for="sUserType">I am a...</label>
        <select id="sUserType">
          <option value="">Select Role</option>
          <option value="user">User</option>
          <option value="consultant">Consultant</option>
        </select>
        <small id="error-type" class="error-msg"></small>
      </div>

      <p id="generalError" class="error-msg" style="text-align:center;"></p>

      <button type="submit">Sign Up</button>

      <p class="login-link">
        <a href="login.php">Already have an account? Sign In</a>
      </p>

    </form>
  </div>
</div>

<script src="../assets/js/register.js"></script>
</body>
</html>
