document.getElementById('logoutBtn').addEventListener('click', function(e) {
    e.preventDefault(); // Stop link from jumping
    
    // Path goes up 2 levels because we are in /views/user/
    fetch('../../controllers/logout.php')
    .then(res => res.json())
    .then(data => {
        if (data.status) {
            // Redirect to login (which is in /views/)
            window.location.href = '../../views/login.php';
        }
    })
    .catch(err => console.error("Logout failed:", err));
});