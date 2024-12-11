document.addEventListener("DOMContentLoaded", () => {
    const newPassword = document.getElementById("new_password");
    const confirmPassword = document.getElementById("confirm_password");
    const errorMessage = document.getElementById("error_message");
    const submitButton = document.getElementById("submit_button");

    // Function to check if passwords match
    function checkPasswordsMatch() {
        if (newPassword.value !== confirmPassword.value) {
            errorMessage.style.display = "inline"; // Show error message
            submitButton.disabled = true; // Disable the submit button
        } else {
            errorMessage.style.display = "none"; // Hide error message
            submitButton.disabled = false; // Enable the submit button
        }
    }

    // Event listeners to check passwords when user types
    newPassword.addEventListener("input", checkPasswordsMatch);
    confirmPassword.addEventListener("input", checkPasswordsMatch);
});