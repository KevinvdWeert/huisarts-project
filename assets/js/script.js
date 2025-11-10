// Mobile Navigation Toggle
document.addEventListener('DOMContentLoaded', function() {
    // Create mobile menu button if not exists
    const navContainer = document.querySelector('.nav-container');
    const navMenu = document.querySelector('.nav-menu');
    
    if (navContainer && navMenu) {
        // Create hamburger button
        const mobileMenuBtn = document.createElement('button');
        mobileMenuBtn.innerHTML = '☰';
        mobileMenuBtn.className = 'mobile-menu-btn';
        mobileMenuBtn.setAttribute('aria-label', 'Toggle navigation menu');
        
        // Insert button before nav menu
        navContainer.insertBefore(mobileMenuBtn, navMenu);
        
        // Toggle mobile menu
        mobileMenuBtn.addEventListener('click', function() {
            navMenu.classList.toggle('nav-menu-open');
            mobileMenuBtn.innerHTML = navMenu.classList.contains('nav-menu-open') ? '✕' : '☰';
        });
    }
    
    // Form validation enhancement
    const contactForm = document.querySelector('form[action="contact_handler.php"]');
    if (contactForm) {
        contactForm.addEventListener('submit', function(e) {
            const name = this.querySelector('#name').value.trim();
            const email = this.querySelector('#email').value.trim();
            const message = this.querySelector('#message').value.trim();
            
            if (!name || !email || !message) {
                e.preventDefault();
                alert('Vul alle verplichte velden in.');
                return;
            }
            
            // Basic email validation
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailRegex.test(email)) {
                e.preventDefault();
                alert('Voer een geldig e-mailadres in.');
                return;
            }
        });
    }
    
    // Smooth scrolling for anchor links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });
    
    // Auto-hide alerts after 5 seconds
    const alerts = document.querySelectorAll('.alert');
    alerts.forEach(alert => {
        setTimeout(() => {
            alert.style.opacity = '0';
            alert.style.transition = 'opacity 0.5s ease';
            setTimeout(() => {
                alert.remove();
            }, 500);
        }, 5000);
    });
});

// Add loading state to form submit button
function addLoadingState() {
    const submitBtn = document.querySelector('.submit-btn');
    if (submitBtn) {
        submitBtn.addEventListener('click', function() {
            this.innerHTML = 'Verzenden...';
            this.disabled = true;
        });
    }
}