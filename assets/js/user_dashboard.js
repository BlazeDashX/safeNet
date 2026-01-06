// Logout action
document.getElementById('logoutBtn').addEventListener('click', function (e) {
    e.preventDefault();

    // Logout request
    fetch('../../controllers/logout.php')
    .then(res => res.json())
    .then(data => {
        if (data.status) {
            window.location.href = '../../views/login.php';
        }
    });
});
