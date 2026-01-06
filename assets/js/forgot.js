document.getElementById('verifyForm').onsubmit = function(e) {
    e.preventDefault();
    const formData = new FormData(this);
    formData.append('action', 'verify');

    fetch('../controllers/forgotCheck.php', {
        method: 'POST',
        body: formData
    })
    .then(res => res.json())
    .then(data => {
        // Reset errors
        document.querySelectorAll('.error-msg').forEach(el => el.style.display = 'none');

        if (data.status) {
            document.getElementById('step-1').style.display = 'none';
            document.getElementById('step-2').style.display = 'block';
            document.getElementById('verified_user_id').value = data.userId;
        } else {
            const errEl = document.getElementById('error-email');
            errEl.innerText = data.message;
            errEl.style.display = 'block';
        }
    });
};

document.getElementById('resetForm').onsubmit = function(e) {
    e.preventDefault();
    const formData = new FormData(this);
    formData.append('action', 'reset');

    fetch('../controllers/forgotCheck.php', {
        method: 'POST',
        body: formData
    })
    .then(res => res.json())
    .then(data => {
        if (data.status) {
            alert(data.message);
            window.location.href = 'login.php';
        } else {
            const errEl = document.getElementById('error-newpass');
            errEl.innerText = data.message;
            errEl.style.display = 'block';
        }
    });
};