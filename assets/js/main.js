/**
 * Malaysia Solar Platform - Main JavaScript
 * Handles all site interactions, calculator, animations, and chatbot
 */

(function() {
    'use strict';

    // ============================================
    // CONFIGURATION
    // ============================================
    const SYSTEM_CONFIGS = {
        3: { price: 15000, panels: 7, savingsPercent: 0.65 },
        5: { price: 22000, panels: 12, savingsPercent: 0.75 },
        7: { price: 30000, panels: 16, savingsPercent: 0.80 },
        10: { price: 40000, panels: 24, savingsPercent: 0.85 }
    };

    const CHATBOT_RESPONSES = {
        'how much can i save': {
            text: "Your savings depend on your current electricity bill! Generally, solar can reduce your TNB bill by 65-85%. For a RM500 monthly bill, you could save around RM375-425 per month. Try our calculator to get an exact estimate!"
        },
        'what is nem 3.0': {
            text: "NEM 3.0 (Net Energy Metering) is a government program that lets you sell excess solar energy back to TNB at a 1:1 offset ratio. This means every kWh you export reduces your bill by the same amount. It's valid for 25 years from your application date!"
        },
        'installation process': {
            text: "Our installation process is simple:\n\n1️⃣ Site Assessment (1-2 days)\n2️⃣ Custom Design & Proposal\n3️⃣ NEM Application (2-4 weeks)\n4️⃣ Installation (1-2 days)\n5️⃣ TNB Meter Swap\n6️⃣ Start Saving!\n\nMost installations are completed within 6-8 weeks from signing."
        },
        'warranty': {
            text: "All our systems come with comprehensive warranties:\n\n✅ 25-year panel performance warranty\n✅ 10-year inverter warranty\n✅ 5-year workmanship guarantee\n✅ 5-year free maintenance\n\nWe also provide ongoing support and monitoring through our app."
        },
        'financing': {
            text: "We offer multiple financing options:\n\n💰 Cash Purchase: Best value, own immediately\n📊 Bank Financing: Low interest rates, own from day 1\n🏠 Lease-to-Own: Zero upfront, pay from savings\n\nOur lease option means you start saving immediately with no initial investment!"
        },
        'default': {
            text: "Thanks for your question! I'd recommend speaking with our solar consultants for detailed information. Would you like to:\n\n1. Get a free quote\n2. Schedule a call\n3. Chat on WhatsApp\n\nOr ask me about savings, NEM 3.0, installation, warranty, or financing!"
        }
    };

    // ============================================
    // DOM READY
    // ============================================
    document.addEventListener('DOMContentLoaded', function() {
        initHeader();
        initMobileMenu();
        initAnimations();
        initCalculator();
        initChatbot();
        initCountUp();
    });

    // ============================================
    // HEADER SCROLL EFFECT
    // ============================================
    function initHeader() {
        const header = document.getElementById('header');
        if (!header) return;

        let lastScroll = 0;

        window.addEventListener('scroll', function() {
            const currentScroll = window.pageYOffset;

            if (currentScroll > 50) {
                header.classList.add('scrolled');
            } else {
                header.classList.remove('scrolled');
            }

            lastScroll = currentScroll;
        });
    }

    // ============================================
    // MOBILE MENU
    // ============================================
    function initMobileMenu() {
        const toggle = document.getElementById('menu-toggle');
        const nav = document.getElementById('main-nav');

        if (!toggle || !nav) return;

        toggle.addEventListener('click', function() {
            nav.classList.toggle('active');
            toggle.classList.toggle('active');
        });

        // Close menu on link click
        nav.querySelectorAll('a').forEach(link => {
            link.addEventListener('click', function() {
                nav.classList.remove('active');
                toggle.classList.remove('active');
            });
        });
    }

    // ============================================
    // SCROLL ANIMATIONS (AOS-like)
    // ============================================
    function initAnimations() {
        const animatedElements = document.querySelectorAll('[data-aos]');

        if (!animatedElements.length) return;

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const delay = entry.target.dataset.aosDelay || 0;
                    setTimeout(() => {
                        entry.target.classList.add('aos-animate');
                    }, delay);
                }
            });
        }, {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        });

        animatedElements.forEach(el => observer.observe(el));
    }

    // ============================================
    // COUNT UP ANIMATION
    // ============================================
    function initCountUp() {
        const counters = document.querySelectorAll('[data-count]');

        if (!counters.length) return;

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const target = parseInt(entry.target.dataset.count);
                    animateCount(entry.target, target);
                    observer.unobserve(entry.target);
                }
            });
        }, { threshold: 0.5 });

        counters.forEach(counter => observer.observe(counter));
    }

    function animateCount(element, target) {
        const duration = 2000;
        const start = 0;
        const startTime = performance.now();

        function update(currentTime) {
            const elapsed = currentTime - startTime;
            const progress = Math.min(elapsed / duration, 1);

            // Easing function
            const easeOut = 1 - Math.pow(1 - progress, 3);
            const current = Math.floor(start + (target - start) * easeOut);

            element.textContent = current.toLocaleString();

            if (progress < 1) {
                requestAnimationFrame(update);
            } else {
                element.textContent = target.toLocaleString();
            }
        }

        requestAnimationFrame(update);
    }

    // ============================================
    // SOLAR CALCULATOR
    // ============================================
    function initCalculator() {
        const calcInput = document.getElementById('calc-bill');
        if (!calcInput) return;

        // Initial calculation
        updateCalculation(parseFloat(calcInput.value) || 500);

        // Listen for input
        calcInput.addEventListener('input', function() {
            const bill = parseFloat(this.value) || 0;
            updateCalculation(bill);
        });
    }

    function updateCalculation(bill) {
        // Determine system size
        let systemSize;
        if (bill < 300) {
            systemSize = 3;
        } else if (bill < 500) {
            systemSize = 5;
        } else if (bill < 800) {
            systemSize = 7;
        } else {
            systemSize = 10;
        }

        const config = SYSTEM_CONFIGS[systemSize];
        const monthlySavings = bill * config.savingsPercent;
        const yearlySavings = monthlySavings * 12;
        const roiYears = config.price / yearlySavings;
        const savings25yr = yearlySavings * 25;

        // Update DOM
        const savingsEl = document.getElementById('calc-savings');
        const systemEl = document.getElementById('calc-system');
        const roiEl = document.getElementById('calc-roi');
        const savings25yrEl = document.getElementById('calc-25yr');
        const barEl = document.getElementById('calc-bar');

        if (savingsEl) savingsEl.textContent = `RM ${Math.round(monthlySavings).toLocaleString()}`;
        if (systemEl) systemEl.textContent = `${systemSize}kW`;
        if (roiEl) roiEl.textContent = `${roiYears.toFixed(1)} yrs`;
        if (savings25yrEl) savings25yrEl.textContent = `RM ${Math.round(savings25yr).toLocaleString()}`;

        // Update progress bar (max 200k for visual)
        if (barEl) {
            const barPercent = Math.min((savings25yr / 200000) * 100, 100);
            barEl.style.width = `${barPercent}%`;
        }
    }

    // ============================================
    // CHATBOT
    // ============================================
    function initChatbot() {
        const chatbot = document.getElementById('chatbot');
        const toggle = document.getElementById('chatbot-toggle');
        const closeBtn = document.getElementById('chatbot-close');
        const input = document.getElementById('chatbot-input');
        const sendBtn = document.getElementById('chatbot-send');
        const messagesContainer = document.getElementById('chatbot-messages');
        const suggestionBtns = document.querySelectorAll('.suggestion-btn');

        if (!chatbot || !toggle) return;

        // Toggle chatbot
        toggle.addEventListener('click', function() {
            chatbot.classList.toggle('active');
        });

        if (closeBtn) {
            closeBtn.addEventListener('click', function() {
                chatbot.classList.remove('active');
            });
        }

        // Send message
        function sendMessage() {
            const message = input.value.trim();
            if (!message) return;

            // Add user message
            addMessage(message, 'user');
            input.value = '';

            // Get bot response
            setTimeout(() => {
                const response = getBotResponse(message);
                addMessage(response, 'bot');
            }, 800);
        }

        if (sendBtn) {
            sendBtn.addEventListener('click', sendMessage);
        }

        if (input) {
            input.addEventListener('keypress', function(e) {
                if (e.key === 'Enter') {
                    sendMessage();
                }
            });
        }

        // Suggestion buttons
        suggestionBtns.forEach(btn => {
            btn.addEventListener('click', function() {
                const message = this.dataset.message;
                addMessage(message, 'user');

                // Remove suggestions after use
                const suggestionsContainer = this.parentElement;
                if (suggestionsContainer) {
                    suggestionsContainer.style.display = 'none';
                }

                // Get bot response
                setTimeout(() => {
                    const response = getBotResponse(message);
                    addMessage(response, 'bot');
                }, 800);
            });
        });

        function addMessage(text, type) {
            const messageEl = document.createElement('div');
            messageEl.className = `chat-message ${type}`;
            messageEl.innerHTML = `<p>${text.replace(/\n/g, '<br>')}</p>`;
            messagesContainer.appendChild(messageEl);
            messagesContainer.scrollTop = messagesContainer.scrollHeight;
        }

        function getBotResponse(message) {
            const lowerMessage = message.toLowerCase();

            // Check for keywords
            for (const [key, value] of Object.entries(CHATBOT_RESPONSES)) {
                if (key !== 'default' && lowerMessage.includes(key)) {
                    return value.text;
                }
            }

            // Check additional keywords
            if (lowerMessage.includes('save') || lowerMessage.includes('saving')) {
                return CHATBOT_RESPONSES['how much can i save'].text;
            }
            if (lowerMessage.includes('nem') || lowerMessage.includes('metering')) {
                return CHATBOT_RESPONSES['what is nem 3.0'].text;
            }
            if (lowerMessage.includes('install') || lowerMessage.includes('process') || lowerMessage.includes('how long')) {
                return CHATBOT_RESPONSES['installation process'].text;
            }
            if (lowerMessage.includes('warranty') || lowerMessage.includes('guarantee')) {
                return CHATBOT_RESPONSES['warranty'].text;
            }
            if (lowerMessage.includes('finance') || lowerMessage.includes('loan') || lowerMessage.includes('lease') || lowerMessage.includes('pay')) {
                return CHATBOT_RESPONSES['financing'].text;
            }
            if (lowerMessage.includes('price') || lowerMessage.includes('cost') || lowerMessage.includes('how much')) {
                return "Our systems start from RM15,000 for a 3kW system up to RM40,000 for a 10kW system. Use our calculator to see which system fits your needs and the exact savings you'll enjoy!";
            }
            if (lowerMessage.includes('hello') || lowerMessage.includes('hi') || lowerMessage.includes('hey')) {
                return "Hello! 👋 Welcome to Malaysia Solar. How can I help you today? I can tell you about savings, installation, warranty, financing, or help you get started with a free quote!";
            }
            if (lowerMessage.includes('quote') || lowerMessage.includes('start')) {
                return "Great choice! To get your personalized solar quote, click the 'Get Free Quote' button above or visit our calculator page. It only takes 3 minutes to see how much you could save!";
            }

            return CHATBOT_RESPONSES['default'].text;
        }
    }

    // ============================================
    // SMOOTH SCROLL
    // ============================================
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function(e) {
            const href = this.getAttribute('href');
            if (href === '#') return;

            const target = document.querySelector(href);
            if (target) {
                e.preventDefault();
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });

})();

// ============================================
// GLOBAL FUNCTIONS FOR QUOTE WIZARD
// ============================================
window.SYSTEM_CONFIGS = {
    3: { price: 15000, panels: 7, savingsPercent: 0.65 },
    5: { price: 22000, panels: 12, savingsPercent: 0.75 },
    7: { price: 30000, panels: 16, savingsPercent: 0.80 },
    10: { price: 40000, panels: 24, savingsPercent: 0.85 }
};
