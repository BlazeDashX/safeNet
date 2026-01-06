<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>SAFENET - Register</title>

  <!-- Styles -->
  <link rel="stylesheet" href="../assets/css/register.css"/>
  <link href="https://fonts.googleapis.com/css2?family=Segoe+UI:wght@400;600&display=swap" rel="stylesheet">
</head>
<body>
  <div class="container">
    <div class="card">
      <h2>Create Account</h2>
      
      <!-- Registration Form -->
      <form id="registerForm" novalidate>
        
        <!-- Full Name -->
        <div class="form-group">
            <label for="sName">Full Name</label>
            <input type="text" id="sName" placeholder="e.g. John Doe" />
            <small id="error-name" class="error-msg"></small>
        </div>

        <!-- Username -->
        <div class="form-group">
            <label for="sUsername">Username</label>
            <input type="text" id="sUsername" placeholder="e.g. johndoe123" />
            <small id="error-username" class="error-msg"></small>
        </div>

        <!-- Email -->
        <div class="form-group">
            <label for="sEmail">Email Address</label>
            <input type="email" id="sEmail" placeholder="e.g. john@example.com" />
            <small id="error-email" class="error-msg"></small>
        </div>
        
        <!-- Gender -->
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
        
        <!-- Date of Birth -->
        <div class="form-group">
            <label for="sDob">Date of Birth</label>
            <input type="date" id="sDob"/>
            <small id="error-dob" class="error-msg"></small>
        </div>

        <!-- Password -->
        <div class="form-group">
            <label for="sPassword">Password</label>
            <input type="password" id="sPassword" placeholder="Enter password" />
            <small id="error-password" class="error-msg"></small>
        </div>

        <!-- Confirm Password -->
        <div class="form-group">
            <label for="sRePassword">Confirm Password</label>
            <input type="password" id="sRePassword" placeholder="Repeat password" />
            <small id="error-repassword" class="error-msg"></small>
        </div>
        
        <!-- User Type / Role -->
        <div class="form-group">
            <label for="sUserType">I am a...</label>
            <select id="sUserType">
              <option value="">Select Role</option>
              <option value="user">User</option>
              <option value="consultant">Consultant</option>
            </select>
            <small id="error-type" class="error-msg"></small>
        </div>
        
        <!-- General Error Message -->
        <p id="generalError" class="error-msg" style="text-align: center; margin-top: 10px;"></p>

        <!-- Submit Button -->
        <button type="submit">Sign Up</button>

        <!-- Link to Login -->
        <p class="login-link"><a href="login.php">Already have an account? Sign In</a></p>
      </form>
    </div>
  </div>
  
  <!-- JS -->
  <script src="../assets/js/register.js"></script>
</body>
</html>
