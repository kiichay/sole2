document.addEventListener('DOMContentLoaded', () => {
    // Modal Elements
    const profileModal = document.getElementById("profileModal");
    const updateAccountModal = document.getElementById("updateAccountModal");

    // Button Elements
    const editButton = document.getElementById("editButton");
    const saveButton = document.getElementById("saveButton");
    const closeModal = document.getElementById("closeModal");
    const closeUpdateModal = document.getElementById("closeUpdateModal");
    const backButton = document.getElementById("backButton");

    // Event listener for opening the Profile Modal
    editButton.addEventListener('click', () => {
        // Show the Profile Update Modal
        updateAccountModal.style.display = "block";
    });

    // Event listener for closing the Profile Modal
    closeModal.addEventListener('click', () => {
        profileModal.style.display = "none";
    });

    // Event listener for closing the Update Account Modal
    closeUpdateModal.addEventListener('click', () => {
        updateAccountModal.style.display = "none";
    });

    // Event listener for the Back button inside the Update Account Modal
    backButton.addEventListener('click', () => {
        updateAccountModal.style.display = "none"; // Close the modal and go back to the profile modal
        profileModal.style.display = "block"; // Show the profile modal again
    });

    // Event listener for saving the updated details
    saveButton.addEventListener('click', () => {
        // Gather the form data
        const firstName = document.getElementById("firstName").value;
        const lastName = document.getElementById("lastName").value;
        const address = document.getElementById("address").value;
        const contactNumber = document.getElementById("contactNumber").value;
        const email = document.getElementById("email").value;

        // You can add more validation or send the data to the server here (using AJAX)
        // For now, we're just logging the data to the console
        console.log({
            firstName,
            lastName,
            address,
            contactNumber,
            email
        });

        // Close the update modal
        updateAccountModal.style.display = "none";
        // Show the profile modal again
        profileModal.style.display = "block";
    });

    // Close modals if clicked outside of them
    window.addEventListener('click', (event) => {
        if (event.target === profileModal) {
            profileModal.style.display = "none";
        }
        if (event.target === updateAccountModal) {
            updateAccountModal.style.display = "none";
        }
    });
});
