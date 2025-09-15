<?php
/**
 * RS Law Firm - Enhanced SEO & AEO
 */

if (!defined('ABSPATH')) exit;

/**
 * Enqueue child theme styles
 */
function rslawfirm_enqueue() {
    wp_enqueue_style(
        'rslawfirm-child-style',
        get_stylesheet_directory_uri() . '/style.css',
        ['hello-elementor-theme-style'],
        '2.1.0'
    );
}
add_action('wp_enqueue_scripts', 'rslawfirm_enqueue');

/**
 * ==============================
 * STRUCTURED DATA (JSON-LD)
 * ==============================
 */
class RSLawFirm_Schema {

    public function __construct() {
        add_action('wp_head', [$this, 'organization_schema']);
        add_action('wp_head', [$this, 'page_schema']);
        add_action('wp_head', [$this, 'breadcrumb_schema']);
        add_action('wp_head', [$this, 'video_schema']);
    }

    /** Site-wide Organization/LegalService schema */
    public function organization_schema() {
        if (!is_front_page()) return;

        $schema = [
            '@context' => 'https://schema.org',
            '@type'    => 'LegalService',
            'name'     => 'Rachel Schachar Law Office',
            'alternateName' => 'משרד עורכי דין רחל שחר',
            'url'      => home_url('/'),
            'logo'     => get_stylesheet_directory_uri() . '/assets/images/logo.png',
            'image'    => get_stylesheet_directory_uri() . '/assets/images/office.jpg',
            'telephone'=> '+972-XX-XXXXXXX',
            'address'  => [	
                '@type' => 'PostalAddress',
                'streetAddress'   => 'רחוב המשרד 1',
                'addressLocality' => 'תל אביב',
                'postalCode'      => 'XXXXX',
                'addressCountry'  => 'IL'
            ],
            'areaServed' => 'IL',
            'priceRange' => '$$',
            'openingHours' => 'Mo-Th 09:00-17:00',
            'sameAs' => array_filter([
                'https://www.tiktok.com/@YOUR_HANDLE',
                'https://www.facebook.com/YOUR_PAGE',
                'https://www.linkedin.com/in/YOUR_PROFILE'
            ])
        ];

        echo '<script type="application/ld+json">'.wp_json_encode($schema, JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES).'</script>';
    }

    /** Per-page schema: LegalService + FAQPage + Person */
    public function page_schema() {
        global $post;
        if (!is_singular() || empty($post)) return;

        $slug = $post->post_name;

        // Map service pages - Updated to match actual website services
        $services = [
            'divorce'           => 'גירושין',
            'family-law'        => 'דיני משפחה',
            'wills-inheritance' => 'צוואות וירושה',
            'guardianship'      => 'אפוטרופסות',
            'real-estate'       => 'דיני מקרקעין',
            'mediation'         => 'גישור'
        ];
        if (isset($services[$slug])) {
            $schema = [
                '@context' => 'https://schema.org',
                '@type'    => 'LegalService',
                'name'     => $services[$slug],
                'serviceType' => $services[$slug],
                'provider' => [
                    '@type' => 'Organization',
                    'name'  => 'Rachel Schachar Law Office'
                ],
                'areaServed' => 'IL'
            ];
            echo '<script type="application/ld+json">'.wp_json_encode($schema, JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES).'</script>';
        }

        // About page: Person schema
        if (in_array($slug, ['about','rachel-schachar-law-office-about'])) {
            $person = [
                '@context' => 'https://schema.org',
                '@type'    => 'Person',
                'name'     => 'עו״ד רחל שחר',
                'jobTitle' => 'Attorney',
                'worksFor' => [
                    '@type' => 'LegalService',
                    'name'  => 'Rachel Schachar Law Office'
                ],
                'url'   => get_permalink(),
                'image' => get_stylesheet_directory_uri().'/assets/images/rachel.jpg',
                'sameAs'=> [
                    'https://www.tiktok.com/@YOUR_HANDLE',
                    'https://www.linkedin.com/in/YOUR_PROFILE'
                ]
            ];
            echo '<script type="application/ld+json">'.wp_json_encode($person, JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES).'</script>';
        }

        // FAQs (from meta box)
        $faqs = get_post_meta($post->ID, 'rslawfirm_faqs', true);
        if ($faqs && is_array($faqs)) {
            $items = [];
            foreach ($faqs as $f) {
                $items[] = [
                    '@type' => 'Question',
                    'name'  => $f['question'],
                    'acceptedAnswer' => [
                        '@type' => 'Answer',
                        'text'  => $f['answer']
                    ]
                ];
            }
            if (!empty($items)) {
                $faq_schema = [
                    '@context' => 'https://schema.org',
                    '@type'    => 'FAQPage',
                    'mainEntity' => $items
                ];
                echo '<script type="application/ld+json">'.wp_json_encode($faq_schema, JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES).'</script>';
            }
        }
    }

    /** Breadcrumb schema */
    public function breadcrumb_schema() {
        if (is_front_page()) return;
        global $post;

        $crumbs = [
            [
                '@type' => 'ListItem',
                'position' => 1,
                'name' => 'בית',
                'item' => home_url('/')
            ]
        ];
        if (is_singular() && $post) {
            $crumbs[] = [
                '@type' => 'ListItem',
                'position' => 2,
                'name' => get_the_title($post->ID),
                'item' => get_permalink($post->ID)
            ];
        }

        $schema = [
            '@context' => 'https://schema.org',
            '@type'    => 'BreadcrumbList',
            'itemListElement' => $crumbs
        ];
        echo '<script type="application/ld+json">'.wp_json_encode($schema, JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES).'</script>';
    }

    /** TikTok / video embeds schema */
    public function video_schema() {
        if (!is_singular()) return;

        // Example static TikTok — replace with dynamic detection
        $schema = [
            '@context' => 'https://schema.org',
            '@type'    => 'VideoObject',
            'name'     => 'טיפ משפטי קצר על משמורת',
            'description' => 'עו״ד רחל שחר מסבירה על משמורת ילדים בדקה אחת.',
            'thumbnailUrl' => ['https://example.com/path/to/thumb.jpg'],
            'uploadDate'   => '2025-08-15',
            'embedUrl'     => 'https://www.tiktok.com/@YOUR_HANDLE/video/1234567890',
            'contentUrl'   => get_permalink()
        ];
        echo '<script type="application/ld+json">'.wp_json_encode($schema, JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES).'</script>';
    }
}
new RSLawFirm_Schema();

/**
 * Enhanced meta + OG/Twitter
 */
function rslawfirm_meta() {
    global $post;
    echo '<meta name="robots" content="index,follow,max-snippet:-1,max-image-preview:large,max-video-preview:-1">'."\n";
    if (!is_singular()) return;

    $desc = get_post_meta($post->ID, '_yoast_wpseo_metadesc', true);
    if (empty($desc)) {
        $desc = wp_trim_words(strip_tags($post->post_content), 25, '...');
    }

    echo '<meta property="og:locale" content="he_IL" />'."\n";
    echo '<meta property="og:type" content="article" />'."\n";
    echo '<meta property="og:title" content="'.esc_attr(get_the_title()).'" />'."\n";
    echo '<meta property="og:description" content="'.esc_attr($desc).'" />'."\n";
    echo '<meta property="og:url" content="'.esc_url(get_permalink()).'" />'."\n";
    echo '<meta property="og:site_name" content="Rachel Schachar Law Office" />'."\n";

    echo '<meta name="twitter:card" content="summary_large_image" />'."\n";
    echo '<meta name="twitter:title" content="'.esc_attr(get_the_title()).'" />'."\n";
    echo '<meta name="twitter:description" content="'.esc_attr($desc).'" />'."\n";
    echo '<link rel="canonical" href="'.esc_url(get_permalink()).'" />'."\n";
}
add_action('wp_head','rslawfirm_meta',5);