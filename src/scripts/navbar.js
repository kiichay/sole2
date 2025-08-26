/* scripts/navbar.js */

// ------- Debounced search submit -------
(function () {
  const input = document.getElementById('searchInput');
  const form  = document.getElementById('searchForm');
  if (!input || !form) return;

  let t;
  input.addEventListener('keyup', () => {
    clearTimeout(t);
    t = setTimeout(() => form.submit(), 500);
  });
})();

// ------- Helpers to open/close modals -------
function openModal(el) {
  if (el) el.style.display = 'flex';
}

function closeModal(el) {
  if (el) el.style.display = 'none';
}

// ------- Account Settings modal (view) -------
(function () {
  const profileIcon = document.getElementById('profileIcon');
  const profileModal = document.getElementById('profileModal');
  const closeBtn = document.getElementById('closeProfileModal');

  profileIcon?.addEventListener('click', () => openModal(profileModal));
  closeBtn?.addEventListener('click', () => closeModal(profileModal));
  profileModal?.addEventListener('click', (e) => { if (e.target === profileModal) closeModal(profileModal); });
  document.addEventListener('keydown', (e) => { if (e.key === 'Escape') closeModal(profileModal); });
})();

// ------- Edit Account modal -------
(function () {
  const editBtn = document.getElementById('editAccountBtn');
  const profileModal = document.getElementById('profileModal');
  const editModal = document.getElementById('editAccountModal');
  const closeEdit = document.getElementById('closeEditModal');
  const backFromEdit = document.getElementById('backFromEditBtn');

  editBtn?.addEventListener('click', () => {
    closeModal(profileModal);
    openModal(editModal);
  });
  closeEdit?.addEventListener('click', () => closeModal(editModal));
  backFromEdit?.addEventListener('click', () => {
    closeModal(editModal);
    openModal(profileModal);
  });
  editModal?.addEventListener('click', (e) => { if (e.target === editModal) closeModal(editModal); });
  document.addEventListener('keydown', (e) => { if (e.key === 'Escape') closeModal(editModal); });
})();

// ------- Change Avatar: open picker + live preview -------
(function () {
  const btn = document.getElementById('changeAvatarBtn');
  const input = document.getElementById('avatarInput');

  const previews = [
    document.getElementById('avatarPreview'), // edit modal
    document.getElementById('profileImg'),    // view modal
    document.getElementById('profileIcon')    // navbar thumb
  ].filter(Boolean);

  btn?.addEventListener('click', () => input?.click());
  input?.addEventListener('change', (e) => {
    const file = e.target.files && e.target.files[0];
    if (!file) return;
    const url = URL.createObjectURL(file);
    previews.forEach(img => img.src = url);
  });
})();

// Show alert banner with the given message and hide it after 5 seconds
function showAlert(message) {
    const alertBanner = document.getElementById('alertBanner');
    const alertMessage = document.getElementById('alertMessage');
    
    alertMessage.textContent = message;  // Set the message text
    alertBanner.style.display = 'block'; // Show the banner
    alertBanner.style.opacity = 1; // Ensure full opacity when it's shown

    // Automatically hide the banner after 5 seconds (with fade-out effect)
    setTimeout(() => {
        alertBanner.style.opacity = 0; // Fade out the banner
        // After the fade-out transition is complete, hide the banner
        setTimeout(() => {
            alertBanner.style.display = 'none'; // Hide the banner
        }, 400); // Match the fade-out time (0.5s)
    }, 4000); // Time before it starts fading out (5 seconds)
}

// // Close the alert banner when the user clicks the close button
// function closeAlert() {
//     const alertBanner = document.getElementById('alertBanner');
//     alertBanner.style.opacity = 0;  // Fade out the banner
//     setTimeout(() => {
//         alertBanner.style.display = 'none';  // Hide the banner after fade-out
//     }, 500);  // Match the fade-out time (0.5s)
// }

// ------- Form Validation: contact number and password -------

(function () {
    const form = document.getElementById('editAccountForm');
    const phone = document.getElementById('contactnumber');
    const password = document.getElementById('password');

    // Validate phone number format
    phone?.addEventListener('input', () => {
        phone.value = phone.value.replace(/\D/g, '').slice(0, 13); // Keep only digits and limit length to 13
        if (phone.value.startsWith('9') && phone.value.length === 11) {
            phone.value = '+63' + phone.value.slice(1); // Format as +63
        } else if (phone.value.startsWith('0') && phone.value.length === 11) {
            phone.value = '0' + phone.value.slice(1); // Local version (starts with 0)
        }
    });

    // Validate on form submission
    form?.addEventListener('submit', (e) => {
        // Check if the phone number is valid
        if (!/^(\+63|0)[9][0-9]{9}$/.test(phone.value)) {
            e.preventDefault();  // Prevent form submission
            showAlert('Please enter a valid Philippine phone number starting with +63 or 09 (11 digits).');
            phone.focus();
            return;
        }

        // Check if the password contains at least one special character
        if (password.value && !/[!@#$%^&*(),.?":{}|<>]/.test(password.value)) {
            e.preventDefault();  // Prevent form submission
            showAlert('Password must contain at least one special character.');
            password.focus();
            return;
        }
    });
})();
