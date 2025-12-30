document.getElementById('logoutBtn').addEventListener('click', function(e) {
    e.preventDefault(); 
    
    // Path adjusted for deep folder structure
    fetch('../../controllers/logout.php')
    .then(res => res.json())
    .then(data => {
        if (data.status) {
            window.location.href = '../../views/login.php';
        }
    })
    .catch(err => console.error("Logout failed:", err));
});