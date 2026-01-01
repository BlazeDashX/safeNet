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
    
    // Helper: Clear visual errors from inputs
    function clearInputErrors() {
        // Clear red borders on all inputs/selects on submission attempt
        document.querySelectorAll('input, select').forEach(el => el.classList.remove('error-border'));
    }
    
    clearInputErrors(); // Clear borders first
    
    // Helper: Show error (Updated to add 'error-border' to input for consistency)
    function showError(fieldId, message) {
        const errorEl = document.getElementById(fieldId);
        
        // Map error element ID to input element ID
        let inputId = fieldId.replace('error-', 's');
        if (fieldId === 'error-name') inputId = 'sName';
        if (fieldId === 'error-dob') inputId = 'sDob';
        // Add more mapping if needed, but the s[Field] pattern seems to work for most
        
        const inputEl = document.getElementById(inputId);
        
        if (errorEl) {
            errorEl.textContent = message;
            errorEl.style.display = 'block';
            if (inputEl) {
                // Adds the red border class defined in profile_edit.php's CSS
                inputEl.classList.add('error-border');
            }
        }
    }

    let isValid = true;

    // --- VALIDATION START ---

    if (name === "") { showError('error-name', "Name is required"); isValid = false; }
    if (username === "") { showError('error-username', "Username is required"); isValid = false; }
    
    // Email Validation
    const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/; 
    
    if (email === "") { 
        showError('error-email', "Email is required"); 
        isValid = false; 
    } else if (!emailPattern.test(email)) {
        showError('error-email', "Invalid email format (e.g., user@mail.com)");
        isValid = false;
    }

    if (gender === "") { showError('error-gender', "Select a gender"); isValid = false; }
    
    // DOB Validation (Age 14+) - LOGIC ALIGNED WITH profile_edit.js
    if (dob === "") { 
        showError('error-dob', "Date of birth required"); 
        isValid = false; 
    } else {
        const dobDate = new Date(dob);
        const today = new Date();
        let age = today.getFullYear() - dobDate.getFullYear();
        const m = today.getMonth() - dobDate.getMonth();
        
        if (m < 0 || (m === 0 && today.getDate() < dobDate.getDate())) {
            age--;
        }
        
        if (age < 14) {
            showError('error-dob', "You must be at least 14 years old");
            isValid = false;
        }
    }
    
    // Password Checks - LENGTH ALIGNED WITH change_password.js (8 chars)
    if (password === "") { 
        showError('error-password', "Password required"); 
        isValid = false; 
    } else if (password.length < 8) { 
        showError('error-password', "Password must be at least 8 characters");
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