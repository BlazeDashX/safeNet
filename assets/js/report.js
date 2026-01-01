document.getElementById('reportForm').onsubmit = function(e) {
    e.preventDefault();

    const formData = new FormData(this); // Automatically grabs all inputs + files

    fetch('../../controllers/reportCheck.php', {
        method: 'POST',
        body: formData // No headers needed for FormData
    })
    .then(res => res.json())
    .then(data => {
        if (data.status) {
            alert(data.message);
            // Redirect to dashboard
            window.location.href = '../user/userDashboard.php';
        } else {
            alert("Error: " + data.message);
        }
    })
    .catch(err => console.error(err));
};

console.log("REAL report.js loaded from assets/js");
