<?php
/**
 * RS Law Firm - Enhanced SEO & AEO Theme Functions
 * Hebrew Law Firm Technical SEO + Answer Engine Optimization
 *
 * @package HelloElementorChild
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Load child theme css and scripts with enhanced SEO features
 */
function hello_elementor_child_enqueue_scripts() {
	wp_enqueue_style(
		'hello-elementor-child-style',
		get_stylesheet_directory_uri() . '/style.css',
        ['hello-elementor-theme-style'],
        '2.0.0'
    );
    
    // Enqueue Hebrew-optimized styles and scripts
    wp_enqueue_script(
        'rslawfirm-seo-enhancements',
        get_stylesheet_directory_uri() . '/assets/js/seo-enhancements.js',
        ['jquery'],
        '2.0.0',
        true
    );
    
    // Localize script for Hebrew content
    wp_localize_script('rslawfirm-seo-enhancements', 'rslawfirm_vars', [
        'ajax_url' => admin_url('admin-ajax.php'),
        'nonce' => wp_create_nonce('rslawfirm_nonce'),
        'phone' => get_option('rslawfirm_phone', '+972-XX-XXXXXXX'),
        'whatsapp' => get_option('rslawfirm_whatsapp', '+972XXXXXXXXX'),
        'strings' => [
            'consultation_cta' => 'שיחת ייעוץ ללא התחייבות',
            'quick_consultation' => 'שיחת ייעוץ עכשיו',
            'office_hours' => 'שעות פתיחה: א׳-ה׳ 9:00-17:00'
        ]
    ]);
}
add_action('wp_enqueue_scripts', 'hello_elementor_child_enqueue_scripts');

/**
 * Enhanced JSON-LD Structured Data Implementation
 */
class RSLawFirm_StructuredData {
    
    public function __construct() {
        add_action('wp_head', [$this, 'output_organization_schema']);
        add_action('wp_head', [$this, 'output_page_specific_schema']);
        add_action('wp_head', [$this, 'output_breadcrumb_schema']);
    }
    
    /**
     * Output Organization/LegalService schema site-wide
     */
    public function output_organization_schema() {
        $schema = [
            '@context' => 'https://schema.org',
            '@type' => ['Organization', 'LegalService', 'LocalBusiness'],
            'name' => 'RS Law Firm',
            'alternateName' => 'משרד עורכי דין RS',
            'url' => home_url('/'),
            'logo' => get_stylesheet_directory_uri() . '/assets/images/logo.png',
            'image' => get_stylesheet_directory_uri() . '/assets/images/office.jpg',
            'address' => [
                '@type' => 'PostalAddress',
                'streetAddress' => get_option('rslawfirm_address', 'כתובת המשרד'),
                'addressLocality' => 'תל אביב',
                'addressCountry' => 'IL'
            ],
            'telephone' => get_option('rslawfirm_phone', '+972-XX-XXXXXXX'),
            'areaServed' => 'IL',
            'priceRange' => '$$',
            'openingHours' => 'Mo-Th 09:00-17:00',
            'sameAs' => array_filter([
                get_option('rslawfirm_facebook'),
                get_option('rslawfirm_linkedin'),
                get_option('rslawfirm_instagram')
            ]),
            'hasOfferCatalog' => [
                '@type' => 'OfferCatalog',
                'name' => 'שירותים משפטיים',
                'itemListElement' => [
                    ['@type' => 'Offer', 'itemOffered' => ['@type' => 'Service', 'name' => 'דיני עבודה']],
                    ['@type' => 'Offer', 'itemOffered' => ['@type' => 'Service', 'name' => 'נזקי גוף']],
                    ['@type' => 'Offer', 'itemOffered' => ['@type' => 'Service', 'name' => 'דיני מקרקעין']],
                    ['@type' => 'Offer', 'itemOffered' => ['@type' => 'Service', 'name' => 'דיני פלילי']],
                    ['@type' => 'Offer', 'itemOffered' => ['@type' => 'Service', 'name' => 'הוצאה לפועל']],
                    ['@type' => 'Offer', 'itemOffered' => ['@type' => 'Service', 'name' => 'דיני גירושין ומשפחה']]
                ]
            ]
        ];
        
        echo '<script type="application/ld+json">' . wp_json_encode($schema, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) . '</script>' . "\n";
    }
    
    /**
     * Output page-specific schema (FAQPage, LegalService)
     */
    public function output_page_specific_schema() {
        global $post;
        
        if (!is_singular()) return;
        
        // Check if this is a service page
        $service_pages = [
            'labor-law' => 'דיני עבודה',
            'personal-injury' => 'נזקי גוף', 
            'real-estate' => 'דיני מקרקעין',
            'criminal-law' => 'דיני פלילי',
            'debt-collection' => 'הוצאה לפועל',
            'family-law' => 'דיני משפחה וגירושין'
        ];
        
        $page_slug = $post->post_name;
        
        if (isset($service_pages[$page_slug])) {
            $this->output_legal_service_schema($service_pages[$page_slug]);
        }
        
        // Output FAQ schema if FAQs exist
        $faqs = get_post_meta($post->ID, 'rslawfirm_faqs', true);
        if ($faqs && is_array($faqs)) {
            $this->output_faq_schema($faqs);
        }
    }
    
    /**
     * Output LegalService specific schema
     */
    private function output_legal_service_schema($service_name) {
        $schema = [
            '@context' => 'https://schema.org',
            '@type' => 'LegalService',
            'name' => $service_name,
            'provider' => [
                '@type' => 'Organization',
                'name' => 'RS Law Firm'
            ],
            'areaServed' => 'IL',
            'serviceType' => $service_name,
            'hasOfferCatalog' => [
                '@type' => 'OfferCatalog',
                'name' => $service_name . ' - שירותים',
                'itemListElement' => [
                    [
                        '@type' => 'Offer',
                        'itemOffered' => [
                            '@type' => 'Service',
                            'name' => 'ייעוץ משפטי ב' . $service_name
                        ]
                    ]
                ]
            ]
        ];
        
        echo '<script type="application/ld+json">' . wp_json_encode($schema, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) . '</script>' . "\n";
    }
    
    /**
     * Output FAQ schema
     */
    private function output_faq_schema($faqs) {
        $faq_items = [];
        
        foreach ($faqs as $faq) {
            if (isset($faq['question']) && isset($faq['answer'])) {
                $faq_items[] = [
                    '@type' => 'Question',
                    'name' => $faq['question'],
                    'acceptedAnswer' => [
                        '@type' => 'Answer',
                        'text' => $faq['answer']
                    ]
                ];
            }
        }
        
        if (!empty($faq_items)) {
            $schema = [
                '@context' => 'https://schema.org',
                '@type' => 'FAQPage',
                'mainEntity' => $faq_items
            ];
            
            echo '<script type="application/ld+json">' . wp_json_encode($schema, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) . '</script>' . "\n";
        }
    }
    
    /**
     * Output breadcrumb schema
     */
    public function output_breadcrumb_schema() {
        if (is_front_page()) return;
        
        $breadcrumbs = [];
        $breadcrumbs[] = [
            '@type' => 'ListItem',
            'position' => 1,
            'name' => 'בית',
            'item' => home_url('/')
        ];
        
        if (is_singular()) {
            global $post;
            $breadcrumbs[] = [
                '@type' => 'ListItem',
                'position' => 2,
                'name' => get_the_title($post->ID),
                'item' => get_permalink($post->ID)
            ];
        }
        
        if (count($breadcrumbs) > 1) {
            $schema = [
                '@context' => 'https://schema.org',
                '@type' => 'BreadcrumbList',
                'itemListElement' => $breadcrumbs
            ];
            
            echo '<script type="application/ld+json">' . wp_json_encode($schema, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) . '</script>' . "\n";
        }
    }
}

// Initialize structured data
new RSLawFirm_StructuredData();

/**
 * Enhanced Meta Tags and OpenGraph
 */
function rslawfirm_enhanced_meta_tags() {
    global $post;
    
    // Enhanced meta robots
    echo '<meta name="robots" content="index,follow,max-image-preview:large,max-snippet:-1,max-video-preview:-1">' . "\n";
    
    if (is_singular()) {
        // Enhanced meta description with Hebrew support
        $meta_description = get_post_meta($post->ID, '_yoast_wpseo_metadesc', true);
        if (empty($meta_description)) {
            $meta_description = wp_trim_words(strip_tags($post->post_content), 25, '...');
        }
        
        // OpenGraph tags with Hebrew support
        echo '<meta property="og:title" content="' . esc_attr(get_the_title()) . '">' . "\n";
        echo '<meta property="og:description" content="' . esc_attr($meta_description) . '">' . "\n";
        echo '<meta property="og:type" content="article">' . "\n";
        echo '<meta property="og:url" content="' . esc_url(get_permalink()) . '">' . "\n";
        echo '<meta property="og:site_name" content="RS Law Firm - משרד עורכי דין">' . "\n";
        echo '<meta property="og:locale" content="he_IL">' . "\n";
        
        // Twitter Cards
        echo '<meta name="twitter:card" content="summary_large_image">' . "\n";
        echo '<meta name="twitter:title" content="' . esc_attr(get_the_title()) . '">' . "\n";
        echo '<meta name="twitter:description" content="' . esc_attr($meta_description) . '">' . "\n";
        
        // Canonical URL
        echo '<link rel="canonical" href="' . esc_url(get_permalink()) . '">' . "\n";
    }
}
add_action('wp_head', 'rslawfirm_enhanced_meta_tags');

/**
 * Mobile Sticky CTA Implementation
 */
function rslawfirm_mobile_sticky_cta() {
    $phone = get_option('rslawfirm_phone', '+972XXXXXXXXX');
    $whatsapp = get_option('rslawfirm_whatsapp', '+972XXXXXXXXX');
    ?>
    <div id="rslawfirm-mobile-sticky-cta" class="mobile-sticky-cta" style="display: none;">
        <div class="cta-buttons">
            <a href="tel:<?php echo esc_attr($phone); ?>" class="cta-phone">
                <span class="icon">📞</span>
                <span class="text">התקשר</span>
            </a>
            <a href="https://wa.me/<?php echo esc_attr(str_replace(['+', '-', ' '], '', $whatsapp)); ?>" class="cta-whatsapp" target="_blank">
                <span class="icon">💬</span>
                <span class="text">וואטסאפ</span>
            </a>
        </div>
    </div>
    
    <script>
    jQuery(document).ready(function($) {
        // Show sticky CTA on mobile devices
        function toggleStickyCTA() {
            if ($(window).width() <= 768) {
                $('#rslawfirm-mobile-sticky-cta').show();
            } else {
                $('#rslawfirm-mobile-sticky-cta').hide();
            }
        }
        
        toggleStickyCTA();
        $(window).resize(toggleStickyCTA);
    });
    </script>
    <?php
}
add_action('wp_footer', 'rslawfirm_mobile_sticky_cta');

/**
 * Performance Optimizations
 */
function rslawfirm_performance_optimizations() {
    // Preload critical resources
    echo '<link rel="preload" href="' . get_stylesheet_directory_uri() . '/style.css" as="style">' . "\n";
    
    // DNS prefetch for external resources
    echo '<link rel="dns-prefetch" href="//fonts.googleapis.com">' . "\n";
    echo '<link rel="dns-prefetch" href="//fonts.gstatic.com">' . "\n";
}
add_action('wp_head', 'rslawfirm_performance_optimizations', 1);

/**
 * Hebrew RTL and Language Support
 */
function rslawfirm_language_support() {
    add_theme_support('html5', ['search-form', 'comment-form', 'comment-list', 'gallery', 'caption']);
    
    // RTL support for Hebrew
    if (is_rtl()) {
        wp_enqueue_style('rslawfirm-rtl', get_stylesheet_directory_uri() . '/rtl.css', [], '2.0.0');
    }
}
add_action('after_setup_theme', 'rslawfirm_language_support');

/**
 * Custom Post Meta for SEO Fields
 */
function rslawfirm_add_seo_meta_boxes() {
    add_meta_box(
        'rslawfirm_seo_meta',
        'RS Law Firm - הגדרות SEO',
        'rslawfirm_seo_meta_callback',
        ['page', 'post'],
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'rslawfirm_add_seo_meta_boxes');

function rslawfirm_seo_meta_callback($post) {
    wp_nonce_field('rslawfirm_seo_meta_nonce', 'rslawfirm_seo_meta_nonce');
    
    $faqs = get_post_meta($post->ID, 'rslawfirm_faqs', true) ?: [];
    ?>
    <div class="rslawfirm-seo-fields">
        <h4>שאלות נפוצות (FAQs)</h4>
        <div id="rslawfirm-faqs-container">
            <?php foreach ($faqs as $index => $faq): ?>
            <div class="faq-item" data-index="<?php echo $index; ?>">
                <p>
                    <label>שאלה:</label>
                    <input type="text" name="rslawfirm_faqs[<?php echo $index; ?>][question]" 
                           value="<?php echo esc_attr($faq['question'] ?? ''); ?>" style="width: 100%;" />
                </p>
                <p>
                    <label>תשובה:</label>
                    <textarea name="rslawfirm_faqs[<?php echo $index; ?>][answer]" 
                              rows="3" style="width: 100%;"><?php echo esc_textarea($faq['answer'] ?? ''); ?></textarea>
                </p>
                <button type="button" class="remove-faq">הסר שאלה</button>
                <hr>
            </div>
            <?php endforeach; ?>
        </div>
        <button type="button" id="add-faq">הוסף שאלה נפוצה</button>
    </div>
    
    <script>
    jQuery(document).ready(function($) {
        var faqIndex = <?php echo count($faqs); ?>;
        
        $('#add-faq').click(function() {
            var html = '<div class="faq-item" data-index="' + faqIndex + '">' +
                '<p><label>שאלה:</label>' +
                '<input type="text" name="rslawfirm_faqs[' + faqIndex + '][question]" style="width: 100%;" /></p>' +
                '<p><label>תשובה:</label>' +
                '<textarea name="rslawfirm_faqs[' + faqIndex + '][answer]" rows="3" style="width: 100%;"></textarea></p>' +
                '<button type="button" class="remove-faq">הסר שאלה</button><hr></div>';
            $('#rslawfirm-faqs-container').append(html);
            faqIndex++;
        });
        
        $(document).on('click', '.remove-faq', function() {
            $(this).closest('.faq-item').remove();
        });
    });
    </script>
    <?php
}

function rslawfirm_save_seo_meta($post_id) {
    if (!isset($_POST['rslawfirm_seo_meta_nonce']) || 
        !wp_verify_nonce($_POST['rslawfirm_seo_meta_nonce'], 'rslawfirm_seo_meta_nonce')) {
        return;
    }
    
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
    if (!current_user_can('edit_post', $post_id)) return;
    
    if (isset($_POST['rslawfirm_faqs'])) {
        $faqs = array_filter($_POST['rslawfirm_faqs'], function($faq) {
            return !empty($faq['question']) && !empty($faq['answer']);
        });
        update_post_meta($post_id, 'rslawfirm_faqs', $faqs);
    }
}
add_action('save_post', 'rslawfirm_save_seo_meta');

/**
 * Include FAQ Data System
 */
require_once get_stylesheet_directory() . '/inc/faq-data.php';

/**
 * Include Performance Optimization
 */
require_once get_stylesheet_directory() . '/inc/performance-optimization.php';


