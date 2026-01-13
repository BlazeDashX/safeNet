document.getElementById('reportForm').onsubmit = function(e) {
    e.preventDefault();

    // Clear previous errors
    document.querySelectorAll('.error-text').forEach(el => el.style.display = 'none');
    document.querySelectorAll('input, select, textarea').forEach(el => el.classList.remove('error-border'));
    document.getElementById('generalError').textContent = "";

    // Get form values
    const desc = document.getElementById('desc').value.trim();
    const rel = document.getElementById('rel').value;
    const type = document.getElementById('type').value;
    const fileEl = document.getElementById('evidence');

    let valid = true;

    // Validation
    if (!desc) {
        document.getElementById('err-desc').textContent = "Description required";
        document.getElementById('err-desc').style.display = "block";
        document.getElementById('desc').classList.add('error-border');
        valid = false;
    } else if (desc.length < 15) {
        document.getElementById('err-desc').textContent = "Description too short";
        document.getElementById('err-desc').style.display = "block";
        document.getElementById('desc').classList.add('error-border');
        valid = false;
    }

    if (!rel) {
        document.getElementById('err-rel').textContent = "Select relationship";
        document.getElementById('err-rel').style.display = "block";
        document.getElementById('rel').classList.add('error-border');
        valid = false;
    }

    if (!type) {
        document.getElementById('err-type').textContent = "Select incident type";
        document.getElementById('err-type').style.display = "block";
        document.getElementById('type').classList.add('error-border');
        valid = false;
    }

    // File size/type validation
    if (fileEl.files.length > 0) {
        const allowed = ['jpg','jpeg','png','pdf'];
        const file = fileEl.files[0];
        const ext = file.name.split('.').pop().toLowerCase();

        if (!allowed.includes(ext)) {
            document.getElementById('err-file').textContent = "Invalid file type";
            document.getElementById('err-file').style.display = "block";
            fileEl.classList.add('error-border');
            valid = false;
        } else if (file.size > 2 * 1024 * 1024) {
            document.getElementById('err-file').textContent = "File too large (max 2MB)";
            document.getElementById('err-file').style.display = "block";
            fileEl.classList.add('error-border');
            valid = false;
        }
    }

    if (!valid) return;

    // Submit using XMLHttpRequest
    const formData = new FormData();
    formData.append('description', desc);
    formData.append('relationship', rel);
    formData.append('type', type);
    if (fileEl.files.length > 0) formData.append('evidence', fileEl.files[0]);

    const xhr = new XMLHttpRequest();
    xhr.open('POST', '../../controllers/reportCheck.php', true);
    xhr.onload = function() {
        if (xhr.status === 200) {
            try {
                const res = JSON.parse(xhr.responseText);
                if (res.status) {
                    alert(res.message);
                    window.location.href = '../user/userDashboard.php';
                } else {
                    document.getElementById('generalError').textContent = res.message;
                    document.getElementById('generalError').style.display = "block";
                }
            } catch (err) {
                document.getElementById('generalError').textContent = "System error.";
                document.getElementById('generalError').style.display = "block";
            }
        } else {
            document.getElementById('generalError').textContent = "Server error.";
            document.getElementById('generalError').style.display = "block";
        }
    };
    xhr.send(formData);
};
