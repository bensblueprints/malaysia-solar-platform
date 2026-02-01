<?php
/**
 * Template Name: Solar Products
 * E-Commerce page with system packages
 *
 * @package Malaysia_Solar
 */

get_header();
?>

<!-- Page Header -->
<section class="page-header">
    <div class="container">
        <div class="breadcrumb">
            <a href="<?php echo esc_url(home_url('/')); ?>">Home</a>
            <span>/</span>
            <span>Solar Products</span>
        </div>
        <h1>Solar System Packages</h1>
        <p style="color: var(--medium-gray); font-size: 1.125rem; margin-top: var(--space-md);">
            Premium Tier-1 solar systems with professional installation and comprehensive warranties
        </p>
    </div>
</section>

<!-- Products Grid -->
<section class="section">
    <div class="container">
        <div class="grid grid-4 gap-xl">
            <!-- 3kW System -->
            <div class="product-card">
                <div class="product-image">
                    <svg width="120" height="80" viewBox="0 0 120 80" fill="none">
                        <rect x="10" y="10" width="100" height="60" rx="4" fill="#1A2B4A"/>
                        <g fill="#F7B32B" opacity="0.6">
                            <rect x="15" y="15" width="18" height="12" rx="1"/>
                            <rect x="36" y="15" width="18" height="12" rx="1"/>
                            <rect x="57" y="15" width="18" height="12" rx="1"/>
                            <rect x="15" y="30" width="18" height="12" rx="1"/>
                            <rect x="36" y="30" width="18" height="12" rx="1"/>
                            <rect x="57" y="30" width="18" height="12" rx="1"/>
                            <rect x="15" y="45" width="18" height="12" rx="1"/>
                        </g>
                    </svg>
                    <span class="product-badge">3kW</span>
                </div>
                <div class="product-content">
                    <h3 class="product-title">Starter Solar System</h3>
                    <p style="color: var(--medium-gray); font-size: 0.875rem; margin-bottom: var(--space-md);">
                        Perfect for small homes and apartments
                    </p>
                    <ul class="product-specs">
                        <li><span class="spec-label">System Size</span><span class="spec-value">3 kW</span></li>
                        <li><span class="spec-label">Panels</span><span class="spec-value">7 panels</span></li>
                        <li><span class="spec-label">Roof Space</span><span class="spec-value">~15 sqm</span></li>
                        <li><span class="spec-label">Monthly Savings</span><span class="spec-value">RM 180-240</span></li>
                        <li><span class="spec-label">Panel Warranty</span><span class="spec-value">25 Years</span></li>
                    </ul>
                    <div class="product-price">
                        <span class="price-amount">RM 15,000</span>
                    </div>
                    <a href="<?php echo esc_url(home_url('/get-a-quote/?system=3')); ?>" class="btn btn-primary w-full">Get Quote</a>
                </div>
            </div>

            <!-- 5kW System -->
            <div class="product-card" style="border: 2px solid var(--solar-amber);">
                <div class="product-image" style="position: relative;">
                    <div style="position: absolute; top: var(--space-md); right: var(--space-md); background: var(--solar-amber); color: var(--space-deep); padding: 4px 12px; border-radius: var(--radius-full); font-size: 0.75rem; font-weight: 700;">MOST POPULAR</div>
                    <svg width="120" height="80" viewBox="0 0 120 80" fill="none">
                        <rect x="10" y="10" width="100" height="60" rx="4" fill="#1A2B4A"/>
                        <g fill="#F7B32B" opacity="0.8">
                            <rect x="15" y="15" width="18" height="12" rx="1"/>
                            <rect x="36" y="15" width="18" height="12" rx="1"/>
                            <rect x="57" y="15" width="18" height="12" rx="1"/>
                            <rect x="78" y="15" width="18" height="12" rx="1"/>
                            <rect x="15" y="30" width="18" height="12" rx="1"/>
                            <rect x="36" y="30" width="18" height="12" rx="1"/>
                            <rect x="57" y="30" width="18" height="12" rx="1"/>
                            <rect x="78" y="30" width="18" height="12" rx="1"/>
                            <rect x="15" y="45" width="18" height="12" rx="1"/>
                            <rect x="36" y="45" width="18" height="12" rx="1"/>
                            <rect x="57" y="45" width="18" height="12" rx="1"/>
                            <rect x="78" y="45" width="18" height="12" rx="1"/>
                        </g>
                    </svg>
                    <span class="product-badge">5kW</span>
                </div>
                <div class="product-content">
                    <h3 class="product-title">Home Solar System</h3>
                    <p style="color: var(--medium-gray); font-size: 0.875rem; margin-bottom: var(--space-md);">
                        Ideal for most Malaysian households
                    </p>
                    <ul class="product-specs">
                        <li><span class="spec-label">System Size</span><span class="spec-value">5 kW</span></li>
                        <li><span class="spec-label">Panels</span><span class="spec-value">12 panels</span></li>
                        <li><span class="spec-label">Roof Space</span><span class="spec-value">~25 sqm</span></li>
                        <li><span class="spec-label">Monthly Savings</span><span class="spec-value">RM 350-420</span></li>
                        <li><span class="spec-label">Panel Warranty</span><span class="spec-value">25 Years</span></li>
                    </ul>
                    <div class="product-price">
                        <span class="price-amount">RM 22,000</span>
                    </div>
                    <a href="<?php echo esc_url(home_url('/get-a-quote/?system=5')); ?>" class="btn btn-primary w-full">Get Quote</a>
                </div>
            </div>

            <!-- 7kW System -->
            <div class="product-card">
                <div class="product-image">
                    <svg width="120" height="80" viewBox="0 0 120 80" fill="none">
                        <rect x="5" y="5" width="110" height="70" rx="4" fill="#1A2B4A"/>
                        <g fill="#F7B32B" opacity="0.7">
                            <rect x="10" y="10" width="15" height="10" rx="1"/>
                            <rect x="28" y="10" width="15" height="10" rx="1"/>
                            <rect x="46" y="10" width="15" height="10" rx="1"/>
                            <rect x="64" y="10" width="15" height="10" rx="1"/>
                            <rect x="82" y="10" width="15" height="10" rx="1"/>
                            <rect x="10" y="23" width="15" height="10" rx="1"/>
                            <rect x="28" y="23" width="15" height="10" rx="1"/>
                            <rect x="46" y="23" width="15" height="10" rx="1"/>
                            <rect x="64" y="23" width="15" height="10" rx="1"/>
                            <rect x="82" y="23" width="15" height="10" rx="1"/>
                            <rect x="10" y="36" width="15" height="10" rx="1"/>
                            <rect x="28" y="36" width="15" height="10" rx="1"/>
                            <rect x="46" y="36" width="15" height="10" rx="1"/>
                            <rect x="64" y="36" width="15" height="10" rx="1"/>
                            <rect x="82" y="36" width="15" height="10" rx="1"/>
                            <rect x="10" y="49" width="15" height="10" rx="1"/>
                        </g>
                    </svg>
                    <span class="product-badge">7kW</span>
                </div>
                <div class="product-content">
                    <h3 class="product-title">Premium Solar System</h3>
                    <p style="color: var(--medium-gray); font-size: 0.875rem; margin-bottom: var(--space-md);">
                        Great for larger families and semi-Ds
                    </p>
                    <ul class="product-specs">
                        <li><span class="spec-label">System Size</span><span class="spec-value">7 kW</span></li>
                        <li><span class="spec-label">Panels</span><span class="spec-value">16 panels</span></li>
                        <li><span class="spec-label">Roof Space</span><span class="spec-value">~35 sqm</span></li>
                        <li><span class="spec-label">Monthly Savings</span><span class="spec-value">RM 500-600</span></li>
                        <li><span class="spec-label">Panel Warranty</span><span class="spec-value">25 Years</span></li>
                    </ul>
                    <div class="product-price">
                        <span class="price-amount">RM 30,000</span>
                    </div>
                    <a href="<?php echo esc_url(home_url('/get-a-quote/?system=7')); ?>" class="btn btn-primary w-full">Get Quote</a>
                </div>
            </div>

            <!-- 10kW System -->
            <div class="product-card">
                <div class="product-image">
                    <svg width="120" height="80" viewBox="0 0 120 80" fill="none">
                        <rect x="5" y="5" width="110" height="70" rx="4" fill="#1A2B4A"/>
                        <g fill="#F7B32B" opacity="0.8">
                            <rect x="10" y="10" width="12" height="8" rx="1"/>
                            <rect x="25" y="10" width="12" height="8" rx="1"/>
                            <rect x="40" y="10" width="12" height="8" rx="1"/>
                            <rect x="55" y="10" width="12" height="8" rx="1"/>
                            <rect x="70" y="10" width="12" height="8" rx="1"/>
                            <rect x="85" y="10" width="12" height="8" rx="1"/>
                            <rect x="10" y="21" width="12" height="8" rx="1"/>
                            <rect x="25" y="21" width="12" height="8" rx="1"/>
                            <rect x="40" y="21" width="12" height="8" rx="1"/>
                            <rect x="55" y="21" width="12" height="8" rx="1"/>
                            <rect x="70" y="21" width="12" height="8" rx="1"/>
                            <rect x="85" y="21" width="12" height="8" rx="1"/>
                            <rect x="10" y="32" width="12" height="8" rx="1"/>
                            <rect x="25" y="32" width="12" height="8" rx="1"/>
                            <rect x="40" y="32" width="12" height="8" rx="1"/>
                            <rect x="55" y="32" width="12" height="8" rx="1"/>
                            <rect x="70" y="32" width="12" height="8" rx="1"/>
                            <rect x="85" y="32" width="12" height="8" rx="1"/>
                            <rect x="10" y="43" width="12" height="8" rx="1"/>
                            <rect x="25" y="43" width="12" height="8" rx="1"/>
                            <rect x="40" y="43" width="12" height="8" rx="1"/>
                            <rect x="55" y="43" width="12" height="8" rx="1"/>
                            <rect x="70" y="43" width="12" height="8" rx="1"/>
                            <rect x="85" y="43" width="12" height="8" rx="1"/>
                        </g>
                    </svg>
                    <span class="product-badge">10kW</span>
                </div>
                <div class="product-content">
                    <h3 class="product-title">Max Solar System</h3>
                    <p style="color: var(--medium-gray); font-size: 0.875rem; margin-bottom: var(--space-md);">
                        For bungalows and high-usage homes
                    </p>
                    <ul class="product-specs">
                        <li><span class="spec-label">System Size</span><span class="spec-value">10 kW</span></li>
                        <li><span class="spec-label">Panels</span><span class="spec-value">24 panels</span></li>
                        <li><span class="spec-label">Roof Space</span><span class="spec-value">~50 sqm</span></li>
                        <li><span class="spec-label">Monthly Savings</span><span class="spec-value">RM 700-850</span></li>
                        <li><span class="spec-label">Panel Warranty</span><span class="spec-value">25 Years</span></li>
                    </ul>
                    <div class="product-price">
                        <span class="price-amount">RM 40,000</span>
                    </div>
                    <a href="<?php echo esc_url(home_url('/get-a-quote/?system=10')); ?>" class="btn btn-primary w-full">Get Quote</a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- What's Included -->
<section class="section" style="background: var(--soft-gray);">
    <div class="container">
        <div class="section-header">
            <span class="section-label">All Packages Include</span>
            <h2 class="section-title">Complete Solar Solution</h2>
        </div>

        <div class="grid grid-3 gap-xl">
            <div class="feature-card">
                <div class="feature-icon">
                    <svg viewBox="0 0 24 24" fill="none">
                        <rect x="3" y="3" width="18" height="18" rx="2" stroke="currentColor" stroke-width="2"/>
                        <path d="M3 9h18M9 21V9" stroke="currentColor" stroke-width="2"/>
                    </svg>
                </div>
                <h3 class="feature-title">Tier-1 Solar Panels</h3>
                <p class="feature-description">Premium monocrystalline PERC panels from top manufacturers like LONGi and JA Solar with 25-year warranty.</p>
            </div>

            <div class="feature-card">
                <div class="feature-icon">
                    <svg viewBox="0 0 24 24" fill="none">
                        <rect x="2" y="6" width="20" height="12" rx="2" stroke="currentColor" stroke-width="2"/>
                        <path d="M6 10v4M10 10v4M14 10v4M18 10v4" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                    </svg>
                </div>
                <h3 class="feature-title">Quality Inverter</h3>
                <p class="feature-description">Huawei, Solis, or Growatt inverters with smart monitoring app and 10-year manufacturer warranty.</p>
            </div>

            <div class="feature-card">
                <div class="feature-icon">
                    <svg viewBox="0 0 24 24" fill="none">
                        <path d="M14.7 6.3a1 1 0 000 1.4l1.6 1.6a1 1 0 001.4 0l3.77-3.77a6 6 0 01-7.94 7.94l-6.91 6.91a2.12 2.12 0 01-3-3l6.91-6.91a6 6 0 017.94-7.94l-3.76 3.76z" stroke="currentColor" stroke-width="2"/>
                    </svg>
                </div>
                <h3 class="feature-title">Professional Installation</h3>
                <p class="feature-description">Certified technicians handle everything from structural assessment to final commissioning in 1-2 days.</p>
            </div>

            <div class="feature-card">
                <div class="feature-icon">
                    <svg viewBox="0 0 24 24" fill="none">
                        <path d="M9 12l2 2 4-4" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M21 12c0 1.66-4 3-9 3s-9-1.34-9-3" stroke="currentColor" stroke-width="2"/>
                        <path d="M3 5v14c0 1.66 4 3 9 3s9-1.34 9-3V5" stroke="currentColor" stroke-width="2"/>
                        <path d="M21 5c0 1.66-4 3-9 3S3 6.66 3 5s4-3 9-3 9 1.34 9 3" stroke="currentColor" stroke-width="2"/>
                    </svg>
                </div>
                <h3 class="feature-title">NEM Application</h3>
                <p class="feature-description">We handle all TNB paperwork, meter installation coordination, and NEM approval process for you.</p>
            </div>

            <div class="feature-card">
                <div class="feature-icon">
                    <svg viewBox="0 0 24 24" fill="none">
                        <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z" stroke="currentColor" stroke-width="2"/>
                        <path d="M9 12l2 2 4-4" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </div>
                <h3 class="feature-title">Comprehensive Warranty</h3>
                <p class="feature-description">25-year panel warranty, 10-year inverter warranty, and 5-year workmanship guarantee.</p>
            </div>

            <div class="feature-card">
                <div class="feature-icon">
                    <svg viewBox="0 0 24 24" fill="none">
                        <path d="M12 2v4M12 18v4M4.93 4.93l2.83 2.83M16.24 16.24l2.83 2.83M2 12h4M18 12h4M4.93 19.07l2.83-2.83M16.24 7.76l2.83-2.83" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                    </svg>
                </div>
                <h3 class="feature-title">5-Year Maintenance</h3>
                <p class="feature-description">Free maintenance and monitoring for 5 years including annual inspections and panel cleaning.</p>
            </div>
        </div>
    </div>
</section>

<!-- Commitment Fee Info -->
<section class="section">
    <div class="container container-narrow">
        <div class="card" style="text-align: center; padding: var(--space-2xl);">
            <h3 style="margin-bottom: var(--space-md);">How Our Process Works</h3>
            <p style="color: var(--medium-gray); margin-bottom: var(--space-xl);">
                Get started with a small commitment fee that's deducted from your final price
            </p>

            <div style="display: flex; justify-content: center; gap: var(--space-2xl); flex-wrap: wrap; margin-bottom: var(--space-xl);">
                <div style="text-align: center;">
                    <div style="width: 64px; height: 64px; background: var(--gradient-solar); border-radius: var(--radius-full); display: flex; align-items: center; justify-content: center; margin: 0 auto var(--space-md); font-family: var(--font-display); font-size: 1.5rem; font-weight: 700;">1</div>
                    <h4 style="font-size: 1rem; margin-bottom: var(--space-xs);">Get Quote</h4>
                    <p style="font-size: 0.875rem; color: var(--medium-gray);">Use our calculator</p>
                </div>
                <div style="text-align: center;">
                    <div style="width: 64px; height: 64px; background: var(--gradient-solar); border-radius: var(--radius-full); display: flex; align-items: center; justify-content: center; margin: 0 auto var(--space-md); font-family: var(--font-display); font-size: 1.5rem; font-weight: 700;">2</div>
                    <h4 style="font-size: 1rem; margin-bottom: var(--space-xs);">Pay RM 499</h4>
                    <p style="font-size: 0.875rem; color: var(--medium-gray);">Commitment fee</p>
                </div>
                <div style="text-align: center;">
                    <div style="width: 64px; height: 64px; background: var(--gradient-solar); border-radius: var(--radius-full); display: flex; align-items: center; justify-content: center; margin: 0 auto var(--space-md); font-family: var(--font-display); font-size: 1.5rem; font-weight: 700;">3</div>
                    <h4 style="font-size: 1rem; margin-bottom: var(--space-xs);">Site Survey</h4>
                    <p style="font-size: 0.875rem; color: var(--medium-gray);">+ Drone assessment</p>
                </div>
                <div style="text-align: center;">
                    <div style="width: 64px; height: 64px; background: var(--gradient-solar); border-radius: var(--radius-full); display: flex; align-items: center; justify-content: center; margin: 0 auto var(--space-md); font-family: var(--font-display); font-size: 1.5rem; font-weight: 700;">4</div>
                    <h4 style="font-size: 1rem; margin-bottom: var(--space-xs);">Final Proposal</h4>
                    <p style="font-size: 0.875rem; color: var(--medium-gray);">RM 499 deducted</p>
                </div>
            </div>

            <a href="<?php echo esc_url(home_url('/get-a-quote/')); ?>" class="btn btn-primary btn-lg">
                Start Your Solar Journey
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M5 12h14M12 5l7 7-7 7"/>
                </svg>
            </a>
        </div>
    </div>
</section>

<?php get_footer(); ?>
