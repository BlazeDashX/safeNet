// Form submit
document.getElementById('reportForm').onsubmit = function (e) {
    e.preventDefault();

    // Form data
    const formData = new FormData(this);

    // Send request
    fetch('../../controllers/reportCheck.php', {
        method: 'POST',
        body: formData
    })
    .then(res => res.json())
    .then(data => {
        if (data.status) {
            alert(data.message);
            window.location.href = '../user/userDashboard.php';
        } else {
            alert(data.message);
        }
    });
};
