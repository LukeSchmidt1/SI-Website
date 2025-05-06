function validateSignupForm() {
    const email = document.getElementById('email').value;
    const password = document.getElementById('password');
    const passwordValue = password ? password.value : '';

    // Email validation
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!emailRegex.test(email)) {
        alert('Please enter a valid email address.');
        return false;
    }

    // Password validation
    if (passwordValue.length < 6) {
        alert('Password must be at least 6 characters long.');
        return false;
    }
    if (/^[a-zA-Z]+$/.test(passwordValue) || /^[0-9]+$/.test(passwordValue)) {
        alert('Password cannot be entirely alphabetic or numeric.');
        return false;
    }

    return true;
}
