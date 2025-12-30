document.getElementById('changePassForm').onsubmit = function(e) {
    e.preventDefault();

    // 1. Get Elements
    const currentPassEl = document.getElementById('currentPass');
    const newPassEl = document.getElementById('newPass');
    const confirmPassEl = document.getElementById('confirmPass');
    const msg = document.getElementById('msg');
    const dashboardUrl = document.getElementById('dashboardUrl').value; // Get the redirect link

    const currentPass = currentPassEl.value.trim();
    const newPass = newPassEl.value.trim();
    const confirmPass = confirmPassEl.value.trim();

    // 2. Helper Functions for Validation
    function clearErrors() {
        document.querySelectorAll('.error-text').forEach(el => el.style.display = 'none');
        document.querySelectorAll('input').forEach(el => el.classList.remove('error-border'));
        msg.textContent = "";
    }

    function setError(inputEl, errorId, message) {
        inputEl.classList.add('error-border');
        const errorEl = document.getElementById(errorId);
        errorEl.textContent = message;
        errorEl.style.display = 'block';
    }

    // 3. Client-Side Validation
    clearErrors();
    let isValid = true;

    if (currentPass === "") {
        setError(currentPassEl, 'err-current', "Current password is required");
        isValid = false;
    }

    if (newPass === "") {
        setError(newPassEl, 'err-new', "New password is required");
        isValid = false;
    } else if (newPass.length < 8) {
        setError(newPassEl, 'err-new', "Password must be at least 8 characters");
        isValid = false;
    }

    if (confirmPass === "") {
        setError(confirmPassEl, 'err-confirm', "Please confirm your password");
        isValid = false;
    } else if (newPass !== confirmPass) {
        setError(confirmPassEl, 'err-confirm', "Passwords do not match");
        isValid = false;
    }

    if (!isValid) return; 

    // 4. Submit to Server
    const formData = new FormData(this);
    msg.textContent = "Updating...";
    msg.style.color = "blue";

    fetch('../controllers/passwordCheck.php', {
        method: 'POST',
        body: formData
    })
    .then(res => res.json())
    .then(data => {
        if (data.status) {
            // SUCCESS
            msg.textContent = "Success! Redirecting...";
            msg.style.color = "green";
            document.getElementById('changePassForm').reset();
            
            // Pop-up Alert
            alert("✅ Password changed successfully!\n\nClick OK to return to the dashboard.");
            
            // Redirect to correct dashboard
            window.location.href = dashboardUrl;
            
        } else {
            // FAILURE
            if (data.message.toLowerCase().includes("incorrect")) {
                setError(currentPassEl, 'err-current', "Incorrect current password");
                msg.textContent = ""; 
            } else {
                msg.textContent = data.message;
                msg.style.color = "red";
            }
        }
    })
    .catch(err => {
        console.error(err);
        msg.textContent = "System Error. Try again.";
        msg.style.color = "red";
    });
};