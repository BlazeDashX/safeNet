// --- CHANGE PASSWORD FORM ---
document.getElementById('changePassForm').onsubmit = function(e) {
    e.preventDefault(); // Prevent reload

    // --- 1. Get Input Elements ---
    const currentPassEl = document.getElementById('currentPass');
    const newPassEl = document.getElementById('newPass');
    const confirmPassEl = document.getElementById('confirmPass');
    const msg = document.getElementById('msg');
    const dashboardUrl = document.getElementById('dashboardUrl').value;

    const currentPass = currentPassEl.value.trim();
    const newPass = newPassEl.value.trim();
    const confirmPass = confirmPassEl.value.trim();

    // --- 2. Helper Functions ---
    function clearErrors() {
        document.querySelectorAll('.error-text').forEach(el => el.style.display = 'none'); // hide errors
        document.querySelectorAll('input').forEach(el => el.classList.remove('error-border')); // reset border
        msg.textContent = "";
    }

    function setError(inputEl, errorId, message) {
        inputEl.classList.add('error-border'); // highlight field
        const errorEl = document.getElementById(errorId);
        errorEl.textContent = message;
        errorEl.style.display = 'block';
    }

    // --- 3. Validation ---
    clearErrors();
    let isValid = true;

    if (currentPass === "") {
        setError(currentPassEl, 'err-current', "Current password required");
        isValid = false;
    }

    if (newPass === "") {
        setError(newPassEl, 'err-new', "New password required");
        isValid = false;
    } else if (newPass.length < 8) {
        setError(newPassEl, 'err-new', "Min 8 characters");
        isValid = false;
    }

    if (confirmPass === "") {
        setError(confirmPassEl, 'err-confirm', "Confirm password");
        isValid = false;
    } else if (newPass !== confirmPass) {
        setError(confirmPassEl, 'err-confirm', "Passwords mismatch");
        isValid = false;
    }

    if (!isValid) return; // stop if invalid

    // --- 4. Submit Form ---
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
            // Success
            msg.textContent = "Success! Redirecting...";
            msg.style.color = "green";
            this.reset();
            alert("Password changed successfully! Click OK to go to dashboard.");
            window.location.href = dashboardUrl;
        } else {
            // Failure
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
