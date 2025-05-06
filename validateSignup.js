function showAlert(message, type = "info") {
    const placeholder = document.getElementById('js-alert-placeholder');
    if (placeholder) {
        placeholder.innerHTML = `
            <div class="alert alert-${type} mt-3" role="alert">
                ${message}
            </div>
        `;
    }
}

function validateSignupForm() {
    const email = document.getElementById('email').value;
    const password = document.getElementById('password');
    const passwordValue = password ? password.value : '';

    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!emailRegex.test(email)) {
        showAlert('Please enter a valid email address.');
        return false;
    }

    if (passwordValue.length < 6) {
        showAlert('Password must be at least 6 characters long.', 'warning');
        return false;
    }

    if (/^[a-zA-Z]+$/.test(passwordValue) || /^[0-9]+$/.test(passwordValue)) {
        showAlert('Password cannot be entirely alphabetic or numeric.', 'warning');
        return false;
    }

    return true;
}
