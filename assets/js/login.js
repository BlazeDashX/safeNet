// Form submit handler
document.getElementById("loginForm").addEventListener("submit", function (e) {
    e.preventDefault();

    // Input values
    const identifier = document.getElementById("loginIdentifier").value.trim();
    const password = document.getElementById("loginPassword").value.trim();

    // Clear errors
    document.querySelectorAll('.error-msg').forEach(el => el.style.display = 'none');

    // Empty check
    if (!identifier || !password) {
        alert("Please fill in both fields.");
        return;
    }

    // Request data
    const formData = {
        identifier: identifier,
        password: password
    };

    // Send request
    fetch('../controllers/loginCheck.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(formData)
    })
    .then(response => response.json())
    .then(data => {

        // Login success
        if (data.status) {
            window.location.href = data.redirect;
        } 
        // Login failed
        else {
            alert(data.message);
        }
    })
    // Network error
    .catch(() => {
        alert("Server connection error.");
    });
});
