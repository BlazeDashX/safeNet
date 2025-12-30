document.addEventListener("DOMContentLoaded", function() {
    
    // 1. Load Data
    fetch('../controllers/profileCheck.php')
    .then(res => res.json())
    .then(data => {
        if (data.status) {
            const user = data.data;
            document.getElementById('editName').value = user.name;
            document.getElementById('editEmail').value = user.email;
            document.getElementById('editDob').value = user.dob;
            document.getElementById('editGender').value = user.gender;
            
            let role = user.type || 'user';
            document.getElementById('editType').value = role.charAt(0).toUpperCase() + role.slice(1);
        }
    });

    // 2. Helper: Show/Hide Errors
    function setError(id, show, msg = "") {
        const el = document.getElementById(id); // The input field
        const errEl = document.getElementById('err-' + id.replace('edit', '').toLowerCase()); // The span
        
        if (show) {
            el.classList.add('error-border');
            if(errEl) {
                errEl.textContent = msg;
                errEl.style.display = 'block';
            }
        } else {
            el.classList.remove('error-border');
            if(errEl) errEl.style.display = 'none';
        }
    }

    // 3. Handle Submit with Inline Validation
    document.getElementById('editForm').onsubmit = function(e) {
        e.preventDefault();
        
        // Reset previous errors
        document.querySelectorAll('.error-text').forEach(el => el.style.display = 'none');
        document.querySelectorAll('input').forEach(el => el.classList.remove('error-border'));
        document.getElementById('generalError').textContent = "";

        const name = document.getElementById('editName').value.trim();
        const email = document.getElementById('editEmail').value.trim();
        const dob = document.getElementById('editDob').value;
        const gender = document.getElementById('editGender').value;
        
        let isValid = true;

        // --- INLINE JS VALIDATION ---

        // Check Name
        if (name === "") {
            setError('editName', true, "Name is required");
            isValid = false;
        }

        // Check Email
        const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (email === "") {
            setError('editEmail', true, "Email is required");
            isValid = false;
        } else if (!emailPattern.test(email)) {
            setError('editEmail', true, "Please enter a valid email (e.g., user@example.com)");
            isValid = false;
        }

        // Check DOB (Age 14+)
        if (dob === "") {
            setError('editDob', true, "Date of Birth is required");
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
                setError('editDob', true, "You must be at least 14 years old");
                isValid = false;
            }
        }

        if (!isValid) return; // Stop if JS validation failed

        // --- SEND TO PHP (Server Validation) ---
        const formData = { name, email, dob, gender };

        fetch('../controllers/profileCheck.php', {
            method: 'POST',
            headers: {'Content-Type': 'application/json'},
            body: JSON.stringify(formData)
        })
        .then(res => res.json())
        .then(data => {
            if (data.status) {
                alert("Success: " + data.message);
                window.location.href = 'profile.php'; 
            } else {
                // Show PHP errors in the general error box
                const genErr = document.getElementById('generalError');
                genErr.textContent = data.message;
                genErr.style.display = 'block';
            }
        })
        .catch(err => console.error(err));
    };
});