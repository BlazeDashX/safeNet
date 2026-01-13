<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>SAFENET - Login</title>

  <link rel="icon" href="https://img.icons8.com/fluency/48/shield.png"/>
  <link rel="stylesheet" href="../assets/css/login.css">
</head>
<body>

<div class="container">
  <div class="card">

    <h2>Welcome to SAFENET</h2>

    <form id="loginForm">

      <div class="form-group">
        <label for="loginIdentifier">Email or Username</label>
        <input type="text" id="loginIdentifier" />
        <small class="error-msg"></small>
      </div>

      <div class="form-group">
        <label for="loginPassword">Password</label>
        <input type="password" id="loginPassword" />
        <small class="error-msg"></small>
      </div>

      <p id="generalError" class="error-msg" style="text-align:center;"></p>

      <button type="submit">Sign In</button>

      <p class="links">
        <a href="register.php">Create Account</a> |
        <a href="forgot.php">Forgot Password?</a>
      </p>

    </form>

  </div>
</div>

<script src="../assets/js/login.js"></script>
</body>
</html>
