<?php
/**
 * Template Name: Front Page
 * The main landing page template
 *
 * @package Malaysia_Solar
 */

get_header();
?>

<!-- Hero Section -->
<section class="hero">
    <div class="hero-grid"></div>
    <div class="container">
        <div class="hero-content">
            <span class="hero-badge">
                Malaysia's Trusted Solar Provider
            </span>
            <h1>Power Your Home with <span class="highlight">Clean Solar Energy</span></h1>
            <p class="hero-description">
                Save up to 80% on your electricity bills with government-approved solar systems.
                Join thousands of Malaysian homeowners who've already made the switch.
            </p>
            <div class="hero-cta">
                <a href="<?php echo esc_url(home_url('/get-a-quote/')); ?>" class="btn btn-primary btn-lg">
                    Get Free Quote
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M5 12h14M12 5l7 7-7 7"/>
                    </svg>
                </a>
                <a href="#calculator-preview" class="btn btn-secondary btn-lg">
                    Calculate Savings
                </a>
            </div>
            <div class="hero-stats">
                <div class="hero-stat">
                    <div class="hero-stat-value">5,000+</div>
                    <div class="hero-stat-label">Installations</div>
                </div>
                <div class="hero-stat">
                    <div class="hero-stat-value">RM 2M+</div>
                    <div class="hero-stat-label">Saved by Customers</div>
                </div>
                <div class="hero-stat">
                    <div class="hero-stat-value">25 Years</div>
                    <div class="hero-stat-label">Panel Warranty</div>
                </div>
            </div>
        </div>
        <div class="hero-visual">
            <div class="hero-solar-panel">
                <div class="solar-panel-3d">
                    <div class="panel-grid">
                        <?php for ($i = 0; $i < 24; $i++): ?>
                        <div class="panel-cell" style="--i: <?php echo $i; ?>"></div>
                        <?php endfor; ?>
                    </div>
                </div>
                <div class="sun-rays">
                    <div class="sun-core"></div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Features Section -->
<section class="features section">
    <div class="container">
        <div class="section-header">
            <span class="section-label">Why Choose Us</span>
            <h2 class="section-title">Malaysia's Premier Solar Solution</h2>
            <p class="section-description">
                We provide end-to-end solar solutions with certified products, professional installation,
                and ongoing support to maximize your energy savings.
            </p>
        </div>

        <div class="grid grid-4 gap-xl">
            <div class="feature-card">
                <div class="feature-icon">
                    <svg viewBox="0 0 24 24" fill="none">
                        <path d="M12 2v4M12 18v4M4.93 4.93l2.83 2.83M16.24 16.24l2.83 2.83M2 12h4M18 12h4M4.93 19.07l2.83-2.83M16.24 7.76l2.83-2.83" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                        <circle cx="12" cy="12" r="4" fill="currentColor"/>
                    </svg>
                </div>
                <h3 class="feature-title">Premium Panels</h3>
                <p class="feature-description">Tier-1 solar panels with 25-year warranty and proven reliability in tropical climates.</p>
            </div>

            <div class="feature-card">
                <div class="feature-icon">
                    <svg viewBox="0 0 24 24" fill="none">
                        <rect x="2" y="6" width="20" height="12" rx="2" stroke="currentColor" stroke-width="2"/>
                        <path d="M6 10v4M10 10v4M14 10v4M18 10v4" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                    </svg>
                </div>
                <h3 class="feature-title">NEM Certified</h3>
                <p class="feature-description">Fully compliant with NEM 3.0 program. Sell excess energy back to TNB at 1:1 offset.</p>
            </div>

            <div class="feature-card">
                <div class="feature-icon">
                    <svg viewBox="0 0 24 24" fill="none">
                        <path d="M12 1v22M17 5H9.5a3.5 3.5 0 100 7h5a3.5 3.5 0 110 7H6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </div>
                <h3 class="feature-title">Zero Upfront</h3>
                <p class="feature-description">Lease-to-own option available. Start saving immediately with no initial investment.</p>
            </div>

            <div class="feature-card">
                <div class="feature-icon">
                    <svg viewBox="0 0 24 24" fill="none">
                        <path d="M22 11.08V12a10 10 0 11-5.93-9.14" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                        <polyline points="22,4 12,14.01 9,11.01" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </div>
                <h3 class="feature-title">Expert Install</h3>
                <p class="feature-description">Certified technicians handle everything from mounting to grid connection in 1-2 days.</p>
            </div>
        </div>
    </div>
</section>

<!-- Government Programs Section -->
<section class="programs section">
    <div class="container">
        <div class="section-header">
            <span class="section-label">Government Programs</span>
            <h2 class="section-title">Take Advantage of Solar Incentives</h2>
            <p class="section-description">
                Malaysia offers attractive programs to make solar energy more accessible and affordable for homeowners.
            </p>
        </div>

        <div class="program-grid">
            <div class="program-card">
                <span class="program-badge">Net Energy Metering</span>
                <h3 class="program-title">NEM 3.0 Program</h3>
                <p class="program-description">
                    The Net Energy Metering program allows you to export excess solar energy to the grid
                    and offset your electricity bill at a 1:1 ratio.
                </p>
                <ul class="program-features">
                    <li>Sell excess energy back to TNB</li>
                    <li>1:1 energy offset ratio</li>
                    <li>Reduce bills by up to 90%</li>
                    <li>No battery storage needed</li>
                    <li>25-year program guarantee</li>
                </ul>
                <a href="<?php echo esc_url(home_url('/get-a-quote/')); ?>" class="btn btn-primary">
                    Apply for NEM
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M5 12h14M12 5l7 7-7 7"/>
                    </svg>
                </a>
            </div>

            <div class="program-card">
                <span class="program-badge">Solar Industry Scheme</span>
                <h3 class="program-title">SolaRIS Initiative</h3>
                <p class="program-description">
                    The Solar Renewable Industry Scheme promotes solar adoption with various incentives,
                    tax benefits, and financing options.
                </p>
                <ul class="program-features">
                    <li>Green technology tax incentives</li>
                    <li>Preferential financing rates</li>
                    <li>Fast-track approval process</li>
                    <li>Quality assurance standards</li>
                    <li>Local manufacturing support</li>
                </ul>
                <a href="<?php echo esc_url(home_url('/get-a-quote/')); ?>" class="btn btn-primary">
                    Learn More
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M5 12h14M12 5l7 7-7 7"/>
                    </svg>
                </a>
            </div>
        </div>
    </div>
</section>

<!-- Calculator Preview Section -->
<section class="calculator-preview section" id="calculator-preview">
    <div class="container">
        <div class="calculator-content">
            <div class="calculator-info">
                <span class="section-label">ROI Calculator</span>
                <h2 class="section-title">See How Much You Can Save</h2>
                <p class="section-description" style="color: var(--medium-gray);">
                    Our intelligent solar calculator analyzes your roof, location, and energy usage
                    to recommend the perfect system size and show your potential savings.
                </p>

                <div class="calculator-steps">
                    <div class="calc-step">
                        <div class="step-number">1</div>
                        <div class="step-content">
                            <h4>Enter Your TNB Bill</h4>
                            <p>Tell us your average monthly electricity bill amount</p>
                        </div>
                    </div>
                    <div class="calc-step">
                        <div class="step-number">2</div>
                        <div class="step-content">
                            <h4>Draw Your Roof</h4>
                            <p>Use our interactive map to outline your roof area</p>
                        </div>
                    </div>
                    <div class="calc-step">
                        <div class="step-number">3</div>
                        <div class="step-content">
                            <h4>Get Your Quote</h4>
                            <p>Receive personalized system recommendation and savings</p>
                        </div>
                    </div>
                </div>

                <a href="<?php echo esc_url(home_url('/get-a-quote/')); ?>" class="btn btn-primary btn-lg" style="margin-top: var(--space-xl);">
                    Start Calculator
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M5 12h14M12 5l7 7-7 7"/>
                    </svg>
                </a>
            </div>

            <div class="calculator-demo">
                <div class="demo-header">
                    <span class="demo-dot red"></span>
                    <span class="demo-dot yellow"></span>
                    <span class="demo-dot green"></span>
                </div>

                <div class="demo-input-group">
                    <label class="demo-label">Monthly TNB Bill (RM)</label>
                    <input type="number" class="demo-input" id="demo-bill" placeholder="e.g., 500" value="500">
                </div>

                <div class="demo-result" id="demo-result">
                    <div class="demo-savings" id="demo-savings">RM 400</div>
                    <div class="demo-savings-label">Estimated Monthly Savings</div>
                </div>

                <div style="margin-top: var(--space-lg); display: grid; grid-template-columns: 1fr 1fr; gap: var(--space-md);">
                    <div style="text-align: center; padding: var(--space-md); background: var(--soft-gray); border-radius: var(--radius-md);">
                        <div style="font-family: var(--font-display); font-size: 1.5rem; font-weight: 700; color: var(--space-deep);" id="demo-system">5kW</div>
                        <div style="font-size: 0.75rem; color: var(--medium-gray);">Recommended System</div>
                    </div>
                    <div style="text-align: center; padding: var(--space-md); background: var(--soft-gray); border-radius: var(--radius-md);">
                        <div style="font-family: var(--font-display); font-size: 1.5rem; font-weight: 700; color: var(--eco-green);" id="demo-roi">4.5 yrs</div>
                        <div style="font-size: 0.75rem; color: var(--medium-gray);">ROI Period</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Products Preview -->
<section class="section" style="background: var(--soft-gray);">
    <div class="container">
        <div class="section-header">
            <span class="section-label">Our Products</span>
            <h2 class="section-title">Solar System Packages</h2>
            <p class="section-description">
                Choose the right system size for your home. All packages include premium Tier-1 panels,
                inverter, mounting, and professional installation.
            </p>
        </div>

        <?php echo do_shortcode('[solar_products count="4"]'); ?>

        <div style="text-align: center; margin-top: var(--space-2xl);">
            <a href="<?php echo esc_url(home_url('/solar-products/')); ?>" class="btn btn-secondary">
                View All Products
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M5 12h14M12 5l7 7-7 7"/>
                </svg>
            </a>
        </div>
    </div>
</section>

<!-- Case Studies Preview -->
<section class="section">
    <div class="container">
        <div class="section-header">
            <span class="section-label">Success Stories</span>
            <h2 class="section-title">Real Results from Real Homes</h2>
            <p class="section-description">
                See how homeowners across Malaysia are benefiting from their solar installations.
            </p>
        </div>

        <div class="grid grid-3 gap-xl">
            <div class="card">
                <div class="product-image" style="aspect-ratio: 16/9;">
                    <div style="display: flex; flex-direction: column; align-items: center; justify-content: center; height: 100%;">
                        <div style="font-family: var(--font-display); font-size: 3rem; font-weight: 700; color: var(--solar-gold);">78%</div>
                        <div style="color: var(--pure-white); font-size: 0.875rem;">Bill Reduction</div>
                    </div>
                </div>
                <div class="card-body">
                    <h4 style="margin-bottom: var(--space-sm);">Semi-D in Petaling Jaya</h4>
                    <p style="font-size: 0.9375rem; margin-bottom: var(--space-md);">5kW system installed. Monthly bill reduced from RM650 to RM145.</p>
                    <div style="display: flex; justify-content: space-between; font-size: 0.875rem; color: var(--medium-gray);">
                        <span>System: 5kW</span>
                        <span>Savings: RM505/mo</span>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="product-image" style="aspect-ratio: 16/9;">
                    <div style="display: flex; flex-direction: column; align-items: center; justify-content: center; height: 100%;">
                        <div style="font-family: var(--font-display); font-size: 3rem; font-weight: 700; color: var(--solar-gold);">85%</div>
                        <div style="color: var(--pure-white); font-size: 0.875rem;">Bill Reduction</div>
                    </div>
                </div>
                <div class="card-body">
                    <h4 style="margin-bottom: var(--space-sm);">Bungalow in Shah Alam</h4>
                    <p style="font-size: 0.9375rem; margin-bottom: var(--space-md);">10kW system with battery backup. Nearly energy independent.</p>
                    <div style="display: flex; justify-content: space-between; font-size: 0.875rem; color: var(--medium-gray);">
                        <span>System: 10kW</span>
                        <span>Savings: RM890/mo</span>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="product-image" style="aspect-ratio: 16/9;">
                    <div style="display: flex; flex-direction: column; align-items: center; justify-content: center; height: 100%;">
                        <div style="font-family: var(--font-display); font-size: 3rem; font-weight: 700; color: var(--solar-gold);">65%</div>
                        <div style="color: var(--pure-white); font-size: 0.875rem;">Bill Reduction</div>
                    </div>
                </div>
                <div class="card-body">
                    <h4 style="margin-bottom: var(--space-sm);">Terrace in Johor Bahru</h4>
                    <p style="font-size: 0.9375rem; margin-bottom: var(--space-md);">3kW system perfect for smaller home. Quick 4-year payback.</p>
                    <div style="display: flex; justify-content: space-between; font-size: 0.875rem; color: var(--medium-gray);">
                        <span>System: 3kW</span>
                        <span>Savings: RM280/mo</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Testimonials -->
<section class="testimonials section">
    <div class="container">
        <div class="section-header">
            <span class="section-label">Customer Reviews</span>
            <h2 class="section-title">What Our Customers Say</h2>
            <p class="section-description">
                Don't just take our word for it. Here's what homeowners say about their experience.
            </p>
        </div>

        <div class="testimonials-slider">
            <div class="testimonial-card">
                <div class="testimonial-rating">
                    <?php for ($i = 0; $i < 5; $i++): ?>
                    <svg class="star" viewBox="0 0 24 24"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                    <?php endfor; ?>
                </div>
                <p class="testimonial-text">"The installation was quick and professional. My TNB bill dropped from RM800 to just RM120 the very first month. Best investment for my home!"</p>
                <div class="testimonial-author">
                    <div class="author-avatar">A</div>
                    <div class="author-info">
                        <h4>Ahmad Rahman</h4>
                        <p>Subang Jaya • 7kW System</p>
                    </div>
                </div>
            </div>

            <div class="testimonial-card">
                <div class="testimonial-rating">
                    <?php for ($i = 0; $i < 5; $i++): ?>
                    <svg class="star" viewBox="0 0 24 24"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                    <?php endfor; ?>
                </div>
                <p class="testimonial-text">"I was skeptical at first, but the team explained everything clearly. The lease-to-own option meant zero upfront cost, and I'm already saving money!"</p>
                <div class="testimonial-author">
                    <div class="author-avatar">S</div>
                    <div class="author-info">
                        <h4>Sarah Tan</h4>
                        <p>Puchong • 5kW System</p>
                    </div>
                </div>
            </div>

            <div class="testimonial-card">
                <div class="testimonial-rating">
                    <?php for ($i = 0; $i < 5; $i++): ?>
                    <svg class="star" viewBox="0 0 24 24"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                    <?php endfor; ?>
                </div>
                <p class="testimonial-text">"Professional team from quote to installation. They handled all the NEM paperwork and TNB coordination. Highly recommend for hassle-free experience!"</p>
                <div class="testimonial-author">
                    <div class="author-avatar">R</div>
                    <div class="author-info">
                        <h4>Rajan Kumar</h4>
                        <p>Klang • 10kW System</p>
                    </div>
                </div>
            </div>

            <div class="testimonial-card">
                <div class="testimonial-rating">
                    <?php for ($i = 0; $i < 5; $i++): ?>
                    <svg class="star" viewBox="0 0 24 24"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                    <?php endfor; ?>
                </div>
                <p class="testimonial-text">"Great after-sales support! When I had questions about my monitoring app, they responded within hours. The system performance has exceeded expectations."</p>
                <div class="testimonial-author">
                    <div class="author-avatar">L</div>
                    <div class="author-info">
                        <h4>Lee Wei Ming</h4>
                        <p>Ipoh • 5kW System</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="cta-section section">
    <div class="container">
        <div class="cta-content">
            <h2>Ready to Start Saving?</h2>
            <p>Get your personalized solar quote in just 3 minutes. Our team will guide you through the entire process.</p>
            <div class="cta-buttons">
                <a href="<?php echo esc_url(home_url('/get-a-quote/')); ?>" class="btn btn-secondary btn-lg">
                    Get Free Quote
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M5 12h14M12 5l7 7-7 7"/>
                    </svg>
                </a>
                <a href="<?php echo esc_url(malaysia_solar_whatsapp_link('Hi! I would like to know more about solar panels for my home.')); ?>" class="btn btn-outline btn-lg" style="border-color: var(--space-deep); color: var(--space-deep);">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                    </svg>
                    WhatsApp Us
                </a>
            </div>
        </div>
    </div>
</section>

<script>
// Demo Calculator Preview
document.addEventListener('DOMContentLoaded', function() {
    const demoBill = document.getElementById('demo-bill');
    const demoSavings = document.getElementById('demo-savings');
    const demoSystem = document.getElementById('demo-system');
    const demoRoi = document.getElementById('demo-roi');

    if (demoBill) {
        demoBill.addEventListener('input', function() {
            const bill = parseFloat(this.value) || 0;

            // Calculate recommended system and savings
            let systemSize, price, savingsPercent;
            if (bill < 300) {
                systemSize = 3;
                price = 15000;
                savingsPercent = 0.65;
            } else if (bill < 500) {
                systemSize = 5;
                price = 22000;
                savingsPercent = 0.75;
            } else if (bill < 800) {
                systemSize = 7;
                price = 30000;
                savingsPercent = 0.80;
            } else {
                systemSize = 10;
                price = 40000;
                savingsPercent = 0.85;
            }

            const monthlySavings = bill * savingsPercent;
            const roiYears = price / (monthlySavings * 12);

            demoSavings.textContent = 'RM ' + Math.round(monthlySavings).toLocaleString();
            demoSystem.textContent = systemSize + 'kW';
            demoRoi.textContent = roiYears.toFixed(1) + ' yrs';
        });
    }
});
</script>

<?php get_footer(); ?>
