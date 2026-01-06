// 1. EMAIL VERIFICATION STEP

document.getElementById('verifyForm').onsubmit = function(e) {
    e.preventDefault(); // Prevent page reload

    const formData = new FormData(this);
    formData.append('action', 'verify'); // tell server this is verification step

    fetch('../controllers/forgotCheck.php', {
        method: 'POST',
        body: formData
    })
    .then(res => res.json())
    .then(data => {
        // Hide previous errors
        document.querySelectorAll('.error-msg').forEach(el => el.style.display = 'none');

        if (data.status) {
            // Move to password reset step
            document.getElementById('step-1').style.display = 'none';
            document.getElementById('step-2').style.display = 'block';

            // Store verified user id for password reset
            document.getElementById('verified_user_id').value = data.userId;
        } else {
            // Show error message under email input
            const errEl = document.getElementById('error-email');
            errEl.innerText = data.message;
            errEl.style.display = 'block';
        }
    })
    .catch(err => console.error("Verification failed:", err));
};

// 2. PASSWORD RESET STEP

document.getElementById('resetForm').onsubmit = function(e) {
    e.preventDefault(); // Prevent reload

    const formData = new FormData(this);
    formData.append('action', 'reset'); // tell server this is reset step

    fetch('../controllers/forgotCheck.php', {
        method: 'POST',
        body: formData
    })
    .then(res => res.json())
    .then(data => {
        // Clear previous error
        const errEl = document.getElementById('error-newpass');
        errEl.style.display = 'none';

        if (data.status) {
            // Success: notify user and redirect to login
            alert(data.message);
            window.location.href = 'login.php';
        } else {
            // Show server-side error under password input
            errEl.innerText = data.message;
            errEl.style.display = 'block';
        }
    })
    .catch(err => console.error("Password reset failed:", err));
};
