// Step 1: Verify User
document.getElementById('verifyForm').onsubmit = function(e) {
    e.preventDefault();

    const username = document.getElementById('username').value.trim();
    const email = document.getElementById('email').value.trim();

    // Clear previous errors
    document.querySelectorAll('.error-msg').forEach(el => el.style.display = 'none');

    if (!username || !email) {
        if (!username) {
            document.getElementById('error-username').textContent = "Username required";
            document.getElementById('error-username').style.display = 'block';
        }
        if (!email) {
            document.getElementById('error-email').textContent = "Email required";
            document.getElementById('error-email').style.display = 'block';
        }
        return;
    }

    //AJAX
    const xhttp = new XMLHttpRequest();
    xhttp.open("POST", "../controllers/forgotCheck.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.onreadystatechange = function() {
        if (this.readyState === 4 && this.status === 200) {
            const res = JSON.parse(this.responseText);
            if (res.status) {
                document.getElementById('step-1').style.display = 'none';
                document.getElementById('step-2').style.display = 'block';
                document.getElementById('verified_user_id').value = res.userId;
            } else {
                document.getElementById('error-email').textContent = res.message;
                document.getElementById('error-email').style.display = 'block';
            }
        }
    };

    xhttp.send("action=verify&username=" + encodeURIComponent(username) + "&email=" + encodeURIComponent(email));
};

// Step 2: Reset Password
document.getElementById('resetForm').onsubmit = function(e) {
    e.preventDefault();

    const userId = document.getElementById('verified_user_id').value;
    const newPass = document.getElementById('new_password').value;
    const confPass = document.getElementById('confirm_password').value;

    // Clear previous errors
    document.querySelectorAll('.error-msg').forEach(el => el.style.display = 'none');

    if (!newPass || !confPass) {
        if (!newPass) {
            document.getElementById('error-newpass').textContent = "Password required";
            document.getElementById('error-newpass').style.display = 'block';
        }
        if (!confPass) {
            document.getElementById('error-confpass').textContent = "Confirm password required";
            document.getElementById('error-confpass').style.display = 'block';
        }
        return;
    }

    if (newPass.length < 8) {
        document.getElementById('error-newpass').textContent = "Password must be at least 8 chars";
        document.getElementById('error-newpass').style.display = 'block';
        return;
    }

    if (newPass !== confPass) {
        document.getElementById('error-confpass').textContent = "Passwords do not match";
        document.getElementById('error-confpass').style.display = 'block';
        return;
    }

    // AJAX
    const xhttp = new XMLHttpRequest();
    xhttp.open("POST", "../controllers/forgotCheck.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.onreadystatechange = function() {
        if (this.readyState === 4 && this.status === 200) {
            const res = JSON.parse(this.responseText);
            if (res.status) {
                alert(res.message);
                window.location.href = "login.php";
            } else {
                document.getElementById('error-newpass').textContent = res.message;
                document.getElementById('error-newpass').style.display = 'block';
            }
        }
    };

    xhttp.send(
        "action=reset&user_id=" + encodeURIComponent(userId) +
        "&new_password=" + encodeURIComponent(newPass) +
        "&confirm_password=" + encodeURIComponent(confPass)
    );
};
