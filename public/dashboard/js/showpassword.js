function togglePassword() {
    const passwordInput = document.getElementById("password");
    const toggleIcon = document.getElementById("toggleIcon");
    if (passwordInput.type === "password") {
        passwordInput.type = "text";
        toggleIcon.classList.remove("fa-eye");
        toggleIcon.classList.add("fa-eye-slash");
    } else {
        passwordInput.type = "password";
        toggleIcon.classList.remove("fa-eye-slash");
        toggleIcon.classList.add("fa-eye");
    }
}

function toggleCurrentPassword() {
    const currentPasswordInput = document.getElementById("current_password");
    const toggleIcon = document.getElementById("togglecurrentIcon");
    if (currentPasswordInput.type === "password") {
        currentPasswordInput.type = "text";
        toggleIcon.classList.remove("fa-eye");
        toggleIcon.classList.add("fa-eye-slash");
    } else {
        currentPasswordInput.type = "password";
        toggleIcon.classList.remove("fa-eye-slash");
        toggleIcon.classList.add("fa-eye");
    }
}

function togglePasswordConfirmation() {
    const passwordConfirmationInput = document.getElementById("password_confirmation");
    const toggleIcon = document.getElementById("toggleConfirmationIcon");
    if (passwordConfirmationInput.type === "password") {
        passwordConfirmationInput.type = "text";
        toggleIcon.classList.remove("fa-eye");
        toggleIcon.classList.add("fa-eye-slash");
    } else {
        passwordConfirmationInput.type = "password";
        toggleIcon.classList.remove("fa-eye-slash");
        toggleIcon.classList.add("fa-eye");
    }
}
