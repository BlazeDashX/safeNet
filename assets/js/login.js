document.getElementById("loginForm").addEventListener("submit", function (e) {
    e.preventDefault();
    console.log("Login Button Clicked");

    // 1. Get Values
    const identifier = document.getElementById("loginIdentifier").value.trim();
    const password = document.getElementById("loginPassword").value.trim();

    // Helper: Clear all previous errors
    document.querySelectorAll('.error-msg').forEach(el => el.style.display = 'none');
    
    // Helper: Function to show error under specific field
    function showError(fieldId, message) {
        const errorEl = document.getElementById(fieldId);
        if(errorEl) {
            errorEl.textContent = message;
            errorEl.style.display = 'block';
        }
    }

    let isValid = true;

    // --- MANUAL VALIDATION (Client-Side) ---
    
    // Check Identifier (Email or Username)
    if (identifier === "") {
        showError('error-identifier', "Please enter your email or username");
        isValid = false;
    }

    // Check Password
    if (password === "") {
        showError('error-password', "Please enter your password");
        isValid = false;
    }

    // Stop if validation failed
    if (!isValid) return;

    // --- SEND TO PHP ---
    const formData = {
        identifier: identifier,
        password: password
    };

    fetch('../controllers/loginCheck.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(formData)
    })
    .then(response => response.json())
    .then(data => {
        if (data.status) {
            // Success: Redirect based on user type
            const userType = data.user.type;
            
            // --- UPDATED PATHS FOR NEW FOLDER STRUCTURE ---
            if (userType === 'admin' || userType === 'consultant') {
                // Points to views/admin_consultant/adminDashboard.php
                window.location.href = 'admin_consultant/adminDashboard.php'; 
            } else {
                // Points to views/user/userDashboard.php
                window.location.href = 'user/userDashboard.php';
            }
            
        } else {
            // Failure: Show error in the general error box
            const generalError = document.getElementById('generalError');
            if (generalError) {
                generalError.textContent = data.message;
                generalError.style.display = 'block';
            } else {
                alert(data.message);
            }
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert("System Error. Check console for details.");
    });
});