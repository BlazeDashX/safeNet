document.getElementById('registerForm').addEventListener('submit', function(e) {
    e.preventDefault();

    // Input values
    const name = document.getElementById('sName').value.trim();
    const username = document.getElementById('sUsername').value.trim();
    const email = document.getElementById('sEmail').value.trim();
    const gender = document.getElementById('sGender').value;
    const dob = document.getElementById('sDob').value;
    const password = document.getElementById('sPassword').value;
    const rePassword = document.getElementById('sRePassword').value;
    const type = document.getElementById('sUserType').value;

    // Clear previous errors
    document.querySelectorAll('.error-msg').forEach(el => el.style.display = 'none');

    // Basic validation
    if (!name || !username || !email || !gender || !dob || !password || !rePassword || !type) {
        document.getElementById('generalError').textContent = "Please fill all fields.";
        document.getElementById('generalError').style.display = "block";
        return;
    }
    if (password !== rePassword) {
        document.getElementById('error-repassword').textContent = "Passwords do not match";
        document.getElementById('error-repassword').style.display = "block";
        return;
    }

    // Prepare data
    const user = {
        name, username, email, gender, dob, password, rePassword, type
    };

    const xhttp = new XMLHttpRequest();
    xhttp.open("POST", "../controllers/regCheck.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

    xhttp.onreadystatechange = function() {
        if (this.readyState === 4 && this.status === 200) {
            const response = JSON.parse(this.responseText);

            if (response.status) {
                alert(response.message);
                window.location.href = 'login.php';
            } else {
                document.getElementById('generalError').textContent = response.message;
                document.getElementById('generalError').style.display = "block";
            }
        }
    };

    // 🔴 Encode JSON for PHP 
    xhttp.send("user=" + encodeURIComponent(JSON.stringify(user)));
});
