<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>SAFENET - Login</title>

  <!-- Favicon -->
  <link rel="icon" href="https://img.icons8.com/fluency/48/shield.png"/>
  
    <!-- Styles -->
    <link rel="stylesheet" href="../assets/css/login.css">

</head>
<body>

  <!-- Main container -->
  <div class="container">
    <div class="card">

      <!-- Title -->
      <h2>Welcome to SAFENET</h2>

      <!-- Login form -->
      <form id="loginForm">
        
        <!-- Username/Email -->
        <div class="form-group">
            <label for="loginIdentifier">Email or Username</label>
            <input type="text" id="loginIdentifier" placeholder="Enter your email or username" />
            <small id="error-identifier" class="error-msg"></small> <!-- Error -->
        </div>

        <!-- Password -->
        <div class="form-group">
            <label for="loginPassword">Password</label>
            <input type="password" id="loginPassword" placeholder="Enter your password" />
            <small id="error-password" class="error-msg"></small> <!-- Error -->
        </div>
        
        <!-- Remember me -->
        <div class="checkbox-group">
            <input type="checkbox" id="rememberMe"/> 
            <label for="rememberMe" style="margin:0; font-weight:400;">Remember me</label>
        </div>

        <!-- General error -->
        <p id="generalError" class="error-msg" style="text-align:center; margin-top:10px;"></p>

        <!-- Submit -->
        <button type="submit">Sign In</button>

        <!-- Links -->
        <p class="links">
            <a href="register.php">Create Account</a> | 
            <a href="forgot.php">Forgot Password?</a>
        </p>
      </form>

    </div>
  </div>

  <!-- JS -->
  <script src="../assets/js/login.js"></script>

</body>
</html>
