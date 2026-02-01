/**
 * Products Page - Malaysia Solar Platform
 * Handles bill selection and system highlighting
 */

(function() {
    'use strict';

    // Initialize on DOM ready
    document.addEventListener('DOMContentLoaded', function() {
        initBillSelector();
        checkUrlParams();
    });

    // Initialize bill selector
    function initBillSelector() {
        const billBtns = document.querySelectorAll('.bill-btn');
        const productCards = document.querySelectorAll('.product-card');

        if (!billBtns.length || !productCards.length) return;

        billBtns.forEach(btn => {
            btn.addEventListener('click', function() {
                // Update active button
                billBtns.forEach(b => b.classList.remove('active'));
                this.classList.add('active');

                // Highlight recommended system
                const recommendedSystem = this.dataset.system;
                highlightSystem(recommendedSystem);
            });
        });

        // Highlight initial selection
        const activeBtn = document.querySelector('.bill-btn.active');
        if (activeBtn) {
            highlightSystem(activeBtn.dataset.system);
        }
    }

    // Highlight recommended system
    function highlightSystem(systemSize) {
        const productCards = document.querySelectorAll('.product-card');

        productCards.forEach(card => {
            card.classList.remove('highlighted');
            if (card.dataset.system === systemSize) {
                card.classList.add('highlighted');
                // Smooth scroll to card on mobile
                if (window.innerWidth < 640) {
                    setTimeout(() => {
                        card.scrollIntoView({ behavior: 'smooth', block: 'center' });
                    }, 100);
                }
            }
        });
    }

    // Check URL parameters for pre-selection
    function checkUrlParams() {
        const urlParams = new URLSearchParams(window.location.search);
        const system = urlParams.get('system');

        if (system) {
            // Find and click the corresponding bill button
            const billBtns = document.querySelectorAll('.bill-btn');
            billBtns.forEach(btn => {
                if (btn.dataset.system === system) {
                    btn.click();
                }
            });
        }
    }

})();
