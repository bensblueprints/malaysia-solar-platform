<?php
/**
 * Template Name: Get A Quote
 * Solar Calculator with Google Maps Integration
 *
 * @package Malaysia_Solar
 */

get_header();

$stripe_pk = get_option('malaysia_solar_stripe_pk', '');
?>

<!-- Quote Hero -->
<section class="quote-hero">
    <div class="container">
        <h1>Get Your Free Solar Quote</h1>
        <p>Calculate your potential savings in just a few minutes</p>
    </div>
</section>

<!-- Quote Wizard -->
<section class="quote-wizard">
    <div class="container">
        <div class="wizard-container">
            <!-- Progress Steps -->
            <div class="wizard-progress">
                <div class="wizard-step active" data-step="1">
                    <div class="step-indicator">1</div>
                    <span class="step-label">Your Details</span>
                </div>
                <div class="wizard-step" data-step="2">
                    <div class="step-indicator">2</div>
                    <span class="step-label">Property Info</span>
                </div>
                <div class="wizard-step" data-step="3">
                    <div class="step-indicator">3</div>
                    <span class="step-label">Draw Roof</span>
                </div>
                <div class="wizard-step" data-step="4">
                    <div class="step-indicator">4</div>
                    <span class="step-label">Your Quote</span>
                </div>
            </div>

            <!-- Step 1: Personal Details -->
            <div class="wizard-panel" id="step-1">
                <h3 style="margin-bottom: var(--space-xl);">Tell Us About Yourself</h3>

                <form id="quote-form-step1">
                    <div class="grid grid-2 gap-lg">
                        <div class="form-group">
                            <label class="form-label required">Full Name</label>
                            <input type="text" class="form-input" name="name" id="input-name" required placeholder="e.g., Ahmad bin Abdullah">
                        </div>
                        <div class="form-group">
                            <label class="form-label required">IC Number</label>
                            <input type="text" class="form-input" name="ic_number" id="input-ic" required placeholder="e.g., 880101-01-1234">
                        </div>
                    </div>

                    <div class="grid grid-2 gap-lg">
                        <div class="form-group">
                            <label class="form-label required">Email Address</label>
                            <input type="email" class="form-input" name="email" id="input-email" required placeholder="e.g., ahmad@email.com">
                        </div>
                        <div class="form-group">
                            <label class="form-label required">Phone Number</label>
                            <input type="tel" class="form-input" name="phone" id="input-phone" required placeholder="e.g., 012-345 6789">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label required">Property Address</label>
                        <input type="text" class="form-input" name="address" id="input-address" required placeholder="Enter your full address">
                        <span class="form-hint">This helps us locate your property on the map</span>
                    </div>

                    <div class="form-group">
                        <label class="form-label required">Average Monthly TNB Bill (RM)</label>
                        <input type="number" class="form-input" name="tnb_bill" id="input-tnb-bill" required placeholder="e.g., 500" min="100">
                        <span class="form-hint">Check your recent TNB bills for accuracy</span>
                    </div>

                    <div style="display: flex; justify-content: flex-end; margin-top: var(--space-xl);">
                        <button type="button" class="btn btn-primary" onclick="nextStep(2)">
                            Continue
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M5 12h14M12 5l7 7-7 7"/>
                            </svg>
                        </button>
                    </div>
                </form>
            </div>

            <!-- Step 2: Qualification Questions -->
            <div class="wizard-panel hidden" id="step-2">
                <h3 style="margin-bottom: var(--space-xl);">Property Qualification</h3>

                <div class="form-group">
                    <label class="form-label required">Are you the homeowner?</label>
                    <div style="display: flex; gap: var(--space-md); margin-top: var(--space-sm);">
                        <label class="form-checkbox" style="flex: 1; padding: var(--space-lg); border: 2px solid rgba(10, 22, 40, 0.1); border-radius: var(--radius-md); cursor: pointer;">
                            <input type="radio" name="is_homeowner" value="yes" required>
                            <span>Yes, I own this property</span>
                        </label>
                        <label class="form-checkbox" style="flex: 1; padding: var(--space-lg); border: 2px solid rgba(10, 22, 40, 0.1); border-radius: var(--radius-md); cursor: pointer;">
                            <input type="radio" name="is_homeowner" value="no">
                            <span>No, I am renting</span>
                        </label>
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label required">Do you have rights to the roof?</label>
                    <div style="display: flex; gap: var(--space-md); margin-top: var(--space-sm);">
                        <label class="form-checkbox" style="flex: 1; padding: var(--space-lg); border: 2px solid rgba(10, 22, 40, 0.1); border-radius: var(--radius-md); cursor: pointer;">
                            <input type="radio" name="has_roof_rights" value="yes" required>
                            <span>Yes, I can install on the roof</span>
                        </label>
                        <label class="form-checkbox" style="flex: 1; padding: var(--space-lg); border: 2px solid rgba(10, 22, 40, 0.1); border-radius: var(--radius-md); cursor: pointer;">
                            <input type="radio" name="has_roof_rights" value="no">
                            <span>No / Not sure</span>
                        </label>
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label required">Is your monthly bill more than RM 300?</label>
                    <div style="display: flex; gap: var(--space-md); margin-top: var(--space-sm);">
                        <label class="form-checkbox" style="flex: 1; padding: var(--space-lg); border: 2px solid rgba(10, 22, 40, 0.1); border-radius: var(--radius-md); cursor: pointer;">
                            <input type="radio" name="bill_over_300" value="yes" required>
                            <span>Yes, more than RM 300</span>
                        </label>
                        <label class="form-checkbox" style="flex: 1; padding: var(--space-lg); border: 2px solid rgba(10, 22, 40, 0.1); border-radius: var(--radius-md); cursor: pointer;">
                            <input type="radio" name="bill_over_300" value="no">
                            <span>No, less than RM 300</span>
                        </label>
                    </div>
                </div>

                <div style="display: flex; justify-content: space-between; margin-top: var(--space-xl);">
                    <button type="button" class="btn btn-outline" onclick="prevStep(1)">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M19 12H5M12 19l-7-7 7-7"/>
                        </svg>
                        Back
                    </button>
                    <button type="button" class="btn btn-primary" onclick="nextStep(3)">
                        Continue to Map
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M5 12h14M12 5l7 7-7 7"/>
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Step 3: Map & Roof Drawing -->
            <div class="wizard-panel hidden" id="step-3">
                <h3 style="margin-bottom: var(--space-lg);">Draw Your Roof Area</h3>

                <div class="map-instructions">
                    <svg viewBox="0 0 24 24" fill="none">
                        <circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="2"/>
                        <path d="M12 16v-4M12 8h.01" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                    </svg>
                    <p>Use the map below to locate your property. Then click on the corners of your roof to outline the area where solar panels can be installed.</p>
                </div>

                <!-- Map Container -->
                <div class="map-container" id="map-container">
                    <div id="google-map" style="width: 100%; height: 100%;"></div>
                </div>

                <!-- Drawing Canvas (overlays on satellite view) -->
                <div class="drawing-canvas-wrapper" id="drawing-wrapper" style="display: none;">
                    <div class="drawing-tools">
                        <button type="button" class="tool-btn active" id="tool-draw">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M12 19l7-7 3 3-7 7-3-3z"/>
                                <path d="M18 13l-1.5-7.5L2 2l3.5 14.5L13 18l5-5z"/>
                            </svg>
                            Draw
                        </button>
                        <button type="button" class="tool-btn" id="tool-clear">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <polyline points="3,6 5,6 21,6"/>
                                <path d="M19 6v14a2 2 0 01-2 2H7a2 2 0 01-2-2V6m3 0V4a2 2 0 012-2h4a2 2 0 012 2v2"/>
                            </svg>
                            Clear
                        </button>
                        <span style="margin-left: auto; color: var(--solar-gold); font-size: 0.875rem;">
                            Roof Area: <strong id="calculated-area">0</strong> sqm
                        </span>
                    </div>
                    <canvas id="roof-canvas" width="800" height="400"></canvas>
                </div>

                <!-- Manual Area Input (fallback) -->
                <div class="form-group" style="margin-top: var(--space-lg);">
                    <label class="form-label">Or enter roof area manually (sqm)</label>
                    <input type="number" class="form-input" name="roof_area" id="input-roof-area" placeholder="e.g., 50" style="max-width: 200px;">
                    <span class="form-hint">Typical terrace house: 30-50 sqm, Semi-D: 50-80 sqm, Bungalow: 80-150 sqm</span>
                </div>

                <div style="display: flex; justify-content: space-between; margin-top: var(--space-xl);">
                    <button type="button" class="btn btn-outline" onclick="prevStep(2)">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M19 12H5M12 19l-7-7 7-7"/>
                        </svg>
                        Back
                    </button>
                    <button type="button" class="btn btn-primary" onclick="generateQuote()">
                        Generate Quote
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M5 12h14M12 5l7 7-7 7"/>
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Step 4: Results & Quote -->
            <div class="wizard-panel hidden" id="step-4">
                <div class="results-panel">
                    <div class="results-header">
                        <h3>Your Solar Quote is Ready!</h3>
                        <p style="color: var(--medium-gray);">Based on your information, here's our recommendation</p>
                    </div>

                    <div class="system-recommendation">
                        <h4>Recommended System Size</h4>
                        <div class="system-size" id="result-system-size">5kW</div>
                    </div>

                    <div class="results-grid">
                        <div class="result-item">
                            <div class="result-value" id="result-monthly-savings">RM 400</div>
                            <div class="result-label">Monthly Savings</div>
                        </div>
                        <div class="result-item">
                            <div class="result-value" id="result-yearly-savings">RM 4,800</div>
                            <div class="result-label">Yearly Savings</div>
                        </div>
                        <div class="result-item">
                            <div class="result-value" id="result-roi-years">4.5 Years</div>
                            <div class="result-label">Payback Period</div>
                        </div>
                        <div class="result-item">
                            <div class="result-value" id="result-25yr-savings">RM 120,000</div>
                            <div class="result-label">25-Year Savings</div>
                        </div>
                    </div>

                    <div style="background: rgba(255,255,255,0.1); border-radius: var(--radius-lg); padding: var(--space-lg); margin-bottom: var(--space-xl);">
                        <h4 style="color: var(--pure-white); margin-bottom: var(--space-md);">System Package Includes:</h4>
                        <ul style="list-style: none; display: grid; grid-template-columns: 1fr 1fr; gap: var(--space-sm);">
                            <li style="color: var(--medium-gray); font-size: 0.9375rem;">
                                <span style="color: var(--solar-gold); margin-right: 8px;">✓</span>
                                <span id="result-panel-count">12</span> Premium Solar Panels
                            </li>
                            <li style="color: var(--medium-gray); font-size: 0.9375rem;">
                                <span style="color: var(--solar-gold); margin-right: 8px;">✓</span>
                                Tier-1 Inverter
                            </li>
                            <li style="color: var(--medium-gray); font-size: 0.9375rem;">
                                <span style="color: var(--solar-gold); margin-right: 8px;">✓</span>
                                Professional Installation
                            </li>
                            <li style="color: var(--medium-gray); font-size: 0.9375rem;">
                                <span style="color: var(--solar-gold); margin-right: 8px;">✓</span>
                                NEM Application
                            </li>
                            <li style="color: var(--medium-gray); font-size: 0.9375rem;">
                                <span style="color: var(--solar-gold); margin-right: 8px;">✓</span>
                                25-Year Panel Warranty
                            </li>
                            <li style="color: var(--medium-gray); font-size: 0.9375rem;">
                                <span style="color: var(--solar-gold); margin-right: 8px;">✓</span>
                                5-Year Free Maintenance
                            </li>
                        </ul>
                    </div>

                    <div style="text-align: center; padding: var(--space-lg); background: rgba(247, 179, 43, 0.1); border-radius: var(--radius-lg); margin-bottom: var(--space-xl);">
                        <div style="font-size: 0.875rem; color: var(--medium-gray); margin-bottom: var(--space-xs);">System Price</div>
                        <div style="font-family: var(--font-display); font-size: 2.5rem; font-weight: 700; color: var(--pure-white);" id="result-system-price">RM 22,000</div>
                    </div>
                </div>

                <div style="margin-top: var(--space-xl);">
                    <h4 style="margin-bottom: var(--space-lg);">Choose Your Path</h4>
                    <div class="grid grid-2 gap-lg">
                        <div class="card" style="border: 2px solid transparent; cursor: pointer;" id="path-buy" onclick="selectPath('buy')">
                            <div class="card-body" style="text-align: center;">
                                <div style="width: 64px; height: 64px; background: var(--gradient-solar); border-radius: var(--radius-full); display: flex; align-items: center; justify-content: center; margin: 0 auto var(--space-md);">
                                    <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="var(--space-deep)" stroke-width="2">
                                        <rect x="1" y="4" width="22" height="16" rx="2" ry="2"/>
                                        <line x1="1" y1="10" x2="23" y2="10"/>
                                    </svg>
                                </div>
                                <h4>Buy System</h4>
                                <p style="font-size: 0.9375rem; color: var(--medium-gray);">Pay RM499 commitment fee for site visit & drone survey. Full payment or financing available.</p>
                                <div style="font-family: var(--font-display); font-size: 1.5rem; font-weight: 700; color: var(--solar-amber); margin-top: var(--space-md);">RM 499</div>
                                <div style="font-size: 0.75rem; color: var(--medium-gray);">Commitment Fee</div>
                            </div>
                        </div>

                        <div class="card" style="border: 2px solid transparent; cursor: pointer;" id="path-lease" onclick="selectPath('lease')">
                            <div class="card-body" style="text-align: center;">
                                <div style="width: 64px; height: 64px; background: var(--eco-teal); border-radius: var(--radius-full); display: flex; align-items: center; justify-content: center; margin: 0 auto var(--space-md);">
                                    <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="var(--pure-white)" stroke-width="2">
                                        <path d="M12 1v22M17 5H9.5a3.5 3.5 0 100 7h5a3.5 3.5 0 110 7H6"/>
                                    </svg>
                                </div>
                                <h4>Lease-to-Own</h4>
                                <p style="font-size: 0.9375rem; color: var(--medium-gray);">Zero upfront cost. Pay monthly from your savings. Own the system after the lease period.</p>
                                <div style="font-family: var(--font-display); font-size: 1.5rem; font-weight: 700; color: var(--eco-teal); margin-top: var(--space-md);">RM 0</div>
                                <div style="font-size: 0.75rem; color: var(--medium-gray);">Upfront Cost</div>
                            </div>
                        </div>
                    </div>
                </div>

                <div id="payment-section" style="display: none; margin-top: var(--space-xl);">
                    <div class="card">
                        <div class="card-header">
                            <h4 style="margin: 0;">Pay Commitment Fee - RM 499</h4>
                        </div>
                        <div class="card-body">
                            <p style="margin-bottom: var(--space-lg);">This fee covers your site visit and professional drone survey. It will be deducted from your final system price.</p>

                            <div id="card-element" style="padding: var(--space-md); border: 2px solid rgba(10, 22, 40, 0.1); border-radius: var(--radius-md);"></div>
                            <div id="card-errors" class="form-error" style="margin-top: var(--space-sm);"></div>

                            <button type="button" class="btn btn-primary w-full" id="submit-payment" style="margin-top: var(--space-lg);">
                                Pay RM 499 & Book Site Visit
                            </button>
                        </div>
                    </div>
                </div>

                <div id="lease-section" style="display: none; margin-top: var(--space-xl);">
                    <div class="card">
                        <div class="card-header">
                            <h4 style="margin: 0;">Lease-to-Own Application</h4>
                        </div>
                        <div class="card-body">
                            <p style="margin-bottom: var(--space-lg);">Complete a quick eKYC verification to check your financing eligibility. This takes about 2 minutes.</p>

                            <a href="<?php echo esc_url(home_url('/lease-to-own/')); ?>" class="btn btn-primary w-full">
                                Start eKYC Verification
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M5 12h14M12 5l7 7-7 7"/>
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>

                <div style="display: flex; justify-content: space-between; align-items: center; margin-top: var(--space-xl);">
                    <button type="button" class="btn btn-outline" onclick="prevStep(3)">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M19 12H5M12 19l-7-7 7-7"/>
                        </svg>
                        Modify Quote
                    </button>
                    <a href="<?php echo esc_url(malaysia_solar_whatsapp_link('Hi! I just completed the solar quote calculator and would like to discuss my options.')); ?>" class="btn btn-ghost">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347"/>
                        </svg>
                        Need Help? WhatsApp Us
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<?php if ($stripe_pk): ?>
<script src="https://js.stripe.com/v3/"></script>
<script>
var stripe = Stripe('<?php echo esc_js($stripe_pk); ?>');
var elements = stripe.elements();
var cardElement = elements.create('card', {
    style: {
        base: {
            fontSize: '16px',
            color: '#0A1628',
            '::placeholder': { color: '#94A3B8' }
        }
    }
});
</script>
<?php endif; ?>

<?php get_footer(); ?>
