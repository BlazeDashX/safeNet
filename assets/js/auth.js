document.addEventListener('DOMContentLoaded', function () {

    // --- 1. REGISTRATION FORM ---
    const regForm = document.getElementById('regForm');
    if (regForm) {
        regForm.addEventListener('submit', function (e) {
            e.preventDefault(); // Stop page reload

            const msgBox = document.getElementById('messageBox');
            msgBox.textContent = 'Processing...';
            msgBox.style.color = 'blue';

            // Collect input values
            const formData = {
                username: document.getElementById('username').value,
                email: document.getElementById('email').value,
                password: document.getElementById('password').value,
                confirmPassword: document.getElementById('confirmPassword').value
            };

            // Send to server
            fetch('../controllers/regCheck.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify(formData)
            })
            .then(response => response.json())
            .then(data => {
                if (data.status) {
                    msgBox.style.color = 'green';
                    msgBox.textContent = data.message;
                    setTimeout(() => { window.location.href = 'login.html'; }, 2000); // Redirect
                } else {
                    msgBox.style.color = 'red';
                    msgBox.textContent = data.message; // Show error
                }
            })
            .catch(error => {
                console.error('Error:', error);
                msgBox.textContent = 'An error occurred. Check console.';
            });
        });
    }

    // --- 2. LOGIN FORM ---
    const loginForm = document.getElementById('loginForm');
    if (loginForm) {
        loginForm.addEventListener('submit', function (e) {
            e.preventDefault(); // Prevent reload

            const msgBox = document.getElementById('messageBox');
            msgBox.textContent = 'Verifying...';
            msgBox.style.color = 'blue';

            // Collect login data
            const formData = {
                username: document.getElementById('username').value,
                password: document.getElementById('password').value
            };

            // Send to server
            fetch('../controllers/loginCheck.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify(formData)
            })
            .then(response => response.json())
            .then(data => {
                if (data.status) {
                    msgBox.style.color = 'green';
                    msgBox.textContent = 'Success! Redirecting...';
                    window.location.href = 'dashboard.html'; // Redirect
                } else {
                    msgBox.style.color = 'red';
                    msgBox.textContent = data.message; // Show error
                }
            })
            .catch(error => console.error('Error:', error));
        });
    }

});
