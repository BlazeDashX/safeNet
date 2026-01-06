// Delete user
function deleteUser(id, name) {

    // Confirmation check
    if (confirm("Are you sure you want to permanently remove user '" + name + "'?")) {

        // Send request
        fetch('../../controllers/delete_user.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: 'id=' + id
        })
        .then(res => res.json())
        .then(data => {

            // Success response
            if (data.success) {
                location.reload();
            } 
            // Failure response
            else {
                alert(data.message || "Could not delete user.");
            }
        })
        // Request error
        .catch(() => {
            alert("Network error occurred.");
        });
    }
}
