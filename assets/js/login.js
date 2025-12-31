document.getElementById("loginForm").addEventListener("submit", function (e) {
    e.preventDefault();
    console.log("Login Button Clicked");

    const identifier = document.getElementById("loginIdentifier").value.trim();
    const password = document.getElementById("loginPassword").value.trim();

    // Clear errors
    document.querySelectorAll('.error-msg').forEach(el => el.style.display = 'none');

    if (!identifier || !password) {
        alert("Please fill in both fields.");
        return;
    }

    const formData = {
        identifier: identifier,
        password: password
    };

    // --- DEBUG FETCH ---
    fetch('../controllers/loginCheck.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(formData)
    })
    .then(response => response.text()) // <--- CHANGED: Get raw text first
    .then(text => {
        console.log("Server Raw Response:", text); // Print to console for you to see

        try {
            // Try to convert to JSON manually
            const data = JSON.parse(text);

            if (data.status) {
                // SUCCESS
                console.log("Redirecting to:", data.redirect);
                window.location.href = data.redirect;
            } else {
                // LOGIN FAILED (Wrong password etc)
                alert("Login Failed: " + data.message);
            }
        } catch (error) {
            // PHP ERROR DETECTED
            // This will show you the hidden error causing the crash
            console.error("JSON Parse Failed. Server sent:", text);
            alert("SYSTEM ERROR (Show this to the developer):\n\n" + text);
        }
    })
    .catch(error => {
        console.error('Network Error:', error);
        alert("Network Error: Could not connect to the server.");
    });
});