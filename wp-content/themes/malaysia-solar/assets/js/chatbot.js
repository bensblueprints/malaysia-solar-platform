/**
 * Solar Assistant Chatbot
 * RAG-powered knowledge base chatbot for solar energy questions
 */

(function() {
    'use strict';

    const chatbot = {
        isOpen: false,
        messages: [],

        // Knowledge base for common questions
        knowledgeBase: {
            patterns: [
                {
                    keywords: ['nem', 'net energy', 'metering'],
                    response: 'NEM (Net Energy Metering) is a government program that allows you to sell excess solar energy back to TNB. Under NEM 3.0, you can offset your electricity bill at a 1:1 ratio for the energy you export. This means every kWh you generate can offset your consumption!'
                },
                {
                    keywords: ['solaris', 'solar industry', 'scheme'],
                    response: 'SolaRIS (Solar Renewable Industry Scheme) is a government initiative to promote solar energy adoption in Malaysia. It offers green technology tax incentives, preferential financing rates, and a fast-track approval process for solar installations.'
                },
                {
                    keywords: ['price', 'cost', 'how much', 'expensive'],
                    response: 'Our solar system prices:\n• 3kW System: RM 15,000 (ideal for small homes)\n• 5kW System: RM 22,000 (most popular)\n• 7kW System: RM 30,000 (medium homes)\n• 10kW System: RM 40,000 (large homes)\n\nThese include premium panels, inverter, installation, NEM application, and warranties. Would you like a personalized quote?'
                },
                {
                    keywords: ['warranty', 'guarantee'],
                    response: 'We offer comprehensive warranties:\n• Solar Panels: 25-year performance warranty\n• Inverter: 10-year manufacturer warranty\n• Workmanship: 5-year installation warranty\n• Free Maintenance: 5 years included\n\nOur Tier-1 panels maintain at least 80% efficiency even after 25 years!'
                },
                {
                    keywords: ['installation', 'install', 'how long', 'duration'],
                    response: 'Installation is quick and hassle-free:\n• Site Survey: 1-2 hours\n• Installation: 1-2 days for residential\n• TNB Inspection: 1-2 weeks after install\n• NEM Approval: 2-4 weeks\n\nOur certified technicians handle everything from mounting to grid connection. You don\'t need to be home during installation!'
                },
                {
                    keywords: ['savings', 'save', 'reduce', 'bill'],
                    response: 'Most homeowners save 50-80% on their monthly electricity bills! Here\'s what you can expect:\n• RM 300 bill → Save RM 180-240/month\n• RM 500 bill → Save RM 350-400/month\n• RM 800 bill → Save RM 560-640/month\n\nWith NEM 3.0, excess energy is credited at 1:1 ratio. Try our calculator for a personalized estimate!'
                },
                {
                    keywords: ['financing', 'loan', 'payment', 'installment'],
                    response: 'We offer flexible payment options:\n• Full Payment: Best value, immediate ownership\n• Bank Financing: 6-60 month installments via partner banks\n• Lease-to-Own: Zero upfront cost, pay from savings\n\nThe Lease-to-Own option is great if you want to start saving immediately with no initial investment!'
                },
                {
                    keywords: ['lease', 'zero upfront', 'no cost'],
                    response: 'Our Lease-to-Own program lets you go solar with ZERO upfront cost! Here\'s how it works:\n• No deposit required\n• Fixed monthly payments (usually less than your current bill)\n• System ownership after 10-15 years\n• Maintenance included during lease period\n\nYou start saving from day one! Would you like to check your eligibility?'
                },
                {
                    keywords: ['maintenance', 'cleaning', 'maintain'],
                    response: 'Solar panels require minimal maintenance:\n• Cleaning: 2-3 times per year (rain helps too!)\n• Inspection: Annual checkup recommended\n• No moving parts = minimal wear and tear\n\nWe include 5 years of free maintenance with every installation. Our monitoring app alerts you to any performance issues.'
                },
                {
                    keywords: ['roi', 'payback', 'return', 'investment'],
                    response: 'Solar is one of the best investments for your home:\n• Average ROI: 15-20% annually\n• Payback Period: 4-6 years typically\n• 25-Year Returns: 4-5x your investment\n\nAfter payback, you enjoy essentially FREE electricity for 20+ years! Property value also increases by 3-4%.'
                },
                {
                    keywords: ['suitable', 'roof', 'good for'],
                    response: 'Your home is likely suitable for solar if:\n• Roof faces South, East, or West\n• Minimal shading from trees/buildings\n• Roof age: less than 20 years\n• Roof area: at least 20 sqm available\n\nWe offer free site assessments to determine your solar potential. Even partially shaded roofs can work with modern panel technology!'
                },
                {
                    keywords: ['blackout', 'power cut', 'backup'],
                    response: 'Standard solar systems (grid-tied) don\'t work during blackouts for safety reasons. However, we offer:\n• Hybrid Inverters: Switch to battery backup during outages\n• Battery Storage: Store excess energy for nighttime/emergencies\n• The good news: With NEM, you rarely need backup as you\'re always connected to the grid!'
                },
                {
                    keywords: ['tnb', 'tenaga', 'approval'],
                    response: 'We handle all TNB paperwork for you:\n1. NEM Application submission\n2. TNB meter inspection scheduling\n3. Bidirectional meter installation\n4. System commissioning\n\nTypical timeline: 2-4 weeks for full approval. You don\'t need to visit any TNB office!'
                },
                {
                    keywords: ['rain', 'cloudy', 'weather'],
                    response: 'Solar panels work in all Malaysian weather conditions:\n• Cloudy days: 10-25% of peak output\n• Rainy days: 10-15% output (rain also cleans panels!)\n• Haze: Slightly reduced output\n\nMalaysia\'s tropical climate is actually ideal - we get 4-5 peak sun hours daily. Our calculations account for weather variations!'
                },
                {
                    keywords: ['brand', 'panel', 'quality', 'tier'],
                    response: 'We only use Tier-1 certified panels:\n• Brands: LONGi, JA Solar, Trina, Canadian Solar\n• Efficiency: 20-22%+\n• All panels are monocrystalline PERC technology\n• Inverters: Huawei, Solis, Growatt (all Tier-1)\n\nTier-1 certification means top-quality manufacturing and proven reliability.'
                },
                {
                    keywords: ['hello', 'hi', 'hey', 'good morning', 'good afternoon'],
                    response: 'Hello! Welcome to Malaysia Solar. I\'m your Solar Assistant, ready to help you learn about solar energy and start your savings journey. What would you like to know? You can ask about pricing, NEM programs, installation, or anything else!'
                },
                {
                    keywords: ['thank', 'thanks'],
                    response: 'You\'re welcome! If you have any more questions, feel free to ask. When you\'re ready, you can get a personalized quote using our calculator, or chat with our team directly via WhatsApp. We\'re here to help you go solar! ☀️'
                },
                {
                    keywords: ['contact', 'call', 'phone', 'whatsapp', 'speak'],
                    response: 'You can reach us through:\n• WhatsApp: Click the green button to chat\n• Phone: +60 12-345 6789\n• Email: info@malaysiasolar.com\n• Office Hours: Mon-Sat, 9am-6pm\n\nOur solar consultants are happy to answer any questions or schedule a free site visit!'
                }
            ],

            defaultResponse: "I appreciate your question! While I don't have specific information about that, our solar experts can help. You can:\n\n• Try our free Quote Calculator for personalized recommendations\n• WhatsApp us for immediate assistance\n• Call us at +60 12-345 6789\n\nIs there anything else I can help you with regarding solar panels, pricing, or the installation process?"
        },

        init: function() {
            this.cacheElements();
            this.bindEvents();
            this.loadMessages();
        },

        cacheElements: function() {
            this.widget = document.getElementById('chatbot-widget');
            this.toggle = document.getElementById('chatbot-toggle');
            this.window = document.getElementById('chatbot-window');
            this.close = document.getElementById('chatbot-close');
            this.messagesContainer = document.getElementById('chatbot-messages');
            this.input = document.getElementById('chatbot-input');
            this.sendBtn = document.getElementById('chatbot-send');
        },

        bindEvents: function() {
            if (this.toggle) {
                this.toggle.addEventListener('click', () => this.toggleChat());
            }
            if (this.close) {
                this.close.addEventListener('click', () => this.closeChat());
            }
            if (this.sendBtn) {
                this.sendBtn.addEventListener('click', () => this.sendMessage());
            }
            if (this.input) {
                this.input.addEventListener('keypress', (e) => {
                    if (e.key === 'Enter') {
                        this.sendMessage();
                    }
                });
            }
        },

        toggleChat: function() {
            this.isOpen = !this.isOpen;
            if (this.window) {
                this.window.classList.toggle('active', this.isOpen);
            }
            if (this.isOpen && this.input) {
                setTimeout(() => this.input.focus(), 300);
            }
        },

        closeChat: function() {
            this.isOpen = false;
            if (this.window) {
                this.window.classList.remove('active');
            }
        },

        sendMessage: function() {
            const message = this.input.value.trim();
            if (!message) return;

            // Add user message
            this.addMessage(message, 'user');
            this.input.value = '';

            // Show typing indicator
            this.showTyping();

            // Get response (with slight delay for natural feel)
            setTimeout(() => {
                this.hideTyping();
                const response = this.getResponse(message);
                this.addMessage(response, 'bot');

                // Send to server for logging
                this.logMessage(message, response);
            }, 800 + Math.random() * 700);
        },

        addMessage: function(text, type) {
            const messageDiv = document.createElement('div');
            messageDiv.className = `chat-message ${type}`;
            messageDiv.innerHTML = this.formatMessage(text);

            if (this.messagesContainer) {
                this.messagesContainer.appendChild(messageDiv);
                this.messagesContainer.scrollTop = this.messagesContainer.scrollHeight;
            }

            // Save message
            this.messages.push({ text, type, timestamp: Date.now() });
            this.saveMessages();
        },

        formatMessage: function(text) {
            // Convert newlines to breaks
            text = text.replace(/\n/g, '<br>');
            // Convert bullet points
            text = text.replace(/• /g, '&bull; ');
            return text;
        },

        showTyping: function() {
            const typingDiv = document.createElement('div');
            typingDiv.className = 'chat-message bot typing';
            typingDiv.id = 'typing-indicator';
            typingDiv.innerHTML = '<span class="dot"></span><span class="dot"></span><span class="dot"></span>';

            // Add typing styles
            typingDiv.style.cssText = `
                display: flex;
                gap: 4px;
                padding: 16px;
            `;

            const dots = typingDiv.querySelectorAll('.dot');
            dots.forEach((dot, i) => {
                dot.style.cssText = `
                    width: 8px;
                    height: 8px;
                    background: var(--medium-gray);
                    border-radius: 50%;
                    animation: bounce 1.4s infinite ease-in-out;
                    animation-delay: ${i * 0.16}s;
                `;
            });

            if (this.messagesContainer) {
                this.messagesContainer.appendChild(typingDiv);
                this.messagesContainer.scrollTop = this.messagesContainer.scrollHeight;
            }
        },

        hideTyping: function() {
            const typing = document.getElementById('typing-indicator');
            if (typing) {
                typing.remove();
            }
        },

        getResponse: function(message) {
            const lowerMessage = message.toLowerCase();

            // Check knowledge base patterns
            for (const pattern of this.knowledgeBase.patterns) {
                const matches = pattern.keywords.some(keyword =>
                    lowerMessage.includes(keyword)
                );
                if (matches) {
                    return pattern.response;
                }
            }

            return this.knowledgeBase.defaultResponse;
        },

        logMessage: function(userMessage, botResponse) {
            if (typeof solarChatbot === 'undefined') return;

            const data = new FormData();
            data.append('action', 'chatbot_response');
            data.append('nonce', solarChatbot.nonce);
            data.append('message', userMessage);

            fetch(solarChatbot.ajaxUrl, {
                method: 'POST',
                body: data
            }).catch(() => {
                // Silent fail for logging
            });
        },

        saveMessages: function() {
            try {
                const recentMessages = this.messages.slice(-20);
                sessionStorage.setItem('chatbot_messages', JSON.stringify(recentMessages));
            } catch (e) {
                // Storage not available
            }
        },

        loadMessages: function() {
            try {
                const saved = sessionStorage.getItem('chatbot_messages');
                if (saved) {
                    this.messages = JSON.parse(saved);
                    // Only restore messages from current session
                    const oneHourAgo = Date.now() - (60 * 60 * 1000);
                    this.messages = this.messages.filter(m => m.timestamp > oneHourAgo);
                }
            } catch (e) {
                // Storage not available
            }
        }
    };

    // Add animation keyframes
    const style = document.createElement('style');
    style.textContent = `
        @keyframes bounce {
            0%, 80%, 100% { transform: scale(0); }
            40% { transform: scale(1); }
        }
    `;
    document.head.appendChild(style);

    // Initialize on DOM ready
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', () => chatbot.init());
    } else {
        chatbot.init();
    }
})();
