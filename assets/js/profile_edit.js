document.addEventListener("DOMContentLoaded", function() {
    const editName = document.getElementById('editName');
    const editEmail = document.getElementById('editEmail');
    const editDob = document.getElementById('editDob');
    const editGender = document.getElementById('editGender');
    const editType = document.getElementById('editType');
    const generalError = document.getElementById('generalError');

    // Load profile 
    const xhrLoad = new XMLHttpRequest();
    xhrLoad.open("GET", "../controllers/profileCheck.php", true);
    xhrLoad.onreadystatechange = function() {
        if (this.readyState === 4 && this.status === 200) {
            const res = JSON.parse(this.responseText);
            if (res.status) {
                const user = res.data;
                editName.value = user.name;
                editEmail.value = user.email;
                editDob.value = user.dob;
                editGender.value = user.gender;
                editType.value = user.type.charAt(0).toUpperCase() + user.type.slice(1);
            } else {
                generalError.textContent = res.message;
                generalError.style.display = 'block';
            }
        }
    };
    xhrLoad.send();

    function setError(el, message) {
        el.classList.add('error-border');
        const errEl = document.getElementById('err-' + el.id.replace('edit','').toLowerCase());
        if (errEl) {
            errEl.textContent = message;
            errEl.style.display = 'block';
        }
    }

    function clearErrors() {
        document.querySelectorAll('.error-text').forEach(el => el.style.display = 'none');
        document.querySelectorAll('input').forEach(el => el.classList.remove('error-border'));
        generalError.textContent = '';
    }

    document.getElementById('editForm').onsubmit = function(e) {
        e.preventDefault();
        clearErrors();

        const name = editName.value.trim();
        const email = editEmail.value.trim();
        const dob = editDob.value;
        const gender = editGender.value;

        let valid = true;

        if (name === "") { setError(editName, "Name required"); valid = false; }

        const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (email === "") { setError(editEmail, "Email required"); valid = false; }
        else if (!emailPattern.test(email)) { setError(editEmail, "Invalid email"); valid = false; }

        if (dob === "") { setError(editDob, "DOB required"); valid = false; }
        else {
            const dobDate = new Date(dob);
            const today = new Date();
            let age = today.getFullYear() - dobDate.getFullYear();
            const m = today.getMonth() - dobDate.getMonth();
            if (m < 0 || (m === 0 && today.getDate() < dobDate.getDate())) age--;
            if (age < 14) { setError(editDob, "Age below limit"); valid = false; }
        }

        if (!valid) return;

        //  AJAX submit
        const xhr = new XMLHttpRequest();
        xhr.open("POST", "../controllers/profileCheck.php", true);
        xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhr.onreadystatechange = function() {
            if (this.readyState === 4 && this.status === 200) {
                const res = JSON.parse(this.responseText);
                if (res.status) {
                    alert(res.message);
                    window.location.href = 'profile.php';
                } else {
                    generalError.textContent = res.message;
                    generalError.style.display = 'block';
                }
            }
        };
        xhr.send(
            "name=" + encodeURIComponent(name) +
            "&email=" + encodeURIComponent(email) +
            "&dob=" + encodeURIComponent(dob) +
            "&gender=" + encodeURIComponent(gender)
        );
    };
});
