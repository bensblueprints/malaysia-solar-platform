/**
 * Malaysia Solar Platform - Main JavaScript
 */

(function() {
    'use strict';

    const app = {
        init: function() {
            this.headerScroll();
            this.mobileMenu();
            this.smoothScroll();
            this.animateOnScroll();
            this.formValidation();
        },

        // Header scroll effect
        headerScroll: function() {
            const header = document.getElementById('site-header');
            if (!header) return;

            let lastScroll = 0;

            window.addEventListener('scroll', () => {
                const currentScroll = window.pageYOffset;

                if (currentScroll > 50) {
                    header.classList.add('scrolled');
                } else {
                    header.classList.remove('scrolled');
                }

                lastScroll = currentScroll;
            });
        },

        // Mobile menu toggle
        mobileMenu: function() {
            const toggle = document.getElementById('menu-toggle');
            const nav = document.getElementById('main-navigation');

            if (!toggle || !nav) return;

            toggle.addEventListener('click', () => {
                nav.classList.toggle('active');
                toggle.classList.toggle('active');

                // Animate hamburger
                const spans = toggle.querySelectorAll('span');
                if (toggle.classList.contains('active')) {
                    spans[0].style.transform = 'rotate(45deg) translate(5px, 5px)';
                    spans[1].style.opacity = '0';
                    spans[2].style.transform = 'rotate(-45deg) translate(5px, -5px)';
                } else {
                    spans[0].style.transform = '';
                    spans[1].style.opacity = '';
                    spans[2].style.transform = '';
                }
            });

            // Close menu on link click
            nav.querySelectorAll('a').forEach(link => {
                link.addEventListener('click', () => {
                    nav.classList.remove('active');
                    toggle.classList.remove('active');
                });
            });
        },

        // Smooth scroll for anchor links
        smoothScroll: function() {
            document.querySelectorAll('a[href^="#"]').forEach(anchor => {
                anchor.addEventListener('click', function(e) {
                    const href = this.getAttribute('href');
                    if (href === '#') return;

                    const target = document.querySelector(href);
                    if (target) {
                        e.preventDefault();
                        const headerHeight = document.getElementById('site-header')?.offsetHeight || 80;
                        const targetPosition = target.getBoundingClientRect().top + window.pageYOffset - headerHeight;

                        window.scrollTo({
                            top: targetPosition,
                            behavior: 'smooth'
                        });
                    }
                });
            });
        },

        // Animate elements on scroll
        animateOnScroll: function() {
            const animatedElements = document.querySelectorAll(
                '.feature-card, .product-card, .testimonial-card, .program-card, .card'
            );

            if (!animatedElements.length) return;

            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.style.opacity = '1';
                        entry.target.style.transform = 'translateY(0)';
                        observer.unobserve(entry.target);
                    }
                });
            }, {
                threshold: 0.1,
                rootMargin: '0px 0px -50px 0px'
            });

            animatedElements.forEach(el => {
                el.style.opacity = '0';
                el.style.transform = 'translateY(30px)';
                el.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
                observer.observe(el);
            });
        },

        // Form validation
        formValidation: function() {
            const forms = document.querySelectorAll('form');

            forms.forEach(form => {
                form.addEventListener('submit', function(e) {
                    let isValid = true;
                    const requiredFields = this.querySelectorAll('[required]');

                    requiredFields.forEach(field => {
                        if (!field.value.trim()) {
                            isValid = false;
                            field.classList.add('error');
                            field.style.borderColor = '#E74C3C';
                        } else {
                            field.classList.remove('error');
                            field.style.borderColor = '';
                        }
                    });

                    // Email validation
                    const emailFields = this.querySelectorAll('input[type="email"]');
                    emailFields.forEach(field => {
                        if (field.value && !this.isValidEmail(field.value)) {
                            isValid = false;
                            field.classList.add('error');
                            field.style.borderColor = '#E74C3C';
                        }
                    });

                    if (!isValid) {
                        e.preventDefault();
                        const firstError = this.querySelector('.error');
                        if (firstError) {
                            firstError.focus();
                        }
                    }
                }.bind({
                    isValidEmail: function(email) {
                        return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email);
                    }
                }));

                // Clear error on input
                form.querySelectorAll('input, textarea, select').forEach(field => {
                    field.addEventListener('input', function() {
                        this.classList.remove('error');
                        this.style.borderColor = '';
                    });
                });
            });
        }
    };

    // Counter animation for statistics
    function animateCounters() {
        const counters = document.querySelectorAll('.hero-stat-value, .stat-box .value');

        counters.forEach(counter => {
            const target = counter.textContent;
            const numMatch = target.match(/[\d,]+/);
            if (!numMatch) return;

            const targetNum = parseInt(numMatch[0].replace(/,/g, ''));
            const prefix = target.substring(0, target.indexOf(numMatch[0]));
            const suffix = target.substring(target.indexOf(numMatch[0]) + numMatch[0].length);
            const duration = 2000;
            const increment = targetNum / (duration / 16);
            let current = 0;

            const updateCounter = () => {
                current += increment;
                if (current < targetNum) {
                    counter.textContent = prefix + Math.floor(current).toLocaleString() + suffix;
                    requestAnimationFrame(updateCounter);
                } else {
                    counter.textContent = target;
                }
            };

            // Trigger on scroll into view
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        updateCounter();
                        observer.unobserve(entry.target);
                    }
                });
            }, { threshold: 0.5 });

            observer.observe(counter);
        });
    }

    // Initialize
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', () => {
            app.init();
            animateCounters();
        });
    } else {
        app.init();
        animateCounters();
    }
})();
