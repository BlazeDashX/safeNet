<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>SAFENET - Login</title>
  <link rel="stylesheet" href="../assets/css/login.css"/>
  <link rel="icon" href="https://img.icons8.com/fluency/48/shield.png"/>
</head>
<body>
  <div class="container">
    <div class="card">
      <h2>Welcome to SAFENET</h2>
      
      <form id="loginForm">
        <input type="text" id="loginIdentifier" placeholder="Email or Username" required/>
        <input type="password" id="loginPassword" placeholder="Password" required/>
        
        <label>
            <input type="checkbox" id="rememberMe"/> Remember me
        </label>
        
        <button type="submit">Sign In</button>
        
        <p>
            <a href="register.php">Create Account</a> | 
            <a href="forgot.php">Forgot Password?</a>
        </p>
      </form>
    </div>
  </div>
  
  <script src="../assets/js/login.js"></script>
</body>
</html>