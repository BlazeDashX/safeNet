document.addEventListener('DOMContentLoaded', function () {

    // --- 1. HANDLE REGISTRATION ---
    const regForm = document.getElementById('regForm');
    if (regForm) {
        regForm.addEventListener('submit', function (e) {
            e.preventDefault(); // Stop page reload

            // Clear previous errors
            const msgBox = document.getElementById('messageBox');
            msgBox.textContent = 'Processing...';
            msgBox.style.color = 'blue';

            // Collect Data
            const formData = {
                username: document.getElementById('username').value,
                email: document.getElementById('email').value,
                password: document.getElementById('password').value,
                confirmPassword: document.getElementById('confirmPassword').value
            };

            // Send AJAX Request
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
                    // Optional: Redirect to login after delay
                    setTimeout(() => { window.location.href = 'login.html'; }, 2000);
                } else {
                    msgBox.style.color = 'red';
                    msgBox.textContent = data.message;
                }
            })
            .catch(error => {
                console.error('Error:', error);
                msgBox.textContent = 'An error occurred. Check console.';
            });
        });
    }

    // --- 2. HANDLE LOGIN ---
    const loginForm = document.getElementById('loginForm');
    if (loginForm) {
        loginForm.addEventListener('submit', function (e) {
            e.preventDefault();

            const msgBox = document.getElementById('messageBox');
            msgBox.textContent = 'Verifying...';
            msgBox.style.color = 'blue';

            const formData = {
                username: document.getElementById('username').value,
                password: document.getElementById('password').value
            };

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
                    window.location.href = 'dashboard.html';
                } else {
                    msgBox.style.color = 'red';
                    msgBox.textContent = data.message;
                }
            })
            .catch(error => console.error('Error:', error));
        });
    }
});