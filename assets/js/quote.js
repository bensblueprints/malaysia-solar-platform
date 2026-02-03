/**
 * Quote Wizard - Malaysia Solar Platform
 * Handles multi-step form, Solar API integration, calculations, and submissions
 */

(function() {
    'use strict';

    // State
    const state = {
        currentStep: 1,
        formData: {},
        calculatedResults: {},
        selectedOption: null,
        solarAnalysis: null, // Store Solar API results
        isAnalyzing: false
    };

    // System configurations
    const SYSTEM_CONFIGS = window.SYSTEM_CONFIGS || {
        3: { price: 15000, panels: 7, savingsPercent: 0.65, minBill: 150 },
        5: { price: 22000, panels: 12, savingsPercent: 0.75, minBill: 300 },
        7: { price: 30000, panels: 16, savingsPercent: 0.80, minBill: 500 },
        10: { price: 40000, panels: 24, savingsPercent: 0.85, minBill: 750 },
        12: { price: 48000, panels: 28, savingsPercent: 0.87, minBill: 900 },
        15: { price: 58000, panels: 36, savingsPercent: 0.90, minBill: 1200 }
    };

    // Initialize on DOM ready
    document.addEventListener('DOMContentLoaded', function() {
        initWizard();
        initRoofSizeSelector();
        initAddressAnalysis();
        checkUrlParams();
    });

    // Initialize wizard
    function initWizard() {
        const urlParams = new URLSearchParams(window.location.search);
        const preselectedSystem = urlParams.get('system');

        if (preselectedSystem) {
            const billInput = document.getElementById('input-tnb-bill');
            if (billInput) {
                const systemSizes = { 3: 250, 5: 400, 7: 600, 10: 900, 12: 1100, 15: 1400 };
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

    // Initialize address analysis with Solar API
    function initAddressAnalysis() {
        const addressInput = document.getElementById('input-address');
        const analyzeBtn = document.getElementById('analyze-roof-btn');

        if (analyzeBtn) {
            analyzeBtn.addEventListener('click', function() {
                const address = addressInput ? addressInput.value : '';
                if (address.trim()) {
                    analyzeRoofWithSolarAPI(address);
                } else {
                    showNotification('Please enter your property address first', 'warning');
                }
            });
        }

        // Also trigger analysis on address blur if address is long enough
        if (addressInput) {
            addressInput.addEventListener('blur', function() {
                if (this.value.trim().length > 15 && !state.solarAnalysis) {
                    // Auto-analyze if address looks complete
                    analyzeRoofWithSolarAPI(this.value);
                }
            });
        }
    }

    // Analyze roof using Google Solar API
    async function analyzeRoofWithSolarAPI(address) {
        if (state.isAnalyzing) return;

        state.isAnalyzing = true;
        const analyzeBtn = document.getElementById('analyze-roof-btn');
        const resultsContainer = document.getElementById('roof-analysis-results');

        // Update button state
        if (analyzeBtn) {
            analyzeBtn.disabled = true;
            analyzeBtn.innerHTML = `
                <span class="spinner"></span>
                Analyzing Roof...
            `;
        }

        // Show loading state
        if (resultsContainer) {
            resultsContainer.innerHTML = `
                <div class="analysis-loading">
                    <div class="loading-spinner"></div>
                    <p>Analyzing your roof with satellite imagery...</p>
                </div>
            `;
            resultsContainer.classList.remove('hidden');
        }

        try {
            const response = await fetch('/api/solar-analysis', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ address })
            });

            const data = await response.json();

            if (response.ok && data.success) {
                state.solarAnalysis = data;
                displayRoofAnalysisResults(data);

                // Auto-select roof size based on analysis
                autoSelectRoofSize(data.recommendation);

                showNotification('Roof analysis complete!', 'success');
            } else {
                throw new Error(data.error || 'Analysis failed');
            }

        } catch (error) {
            console.error('Solar analysis error:', error);

            if (resultsContainer) {
                resultsContainer.innerHTML = `
                    <div class="analysis-error">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <circle cx="12" cy="12" r="10"/>
                            <line x1="12" y1="8" x2="12" y2="12"/>
                            <line x1="12" y1="16" x2="12.01" y2="16"/>
                        </svg>
                        <p>Could not analyze this address. Please continue with manual estimation.</p>
                    </div>
                `;
            }
        } finally {
            state.isAnalyzing = false;

            if (analyzeBtn) {
                analyzeBtn.disabled = false;
                analyzeBtn.innerHTML = `
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="11" cy="11" r="8"/>
                        <path d="M21 21l-4.35-4.35"/>
                    </svg>
                    Analyze My Roof
                `;
            }
        }
    }

    // Display roof analysis results
    function displayRoofAnalysisResults(data) {
        const resultsContainer = document.getElementById('roof-analysis-results');
        if (!resultsContainer) return;

        const { roofAnalysis, solarPotential, recommendation } = data;
        const dataSourceLabel = data.dataSource === 'google_solar_api'
            ? 'Based on satellite imagery analysis'
            : 'Based on estimated values for your area';

        const roofAreaDisplay = roofAnalysis.usableRoofAreaSqm
            ? `${roofAnalysis.usableRoofAreaSqm} sqm`
            : 'Not available';

        const maxPanelsDisplay = roofAnalysis.maxPanelCount
            ? `${roofAnalysis.maxPanelCount} panels`
            : 'Estimate based on property type';

        const sunshineBadge = solarPotential.maxSunshineHoursPerYear > 1600
            ? '<span class="badge badge-success">Excellent</span>'
            : '<span class="badge badge-warning">Good</span>';

        resultsContainer.innerHTML = `
            <div class="analysis-results">
                <div class="results-header-mini">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M22 11.08V12a10 10 0 11-5.93-9.14"/>
                        <polyline points="22,4 12,14.01 9,11.01"/>
                    </svg>
                    <h4>Roof Analysis Complete</h4>
                    <span class="data-source">${dataSourceLabel}</span>
                </div>

                <div class="analysis-grid">
                    <div class="analysis-item">
                        <div class="item-icon">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M3 9l9-7 9 7v11a2 2 0 01-2 2H5a2 2 0 01-2-2z"/>
                            </svg>
                        </div>
                        <div class="item-content">
                            <span class="item-value">${roofAreaDisplay}</span>
                            <span class="item-label">Usable Roof Area</span>
                        </div>
                    </div>

                    <div class="analysis-item">
                        <div class="item-icon">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <rect x="3" y="3" width="7" height="7"/>
                                <rect x="14" y="3" width="7" height="7"/>
                                <rect x="14" y="14" width="7" height="7"/>
                                <rect x="3" y="14" width="7" height="7"/>
                            </svg>
                        </div>
                        <div class="item-content">
                            <span class="item-value">${maxPanelsDisplay}</span>
                            <span class="item-label">Max Panel Capacity</span>
                        </div>
                    </div>

                    <div class="analysis-item">
                        <div class="item-icon">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <circle cx="12" cy="12" r="5"/>
                                <line x1="12" y1="1" x2="12" y2="3"/>
                                <line x1="12" y1="21" x2="12" y2="23"/>
                                <line x1="4.22" y1="4.22" x2="5.64" y2="5.64"/>
                                <line x1="18.36" y1="18.36" x2="19.78" y2="19.78"/>
                                <line x1="1" y1="12" x2="3" y2="12"/>
                                <line x1="21" y1="12" x2="23" y2="12"/>
                            </svg>
                        </div>
                        <div class="item-content">
                            <span class="item-value">${Math.round(solarPotential.maxSunshineHoursPerYear)} hrs/year</span>
                            <span class="item-label">Sunshine ${sunshineBadge}</span>
                        </div>
                    </div>
                </div>

                <div class="recommendation-preview">
                    <div class="rec-badge ${recommendation.roofSuitable ? 'suitable' : 'limited'}">
                        ${recommendation.roofSuitable
                            ? '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 11.08V12a10 10 0 11-5.93-9.14"/><polyline points="22,4 12,14.01 9,11.01"/></svg> Suitable for Solar'
                            : '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg> Limited Space'}
                    </div>
                    <p class="rec-system">
                        Recommended: <strong>${recommendation.systemSizeKw}kW System</strong>
                        (${recommendation.panelCount} panels)
                    </p>
                    <p class="rec-production">
                        Expected: ~${recommendation.expectedProduction.monthlyKwh} kWh/month
                    </p>
                </div>

                ${recommendation.notes && recommendation.notes.length > 0 ? `
                    <div class="analysis-notes">
                        ${recommendation.notes.map(note => `<p class="note">${note}</p>`).join('')}
                    </div>
                ` : ''}
            </div>
        `;

        resultsContainer.classList.remove('hidden');
    }

    // Auto-select roof size based on Solar API analysis
    function autoSelectRoofSize(recommendation) {
        if (!recommendation || !recommendation.roofSizeCategory) return;

        const sizeMap = {
            'small': 'small',
            'medium': 'medium',
            'large': 'large',
            'extra_large': 'xlarge'
        };

        const size = sizeMap[recommendation.roofSizeCategory];
        if (!size) return;

        const sizeBtns = document.querySelectorAll('.size-btn');
        const hiddenInput = document.getElementById('roof-size');

        sizeBtns.forEach(btn => {
            btn.classList.remove('active');
            if (btn.dataset.size === size) {
                btn.classList.add('active');
            }
        });

        if (hiddenInput) {
            hiddenInput.value = size;
        }
    }

    // Check URL parameters
    function checkUrlParams() {
        const urlParams = new URLSearchParams(window.location.search);
        const system = urlParams.get('system');

        if (system && SYSTEM_CONFIGS[system]) {
            const estimatedBills = { 3: 250, 5: 450, 7: 650, 10: 900, 12: 1100, 15: 1400 };
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

        document.querySelectorAll('.wizard-step').forEach((el, index) => {
            el.classList.remove('active', 'completed');
            if (index + 1 < step) {
                el.classList.add('completed');
            } else if (index + 1 === step) {
                el.classList.add('active');
            }
        });

        document.querySelectorAll('.wizard-panel').forEach((panel, index) => {
            if (index + 1 === step) {
                panel.classList.remove('hidden');
            } else {
                panel.classList.add('hidden');
            }
        });

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

        let systemSize;
        let config;

        // If we have Solar API data, use it for recommendation
        if (state.solarAnalysis && state.solarAnalysis.recommendation) {
            const rec = state.solarAnalysis.recommendation;
            systemSize = rec.systemSizeKw;

            // Find closest matching config
            const availableSizes = Object.keys(SYSTEM_CONFIGS).map(Number).sort((a, b) => a - b);
            systemSize = availableSizes.reduce((prev, curr) =>
                Math.abs(curr - systemSize) < Math.abs(prev - systemSize) ? curr : prev
            );

            config = SYSTEM_CONFIGS[systemSize];

            // Use Solar API savings if available
            if (rec.estimatedSavings) {
                state.calculatedResults = {
                    systemSize,
                    panels: rec.panelCount || config.panels,
                    price: rec.estimatedPrice || config.price,
                    monthlySavings: rec.estimatedSavings.monthlyRm,
                    yearlySavings: rec.estimatedSavings.yearlyRm,
                    roiYears: rec.paybackPeriodYears,
                    savings25yr: rec.estimatedSavings.over25YearsRm,
                    roofAreaSqm: rec.usableRoofAreaSqm,
                    dataSource: 'solar_api'
                };
            }
        }

        // Fallback to bill-based calculation
        if (!state.calculatedResults.systemSize) {
            if (tnbBill < 300) {
                systemSize = 3;
            } else if (tnbBill < 500) {
                systemSize = 5;
            } else if (tnbBill < 800) {
                systemSize = 7;
            } else if (tnbBill < 1000) {
                systemSize = 10;
            } else if (tnbBill < 1300) {
                systemSize = 12;
            } else {
                systemSize = 15;
            }

            config = SYSTEM_CONFIGS[systemSize];
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
                savings25yr,
                dataSource: 'bill_estimate'
            };
        }

        // Update UI
        updateElement('result-bill', Math.round(tnbBill).toLocaleString());
        updateElement('result-system-size', `${state.calculatedResults.systemSize}kW`);
        updateElement('result-monthly-savings', `RM ${Math.round(state.calculatedResults.monthlySavings).toLocaleString()}`);
        updateElement('result-yearly-savings', `RM ${Math.round(state.calculatedResults.yearlySavings).toLocaleString()}`);
        updateElement('result-roi-years', `${state.calculatedResults.roiYears.toFixed(1)} Years`);
        updateElement('result-25yr-savings', `RM ${Math.round(state.calculatedResults.savings25yr).toLocaleString()}`);
        updateElement('result-panel-count', state.calculatedResults.panels);
        updateElement('result-system-price', `RM ${state.calculatedResults.price.toLocaleString()}`);

        // Show roof analysis badge if available
        const roofBadge = document.getElementById('roof-analysis-badge');
        if (roofBadge && state.solarAnalysis) {
            roofBadge.classList.remove('hidden');
            if (state.calculatedResults.roofAreaSqm) {
                roofBadge.innerHTML = `
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M22 11.08V12a10 10 0 11-5.93-9.14"/>
                        <polyline points="22,4 12,14.01 9,11.01"/>
                    </svg>
                    Based on ${state.calculatedResults.roofAreaSqm} sqm roof analysis
                `;
            }
        }

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

    // Show notification
    function showNotification(message, type = 'info') {
        // Remove existing notifications
        const existing = document.querySelector('.notification-toast');
        if (existing) existing.remove();

        const toast = document.createElement('div');
        toast.className = `notification-toast notification-${type}`;
        toast.innerHTML = `
            <span>${message}</span>
            <button onclick="this.parentElement.remove()">&times;</button>
        `;

        document.body.appendChild(toast);

        // Auto-remove after 4 seconds
        setTimeout(() => {
            if (toast.parentElement) {
                toast.remove();
            }
        }, 4000);
    }

    // Select purchase option
    window.selectOption = function(option) {
        state.selectedOption = option;

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

        const buySection = document.getElementById('buy-section');
        const leaseSection = document.getElementById('lease-section');

        if (buySection) buySection.classList.toggle('hidden', option !== 'buy');
        if (leaseSection) leaseSection.classList.toggle('hidden', option !== 'lease');

        const actionSection = document.getElementById(`${option}-section`);
        if (actionSection) {
            setTimeout(() => {
                actionSection.scrollIntoView({ behavior: 'smooth', block: 'center' });
            }, 100);
        }
    };

    // Submit lead to CRM
    async function submitLead() {
        const webhookUrl = '/api/submit-lead';

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
            data_source: state.calculatedResults.dataSource,
            roof_area_sqm: state.calculatedResults.roofAreaSqm || null,
            solar_analysis: state.solarAnalysis ? {
                location: state.solarAnalysis.location,
                roofAnalysis: state.solarAnalysis.roofAnalysis,
                solarPotential: state.solarAnalysis.solarPotential
            } : null,
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
        }
    }

    // Process payment
    window.processPayment = async function(event) {
        event.preventDefault();

        const submitBtn = document.getElementById('submit-payment');
        if (submitBtn) {
            submitBtn.disabled = true;
            submitBtn.textContent = 'Processing...';
        }

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
