document.getElementById("loginForm").addEventListener("submit", function (e) {
    e.preventDefault();

    let identifier = document.getElementById("loginIdentifier").value.trim();
    let password   = document.getElementById("loginPassword").value.trim();

    if (identifier === "" || password === "") {
        alert("Please fill in both fields.");
        return;
    }

    let user = {
        identifier: identifier,
        password: password
    };

    let data = JSON.stringify(user);

    let xhttp = new XMLHttpRequest();
    xhttp.open("POST", "../controllers/loginCheck.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

    xhttp.onreadystatechange = function () {
        if (this.readyState === 4 && this.status === 200) {
            let response = JSON.parse(this.responseText);

            if (response.status) {
                window.location.href = response.redirect;
            } else {
                alert(response.message);
            }
        }
    };

    xhttp.send("user=" + data);
});
