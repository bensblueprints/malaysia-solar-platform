<?php
/**
 * Malaysia Solar Platform Theme Functions
 *
 * @package Malaysia_Solar
 * @version 1.0.0
 */

if (!defined('ABSPATH')) {
    exit;
}

// Theme Constants
define('MALAYSIA_SOLAR_VERSION', '1.0.0');
define('MALAYSIA_SOLAR_DIR', get_template_directory());
define('MALAYSIA_SOLAR_URI', get_template_directory_uri());

/**
 * Theme Setup
 */
function malaysia_solar_setup() {
    // Add theme support
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('html5', array(
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
        'style',
        'script',
    ));
    add_theme_support('custom-logo', array(
        'height'      => 100,
        'width'       => 300,
        'flex-height' => true,
        'flex-width'  => true,
    ));
    add_theme_support('woocommerce');
    add_theme_support('responsive-embeds');
    add_theme_support('align-wide');

    // Register navigation menus
    register_nav_menus(array(
        'primary'   => __('Primary Menu', 'malaysia-solar'),
        'footer'    => __('Footer Menu', 'malaysia-solar'),
    ));

    // Set content width
    $GLOBALS['content_width'] = 1280;
}
add_action('after_setup_theme', 'malaysia_solar_setup');

/**
 * Enqueue Scripts and Styles
 */
function malaysia_solar_scripts() {
    // Google Fonts
    wp_enqueue_style(
        'malaysia-solar-fonts',
        'https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap',
        array(),
        null
    );

    // Main stylesheet
    wp_enqueue_style(
        'malaysia-solar-style',
        get_stylesheet_uri(),
        array(),
        MALAYSIA_SOLAR_VERSION
    );

    // Main JavaScript
    wp_enqueue_script(
        'malaysia-solar-main',
        MALAYSIA_SOLAR_URI . '/assets/js/main.js',
        array(),
        MALAYSIA_SOLAR_VERSION,
        true
    );

    // Solar Calculator
    if (is_page_template('page-quote.php') || is_page('get-a-quote')) {
        wp_enqueue_script(
            'google-maps',
            'https://maps.googleapis.com/maps/api/js?key=' . get_option('malaysia_solar_google_maps_key', '') . '&libraries=drawing,places',
            array(),
            null,
            true
        );

        wp_enqueue_script(
            'malaysia-solar-calculator',
            MALAYSIA_SOLAR_URI . '/assets/js/calculator.js',
            array('google-maps'),
            MALAYSIA_SOLAR_VERSION,
            true
        );

        wp_localize_script('malaysia-solar-calculator', 'solarCalculator', array(
            'ajaxUrl' => admin_url('admin-ajax.php'),
            'nonce'   => wp_create_nonce('solar_calculator_nonce'),
            'ghlWebhook' => get_option('malaysia_solar_ghl_webhook', ''),
        ));
    }

    // Chatbot
    wp_enqueue_script(
        'malaysia-solar-chatbot',
        MALAYSIA_SOLAR_URI . '/assets/js/chatbot.js',
        array(),
        MALAYSIA_SOLAR_VERSION,
        true
    );

    wp_localize_script('malaysia-solar-chatbot', 'solarChatbot', array(
        'ajaxUrl' => admin_url('admin-ajax.php'),
        'nonce'   => wp_create_nonce('chatbot_nonce'),
    ));
}
add_action('wp_enqueue_scripts', 'malaysia_solar_scripts');

/**
 * Register Custom Post Types
 */
function malaysia_solar_register_post_types() {
    // Solar Products
    register_post_type('solar_product', array(
        'labels' => array(
            'name'               => __('Solar Products', 'malaysia-solar'),
            'singular_name'      => __('Solar Product', 'malaysia-solar'),
            'add_new'            => __('Add New Product', 'malaysia-solar'),
            'add_new_item'       => __('Add New Solar Product', 'malaysia-solar'),
            'edit_item'          => __('Edit Product', 'malaysia-solar'),
            'new_item'           => __('New Product', 'malaysia-solar'),
            'view_item'          => __('View Product', 'malaysia-solar'),
            'search_items'       => __('Search Products', 'malaysia-solar'),
            'not_found'          => __('No products found', 'malaysia-solar'),
            'not_found_in_trash' => __('No products found in Trash', 'malaysia-solar'),
        ),
        'public'        => true,
        'has_archive'   => true,
        'menu_icon'     => 'dashicons-lightbulb',
        'supports'      => array('title', 'editor', 'thumbnail', 'excerpt'),
        'rewrite'       => array('slug' => 'solar-products'),
        'show_in_rest'  => true,
    ));

    // Testimonials
    register_post_type('testimonial', array(
        'labels' => array(
            'name'               => __('Testimonials', 'malaysia-solar'),
            'singular_name'      => __('Testimonial', 'malaysia-solar'),
            'add_new'            => __('Add New Testimonial', 'malaysia-solar'),
            'add_new_item'       => __('Add New Testimonial', 'malaysia-solar'),
            'edit_item'          => __('Edit Testimonial', 'malaysia-solar'),
        ),
        'public'        => true,
        'has_archive'   => false,
        'menu_icon'     => 'dashicons-format-quote',
        'supports'      => array('title', 'editor', 'thumbnail'),
        'show_in_rest'  => true,
    ));

    // Case Studies
    register_post_type('case_study', array(
        'labels' => array(
            'name'               => __('Case Studies', 'malaysia-solar'),
            'singular_name'      => __('Case Study', 'malaysia-solar'),
            'add_new'            => __('Add New Case Study', 'malaysia-solar'),
            'add_new_item'       => __('Add New Case Study', 'malaysia-solar'),
        ),
        'public'        => true,
        'has_archive'   => true,
        'menu_icon'     => 'dashicons-analytics',
        'supports'      => array('title', 'editor', 'thumbnail', 'excerpt'),
        'rewrite'       => array('slug' => 'case-studies'),
        'show_in_rest'  => true,
    ));

    // Team Members
    register_post_type('team_member', array(
        'labels' => array(
            'name'               => __('Team Members', 'malaysia-solar'),
            'singular_name'      => __('Team Member', 'malaysia-solar'),
        ),
        'public'        => true,
        'has_archive'   => false,
        'menu_icon'     => 'dashicons-groups',
        'supports'      => array('title', 'editor', 'thumbnail'),
        'show_in_rest'  => true,
    ));
}
add_action('init', 'malaysia_solar_register_post_types');

/**
 * Register Custom Meta Boxes
 */
function malaysia_solar_register_meta_boxes() {
    // Solar Product Meta
    add_meta_box(
        'solar_product_details',
        __('Product Details', 'malaysia-solar'),
        'malaysia_solar_product_meta_box',
        'solar_product',
        'normal',
        'high'
    );

    // Testimonial Meta
    add_meta_box(
        'testimonial_details',
        __('Testimonial Details', 'malaysia-solar'),
        'malaysia_solar_testimonial_meta_box',
        'testimonial',
        'normal',
        'high'
    );

    // Team Member Meta
    add_meta_box(
        'team_member_details',
        __('Team Member Details', 'malaysia-solar'),
        'malaysia_solar_team_meta_box',
        'team_member',
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'malaysia_solar_register_meta_boxes');

/**
 * Product Meta Box Callback
 */
function malaysia_solar_product_meta_box($post) {
    wp_nonce_field('malaysia_solar_product_meta', 'malaysia_solar_product_nonce');
    $system_size = get_post_meta($post->ID, '_system_size', true);
    $price = get_post_meta($post->ID, '_price', true);
    $monthly_savings = get_post_meta($post->ID, '_monthly_savings', true);
    $panel_count = get_post_meta($post->ID, '_panel_count', true);
    $warranty_years = get_post_meta($post->ID, '_warranty_years', true);
    $inverter_brand = get_post_meta($post->ID, '_inverter_brand', true);
    ?>
    <table class="form-table">
        <tr>
            <th><label for="system_size"><?php _e('System Size (kW)', 'malaysia-solar'); ?></label></th>
            <td><input type="number" step="0.1" id="system_size" name="system_size" value="<?php echo esc_attr($system_size); ?>" class="regular-text"></td>
        </tr>
        <tr>
            <th><label for="price"><?php _e('Price (RM)', 'malaysia-solar'); ?></label></th>
            <td><input type="number" step="0.01" id="price" name="price" value="<?php echo esc_attr($price); ?>" class="regular-text"></td>
        </tr>
        <tr>
            <th><label for="monthly_savings"><?php _e('Est. Monthly Savings (RM)', 'malaysia-solar'); ?></label></th>
            <td><input type="number" step="0.01" id="monthly_savings" name="monthly_savings" value="<?php echo esc_attr($monthly_savings); ?>" class="regular-text"></td>
        </tr>
        <tr>
            <th><label for="panel_count"><?php _e('Number of Panels', 'malaysia-solar'); ?></label></th>
            <td><input type="number" id="panel_count" name="panel_count" value="<?php echo esc_attr($panel_count); ?>" class="regular-text"></td>
        </tr>
        <tr>
            <th><label for="warranty_years"><?php _e('Warranty (Years)', 'malaysia-solar'); ?></label></th>
            <td><input type="number" id="warranty_years" name="warranty_years" value="<?php echo esc_attr($warranty_years); ?>" class="regular-text"></td>
        </tr>
        <tr>
            <th><label for="inverter_brand"><?php _e('Inverter Brand', 'malaysia-solar'); ?></label></th>
            <td><input type="text" id="inverter_brand" name="inverter_brand" value="<?php echo esc_attr($inverter_brand); ?>" class="regular-text"></td>
        </tr>
    </table>
    <?php
}

/**
 * Testimonial Meta Box Callback
 */
function malaysia_solar_testimonial_meta_box($post) {
    wp_nonce_field('malaysia_solar_testimonial_meta', 'malaysia_solar_testimonial_nonce');
    $author_name = get_post_meta($post->ID, '_author_name', true);
    $location = get_post_meta($post->ID, '_location', true);
    $system_size = get_post_meta($post->ID, '_system_size', true);
    $rating = get_post_meta($post->ID, '_rating', true);
    ?>
    <table class="form-table">
        <tr>
            <th><label for="author_name"><?php _e('Customer Name', 'malaysia-solar'); ?></label></th>
            <td><input type="text" id="author_name" name="author_name" value="<?php echo esc_attr($author_name); ?>" class="regular-text"></td>
        </tr>
        <tr>
            <th><label for="location"><?php _e('Location', 'malaysia-solar'); ?></label></th>
            <td><input type="text" id="location" name="location" value="<?php echo esc_attr($location); ?>" class="regular-text"></td>
        </tr>
        <tr>
            <th><label for="system_size"><?php _e('System Installed (kW)', 'malaysia-solar'); ?></label></th>
            <td><input type="number" step="0.1" id="system_size" name="system_size" value="<?php echo esc_attr($system_size); ?>" class="regular-text"></td>
        </tr>
        <tr>
            <th><label for="rating"><?php _e('Rating (1-5)', 'malaysia-solar'); ?></label></th>
            <td>
                <select id="rating" name="rating">
                    <?php for ($i = 5; $i >= 1; $i--): ?>
                        <option value="<?php echo $i; ?>" <?php selected($rating, $i); ?>><?php echo $i; ?> Stars</option>
                    <?php endfor; ?>
                </select>
            </td>
        </tr>
    </table>
    <?php
}

/**
 * Team Member Meta Box Callback
 */
function malaysia_solar_team_meta_box($post) {
    wp_nonce_field('malaysia_solar_team_meta', 'malaysia_solar_team_nonce');
    $position = get_post_meta($post->ID, '_position', true);
    $linkedin = get_post_meta($post->ID, '_linkedin', true);
    ?>
    <table class="form-table">
        <tr>
            <th><label for="position"><?php _e('Position', 'malaysia-solar'); ?></label></th>
            <td><input type="text" id="position" name="position" value="<?php echo esc_attr($position); ?>" class="regular-text"></td>
        </tr>
        <tr>
            <th><label for="linkedin"><?php _e('LinkedIn URL', 'malaysia-solar'); ?></label></th>
            <td><input type="url" id="linkedin" name="linkedin" value="<?php echo esc_attr($linkedin); ?>" class="regular-text"></td>
        </tr>
    </table>
    <?php
}

/**
 * Save Meta Box Data
 */
function malaysia_solar_save_meta_boxes($post_id) {
    // Product Meta
    if (isset($_POST['malaysia_solar_product_nonce']) && wp_verify_nonce($_POST['malaysia_solar_product_nonce'], 'malaysia_solar_product_meta')) {
        $fields = array('system_size', 'price', 'monthly_savings', 'panel_count', 'warranty_years', 'inverter_brand');
        foreach ($fields as $field) {
            if (isset($_POST[$field])) {
                update_post_meta($post_id, '_' . $field, sanitize_text_field($_POST[$field]));
            }
        }
    }

    // Testimonial Meta
    if (isset($_POST['malaysia_solar_testimonial_nonce']) && wp_verify_nonce($_POST['malaysia_solar_testimonial_nonce'], 'malaysia_solar_testimonial_meta')) {
        $fields = array('author_name', 'location', 'system_size', 'rating');
        foreach ($fields as $field) {
            if (isset($_POST[$field])) {
                update_post_meta($post_id, '_' . $field, sanitize_text_field($_POST[$field]));
            }
        }
    }

    // Team Meta
    if (isset($_POST['malaysia_solar_team_nonce']) && wp_verify_nonce($_POST['malaysia_solar_team_nonce'], 'malaysia_solar_team_meta')) {
        if (isset($_POST['position'])) {
            update_post_meta($post_id, '_position', sanitize_text_field($_POST['position']));
        }
        if (isset($_POST['linkedin'])) {
            update_post_meta($post_id, '_linkedin', esc_url_raw($_POST['linkedin']));
        }
    }
}
add_action('save_post', 'malaysia_solar_save_meta_boxes');

/**
 * Theme Options Page
 */
function malaysia_solar_add_admin_menu() {
    add_menu_page(
        __('Solar Settings', 'malaysia-solar'),
        __('Solar Settings', 'malaysia-solar'),
        'manage_options',
        'malaysia-solar-settings',
        'malaysia_solar_settings_page',
        'dashicons-admin-generic',
        60
    );
}
add_action('admin_menu', 'malaysia_solar_add_admin_menu');

function malaysia_solar_settings_page() {
    ?>
    <div class="wrap">
        <h1><?php _e('Malaysia Solar Platform Settings', 'malaysia-solar'); ?></h1>
        <form method="post" action="options.php">
            <?php
            settings_fields('malaysia_solar_settings');
            do_settings_sections('malaysia-solar-settings');
            submit_button();
            ?>
        </form>
    </div>
    <?php
}

function malaysia_solar_register_settings() {
    // API Keys Section
    add_settings_section(
        'malaysia_solar_api_keys',
        __('API Configuration', 'malaysia-solar'),
        '__return_false',
        'malaysia-solar-settings'
    );

    // Google Maps API Key
    register_setting('malaysia_solar_settings', 'malaysia_solar_google_maps_key');
    add_settings_field(
        'google_maps_key',
        __('Google Maps API Key', 'malaysia-solar'),
        'malaysia_solar_text_field_callback',
        'malaysia-solar-settings',
        'malaysia_solar_api_keys',
        array('field' => 'malaysia_solar_google_maps_key')
    );

    // Google Solar API Key
    register_setting('malaysia_solar_settings', 'malaysia_solar_google_solar_key');
    add_settings_field(
        'google_solar_key',
        __('Google Solar API Key', 'malaysia-solar'),
        'malaysia_solar_text_field_callback',
        'malaysia-solar-settings',
        'malaysia_solar_api_keys',
        array('field' => 'malaysia_solar_google_solar_key')
    );

    // CRM Section
    add_settings_section(
        'malaysia_solar_crm',
        __('GoHighLevel CRM Integration', 'malaysia-solar'),
        '__return_false',
        'malaysia-solar-settings'
    );

    // GHL Webhook URL
    register_setting('malaysia_solar_settings', 'malaysia_solar_ghl_webhook');
    add_settings_field(
        'ghl_webhook',
        __('GoHighLevel Webhook URL', 'malaysia-solar'),
        'malaysia_solar_text_field_callback',
        'malaysia-solar-settings',
        'malaysia_solar_crm',
        array('field' => 'malaysia_solar_ghl_webhook')
    );

    // GHL API Key
    register_setting('malaysia_solar_settings', 'malaysia_solar_ghl_api_key');
    add_settings_field(
        'ghl_api_key',
        __('GoHighLevel API Key', 'malaysia-solar'),
        'malaysia_solar_text_field_callback',
        'malaysia-solar-settings',
        'malaysia_solar_crm',
        array('field' => 'malaysia_solar_ghl_api_key')
    );

    // Payment Section
    add_settings_section(
        'malaysia_solar_payment',
        __('Payment Gateway', 'malaysia-solar'),
        '__return_false',
        'malaysia-solar-settings'
    );

    // Stripe Publishable Key
    register_setting('malaysia_solar_settings', 'malaysia_solar_stripe_pk');
    add_settings_field(
        'stripe_pk',
        __('Stripe Publishable Key', 'malaysia-solar'),
        'malaysia_solar_text_field_callback',
        'malaysia-solar-settings',
        'malaysia_solar_payment',
        array('field' => 'malaysia_solar_stripe_pk')
    );

    // Stripe Secret Key
    register_setting('malaysia_solar_settings', 'malaysia_solar_stripe_sk');
    add_settings_field(
        'stripe_sk',
        __('Stripe Secret Key', 'malaysia-solar'),
        'malaysia_solar_text_field_callback',
        'malaysia-solar-settings',
        'malaysia_solar_payment',
        array('field' => 'malaysia_solar_stripe_sk', 'type' => 'password')
    );

    // WhatsApp Section
    add_settings_section(
        'malaysia_solar_whatsapp',
        __('WhatsApp Integration', 'malaysia-solar'),
        '__return_false',
        'malaysia-solar-settings'
    );

    // WhatsApp Business Number
    register_setting('malaysia_solar_settings', 'malaysia_solar_whatsapp_number');
    add_settings_field(
        'whatsapp_number',
        __('WhatsApp Business Number', 'malaysia-solar'),
        'malaysia_solar_text_field_callback',
        'malaysia-solar-settings',
        'malaysia_solar_whatsapp',
        array('field' => 'malaysia_solar_whatsapp_number', 'placeholder' => '+60123456789')
    );
}
add_action('admin_init', 'malaysia_solar_register_settings');

function malaysia_solar_text_field_callback($args) {
    $value = get_option($args['field'], '');
    $type = isset($args['type']) ? $args['type'] : 'text';
    $placeholder = isset($args['placeholder']) ? $args['placeholder'] : '';
    printf(
        '<input type="%s" name="%s" value="%s" placeholder="%s" class="regular-text">',
        esc_attr($type),
        esc_attr($args['field']),
        esc_attr($value),
        esc_attr($placeholder)
    );
}

/**
 * AJAX Handlers
 */

// Submit Quote Lead to GoHighLevel
function malaysia_solar_submit_quote() {
    check_ajax_referer('solar_calculator_nonce', 'nonce');

    $data = array(
        'name'          => sanitize_text_field($_POST['name']),
        'ic_number'     => sanitize_text_field($_POST['ic_number']),
        'email'         => sanitize_email($_POST['email']),
        'phone'         => sanitize_text_field($_POST['phone']),
        'address'       => sanitize_textarea_field($_POST['address']),
        'tnb_bill'      => floatval($_POST['tnb_bill']),
        'roof_area'     => floatval($_POST['roof_area']),
        'system_size'   => sanitize_text_field($_POST['system_size']),
        'monthly_savings' => floatval($_POST['monthly_savings']),
        'yearly_savings'  => floatval($_POST['yearly_savings']),
        'roi_years'     => floatval($_POST['roi_years']),
        'is_homeowner'  => sanitize_text_field($_POST['is_homeowner']),
        'has_roof_rights' => sanitize_text_field($_POST['has_roof_rights']),
        'purchase_path' => sanitize_text_field($_POST['purchase_path']),
        'source'        => 'Website Calculator',
        'timestamp'     => current_time('mysql'),
    );

    // Send to GoHighLevel webhook
    $webhook_url = get_option('malaysia_solar_ghl_webhook');
    if (!empty($webhook_url)) {
        $response = wp_remote_post($webhook_url, array(
            'body'    => json_encode($data),
            'headers' => array('Content-Type' => 'application/json'),
            'timeout' => 30,
        ));

        if (is_wp_error($response)) {
            error_log('GHL Webhook Error: ' . $response->get_error_message());
        }
    }

    // Store lead in database
    global $wpdb;
    $table_name = $wpdb->prefix . 'solar_leads';
    $wpdb->insert($table_name, $data);

    // Generate quote PDF (placeholder)
    $quote_id = 'SQ-' . date('Ymd') . '-' . $wpdb->insert_id;

    wp_send_json_success(array(
        'message'  => __('Quote submitted successfully!', 'malaysia-solar'),
        'quote_id' => $quote_id,
    ));
}
add_action('wp_ajax_submit_quote', 'malaysia_solar_submit_quote');
add_action('wp_ajax_nopriv_submit_quote', 'malaysia_solar_submit_quote');

// Chatbot Response
function malaysia_solar_chatbot_response() {
    check_ajax_referer('chatbot_nonce', 'nonce');

    $message = sanitize_text_field($_POST['message']);

    // Knowledge base responses
    $knowledge_base = array(
        'nem' => 'NEM (Net Energy Metering) is a government program that allows you to sell excess solar energy back to TNB. Under NEM 3.0, you can offset your electricity bill at a 1:1 ratio for the energy you export.',
        'solaris' => 'SolaRIS (Solar Renewable Industry Scheme) is a government initiative to promote solar energy adoption in Malaysia with various incentives and rebates.',
        'price' => 'Our solar systems range from RM15,000 for a 3kW system to RM40,000 for a 10kW system. The exact price depends on your roof size and energy needs.',
        'warranty' => 'All our solar panels come with a 25-year performance warranty, and inverters have a 10-year warranty. We also provide 5 years of free maintenance.',
        'installation' => 'Installation typically takes 1-2 days for residential systems. Our certified technicians handle everything from mounting to grid connection.',
        'savings' => 'On average, homeowners save 50-80% on their monthly electricity bills. A typical 5kW system can save you RM300-500 per month.',
        'financing' => 'We offer a Lease-to-Own option with zero upfront cost. You can also pay the full amount or use our installment plans with partner banks.',
        'maintenance' => 'Solar panels require minimal maintenance. We recommend annual inspections and cleaning 2-3 times per year for optimal performance.',
    );

    $response = "I'm sorry, I don't have specific information about that. Would you like me to connect you with our solar experts? You can also call us at +60 3-XXXX XXXX or WhatsApp us.";

    $message_lower = strtolower($message);
    foreach ($knowledge_base as $keyword => $answer) {
        if (strpos($message_lower, $keyword) !== false) {
            $response = $answer;
            break;
        }
    }

    // Log unanswered questions
    if ($response === "I'm sorry, I don't have specific information about that. Would you like me to connect you with our solar experts? You can also call us at +60 3-XXXX XXXX or WhatsApp us.") {
        $unanswered = get_option('malaysia_solar_unanswered_questions', array());
        $unanswered[] = array(
            'question' => $message,
            'timestamp' => current_time('mysql'),
        );
        update_option('malaysia_solar_unanswered_questions', $unanswered);
    }

    wp_send_json_success(array('response' => $response));
}
add_action('wp_ajax_chatbot_response', 'malaysia_solar_chatbot_response');
add_action('wp_ajax_nopriv_chatbot_response', 'malaysia_solar_chatbot_response');

// Process Payment
function malaysia_solar_process_payment() {
    check_ajax_referer('solar_calculator_nonce', 'nonce');

    require_once MALAYSIA_SOLAR_DIR . '/inc/stripe-php/init.php';

    $stripe_sk = get_option('malaysia_solar_stripe_sk');
    \Stripe\Stripe::setApiKey($stripe_sk);

    try {
        $payment_intent = \Stripe\PaymentIntent::create([
            'amount' => 49900, // RM499 in cents
            'currency' => 'myr',
            'description' => 'Solar Site Visit & Drone Survey Commitment Fee',
            'metadata' => array(
                'customer_name' => sanitize_text_field($_POST['name']),
                'customer_email' => sanitize_email($_POST['email']),
                'quote_id' => sanitize_text_field($_POST['quote_id']),
            ),
        ]);

        wp_send_json_success(array(
            'clientSecret' => $payment_intent->client_secret,
        ));
    } catch (Exception $e) {
        wp_send_json_error(array('message' => $e->getMessage()));
    }
}
add_action('wp_ajax_process_payment', 'malaysia_solar_process_payment');
add_action('wp_ajax_nopriv_process_payment', 'malaysia_solar_process_payment');

/**
 * Create Database Tables on Theme Activation
 */
function malaysia_solar_activate() {
    global $wpdb;
    $charset_collate = $wpdb->get_charset_collate();

    // Leads table
    $table_name = $wpdb->prefix . 'solar_leads';
    $sql = "CREATE TABLE IF NOT EXISTS $table_name (
        id bigint(20) NOT NULL AUTO_INCREMENT,
        name varchar(255) NOT NULL,
        ic_number varchar(50),
        email varchar(255) NOT NULL,
        phone varchar(50) NOT NULL,
        address text,
        tnb_bill decimal(10,2),
        roof_area decimal(10,2),
        system_size varchar(20),
        monthly_savings decimal(10,2),
        yearly_savings decimal(10,2),
        roi_years decimal(5,2),
        is_homeowner varchar(10),
        has_roof_rights varchar(10),
        purchase_path varchar(50),
        source varchar(100),
        status varchar(50) DEFAULT 'new_lead',
        timestamp datetime DEFAULT CURRENT_TIMESTAMP,
        PRIMARY KEY (id)
    ) $charset_collate;";

    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($sql);

    // Create default pages
    $pages = array(
        'get-a-quote'    => array('title' => 'Get A Quote', 'template' => 'page-quote.php'),
        'solar-products' => array('title' => 'Solar Products', 'template' => 'page-products.php'),
        'lease-to-own'   => array('title' => 'Lease to Own', 'template' => 'page-lease.php'),
        'about-us'       => array('title' => 'About Us', 'template' => 'page-about.php'),
        'checkout'       => array('title' => 'Checkout', 'template' => 'page-checkout.php'),
    );

    foreach ($pages as $slug => $page_data) {
        $page_exists = get_page_by_path($slug);
        if (!$page_exists) {
            $page_id = wp_insert_post(array(
                'post_title'     => $page_data['title'],
                'post_name'      => $slug,
                'post_status'    => 'publish',
                'post_type'      => 'page',
                'post_content'   => '',
            ));
            if ($page_id && !is_wp_error($page_id)) {
                update_post_meta($page_id, '_wp_page_template', $page_data['template']);
            }
        }
    }

    flush_rewrite_rules();
}
add_action('after_switch_theme', 'malaysia_solar_activate');

/**
 * Solar Calculator Shortcode
 */
function malaysia_solar_calculator_shortcode($atts) {
    ob_start();
    include MALAYSIA_SOLAR_DIR . '/template-parts/calculator-widget.php';
    return ob_get_clean();
}
add_shortcode('solar_calculator', 'malaysia_solar_calculator_shortcode');

/**
 * Testimonials Shortcode
 */
function malaysia_solar_testimonials_shortcode($atts) {
    $atts = shortcode_atts(array(
        'count' => 6,
    ), $atts);

    $testimonials = get_posts(array(
        'post_type'      => 'testimonial',
        'posts_per_page' => intval($atts['count']),
        'orderby'        => 'date',
        'order'          => 'DESC',
    ));

    ob_start();
    ?>
    <div class="testimonials-slider">
        <?php foreach ($testimonials as $testimonial):
            $author = get_post_meta($testimonial->ID, '_author_name', true);
            $location = get_post_meta($testimonial->ID, '_location', true);
            $rating = get_post_meta($testimonial->ID, '_rating', true);
        ?>
        <div class="testimonial-card">
            <div class="testimonial-rating">
                <?php for ($i = 0; $i < intval($rating); $i++): ?>
                <svg class="star" viewBox="0 0 24 24"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                <?php endfor; ?>
            </div>
            <p class="testimonial-text">"<?php echo esc_html($testimonial->post_content); ?>"</p>
            <div class="testimonial-author">
                <div class="author-avatar"><?php echo esc_html(substr($author, 0, 1)); ?></div>
                <div class="author-info">
                    <h4><?php echo esc_html($author); ?></h4>
                    <p><?php echo esc_html($location); ?></p>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
    <?php
    return ob_get_clean();
}
add_shortcode('testimonials', 'malaysia_solar_testimonials_shortcode');

/**
 * Products Grid Shortcode
 */
function malaysia_solar_products_shortcode($atts) {
    $atts = shortcode_atts(array(
        'count' => 4,
    ), $atts);

    $products = get_posts(array(
        'post_type'      => 'solar_product',
        'posts_per_page' => intval($atts['count']),
        'orderby'        => 'meta_value_num',
        'meta_key'       => '_system_size',
        'order'          => 'ASC',
    ));

    ob_start();
    ?>
    <div class="grid grid-4 gap-xl">
        <?php foreach ($products as $product):
            $system_size = get_post_meta($product->ID, '_system_size', true);
            $price = get_post_meta($product->ID, '_price', true);
            $monthly_savings = get_post_meta($product->ID, '_monthly_savings', true);
            $panel_count = get_post_meta($product->ID, '_panel_count', true);
            $warranty = get_post_meta($product->ID, '_warranty_years', true);
        ?>
        <div class="product-card">
            <div class="product-image">
                <?php if (has_post_thumbnail($product->ID)): ?>
                    <?php echo get_the_post_thumbnail($product->ID, 'medium_large'); ?>
                <?php else: ?>
                    <svg width="120" height="80" viewBox="0 0 120 80" fill="none">
                        <rect x="10" y="10" width="100" height="60" rx="4" fill="#1A2B4A"/>
                        <g fill="#F7B32B" opacity="0.6">
                            <rect x="15" y="15" width="18" height="12" rx="1"/>
                            <rect x="36" y="15" width="18" height="12" rx="1"/>
                            <rect x="57" y="15" width="18" height="12" rx="1"/>
                            <rect x="78" y="15" width="18" height="12" rx="1"/>
                            <rect x="15" y="30" width="18" height="12" rx="1"/>
                            <rect x="36" y="30" width="18" height="12" rx="1"/>
                            <rect x="57" y="30" width="18" height="12" rx="1"/>
                            <rect x="78" y="30" width="18" height="12" rx="1"/>
                        </g>
                    </svg>
                <?php endif; ?>
                <span class="product-badge"><?php echo esc_html($system_size); ?>kW</span>
            </div>
            <div class="product-content">
                <h3 class="product-title"><?php echo esc_html($product->post_title); ?></h3>
                <ul class="product-specs">
                    <li><span class="spec-label">Panels</span><span class="spec-value"><?php echo esc_html($panel_count); ?> panels</span></li>
                    <li><span class="spec-label">Monthly Savings</span><span class="spec-value">RM <?php echo number_format($monthly_savings); ?></span></li>
                    <li><span class="spec-label">Warranty</span><span class="spec-value"><?php echo esc_html($warranty); ?> Years</span></li>
                </ul>
                <div class="product-price">
                    <span class="price-amount">RM <?php echo number_format($price); ?></span>
                </div>
                <a href="<?php echo esc_url(home_url('/get-a-quote/?system=' . $system_size)); ?>" class="btn btn-primary w-full">Get Quote</a>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
    <?php
    return ob_get_clean();
}
add_shortcode('solar_products', 'malaysia_solar_products_shortcode');

/**
 * WhatsApp Integration
 */
function malaysia_solar_whatsapp_link($message = '') {
    $number = get_option('malaysia_solar_whatsapp_number', '');
    $number = preg_replace('/[^0-9]/', '', $number);
    $encoded_message = urlencode($message);
    return "https://wa.me/{$number}?text={$encoded_message}";
}

/**
 * Include Template Parts
 */
function malaysia_solar_get_template_part($slug, $name = null, $args = array()) {
    if ($name) {
        $template = MALAYSIA_SOLAR_DIR . "/template-parts/{$slug}-{$name}.php";
    } else {
        $template = MALAYSIA_SOLAR_DIR . "/template-parts/{$slug}.php";
    }

    if (file_exists($template)) {
        extract($args);
        include $template;
    }
}
