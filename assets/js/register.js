// Form submit
document.getElementById('registerForm').addEventListener('submit', function (e) {
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

    // Clear errors
    document.querySelectorAll('.error-msg')
        .forEach(el => el.style.display = 'none');
    document.querySelectorAll('input, select')
        .forEach(el => el.classList.remove('error-border'));

    // Error display
    function showError(fieldId, message) {
        const errorEl = document.getElementById(fieldId);
        let inputId = fieldId.replace('error-', 's');
        if (fieldId === 'error-name') inputId = 'sName';
        if (fieldId === 'error-dob') inputId = 'sDob';

        const inputEl = document.getElementById(inputId);

        if (errorEl) {
            errorEl.textContent = message;
            errorEl.style.display = 'block';
            if (inputEl) inputEl.classList.add('error-border');
        }
    }

    let isValid = true;

    // Name check
    if (name === "") {
        showError('error-name', "Name required");
        isValid = false;
    }

    // Username check
    if (username === "") {
        showError('error-username', "Username required");
        isValid = false;
    }

    // Email check
    const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (email === "") {
        showError('error-email', "Email required");
        isValid = false;
    } else if (!emailPattern.test(email)) {
        showError('error-email', "Invalid email");
        isValid = false;
    }

    // Gender check
    if (gender === "") {
        showError('error-gender', "Select gender");
        isValid = false;
    }

    // DOB check
    if (dob === "") {
        showError('error-dob', "DOB required");
        isValid = false;
    } else {
        const dobDate = new Date(dob);
        const today = new Date();
        let age = today.getFullYear() - dobDate.getFullYear();
        const m = today.getMonth() - dobDate.getMonth();
        if (m < 0 || (m === 0 && today.getDate() < dobDate.getDate())) age--;
        if (age < 14) {
            showError('error-dob', "Age below limit");
            isValid = false;
        }
    }

    // Password check
    if (password === "") {
        showError('error-password', "Password required");
        isValid = false;
    } else if (password.length < 8) {
        showError('error-password', "Min 8 chars");
        isValid = false;
    }

    // Confirm password
    if (rePassword === "") {
        showError('error-repassword', "Confirm password");
        isValid = false;
    } else if (password !== rePassword) {
        showError('error-repassword', "Password mismatch");
        isValid = false;
    }

    // Type check
    if (type === "") {
        showError('error-type', "User type required");
        isValid = false;
    }

    // Validation stop
    if (!isValid) return;

    // Submit data
    const formData = {
        name,
        username,
        email,
        gender,
        dob,
        password,
        rePassword,
        type
    };

    fetch('../controllers/regCheck.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(formData)
    })
    .then(res => res.json())
    .then(data => {
        if (data.status) {
            alert(data.message);
            window.location.href = 'login.php';
        } else {
            const generalError = document.getElementById('generalError');
            if (generalError) {
                generalError.textContent = data.message;
                generalError.style.display = 'block';
            } else {
                alert(data.message);
            }
        }
    });
});
