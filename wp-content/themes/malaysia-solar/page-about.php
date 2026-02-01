<?php
/**
 * Template Name: About Us
 * Company information, team, and track record
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
            <span>About Us</span>
        </div>
        <h1>Powering Malaysia's Solar Future</h1>
        <p style="color: var(--medium-gray); font-size: 1.125rem; margin-top: var(--space-md);">
            Trusted solar solutions since 2018
        </p>
    </div>
</section>

<!-- Company Introduction -->
<section class="section">
    <div class="container">
        <div class="about-intro">
            <div class="about-image" style="background: linear-gradient(135deg, var(--space-navy) 0%, var(--space-deep) 100%); display: flex; align-items: center; justify-content: center;">
                <svg width="200" height="150" viewBox="0 0 200 150" fill="none">
                    <rect x="20" y="30" width="160" height="90" rx="8" fill="#1A2B4A"/>
                    <g fill="#F7B32B" opacity="0.7">
                        <?php for ($row = 0; $row < 4; $row++): ?>
                            <?php for ($col = 0; $col < 8; $col++): ?>
                                <rect x="<?php echo 28 + ($col * 19); ?>" y="<?php echo 38 + ($row * 19); ?>" width="15" height="15" rx="2"/>
                            <?php endfor; ?>
                        <?php endfor; ?>
                    </g>
                    <circle cx="170" cy="25" r="20" fill="#F7B32B" opacity="0.8"/>
                </svg>
            </div>
            <div>
                <h2 style="margin-bottom: var(--space-lg);">Our Mission</h2>
                <p style="font-size: 1.125rem; color: var(--space-blue); margin-bottom: var(--space-lg);">
                    We believe every Malaysian home deserves access to clean, affordable solar energy.
                    Our mission is to make the transition to solar as simple and accessible as possible,
                    helping homeowners reduce their electricity bills while contributing to a sustainable future.
                </p>
                <p style="margin-bottom: var(--space-xl);">
                    Founded in 2018, Malaysia Solar has grown to become one of the leading solar installation
                    companies in the country. We've helped thousands of families make the switch to solar,
                    collectively saving millions in electricity costs and reducing carbon emissions.
                </p>

                <div class="about-stats">
                    <div class="stat-box">
                        <div class="value">5,000+</div>
                        <div class="label">Installations</div>
                    </div>
                    <div class="stat-box">
                        <div class="value">50 MW</div>
                        <div class="label">Capacity Installed</div>
                    </div>
                    <div class="stat-box">
                        <div class="value">98%</div>
                        <div class="label">Customer Satisfaction</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Why Choose Us -->
<section class="section" style="background: var(--soft-gray);">
    <div class="container">
        <div class="section-header">
            <span class="section-label">Why Choose Us</span>
            <h2 class="section-title">Our Commitment to Excellence</h2>
        </div>

        <div class="grid grid-3 gap-xl">
            <div class="feature-card">
                <div class="feature-icon">
                    <svg viewBox="0 0 24 24" fill="none">
                        <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z" stroke="currentColor" stroke-width="2"/>
                    </svg>
                </div>
                <h3 class="feature-title">Licensed & Certified</h3>
                <p class="feature-description">
                    SEDA licensed, CIDB registered, and fully insured. Our technicians are
                    certified by major panel manufacturers for proper installation.
                </p>
            </div>

            <div class="feature-card">
                <div class="feature-icon">
                    <svg viewBox="0 0 24 24" fill="none">
                        <circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="2"/>
                        <path d="M12 6v6l4 2" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                    </svg>
                </div>
                <h3 class="feature-title">Proven Track Record</h3>
                <p class="feature-description">
                    Over 5 years of experience and 5,000+ successful installations.
                    Our systems consistently perform above expectations.
                </p>
            </div>

            <div class="feature-card">
                <div class="feature-icon">
                    <svg viewBox="0 0 24 24" fill="none">
                        <path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2" stroke="currentColor" stroke-width="2"/>
                        <circle cx="9" cy="7" r="4" stroke="currentColor" stroke-width="2"/>
                        <path d="M23 21v-2a4 4 0 00-3-3.87M16 3.13a4 4 0 010 7.75" stroke="currentColor" stroke-width="2"/>
                    </svg>
                </div>
                <h3 class="feature-title">Dedicated Support</h3>
                <p class="feature-description">
                    Local team based in KL with nationwide coverage. We're always just
                    a call or WhatsApp away for any questions or support.
                </p>
            </div>

            <div class="feature-card">
                <div class="feature-icon">
                    <svg viewBox="0 0 24 24" fill="none">
                        <rect x="3" y="3" width="18" height="18" rx="2" stroke="currentColor" stroke-width="2"/>
                        <path d="M3 9h18M9 21V9" stroke="currentColor" stroke-width="2"/>
                    </svg>
                </div>
                <h3 class="feature-title">Premium Equipment</h3>
                <p class="feature-description">
                    We only use Tier-1 certified panels and inverters from trusted
                    manufacturers with proven reliability in tropical climates.
                </p>
            </div>

            <div class="feature-card">
                <div class="feature-icon">
                    <svg viewBox="0 0 24 24" fill="none">
                        <path d="M12 2v4M12 18v4M4.93 4.93l2.83 2.83M16.24 16.24l2.83 2.83M2 12h4M18 12h4" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                        <circle cx="12" cy="12" r="4" fill="currentColor"/>
                    </svg>
                </div>
                <h3 class="feature-title">Performance Guarantee</h3>
                <p class="feature-description">
                    We stand behind our work with comprehensive warranties and
                    a satisfaction guarantee on every installation.
                </p>
            </div>

            <div class="feature-card">
                <div class="feature-icon">
                    <svg viewBox="0 0 24 24" fill="none">
                        <path d="M12 1v22M17 5H9.5a3.5 3.5 0 100 7h5a3.5 3.5 0 110 7H6" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                    </svg>
                </div>
                <h3 class="feature-title">Flexible Financing</h3>
                <p class="feature-description">
                    Multiple payment options including lease-to-own with zero upfront
                    cost, bank financing, and cash purchase discounts.
                </p>
            </div>
        </div>
    </div>
</section>

<!-- Team Section -->
<section class="section">
    <div class="container">
        <div class="section-header">
            <span class="section-label">Our Team</span>
            <h2 class="section-title">Meet the Experts</h2>
            <p class="section-description">
                Our dedicated team of solar professionals is committed to delivering
                the best experience for every customer.
            </p>
        </div>

        <div class="team-grid">
            <div class="team-member">
                <div class="member-photo">AZ</div>
                <h4>Ahmad Zulkifli</h4>
                <p class="role">Founder & CEO</p>
                <p style="font-size: 0.875rem; color: var(--medium-gray); margin-top: var(--space-sm);">
                    15+ years in renewable energy. Former TNB engineer passionate about sustainable solutions.
                </p>
            </div>

            <div class="team-member">
                <div class="member-photo" style="background: var(--eco-teal);">SL</div>
                <h4>Sarah Lim</h4>
                <p class="role">Operations Director</p>
                <p style="font-size: 0.875rem; color: var(--medium-gray); margin-top: var(--space-sm);">
                    Oversees all installations and customer service. Expert in project management.
                </p>
            </div>

            <div class="team-member">
                <div class="member-photo" style="background: var(--space-blue);">RK</div>
                <h4>Rajan Kumar</h4>
                <p class="role">Technical Lead</p>
                <p style="font-size: 0.875rem; color: var(--medium-gray); margin-top: var(--space-sm);">
                    Certified solar engineer with 10+ years experience. Leads our installation team.
                </p>
            </div>

            <div class="team-member">
                <div class="member-photo" style="background: var(--solar-orange);">NA</div>
                <h4>Nurul Aisyah</h4>
                <p class="role">Customer Success Manager</p>
                <p style="font-size: 0.875rem; color: var(--medium-gray); margin-top: var(--space-sm);">
                    Ensures every customer has a smooth experience from quote to after-sales support.
                </p>
            </div>
        </div>
    </div>
</section>

<!-- Service Areas -->
<section class="section" style="background: var(--gradient-space);">
    <div class="container">
        <div class="section-header">
            <span class="section-label" style="background: rgba(247,179,43,0.2); color: var(--solar-gold);">Coverage</span>
            <h2 class="section-title" style="color: var(--pure-white);">We Serve All of Malaysia</h2>
            <p class="section-description" style="color: var(--medium-gray);">
                From Johor to Penang, our team covers all major states in Peninsular Malaysia.
            </p>
        </div>

        <div class="grid grid-4 gap-lg" style="margin-top: var(--space-xl);">
            <?php
            $states = array(
                'Kuala Lumpur & Selangor',
                'Johor',
                'Penang',
                'Perak',
                'Negeri Sembilan',
                'Melaka',
                'Pahang',
                'Kedah'
            );
            foreach ($states as $state):
            ?>
            <div style="background: rgba(255,255,255,0.05); border-radius: var(--radius-md); padding: var(--space-md); text-align: center;">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="var(--solar-gold)" stroke-width="2" style="margin-bottom: var(--space-sm);">
                    <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0118 0z"/>
                    <circle cx="12" cy="10" r="3"/>
                </svg>
                <p style="color: var(--pure-white); margin-bottom: 0; font-size: 0.9375rem;"><?php echo esc_html($state); ?></p>
            </div>
            <?php endforeach; ?>
        </div>

        <p style="text-align: center; color: var(--medium-gray); margin-top: var(--space-xl);">
            Don't see your area? Contact us - we're expanding coverage regularly!
        </p>
    </div>
</section>

<!-- CTA Section -->
<section class="cta-section section">
    <div class="container">
        <div class="cta-content">
            <h2>Ready to Join the Solar Revolution?</h2>
            <p>Get your free personalized quote today and start your journey to energy independence.</p>
            <div class="cta-buttons">
                <a href="<?php echo esc_url(home_url('/get-a-quote/')); ?>" class="btn btn-secondary btn-lg">
                    Get Free Quote
                </a>
                <a href="<?php echo esc_url(malaysia_solar_whatsapp_link('Hi! I would like to learn more about Malaysia Solar.')); ?>" class="btn btn-outline btn-lg" style="border-color: var(--space-deep); color: var(--space-deep);">
                    Chat With Us
                </a>
            </div>
        </div>
    </div>
</section>

<?php get_footer(); ?>
