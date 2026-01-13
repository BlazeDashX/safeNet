document.getElementById('changePassForm').onsubmit = function(e) {
    e.preventDefault();

    const currentPass = document.getElementById('currentPass').value.trim();
    const newPass = document.getElementById('newPass').value.trim();
    const confirmPass = document.getElementById('confirmPass').value.trim();
    const dashboardUrl = document.getElementById('dashboardUrl').value;
    const msg = document.getElementById('msg');

    // Clear previous errors
    document.querySelectorAll('.error-text').forEach(el => el.style.display = 'none');
    document.querySelectorAll('input').forEach(el => el.classList.remove('error-border'));
    msg.textContent = "";

    let valid = true;

    // Validation
    if (currentPass === "") {
        document.getElementById('err-current').textContent = "Current password required";
        document.getElementById('err-current').style.display = 'block';
        document.getElementById('currentPass').classList.add('error-border');
        valid = false;
    }

    if (newPass === "") {
        document.getElementById('err-new').textContent = "New password required";
        document.getElementById('err-new').style.display = 'block';
        document.getElementById('newPass').classList.add('error-border');
        valid = false;
    } else if (newPass.length < 8) {
        document.getElementById('err-new').textContent = "Min 8 characters";
        document.getElementById('err-new').style.display = 'block';
        document.getElementById('newPass').classList.add('error-border');
        valid = false;
    }

    if (confirmPass === "") {
        document.getElementById('err-confirm').textContent = "Confirm password required";
        document.getElementById('err-confirm').style.display = 'block';
        document.getElementById('confirmPass').classList.add('error-border');
        valid = false;
    } else if (newPass !== confirmPass) {
        document.getElementById('err-confirm').textContent = "Passwords mismatch";
        document.getElementById('err-confirm').style.display = 'block';
        document.getElementById('confirmPass').classList.add('error-border');
        valid = false;
    }

    if (!valid) return;

    msg.textContent = "Updating...";
    msg.style.color = "blue";

    // AJAX
    const xhttp = new XMLHttpRequest();
    xhttp.open("POST", "../controllers/passwordCheck.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.onreadystatechange = function() {
        if (this.readyState === 4 && this.status === 200) {
            const res = JSON.parse(this.responseText);
            if (res.status) {
                msg.textContent = "Success! Redirecting...";
                msg.style.color = "green";
                alert("Password changed successfully! Click OK to go to dashboard.");
                window.location.href = dashboardUrl;
            } else {
                if (res.message.toLowerCase().includes("incorrect")) {
                    document.getElementById('err-current').textContent = "Incorrect current password";
                    document.getElementById('err-current').style.display = 'block';
                } else {
                    msg.textContent = res.message;
                    msg.style.color = "red";
                }
            }
        }
    };

    xhttp.send(
        "currentPass=" + encodeURIComponent(currentPass) +
        "&newPass=" + encodeURIComponent(newPass) +
        "&confirmPass=" + encodeURIComponent(confirmPass)
    );
};
