<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>SAFENET - Login</title>
  <link rel="icon" href="https://img.icons8.com/fluency/48/shield.png"/>
  <link href="https://fonts.googleapis.com/css2?family=Segoe+UI:wght@400;600&display=swap" rel="stylesheet">
  
  <style>
    /* EMBEDDED CSS TO ENSURE IT LOADS */
    * { margin:0; padding:0; box-sizing:border-box; font-family:'Segoe UI',sans-serif; }

    body { 
        background:#f0f2f5; 
        color:#333; 
        display: flex;
        justify-content: center;
        align-items: center;
        min-height: 100vh;
    }

    .container { 
        width: 100%;
        max-width: 450px; 
        padding: 20px; 
    }

    .card { 
        background:white; 
        padding: 40px; 
        border-radius:12px; 
        box-shadow:0 4px 15px rgba(0,0,0,0.1); 
    }

    h2 { 
        text-align:center; 
        margin-bottom:30px; 
        color:#1a3b5d; 
    }

    .form-group {
        margin-bottom: 20px;
        text-align: left;
    }

    label {
        display: block;
        margin-bottom: 8px;
        font-weight: 600;
        color: #444;
        font-size: 14px;
    }

    input[type="text"], input[type="password"] { 
        width:100%; 
        padding:12px; 
        border:1px solid #ccc; 
        border-radius:8px;
        font-size: 14px;
    }

    input:focus {
        border-color: #1a3b5d;
        outline: none;
    }

    .checkbox-group {
        margin-bottom: 20px;
        font-size: 14px;
        display: flex;
        align-items: center;
    }

    .checkbox-group input {
        margin-right: 8px;
        width: auto;
    }

    button { 
        background:#1a3b5d; 
        color:white; 
        padding:12px; 
        border:none; 
        border-radius:8px; 
        cursor:pointer; 
        width:100%; 
        font-size:16px; 
    }

    button:hover { background:#0f2840; }

    .links {
        text-align: center;
        margin-top: 20px;
        font-size: 14px;
    }

    a { color:#1a3b5d; text-decoration:none; }
    a:hover { text-decoration:underline; }

    /* THIS IS THE RED ERROR STYLE */
    .error-msg {
        color: #d93025; /* RED COLOR */
        font-size: 12px;
        display: none;
        margin-top: 5px;
        font-weight: 600;
    }
  </style>
</head>
<body>
  <div class="container">
    <div class="card">
      <h2>Welcome to SAFENET</h2>
      
      <form id="loginForm" novalidate>
        
        <div class="form-group">
            <label for="loginIdentifier">Email or Username</label>
            <input type="text" id="loginIdentifier" placeholder="Enter your email or username" />
            <small id="error-identifier" class="error-msg"></small>
        </div>

        <div class="form-group">
            <label for="loginPassword">Password</label>
            <input type="password" id="loginPassword" placeholder="Enter your password" />
            <small id="error-password" class="error-msg"></small>
        </div>
        
        <div class="checkbox-group">
            <input type="checkbox" id="rememberMe"/> 
            <label for="rememberMe" style="margin:0; font-weight:400;">Remember me</label>
        </div>

        <p id="generalError" class="error-msg" style="text-align: center; margin-top: 10px;"></p>
        
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