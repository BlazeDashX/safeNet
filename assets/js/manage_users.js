// Faculty-style JS for Manage Users

document.addEventListener("DOMContentLoaded", function () {
    // Delete user buttons
    const deleteButtons = document.querySelectorAll(".btn-delete");

    deleteButtons.forEach(btn => {
        btn.addEventListener("click", function () {
            const userId = this.dataset.id;
            const userName = this.dataset.name;

            if (!confirm(`Are you sure you want to permanently remove user '${userName}'?`)) return;

            // Send POST request to delete_user.php
            fetch("../../controllers/delete_user.php", {
                method: "POST",
                headers: { "Content-Type": "application/x-www-form-urlencoded" },
                body: `id=${userId}`
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    alert(`User '${userName}' removed successfully.`);
                    location.reload();
                } else {
                    alert(data.message || "Could not delete user.");
                }
            })
            .catch(err => {
                console.error(err);
                alert("Network error occurred.");
            });
        });
    });
});
