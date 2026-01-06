// Logout button click
document.getElementById('logoutBtn').addEventListener('click', function(e) {
    e.preventDefault(); // Prevent default link behavior

    // Call logout controller
    fetch('../../controllers/logout.php')
        .then(res => res.json()) // Parse JSON response
        .then(data => {
            if (data.status) {
                // Redirect to login on success
                window.location.href = '../../views/login.php';
            }
        })
        .catch(err => console.error("Logout failed:", err)); // Error handling
});
