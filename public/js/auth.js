// Auth JavaScript functionality
document.addEventListener('DOMContentLoaded', function() {
    // Password toggle functionality
    const togglePassword = document.getElementById('togglePassword');
    const passwordInput = document.getElementById('password');
    const eyeOpen = document.getElementById('eyeOpen');
    const eyeClosed = document.getElementById('eyeClosed');

    if (togglePassword && passwordInput && eyeOpen && eyeClosed) {
        togglePassword.addEventListener('click', function() {
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);

            eyeOpen.classList.toggle('hidden');
            eyeClosed.classList.toggle('hidden');
        });
    }

    // Form validation
    const forms = document.querySelectorAll('form');
    forms.forEach(form => {
        form.addEventListener('submit', function(e) {
            const submitBtn = form.querySelector('button[type="submit"]');
            if (submitBtn) {
                submitBtn.disabled = true;
                submitBtn.innerHTML = 'Memproses...';

                // Re-enable button after 3 seconds to prevent permanent disable
                setTimeout(() => {
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = submitBtn.getAttribute('data-original-text') || 'Submit';
                }, 3000);
            }
        });
    });

    // Store original button text
    const submitButtons = document.querySelectorAll('button[type="submit"]');
    submitButtons.forEach(btn => {
        btn.setAttribute('data-original-text', btn.innerHTML);
    });
});

// Navbar mobile menu toggle
document.addEventListener('DOMContentLoaded', function() {
    const toggleOpen = document.getElementById('toggleOpen');
    const toggleClose = document.getElementById('toggleClose');
    const collapseMenu = document.getElementById('collapseMenu');

    if (toggleOpen && collapseMenu) {
        toggleOpen.addEventListener('click', function() {
            collapseMenu.style.display = 'block';
        });
    }

    if (toggleClose && collapseMenu) {
        toggleClose.addEventListener('click', function() {
            collapseMenu.style.display = 'none';
        });
    }
});
