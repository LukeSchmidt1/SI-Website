document.addEventListener("DOMContentLoaded", function () {
    const form = document.getElementById("addSIForm");

    form.addEventListener("submit", function (event) {
        const nameInput = document.getElementById("name");
        const emailInput = document.getElementById("email");
        const classInput = document.getElementById("class_name");
        const timeInput = document.getElementById("session_time");
        const locationInput = document.getElementById("session_location");

        const nameError = document.getElementById("name-error");
        const emailError = document.getElementById("email-error");
        const classError = document.getElementById("class-name-error");
        const timeError = document.getElementById("session-time-error");
        const locationError = document.getElementById("session-location-error");

        const name = nameInput.value.trim();
        const email = emailInput.value.trim();
        const className = classInput.value.trim();
        const location = locationInput.value.trim();

        const nameRegex = /^[A-Za-z]+ [A-Za-z]+$/;
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        const classRegex = /^[A-Z]{4} \d{4}$/;
        const locationRegex = /^[A-Z]{3} \d{3}$/;

        let isValid = true;

        // Clear all previous errors
        [nameInput, emailInput, classInput, timeInput, locationInput].forEach(input => {
            input.classList.remove("is-invalid");
        });
        [nameError, emailError, classError, timeError, locationError].forEach(div => {
            div.textContent = "";
        });

        if (!nameRegex.test(name)) {
            nameInput.classList.add("is-invalid");
            nameError.textContent = "Please enter a valid first and last name.";
            isValid = false;
        }

        if (!emailRegex.test(email)) {
            emailInput.classList.add("is-invalid");
            emailError.textContent = "Please enter a valid email.";
            isValid = false;
        }

        if (!classRegex.test(className)) {
            classInput.classList.add("is-invalid");
            classError.textContent = "Use format ABCD 1234.";
            isValid = false;
        }

        if (timeInput.value === "") {
            timeInput.classList.add("is-invalid");
            timeError.textContent = "Please select a session time.";
            isValid = false;
        }

        if (!locationRegex.test(location)) {
            locationInput.classList.add("is-invalid");
            locationError.textContent = "Use format ATK 123.";
            isValid = false;
        }

        if (!isValid) {
            event.preventDefault();
        }
    });
});
