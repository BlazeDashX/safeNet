// Page load
document.addEventListener("DOMContentLoaded", function() {

    // Fetch profile
    fetch('../controllers/profileCheck.php')
    .then(res => res.json())
    .then(data => {

        // Status check
        if (data.status) {
            const user = data.data;

            // Display data
            document.getElementById('pName').textContent = user.name;
            document.getElementById('pUsername').textContent = user.username;
            document.getElementById('pEmail').textContent = user.email;
            document.getElementById('pGender').textContent = user.gender;
            document.getElementById('pDob').textContent = user.dob;

            // Format role
            let role = user.type || 'User';
            document.getElementById('pType').textContent =
                role.charAt(0).toUpperCase() + role.slice(1);
        } 
        // Request failed
        else {
            alert(data.message);
        }
    })
    // Fetch error
    .catch(() => {
        document.getElementById('pName').textContent = "Data load error";
    });
});
