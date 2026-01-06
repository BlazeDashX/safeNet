// Page load
document.addEventListener("DOMContentLoaded", function() {

    // Load profile
    fetch('../controllers/profileCheck.php')
    .then(res => res.json())
    .then(data => {
        if (data.status) {
            const user = data.data;
            document.getElementById('editName').value = user.name;
            document.getElementById('editEmail').value = user.email;
            document.getElementById('editDob').value = user.dob;
            document.getElementById('editGender').value = user.gender;

            // User role
            let role = user.type || 'user';
            document.getElementById('editType').value =
                role.charAt(0).toUpperCase() + role.slice(1);
        }
    });

    // Error handler
    function setError(id, show, msg = "") {
        const el = document.getElementById(id);
        const errEl = document.getElementById(
            'err-' + id.replace('edit', '').toLowerCase()
        );

        if (show) {
            el.classList.add('error-border');
            if (errEl) {
                errEl.textContent = msg;
                errEl.style.display = 'block';
            }
        } else {
            el.classList.remove('error-border');
            if (errEl) errEl.style.display = 'none';
        }
    }

    // Form submit
    document.getElementById('editForm').onsubmit = function(e) {
        e.preventDefault();

        // Reset errors
        document.querySelectorAll('.error-text')
            .forEach(el => el.style.display = 'none');
        document.querySelectorAll('input')
            .forEach(el => el.classList.remove('error-border'));
        document.getElementById('generalError').textContent = "";

        // Form values
        const name = document.getElementById('editName').value.trim();
        const email = document.getElementById('editEmail').value.trim();
        const dob = document.getElementById('editDob').value;
        const gender = document.getElementById('editGender').value;

        let isValid = true;

        // Name check
        if (name === "") {
            setError('editName', true, "Name required");
            isValid = false;
        }

        // Email check
        const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (email === "") {
            setError('editEmail', true, "Email required");
            isValid = false;
        } else if (!emailPattern.test(email)) {
            setError('editEmail', true, "Invalid email");
            isValid = false;
        }

        // DOB check
        if (dob === "") {
            setError('editDob', true, "DOB required");
            isValid = false;
        } else {
            const dobDate = new Date(dob);
            const today = new Date();
            let age = today.getFullYear() - dobDate.getFullYear();
            const m = today.getMonth() - dobDate.getMonth();
            if (m < 0 || (m === 0 && today.getDate() < dobDate.getDate())) {
                age--;
            }
            if (age < 14) {
                setError('editDob', true, "Age below limit");
                isValid = false;
            }
        }

        // Validation stop
        if (!isValid) return;

        // Submit data
        const formData = { name, email, dob, gender };

        fetch('../controllers/profileCheck.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(formData)
        })
        .then(res => res.json())
        .then(data => {
            if (data.status) {
                alert(data.message);
                window.location.href = 'profile.php';
            } else {
                const genErr = document.getElementById('generalError');
                genErr.textContent = data.message;
                genErr.style.display = 'block';
            }
        });
    };
});
