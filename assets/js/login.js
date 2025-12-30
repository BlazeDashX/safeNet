document.getElementById("loginForm").onsubmit = function (e) {
    e.preventDefault();

    const formData = {
        identifier: document.getElementById("loginIdentifier").value.trim(),
        password: document.getElementById("loginPassword").value.trim()
    };

    fetch('../controllers/loginCheck.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(formData)
    })
    .then(response => response.json())
    .then(data => {
        if (data.status) {
            // Redirect based on user type received from PHP
            const userType = data.user.type;
            if (userType === 'admin' || userType === 'consultant') {
                window.location.href = 'admin_dashboard.html';
            } else {
                window.location.href = 'user_dashboard.html';
            }
        } else {
            alert(data.message);
        }
    })
    .catch(error => console.error('Error:', error));
};