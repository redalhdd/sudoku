document.addEventListener('DOMContentLoaded', () => {
    const urlParams = new URLSearchParams(window.location.search);
    const error = urlParams.get('error');
    const modal = document.getElementById('profileModal');
    const modalMessage = document.getElementById('modalMessage');
    const closeModal = document.querySelector('.close');

    if (error) {
        // Customize the error message based on the error code
        if (error === 'username_taken') {
            modalMessage.textContent = 'Nom d\'utilisateur déjà pris.';
        } else if (error== 'password_incorrect'){
            modalMessage.textContent = 'Mot de passe incorrect !';
        }else if (error== 'username_incorrect'){
            modalMessage.textContent = 'Nom d\'utilisateur incorrect !';
        }
        modal.style.display = 'block';
    }

    // Close the modal when the close button is clicked
    closeModal.addEventListener('click', () => {
        modal.style.display = 'none';
        window.history.pushState({}, document.title, window.location.pathname); // Remove the error from the URL
    });

    // Close the modal when clicking outside of it
    window.onclick = (event) => {
        if (event.target === modal) {
            modal.style.display = 'none';
            window.history.pushState({}, document.title, window.location.pathname); // Remove the error from the URL
        }
    };
});
