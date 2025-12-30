document.addEventListener("DOMContentLoaded", function() {
    
    // 1. Fetch user data from the PHP Controller
    fetch('../controllers/profileCheck.php')
    .then(res => res.json()) // Parse the JSON response
    .then(data => {
        
        // 2. Check if the request was successful
        if (data.status) {
            const user = data.data;
            
            // 3. Inject data into the HTML Table
            // Using textContent is safer than innerHTML (prevents XSS)
            document.getElementById('pName').textContent = user.name;
            document.getElementById('pUsername').textContent = user.username;
            document.getElementById('pEmail').textContent = user.email;
            document.getElementById('pGender').textContent = user.gender;
            document.getElementById('pDob').textContent = user.dob;
            
            // 4. Format the Role (e.g., "admin" -> "Admin")
            // The || 'User' part is a fallback just in case
            let role = user.type || 'User';
            document.getElementById('pType').textContent = role.charAt(0).toUpperCase() + role.slice(1);
            
        } else {
            // If session expired or user not found
            console.error("Server Error:", data.message);
            alert("Error: " + data.message);
            // Optional: Redirect to login if unauthorized
            // window.location.href = 'login.php';
        }
    })
    .catch(err => {
        // If the fetch fails entirely (e.g., 404 or 500 error)
        console.error("Fetch Error:", err);
        document.getElementById('pName').textContent = "Error loading data.";
    });
});