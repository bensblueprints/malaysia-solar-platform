/**
 * Solar Calculator Module
 * Handles the multi-step quote wizard, Google Maps integration, and roof drawing
 */

(function() {
    'use strict';

    // Calculator state
    const state = {
        currentStep: 1,
        formData: {},
        roofArea: 0,
        map: null,
        drawingManager: null,
        polygon: null,
        markers: [],
        calculatedResults: {}
    };

    // System configurations
    const SYSTEM_CONFIGS = {
        3: { price: 15000, panels: 7, savingsPercent: 0.65 },
        5: { price: 22000, panels: 12, savingsPercent: 0.75 },
        7: { price: 30000, panels: 16, savingsPercent: 0.80 },
        10: { price: 40000, panels: 24, savingsPercent: 0.85 }
    };

    // DOM Elements
    const elements = {};

    /**
     * Initialize the calculator
     */
    function init() {
        cacheElements();
        bindEvents();
        initMap();
    }

    /**
     * Cache DOM elements
     */
    function cacheElements() {
        elements.wizardSteps = document.querySelectorAll('.wizard-step');
        elements.wizardPanels = document.querySelectorAll('.wizard-panel');
        elements.calculatedArea = document.getElementById('calculated-area');
        elements.roofAreaInput = document.getElementById('input-roof-area');
        elements.mapContainer = document.getElementById('google-map');
        elements.drawingWrapper = document.getElementById('drawing-wrapper');
        elements.roofCanvas = document.getElementById('roof-canvas');
    }

    /**
     * Bind event listeners
     */
    function bindEvents() {
        // Tool buttons
        const toolDraw = document.getElementById('tool-draw');
        const toolClear = document.getElementById('tool-clear');

        if (toolDraw) {
            toolDraw.addEventListener('click', () => enableDrawing());
        }
        if (toolClear) {
            toolClear.addEventListener('click', () => clearDrawing());
        }

        // Manual area input
        if (elements.roofAreaInput) {
            elements.roofAreaInput.addEventListener('input', function() {
                state.roofArea = parseFloat(this.value) || 0;
                updateCalculatedArea();
            });
        }

        // Path selection
        document.querySelectorAll('[id^="path-"]').forEach(card => {
            card.addEventListener('click', function() {
                const path = this.id.replace('path-', '');
                selectPath(path);
            });
        });
    }

    /**
     * Initialize Google Map
     */
    function initMap() {
        if (!elements.mapContainer || typeof google === 'undefined') {
            console.log('Google Maps not available');
            return;
        }

        // Default to Kuala Lumpur
        const defaultLocation = { lat: 3.1390, lng: 101.6869 };

        state.map = new google.maps.Map(elements.mapContainer, {
            center: defaultLocation,
            zoom: 18,
            mapTypeId: 'satellite',
            tilt: 0,
            mapTypeControl: true,
            mapTypeControlOptions: {
                style: google.maps.MapTypeControlStyle.HORIZONTAL_BAR,
                position: google.maps.ControlPosition.TOP_RIGHT
            },
            streetViewControl: false,
            fullscreenControl: true
        });

        // Initialize Drawing Manager
        state.drawingManager = new google.maps.drawing.DrawingManager({
            drawingMode: google.maps.drawing.OverlayType.POLYGON,
            drawingControl: true,
            drawingControlOptions: {
                position: google.maps.ControlPosition.TOP_CENTER,
                drawingModes: [google.maps.drawing.OverlayType.POLYGON]
            },
            polygonOptions: {
                fillColor: '#F7B32B',
                fillOpacity: 0.4,
                strokeWeight: 2,
                strokeColor: '#F7B32B',
                clickable: true,
                editable: true,
                draggable: true
            }
        });

        state.drawingManager.setMap(state.map);

        // Listen for polygon completion
        google.maps.event.addListener(state.drawingManager, 'polygoncomplete', function(polygon) {
            if (state.polygon) {
                state.polygon.setMap(null);
            }
            state.polygon = polygon;
            calculatePolygonArea(polygon);

            // Update area on edit
            google.maps.event.addListener(polygon.getPath(), 'set_at', function() {
                calculatePolygonArea(polygon);
            });
            google.maps.event.addListener(polygon.getPath(), 'insert_at', function() {
                calculatePolygonArea(polygon);
            });
        });

        // Setup Places Autocomplete for address input
        const addressInput = document.getElementById('input-address');
        if (addressInput) {
            const autocomplete = new google.maps.places.Autocomplete(addressInput, {
                componentRestrictions: { country: 'my' },
                fields: ['geometry', 'formatted_address']
            });

            autocomplete.addListener('place_changed', function() {
                const place = autocomplete.getPlace();
                if (place.geometry) {
                    state.map.setCenter(place.geometry.location);
                    state.map.setZoom(20);

                    // Add marker
                    new google.maps.Marker({
                        position: place.geometry.location,
                        map: state.map,
                        title: 'Your Property'
                    });
                }
            });
        }
    }

    /**
     * Calculate polygon area in square meters
     */
    function calculatePolygonArea(polygon) {
        const area = google.maps.geometry.spherical.computeArea(polygon.getPath());
        state.roofArea = Math.round(area);
        updateCalculatedArea();

        // Update manual input
        if (elements.roofAreaInput) {
            elements.roofAreaInput.value = state.roofArea;
        }
    }

    /**
     * Update calculated area display
     */
    function updateCalculatedArea() {
        if (elements.calculatedArea) {
            elements.calculatedArea.textContent = state.roofArea.toLocaleString();
        }
    }

    /**
     * Enable drawing mode
     */
    function enableDrawing() {
        if (state.drawingManager) {
            state.drawingManager.setDrawingMode(google.maps.drawing.OverlayType.POLYGON);
        }
        document.getElementById('tool-draw')?.classList.add('active');
    }

    /**
     * Clear drawing
     */
    function clearDrawing() {
        if (state.polygon) {
            state.polygon.setMap(null);
            state.polygon = null;
        }
        state.roofArea = 0;
        updateCalculatedArea();
        if (elements.roofAreaInput) {
            elements.roofAreaInput.value = '';
        }
    }

    /**
     * Navigate to next step
     */
    window.nextStep = function(step) {
        if (!validateCurrentStep()) {
            return;
        }

        collectFormData();
        showStep(step);
    };

    /**
     * Navigate to previous step
     */
    window.prevStep = function(step) {
        showStep(step);
    };

    /**
     * Show specific step
     */
    function showStep(step) {
        state.currentStep = step;

        // Update progress indicators
        elements.wizardSteps.forEach((el, index) => {
            el.classList.remove('active', 'completed');
            if (index + 1 < step) {
                el.classList.add('completed');
            } else if (index + 1 === step) {
                el.classList.add('active');
            }
        });

        // Show/hide panels
        elements.wizardPanels.forEach((panel, index) => {
            if (index + 1 === step) {
                panel.classList.remove('hidden');
            } else {
                panel.classList.add('hidden');
            }
        });

        // Scroll to top of wizard
        document.querySelector('.wizard-container')?.scrollIntoView({ behavior: 'smooth' });
    }

    /**
     * Validate current step
     */
    function validateCurrentStep() {
        const currentPanel = document.getElementById(`step-${state.currentStep}`);
        if (!currentPanel) return true;

        const requiredInputs = currentPanel.querySelectorAll('[required]');
        let isValid = true;

        requiredInputs.forEach(input => {
            if (input.type === 'radio') {
                const name = input.name;
                const checked = currentPanel.querySelector(`input[name="${name}"]:checked`);
                if (!checked) {
                    isValid = false;
                    highlightError(input.closest('.form-group') || input.closest('div'));
                }
            } else if (!input.value.trim()) {
                isValid = false;
                highlightError(input);
            }
        });

        return isValid;
    }

    /**
     * Highlight input error
     */
    function highlightError(element) {
        element.classList.add('error');
        element.style.borderColor = '#E74C3C';
        setTimeout(() => {
            element.classList.remove('error');
            element.style.borderColor = '';
        }, 3000);
    }

    /**
     * Collect form data from current step
     */
    function collectFormData() {
        const currentPanel = document.getElementById(`step-${state.currentStep}`);
        if (!currentPanel) return;

        const inputs = currentPanel.querySelectorAll('input, select, textarea');
        inputs.forEach(input => {
            if (input.type === 'radio') {
                if (input.checked) {
                    state.formData[input.name] = input.value;
                }
            } else {
                state.formData[input.name] = input.value;
            }
        });
    }

    /**
     * Generate quote and show results
     */
    window.generateQuote = function() {
        collectFormData();

        // Get roof area
        const roofArea = state.roofArea || parseFloat(state.formData.roof_area) || 50;
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

        // Check roof area constraints (approx 4sqm per kW needed)
        const maxSystemForRoof = Math.floor(roofArea / 4);
        if (maxSystemForRoof < systemSize) {
            systemSize = Object.keys(SYSTEM_CONFIGS)
                .map(Number)
                .filter(s => s <= maxSystemForRoof)
                .pop() || 3;
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
        document.getElementById('result-system-size').textContent = `${systemSize}kW`;
        document.getElementById('result-monthly-savings').textContent = `RM ${Math.round(monthlySavings).toLocaleString()}`;
        document.getElementById('result-yearly-savings').textContent = `RM ${Math.round(yearlySavings).toLocaleString()}`;
        document.getElementById('result-roi-years').textContent = `${roiYears.toFixed(1)} Years`;
        document.getElementById('result-25yr-savings').textContent = `RM ${Math.round(savings25yr).toLocaleString()}`;
        document.getElementById('result-panel-count').textContent = config.panels;
        document.getElementById('result-system-price').textContent = `RM ${config.price.toLocaleString()}`;

        // Submit lead to CRM
        submitLead();

        // Show results
        showStep(4);
    };

    /**
     * Select purchase path
     */
    window.selectPath = function(path) {
        state.formData.purchase_path = path;

        // Update UI
        document.getElementById('path-buy').style.borderColor = path === 'buy' ? 'var(--solar-amber)' : 'transparent';
        document.getElementById('path-lease').style.borderColor = path === 'lease' ? 'var(--eco-teal)' : 'transparent';

        // Show relevant section
        document.getElementById('payment-section').style.display = path === 'buy' ? 'block' : 'none';
        document.getElementById('lease-section').style.display = path === 'lease' ? 'block' : 'none';

        // Initialize Stripe card element for buy path
        if (path === 'buy' && typeof stripe !== 'undefined' && typeof cardElement !== 'undefined') {
            const cardElementContainer = document.getElementById('card-element');
            if (cardElementContainer && !cardElementContainer.hasChildNodes()) {
                cardElement.mount('#card-element');
            }
        }
    };

    /**
     * Submit lead to CRM
     */
    function submitLead() {
        if (typeof solarCalculator === 'undefined') return;

        const data = new FormData();
        data.append('action', 'submit_quote');
        data.append('nonce', solarCalculator.nonce);

        // Add form data
        Object.keys(state.formData).forEach(key => {
            data.append(key, state.formData[key]);
        });

        // Add calculated results
        data.append('roof_area', state.roofArea);
        data.append('system_size', state.calculatedResults.systemSize + 'kW');
        data.append('monthly_savings', state.calculatedResults.monthlySavings);
        data.append('yearly_savings', state.calculatedResults.yearlySavings);
        data.append('roi_years', state.calculatedResults.roiYears);

        fetch(solarCalculator.ajaxUrl, {
            method: 'POST',
            body: data
        })
        .then(response => response.json())
        .then(result => {
            if (result.success) {
                state.quoteId = result.data.quote_id;
                console.log('Quote submitted:', result.data.quote_id);
            }
        })
        .catch(error => {
            console.error('Error submitting quote:', error);
        });
    }

    /**
     * Process payment
     */
    window.processPayment = function() {
        if (typeof stripe === 'undefined' || typeof cardElement === 'undefined') {
            alert('Payment system not available. Please contact us directly.');
            return;
        }

        const submitBtn = document.getElementById('submit-payment');
        submitBtn.disabled = true;
        submitBtn.textContent = 'Processing...';

        const data = new FormData();
        data.append('action', 'process_payment');
        data.append('nonce', solarCalculator.nonce);
        data.append('name', state.formData.name);
        data.append('email', state.formData.email);
        data.append('quote_id', state.quoteId || '');

        fetch(solarCalculator.ajaxUrl, {
            method: 'POST',
            body: data
        })
        .then(response => response.json())
        .then(result => {
            if (result.success) {
                return stripe.confirmCardPayment(result.data.clientSecret, {
                    payment_method: {
                        card: cardElement,
                        billing_details: {
                            name: state.formData.name,
                            email: state.formData.email
                        }
                    }
                });
            } else {
                throw new Error(result.data.message || 'Payment failed');
            }
        })
        .then(result => {
            if (result.error) {
                throw new Error(result.error.message);
            }
            // Payment successful
            alert('Payment successful! Our team will contact you within 24 hours to schedule your site visit.');
            window.location.href = window.location.origin + '/thank-you/';
        })
        .catch(error => {
            document.getElementById('card-errors').textContent = error.message;
            submitBtn.disabled = false;
            submitBtn.textContent = 'Pay RM 499 & Book Site Visit';
        });
    };

    // Initialize on DOM ready
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', init);
    } else {
        init();
    }
})();
