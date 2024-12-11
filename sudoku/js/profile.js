// Wait for the DOM to load
document.addEventListener("DOMContentLoaded", () => {
    // Get DOM elements
    const modal = document.getElementById("profileModal");
    const profileLink = document.getElementById("profile-link");
    const closeBtn = document.querySelector(".close");

    // Check if modal and buttons exist in the DOM
    if (modal && profileLink && closeBtn) {
        // Show the modal when clicking the "Profile" link
        profileLink.addEventListener("click", (event) => {
            event.preventDefault(); // Prevent the default anchor behavior
            modal.style.display = "block"; // Show the modal
        });

        // Close the modal when clicking the close button
        closeBtn.addEventListener("click", () => {
            modal.style.display = "none"; // Hide the modal
        });

        // Close the modal when clicking outside the modal content
        window.addEventListener("click", (event) => {
            if (event.target === modal) {
                modal.style.display = "none"; // Hide the modal
            }
        });
    } else {
        console.error("Modal elements not found in the DOM.");
    }
});