function deleteUser(id, name) {
    if(confirm("Are you sure you want to permanently remove user '" + name + "'?")) {
        
        fetch('../../controllers/delete_user.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: 'id=' + id
        })
        .then(res => res.text()) // Get raw text first, not JSON
        .then(text => {
            try {
                // Try to convert text to JSON manually
                let data = JSON.parse(text);
                
                if(data.success) {
                    location.reload();
                } else {
                    alert("Error: " + (data.message || "Could not delete user."));
                }
            } catch (e) {
                // If it fails, SHOW THE USER THE RAW TEXT so we know what's wrong
                console.error("Server Response:", text);
                alert("Server Error (Not JSON):\n" + text);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert("Network Error. Check console.");
        });
    }
}