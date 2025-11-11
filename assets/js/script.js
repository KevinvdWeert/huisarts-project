// Enhanced JavaScript for Medical Practice Website - Optimized for Performance and Smoothness
document.addEventListener('DOMContentLoaded', function() {
    // Initialize performance optimizations
    initPerformanceOptimizations();
    
    // Enhanced page loading animation
    addPageLoadingAnimation();
    
    // Mobile Navigation Toggle
    initMobileNavigation();
    
    // Enhanced Form functionality
    enhanceContactForm();
    
    // Smooth Scrolling with easing
    initSmoothScrolling();
    
    // Auto-hide Alerts with better animations
    autoHideAlerts();
    
    // Fixed animations system
    initAnimations();
    
    // Enhanced button effects
    initButtonEffects();
    
    // Improved parallax effects
    initParallaxEffects();
    
    // Initialize lazy loading for images
    initLazyLoading();
    
    // Add scroll-based header effects
    initScrollEffects();
    
    // Initialize card hover effects
    initCardHoverEffects();
    
    // Add typing animation for hero text
    initTypingAnimation();
});

// Performance optimizations
function initPerformanceOptimizations() {
    // Passive event listeners
    window.addEventListener('scroll', throttle(handleScrollEffects, 16), { passive: true });
    window.addEventListener('resize', debounce(handleResize, 250), { passive: true });
    
    // Preload critical resources
    preloadCriticalResources();
}

// Throttle function for performance
function throttle(func, delay) {
    let timeoutId;
    let lastExecTime = 0;
    return function (...args) {
        const currentTime = Date.now();
        
        if (currentTime - lastExecTime > delay) {
            func.apply(this, args);
            lastExecTime = currentTime;
        } else {
            clearTimeout(timeoutId);
            timeoutId = setTimeout(() => {
                func.apply(this, args);
                lastExecTime = Date.now();
            }, delay - (currentTime - lastExecTime));
        }
    };
}

// Debounce function for performance
function debounce(func, delay) {
    let timeoutId;
    return function (...args) {
        clearTimeout(timeoutId);
        timeoutId = setTimeout(() => func.apply(this, args), delay);
    };
}

// Enhanced page loading animation
function addPageLoadingAnimation() {
    const body = document.body;
    const main = document.querySelector('main');
    
    // Create loading overlay
    const loadingOverlay = document.createElement('div');
    loadingOverlay.className = 'loading-overlay';
    loadingOverlay.innerHTML = `
        <div class="loading-spinner">
            <div class="spinner-ring"></div>
            <p class="loading-text">Loading...</p>
        </div>
    `;
    document.body.appendChild(loadingOverlay);
    
    // Animate page entrance
    setTimeout(() => {
        loadingOverlay.style.opacity = '0';
        if (main) {
            main.style.opacity = '1';
            main.style.transform = 'translateY(0)';
        }
        
        setTimeout(() => {
            loadingOverlay.remove();
        }, 500);
    }, 800);
}

// Preload critical resources
function preloadCriticalResources() {
    const criticalImages = document.querySelectorAll('img[data-critical]');
    criticalImages.forEach(img => {
        const link = document.createElement('link');
        link.rel = 'preload';
        link.as = 'image';
        link.href = img.src || img.dataset.src;
        document.head.appendChild(link);
    });
}

// Enhanced button effects with spring animation
function initButtonEffects() {
    const buttons = document.querySelectorAll('button, .btn, a[class*="bg-"], .group');
    
    buttons.forEach(button => {
        // Add ripple effect
        button.addEventListener('mousedown', createRippleEffect);
        
        // Enhanced hover effects
        button.addEventListener('mouseenter', function(e) {
            if (!this.classList.contains('no-hover')) {
                this.style.transform = 'translateY(-3px) scale(1.02)';
                this.style.transition = 'all 0.3s cubic-bezier(0.34, 1.56, 0.64, 1)';
                this.style.boxShadow = '0 10px 25px rgba(0, 0, 0, 0.1)';
            }
        });
        
        button.addEventListener('mouseleave', function(e) {
            if (!this.classList.contains('no-hover')) {
                this.style.transform = 'translateY(0) scale(1)';
                this.style.boxShadow = '0 4px 6px rgba(0, 0, 0, 0.05)';
            }
        });
    });
}

// Create ripple effect
function createRippleEffect(e) {
    const button = e.currentTarget;
    const ripple = document.createElement('span');
    const rect = button.getBoundingClientRect();
    const size = Math.max(rect.width, rect.height);
    const x = e.clientX - rect.left - size / 2;
    const y = e.clientY - rect.top - size / 2;
    
    ripple.className = 'ripple-effect';
    ripple.style.width = ripple.style.height = size + 'px';
    ripple.style.left = x + 'px';
    ripple.style.top = y + 'px';
    
    button.style.position = 'relative';
    button.style.overflow = 'hidden';
    button.appendChild(ripple);
    
    setTimeout(() => {
        ripple.remove();
    }, 1000);
}

// Improved parallax effects with performance optimization
function initParallaxEffects() {
    const parallaxElements = document.querySelectorAll('[data-parallax]');
    let ticking = false;
    
    function updateParallax() {
        const scrolled = window.pageYOffset;
        
        parallaxElements.forEach(element => {
            const speed = element.dataset.parallax || 0.5;
            const yPos = -(scrolled * speed);
            const rect = element.getBoundingClientRect();
            
            // Only animate visible elements
            if (rect.bottom >= 0 && rect.top <= window.innerHeight) {
                element.style.transform = `translate3d(0, ${yPos}px, 0)`;
            }
        });
        
        ticking = false;
    }
    
    function requestTick() {
        if (!ticking) {
            requestAnimationFrame(updateParallax);
            ticking = true;
        }
    }
    
    if (parallaxElements.length > 0) {
        window.addEventListener('scroll', requestTick, { passive: true });
    }
}

// Enhanced lazy loading with fade-in effect
function initLazyLoading() {
    const images = document.querySelectorAll('img[data-src]');
    
    if ('IntersectionObserver' in window) {
        const imageObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const img = entry.target;
                    const tempImg = new Image();
                    
                    tempImg.onload = () => {
                        img.src = tempImg.src;
                        img.classList.add('loaded');
                        img.classList.remove('lazy');
                    };
                    
                    tempImg.src = img.dataset.src;
                    imageObserver.unobserve(img);
                }
            });
        }, {
            rootMargin: '50px'
        });
        
        images.forEach(img => {
            img.classList.add('lazy');
            imageObserver.observe(img);
        });
    }
}

// Enhanced mobile navigation
function initMobileNavigation() {
    const mobileMenuBtn = document.querySelector('.mobile-menu-btn');
    const mobileNavMenu = document.querySelector('.mobile-nav-menu');
    let isOpen = false;
    
    if (mobileMenuBtn && mobileNavMenu) {
        mobileMenuBtn.addEventListener('click', function(e) {
            e.stopPropagation();
            isOpen = !isOpen;
            
            // Animate menu toggle
            if (isOpen) {
                mobileNavMenu.classList.remove('hidden');
                setTimeout(() => {
                    mobileNavMenu.style.opacity = '1';
                    mobileNavMenu.style.transform = 'translateY(0)';
                }, 10);
            } else {
                mobileNavMenu.style.opacity = '0';
                mobileNavMenu.style.transform = 'translateY(-20px)';
                setTimeout(() => {
                    mobileNavMenu.classList.add('hidden');
                }, 300);
            }
            
            // Update button icon with animation
            const icon = mobileMenuBtn.querySelector('svg');
            icon.style.transform = 'rotate(180deg)';
            setTimeout(() => {
                icon.innerHTML = isOpen 
                    ? '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>'
                    : '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>';
                icon.style.transform = 'rotate(0deg)';
            }, 150);
        });
        
        // Close mobile menu when clicking outside
        document.addEventListener('click', function(e) {
            if (isOpen && !mobileMenuBtn.contains(e.target) && !mobileNavMenu.contains(e.target)) {
                isOpen = false;
                mobileNavMenu.style.opacity = '0';
                mobileNavMenu.style.transform = 'translateY(-20px)';
                setTimeout(() => {
                    mobileNavMenu.classList.add('hidden');
                }, 300);
            }
        });
    }
}

// Enhanced contact form with better UX
function enhanceContactForm() {
    const contactForm = document.querySelector('form[action*="contact"]');
    if (contactForm) {
        // Add floating labels
        addFloatingLabels(contactForm);
        
        // Real-time validation with smooth feedback
        const inputs = contactForm.querySelectorAll('input, textarea, select');
        inputs.forEach(input => {
            input.addEventListener('focus', handleInputFocus);
            input.addEventListener('blur', handleInputBlur);
            input.addEventListener('input', handleInputChange);
        });
        
        // Enhanced form submission
        contactForm.addEventListener('submit', handleFormSubmission);
    }
}

// Add floating labels
function addFloatingLabels(form) {
    const inputs = form.querySelectorAll('input[type="text"], input[type="email"], textarea');
    inputs.forEach(input => {
        const wrapper = document.createElement('div');
        wrapper.className = 'floating-label-wrapper';
        input.parentNode.insertBefore(wrapper, input);
        wrapper.appendChild(input);
        
        if (input.placeholder) {
            const label = document.createElement('label');
            label.textContent = input.placeholder;
            label.className = 'floating-label';
            wrapper.appendChild(label);
            input.placeholder = '';
        }
    });
}

// Handle input interactions
function handleInputFocus(e) {
    const input = e.target;
    const wrapper = input.closest('.floating-label-wrapper');
    if (wrapper) {
        wrapper.classList.add('focused');
    }
}

function handleInputBlur(e) {
    const input = e.target;
    const wrapper = input.closest('.floating-label-wrapper');
    if (wrapper && !input.value) {
        wrapper.classList.remove('focused');
    }
    validateField(e);
}

function handleInputChange(e) {
    const input = e.target;
    const wrapper = input.closest('.floating-label-wrapper');
    if (wrapper) {
        wrapper.classList.toggle('has-value', input.value.length > 0);
    }
    clearFieldError(e);
}

// Enhanced form submission
function handleFormSubmission(e) {
    const form = e.target;
    if (!validateForm(form)) {
        e.preventDefault();
        return false;
    }
    
    // Add loading state with better animation
    const submitBtn = form.querySelector('button[type="submit"]');
    if (submitBtn) {
        const originalText = submitBtn.innerHTML;
        submitBtn.disabled = true;
        submitBtn.innerHTML = `
            <div class="loading-spinner-btn">
                <div class="spinner-small"></div>
                <span>Sending...</span>
            </div>
        `;
        
        // Reset after timeout if no response
        setTimeout(() => {
            if (submitBtn.disabled) {
                submitBtn.disabled = false;
                submitBtn.innerHTML = originalText;
            }
        }, 10000);
    }
}

// Field Validation
function validateField(e) {
    const field = e.target;
    const value = field.value.trim();
    
    // Remove existing error
    clearFieldError(e);
    
    if (field.hasAttribute('required') && !value) {
        showFieldError(field, 'This field is required');
        return false;
    }
    
    if (field.type === 'email' && value) {
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailRegex.test(value)) {
            showFieldError(field, 'Please enter a valid email address');
            return false;
        }
    }
    
    return true;
}

function clearFieldError(e) {
    const field = e.target;
    const errorEl = field.parentNode.querySelector('.field-error');
    if (errorEl) {
        errorEl.remove();
    }
    field.classList.remove('border-red-500');
    field.classList.add('border-gray-200');
}

function showFieldError(field, message) {
    field.classList.remove('border-gray-200');
    field.classList.add('border-red-500');
    
    const errorEl = document.createElement('p');
    errorEl.className = 'field-error text-red-500 text-sm mt-1';
    errorEl.textContent = message;
    field.parentNode.appendChild(errorEl);
}

function validateForm(form) {
    const inputs = form.querySelectorAll('input[required], textarea[required]');
    let isValid = true;
    
    inputs.forEach(input => {
        const event = { target: input };
        if (!validateField(event)) {
            isValid = false;
        }
    });
    
    return isValid;
}

// Enhanced smooth scrolling with custom easing
function initSmoothScrolling() {
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                smoothScrollTo(target, 1000);
            }
        });
    });
}

function smoothScrollTo(element, duration) {
    const targetPosition = element.offsetTop - 80; // Account for header
    const startPosition = window.pageYOffset;
    const distance = targetPosition - startPosition;
    let startTime = null;

    function animation(currentTime) {
        if (startTime === null) startTime = currentTime;
        const timeElapsed = currentTime - startTime;
        const run = easeInOutCubic(timeElapsed, startPosition, distance, duration);
        window.scrollTo(0, run);
        if (timeElapsed < duration) requestAnimationFrame(animation);
    }

    function easeInOutCubic(t, b, c, d) {
        t /= d/2;
        if (t < 1) return c/2*t*t*t + b;
        t -= 2;
        return c/2*(t*t*t + 2) + b;
    }

    requestAnimationFrame(animation);
}

// Enhanced auto-hide alerts
function autoHideAlerts() {
    const alerts = document.querySelectorAll('.alert, .bg-green-100, .bg-red-100');
    alerts.forEach((alert, index) => {
        // Add close button
        const closeBtn = document.createElement('button');
        closeBtn.innerHTML = '×';
        closeBtn.className = 'alert-close';
        closeBtn.onclick = () => hideAlert(alert);
        alert.appendChild(closeBtn);
        
        // Auto-hide with stagger
        setTimeout(() => {
            hideAlert(alert);
        }, 5000 + (index * 500));
    });
}

function hideAlert(alert) {
    alert.style.transform = 'translateX(100%)';
    alert.style.opacity = '0';
    setTimeout(() => {
        alert.remove();
    }, 300);
}

// Fixed animation system
function initAnimations() {
    // Create Intersection Observer with better options
    const observerOptions = {
        threshold: [0, 0.1, 0.25],
        rootMargin: '0px 0px -10% 0px'
    };
    
    const animationObserver = new IntersectionObserver(function(entries) {
        entries.forEach(entry => {
            if (entry.isIntersecting && entry.intersectionRatio > 0.1) {
                const target = entry.target;
                const animationType = target.dataset.animation || 'fadeInUp';
                const delay = target.dataset.delay || 0;
                
                setTimeout(() => {
                    target.classList.add('animate-' + animationType);
                    target.classList.add('animation-complete');
                }, delay);
                
                animationObserver.unobserve(target);
            }
        });
    }, observerOptions);
    
    // Observe elements with animation classes
    document.querySelectorAll('[data-animation], .service-card, .feature-card, section > div').forEach(el => {
        el.classList.add('animation-ready');
        animationObserver.observe(el);
    });
}

// Scroll effects for header
function initScrollEffects() {
    const header = document.querySelector('header');
    let lastScrollY = 0;
    
    function updateHeaderOnScroll() {
        const currentScrollY = window.pageYOffset;
        
        if (header) {
            if (currentScrollY > 100) {
                header.classList.add('scrolled');
            } else {
                header.classList.remove('scrolled');
            }
            
            // Hide/show header based on scroll direction
            if (currentScrollY > lastScrollY && currentScrollY > 200) {
                header.style.transform = 'translateY(-100%)';
            } else {
                header.style.transform = 'translateY(0)';
            }
        }
        
        lastScrollY = currentScrollY;
    }
    
    window.addEventListener('scroll', throttle(updateHeaderOnScroll, 16), { passive: true });
}

// Card hover effects
function initCardHoverEffects() {
    const cards = document.querySelectorAll('.service-card, .feature-card, .group');
    
    cards.forEach(card => {
        card.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-8px) scale(1.02)';
            this.style.boxShadow = '0 20px 40px rgba(0, 0, 0, 0.1)';
        });
        
        card.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0) scale(1)';
            this.style.boxShadow = '0 4px 6px rgba(0, 0, 0, 0.05)';
        });
    });
}

// Typing animation for hero text
function initTypingAnimation() {
    const typingElements = document.querySelectorAll('[data-typing]');
    
    typingElements.forEach(element => {
        const text = element.textContent;
        const speed = parseInt(element.dataset.speed) || 50;
        element.textContent = '';
        element.style.borderRight = '2px solid';
        element.style.animation = 'blink 1s infinite';
        
        typeText(element, text, speed);
    });
}

function typeText(element, text, speed) {
    let i = 0;
    const timer = setInterval(() => {
        element.textContent += text.charAt(i);
        i++;
        if (i > text.length - 1) {
            clearInterval(timer);
            setTimeout(() => {
                element.style.borderRight = 'none';
                element.style.animation = 'none';
            }, 1000);
        }
    }, speed);
}

// Handle resize events
function handleResize() {
    // Recalculate parallax positions
    const parallaxElements = document.querySelectorAll('[data-parallax]');
    parallaxElements.forEach(element => {
        element.style.transform = 'translate3d(0, 0, 0)';
    });
}

// Enhanced scroll effects
function handleScrollEffects() {
    const scrollY = window.pageYOffset;
    const header = document.querySelector('header');
    
    // Header background opacity
    if (header) {
        const opacity = Math.min(scrollY / 100, 1);
        header.style.backgroundColor = `rgba(255, 255, 255, ${0.9 + opacity * 0.1})`;
    }
}

// Add enhanced CSS styles
const enhancedStyles = document.createElement('style');
enhancedStyles.textContent = `
    /* Loading overlay */
    .loading-overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100vw;
        height: 100vh;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 10000;
        transition: opacity 0.5s ease;
    }
    
    .loading-spinner {
        text-align: center;
        color: white;
    }
    
    .spinner-ring {
        width: 50px;
        height: 50px;
        border: 3px solid rgba(255, 255, 255, 0.3);
        border-top: 3px solid white;
        border-radius: 50%;
        animation: spin 1s linear infinite;
        margin: 0 auto 20px;
    }
    
    .loading-text {
        font-size: 18px;
        font-weight: 500;
        opacity: 0.9;
    }
    
    /* Enhanced animations */
    .animation-ready {
        opacity: 0;
        transform: translateY(30px);
        transition: all 0.8s cubic-bezier(0.25, 0.46, 0.45, 0.94);
    }
    
    .animate-fadeInUp {
        opacity: 1 !important;
        transform: translateY(0) !important;
    }
    
    .animate-fadeInLeft {
        opacity: 1 !important;
        transform: translateX(0) !important;
    }
    
    .animate-fadeInRight {
        opacity: 1 !important;
        transform: translateX(0) !important;
    }
    
    /* Ripple effect */
    .ripple-effect {
        position: absolute;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.6);
        transform: scale(0);
        animation: ripple 0.6s linear;
        pointer-events: none;
    }
    
    @keyframes ripple {
        to {
            transform: scale(4);
            opacity: 0;
        }
    }
    
    /* Floating labels */
    .floating-label-wrapper {
        position: relative;
        margin-bottom: 1.5rem;
    }
    
    .floating-label {
        position: absolute;
        left: 0.75rem;
        top: 0.75rem;
        color: #9CA3AF;
        transition: all 0.3s ease;
        pointer-events: none;
        background: white;
        padding: 0 0.25rem;
        z-index: 1;
    }
    
    .floating-label-wrapper.focused .floating-label,
    .floating-label-wrapper.has-value .floating-label {
        top: -0.5rem;
        left: 0.5rem;
        font-size: 0.75rem;
        color: #3B82F6;
        font-weight: 500;
    }
    
    /* Enhanced header */
    header {
        transition: all 0.3s cubic-bezier(0.25, 0.46, 0.45, 0.94);
    }
    
    header.scrolled {
        backdrop-filter: blur(20px);
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
    }
    
    /* Loading spinner for buttons */
    .loading-spinner-btn {
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    
    .spinner-small {
        width: 16px;
        height: 16px;
        border: 2px solid rgba(255, 255, 255, 0.3);
        border-top: 2px solid white;
        border-radius: 50%;
        animation: spin 1s linear infinite;
    }
    
    /* Lazy loading images */
    img.lazy {
        opacity: 0;
        transition: opacity 0.5s ease;
    }
    
    img.loaded {
        opacity: 1;
    }
    
    /* Alert close button */
    .alert-close {
        position: absolute;
        top: 0.5rem;
        right: 0.5rem;
        background: none;
        border: none;
        font-size: 1.25rem;
        color: #6B7280;
        cursor: pointer;
        padding: 0.25rem;
        line-height: 1;
    }
    
    /* Mobile nav improvements */
    .mobile-nav-menu {
        transition: all 0.3s cubic-bezier(0.25, 0.46, 0.45, 0.94);
        opacity: 0;
        transform: translateY(-20px);
    }
    
    /* Typing animation */
    @keyframes blink {
        0%, 50% { border-color: transparent; }
        51%, 100% { border-color: currentColor; }
    }
    
    /* Smooth transitions for all interactive elements */
    button, .btn, a, .group {
        transition: all 0.3s cubic-bezier(0.25, 0.46, 0.45, 0.94);
    }
    
    /* Performance optimizations */
    * {
        -webkit-font-smoothing: antialiased;
        -moz-osx-font-smoothing: grayscale;
    }
    
    img {
        image-rendering: optimizeQuality;
    }
`;

document.head.appendChild(enhancedStyles);