<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>SAFENET - Forgot Password</title>

    <link rel="icon" href="https://img.icons8.com/fluency/48/shield.png"/>
    <link rel="stylesheet" href="../assets/css/login.css">
</head>
<body>

<div class="container">
    <div class="card">
        <h2>Reset Password</h2>

        <!-- Step 1: Verify User -->
        <div id="step-1">
            <p class="subtitle">Enter your details to verify your account.</p>
            <form id="verifyForm">
                <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" id="username" name="username" placeholder="Enter your username">
                    <small id="error-username" class="error-msg"></small>
                </div>
                <div class="form-group">
                    <label for="email">Email Address</label>
                    <input type="text" id="email" name="email" placeholder="Enter your registered email">
                    <small id="error-email" class="error-msg"></small>
                </div>
                <button type="submit">Verify Account</button>
            </form>
        </div>

        <!-- Step 2: Reset Password -->
        <div id="step-2" style="display: none;">
            <p class="subtitle">Identity verified. Set your new password.</p>
            <form id="resetForm">
                <input type="hidden" id="verified_user_id" name="user_id">

                <div class="form-group">
                    <label for="new_password">New Password</label>
                    <input type="password" id="new_password" name="new_password">
                    <small id="error-newpass" class="error-msg"></small>
                </div>
                <div class="form-group">
                    <label for="confirm_password">Confirm Password</label>
                    <input type="password" id="confirm_password" name="confirm_password">
                    <small id="error-confpass" class="error-msg"></small>
                </div>

                <button type="submit">Update Password</button>
            </form>
        </div>

        <p class="links">
            <a href="login.php">&larr; Back to Login</a>
        </p>

    </div>
</div>

<script src="../assets/js/forgot.js"></script>
</body>
</html>
