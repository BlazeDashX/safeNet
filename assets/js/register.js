document.getElementById('registerForm').addEventListener('submit', function(e) {
    e.preventDefault();
    console.log("Button Clicked! Starting validation...");

    // 1. Get Values
    const name = document.getElementById('sName').value.trim();
    const username = document.getElementById('sUsername').value.trim();
    const email = document.getElementById('sEmail').value.trim();
    const gender = document.getElementById('sGender').value;
    const dob = document.getElementById('sDob').value;
    const password = document.getElementById('sPassword').value;
    const rePassword = document.getElementById('sRePassword').value;
    const type = document.getElementById('sUserType').value;

    // Helper: Clear all previous errors
    document.querySelectorAll('.error-msg').forEach(el => el.style.display = 'none');
    
    // Helper: Show error
    function showError(fieldId, message) {
        const errorEl = document.getElementById(fieldId);
        if(errorEl) {
            errorEl.textContent = message;
            errorEl.style.display = 'block';
        }
    }

    let isValid = true;

    // --- VALIDATION START ---

    if (name === "") { showError('error-name', "Name is required"); isValid = false; }
    if (username === "") { showError('error-username', "Username is required"); isValid = false; }
    
    // --- EMAIL VALIDATION (NEW) ---
    const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/; // Simple standard email regex
    
    if (email === "") { 
        showError('error-email', "Email is required"); 
        isValid = false; 
    } else if (!emailPattern.test(email)) {
        // This runs if email is NOT valid (e.g., "aa" or "aa@")
        showError('error-email', "Invalid email format (e.g., user@mail.com)");
        isValid = false;
    }

    if (gender === "") { showError('error-gender', "Select a gender"); isValid = false; }
    if (dob === "") { showError('error-dob', "Date of birth required"); isValid = false; }
    
    // Password Checks
    if (password === "") { 
        showError('error-password', "Password required"); 
        isValid = false; 
    } else if (password.length < 4) {
        showError('error-password', "Password must be 4+ chars");
        isValid = false;
    }

    if (rePassword === "") {
        showError('error-repassword', "Confirm your password");
        isValid = false;
    } else if (password !== rePassword) {
        showError('error-repassword', "Passwords do not match");
        isValid = false;
    }

    if (type === "") { showError('error-type', "User Type required"); isValid = false; }

    // --- STOP IF INVALID ---
    if (!isValid) {
        console.log("Validation Failed. Stopping.");
        return;
    }

    console.log("Validation Success. Sending to PHP...");

    // --- SEND TO PHP ---
    const formData = {
        name: name,
        username: username,
        email: email,
        gender: gender,
        dob: dob,
        password: password,
        rePassword: rePassword,
        type: type
    };

    fetch('../controllers/regCheck.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(formData)
    })
    .then(response => response.json())
    .then(data => {
        console.log("Response received:", data);
        if (data.status) {
            alert("Success! Redirecting to login...");
            window.location.href = 'login.php';
        } else {
            const generalError = document.getElementById('generalError');
            if(generalError) {
                generalError.textContent = data.message;
                generalError.style.display = 'block';
            } else {
                alert(data.message);
            }
        }
    })
    .catch(error => {
        console.error('Fetch Error:', error);
        alert("System Error. Check console for details.");
    });
});