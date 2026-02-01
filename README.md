# Malaysia Solar Platform

A premium WordPress theme for a Malaysian solar energy company, featuring an interactive solar calculator, e-commerce functionality, and CRM integration.

## Features

### 1. Landing Page
- Professional, mobile-responsive design
- Solar programs overview (NEM, SolaRIS)
- ROI calculator preview
- Customer testimonials
- Clear CTAs for quote generation

### 2. Solar Calculator (`/get-a-quote/`)
- Multi-step quote wizard
- Google Maps API integration with satellite view
- Interactive roof drawing tool
- Dynamic system recommendations (3kW, 5kW, 7kW, 10kW)
- Automatic savings and ROI calculator
- Qualification questions
- Buy System OR Lease-to-Own pathways

### 3. E-Commerce (`/solar-products/`)
- Product listing with system packages (RM15,000 - RM40,000)
- Warranty and T&C display
- RM499 commitment fee collection
- Stripe payment integration
- Project timeline display

### 4. Lease-to-Own (`/lease-to-own/`)
- Zero Capex financing option
- eKYC eligibility checker
- Pre-qualification workflow

### 5. About Us (`/about-us/`)
- Company introduction
- Team showcase
- Service locations

### 6. AI Chatbot
- RAG-powered knowledge base
- Floating widget on all pages
- Solar policy, contracts, equipment Q&A

## Theme Setup

### Requirements
- WordPress 6.0+
- PHP 8.0+
- MySQL 5.7+ or MariaDB 10.3+

### Installation

1. Upload the `malaysia-solar` theme folder to `/wp-content/themes/`
2. Activate the theme in WordPress Admin > Appearance > Themes
3. Configure settings in WordPress Admin > Solar Settings

### Configuration

Navigate to **Solar Settings** in the WordPress admin panel to configure:

- **Google Maps API Key** - For map and satellite view
- **Google Solar API Key** - For solar potential analysis
- **GoHighLevel Webhook URL** - For CRM integration
- **Stripe Keys** - For payment processing
- **WhatsApp Number** - For customer communication

### Required Pages

The theme automatically creates these pages on activation:
- Get A Quote
- Solar Products
- Lease to Own
- About Us
- Checkout

## CRM Integration (GoHighLevel)

### Pipeline Stages
1. New Lead - Form submission
2. Pre-Qualified - Calculator completed
3. Quote Generated - System recommendation
4. Commitment Payment - RM499 paid
5. Site Visit Scheduled - Calendly booking
6. Proposal Sent - Site report complete
7. Negotiation - Customer response
8. Closed Won - Contract signed
9. Closed Lost - Customer declined

### Webhook Payload

```json
{
  "name": "Customer Name",
  "email": "customer@email.com",
  "phone": "+60123456789",
  "address": "Property Address",
  "tnb_bill": 500,
  "roof_area": 50,
  "system_size": "5kW",
  "monthly_savings": 400,
  "yearly_savings": 4800,
  "roi_years": 4.5,
  "purchase_path": "buy",
  "source": "Website Calculator"
}
```

## Development

### Theme Structure

```
malaysia-solar/
├── assets/
│   ├── js/
│   │   ├── main.js
│   │   ├── calculator.js
│   │   └── chatbot.js
│   └── images/
├── template-parts/
├── style.css
├── functions.php
├── header.php
├── footer.php
├── front-page.php
├── page-quote.php
├── page-products.php
├── page-lease.php
├── page-about.php
├── index.php
├── single.php
└── page.php
```

### Shortcodes

- `[solar_calculator]` - Embed calculator widget
- `[testimonials count="6"]` - Display testimonials
- `[solar_products count="4"]` - Display product grid

### Custom Post Types

- `solar_product` - Solar system packages
- `testimonial` - Customer testimonials
- `case_study` - Installation case studies
- `team_member` - Team profiles

## Deployment Options

Since WordPress requires PHP hosting, recommended options:

### Managed WordPress Hosting
- **WP Engine** - Premium managed hosting
- **Kinsta** - High-performance WordPress
- **SiteGround** - Affordable with good support

### Cloud Hosting
- **DigitalOcean** with ServerPilot
- **AWS Lightsail** with WordPress blueprint
- **Google Cloud Platform** with Click-to-Deploy

### Budget Options
- **Bluehost** - WordPress.org recommended
- **Hostinger** - Affordable VPS option

## Support

For questions or issues:
- WhatsApp: +60 12-345 6789
- Email: info@malaysiasolar.com

## License

This theme is licensed under the GNU General Public License v2 or later.
