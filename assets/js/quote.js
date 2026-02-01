/**
 * Quote Wizard - Malaysia Solar Platform
 * Handles multi-step form, calculations, and submissions
 */

(function() {
    'use strict';

    // State
    const state = {
        currentStep: 1,
        formData: {},
        calculatedResults: {},
        selectedOption: null
    };

    // System configurations
    const SYSTEM_CONFIGS = window.SYSTEM_CONFIGS || {
        3: { price: 15000, panels: 7, savingsPercent: 0.65 },
        5: { price: 22000, panels: 12, savingsPercent: 0.75 },
        7: { price: 30000, panels: 16, savingsPercent: 0.80 },
        10: { price: 40000, panels: 24, savingsPercent: 0.85 }
    };

    // Initialize on DOM ready
    document.addEventListener('DOMContentLoaded', function() {
        initWizard();
        initRoofSizeSelector();
        checkUrlParams();
    });

    // Initialize wizard
    function initWizard() {
        // Get URL params for pre-selected system
        const urlParams = new URLSearchParams(window.location.search);
        const preselectedSystem = urlParams.get('system');

        if (preselectedSystem) {
            // Could pre-fill bill amount based on system
            const billInput = document.getElementById('input-tnb-bill');
            if (billInput) {
                const systemSizes = { 3: 250, 5: 400, 7: 600, 10: 900 };
                billInput.value = systemSizes[preselectedSystem] || 500;
            }
        }
    }

    // Initialize roof size selector
    function initRoofSizeSelector() {
        const sizeBtns = document.querySelectorAll('.size-btn');
        const hiddenInput = document.getElementById('roof-size');

        sizeBtns.forEach(btn => {
            btn.addEventListener('click', function() {
                sizeBtns.forEach(b => b.classList.remove('active'));
                this.classList.add('active');
                if (hiddenInput) {
                    hiddenInput.value = this.dataset.size;
                }
            });
        });
    }

    // Check URL parameters
    function checkUrlParams() {
        const urlParams = new URLSearchParams(window.location.search);
        const system = urlParams.get('system');

        if (system && SYSTEM_CONFIGS[system]) {
            // Pre-fill based on system size
            const estimatedBills = { 3: 250, 5: 450, 7: 650, 10: 900 };
            const billInput = document.getElementById('input-tnb-bill');
            if (billInput) {
                billInput.value = estimatedBills[system] || 500;
            }
        }
    }

    // Navigate to next step
    window.nextStep = function(step) {
        if (!validateCurrentStep()) {
            return;
        }

        collectFormData();
        showStep(step);
    };

    // Navigate to previous step
    window.prevStep = function(step) {
        showStep(step);
    };

    // Show specific step
    function showStep(step) {
        state.currentStep = step;

        // Update progress indicators
        document.querySelectorAll('.wizard-step').forEach((el, index) => {
            el.classList.remove('active', 'completed');
            if (index + 1 < step) {
                el.classList.add('completed');
            } else if (index + 1 === step) {
                el.classList.add('active');
            }
        });

        // Show/hide panels
        document.querySelectorAll('.wizard-panel').forEach((panel, index) => {
            if (index + 1 === step) {
                panel.classList.remove('hidden');
            } else {
                panel.classList.add('hidden');
            }
        });

        // Scroll to top of wizard
        const wizardContainer = document.querySelector('.wizard-container');
        if (wizardContainer) {
            wizardContainer.scrollIntoView({ behavior: 'smooth', block: 'start' });
        }
    }

    // Validate current step
    function validateCurrentStep() {
        const currentPanel = document.getElementById(`step-${state.currentStep}`);
        if (!currentPanel) return true;

        const requiredInputs = currentPanel.querySelectorAll('[required]');
        let isValid = true;
        let firstInvalid = null;

        requiredInputs.forEach(input => {
            if (input.type === 'radio') {
                const name = input.name;
                const checked = currentPanel.querySelector(`input[name="${name}"]:checked`);
                if (!checked) {
                    isValid = false;
                    if (!firstInvalid) firstInvalid = input.closest('.form-group');
                }
            } else if (!input.value.trim()) {
                isValid = false;
                highlightError(input);
                if (!firstInvalid) firstInvalid = input;
            }
        });

        if (!isValid && firstInvalid) {
            firstInvalid.scrollIntoView({ behavior: 'smooth', block: 'center' });
        }

        return isValid;
    }

    // Highlight input error
    function highlightError(element) {
        element.classList.add('error');
        element.style.borderColor = '#E74C3C';

        const removeError = () => {
            element.classList.remove('error');
            element.style.borderColor = '';
            element.removeEventListener('input', removeError);
        };

        element.addEventListener('input', removeError);

        setTimeout(() => {
            element.classList.remove('error');
            element.style.borderColor = '';
        }, 3000);
    }

    // Collect form data
    function collectFormData() {
        const currentPanel = document.getElementById(`step-${state.currentStep}`);
        if (!currentPanel) return;

        const inputs = currentPanel.querySelectorAll('input, select, textarea');
        inputs.forEach(input => {
            if (input.type === 'radio') {
                if (input.checked) {
                    state.formData[input.name] = input.value;
                }
            } else if (input.name) {
                state.formData[input.name] = input.value;
            }
        });
    }

    // Generate quote and show results
    window.generateQuote = function() {
        collectFormData();

        const tnbBill = parseFloat(state.formData.tnb_bill) || 500;

        // Determine recommended system size
        let systemSize;
        if (tnbBill < 300) {
            systemSize = 3;
        } else if (tnbBill < 500) {
            systemSize = 5;
        } else if (tnbBill < 800) {
            systemSize = 7;
        } else {
            systemSize = 10;
        }

        const config = SYSTEM_CONFIGS[systemSize];
        const monthlySavings = tnbBill * config.savingsPercent;
        const yearlySavings = monthlySavings * 12;
        const roiYears = config.price / yearlySavings;
        const savings25yr = yearlySavings * 25;

        state.calculatedResults = {
            systemSize,
            panels: config.panels,
            price: config.price,
            monthlySavings,
            yearlySavings,
            roiYears,
            savings25yr
        };

        // Update UI
        updateElement('result-bill', Math.round(tnbBill).toLocaleString());
        updateElement('result-system-size', `${systemSize}kW`);
        updateElement('result-monthly-savings', `RM ${Math.round(monthlySavings).toLocaleString()}`);
        updateElement('result-yearly-savings', `RM ${Math.round(yearlySavings).toLocaleString()}`);
        updateElement('result-roi-years', `${roiYears.toFixed(1)} Years`);
        updateElement('result-25yr-savings', `RM ${Math.round(savings25yr).toLocaleString()}`);
        updateElement('result-panel-count', config.panels);
        updateElement('result-system-price', `RM ${config.price.toLocaleString()}`);

        // Submit lead to CRM
        submitLead();

        // Show results
        showStep(3);
    };

    // Helper function to update element text
    function updateElement(id, text) {
        const el = document.getElementById(id);
        if (el) el.textContent = text;
    }

    // Select purchase option
    window.selectOption = function(option) {
        state.selectedOption = option;

        // Update UI
        document.querySelectorAll('.option-card').forEach(card => {
            card.classList.remove('selected');
        });

        const selectedCard = document.getElementById(`option-${option}`);
        if (selectedCard) {
            selectedCard.classList.add('selected');
            if (option === 'lease') {
                selectedCard.classList.add('lease');
            }
        }

        // Show relevant action section
        const buySection = document.getElementById('buy-section');
        const leaseSection = document.getElementById('lease-section');

        if (buySection) buySection.classList.toggle('hidden', option !== 'buy');
        if (leaseSection) leaseSection.classList.toggle('hidden', option !== 'lease');

        // Scroll to action section
        const actionSection = document.getElementById(`${option}-section`);
        if (actionSection) {
            setTimeout(() => {
                actionSection.scrollIntoView({ behavior: 'smooth', block: 'center' });
            }, 100);
        }
    };

    // Submit lead to CRM (GoHighLevel webhook)
    async function submitLead() {
        const webhookUrl = '/api/submit-lead'; // Netlify function

        const leadData = {
            name: state.formData.name,
            email: state.formData.email,
            phone: state.formData.phone,
            address: state.formData.address,
            tnb_bill: state.formData.tnb_bill,
            property_type: state.formData.property_type,
            is_homeowner: state.formData.is_homeowner,
            roof_size: state.formData.roof_size,
            system_size: `${state.calculatedResults.systemSize}kW`,
            monthly_savings: state.calculatedResults.monthlySavings,
            yearly_savings: state.calculatedResults.yearlySavings,
            roi_years: state.calculatedResults.roiYears,
            system_price: state.calculatedResults.price,
            source: 'Website Calculator',
            timestamp: new Date().toISOString()
        };

        try {
            const response = await fetch(webhookUrl, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(leadData)
            });

            if (response.ok) {
                console.log('Lead submitted successfully');
            }
        } catch (error) {
            console.error('Error submitting lead:', error);
            // Continue anyway - don't block user experience
        }
    }

    // Process payment (stub - would integrate with Stripe)
    window.processPayment = async function(event) {
        event.preventDefault();

        const submitBtn = document.getElementById('submit-payment');
        if (submitBtn) {
            submitBtn.disabled = true;
            submitBtn.textContent = 'Processing...';
        }

        // In production, this would integrate with Stripe
        // For now, redirect to a thank you or contact page
        try {
            const response = await fetch('/api/process-payment', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    ...state.formData,
                    ...state.calculatedResults,
                    amount: 499
                })
            });

            if (response.ok) {
                alert('Thank you! Our team will contact you within 24 hours to schedule your site visit.');
                window.location.href = '/';
            } else {
                throw new Error('Payment failed');
            }
        } catch (error) {
            console.error('Payment error:', error);
            alert('There was an issue processing your request. Please try again or contact us via WhatsApp.');
            if (submitBtn) {
                submitBtn.disabled = false;
                submitBtn.textContent = 'Pay RM 499 & Book Site Visit';
            }
        }
    };

    // Initialize payment form
    const paymentForm = document.getElementById('payment-form');
    if (paymentForm) {
        paymentForm.addEventListener('submit', window.processPayment);
    }

})();
