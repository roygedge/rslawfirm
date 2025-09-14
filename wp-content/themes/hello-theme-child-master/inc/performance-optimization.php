<?php
/**
 * RS Law Firm - Performance Optimization
 * Core Web Vitals Enhancement for Hebrew Legal Site
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Performance Optimization Class
 */
class RSLawFirm_Performance {
    
    public function __construct() {
        add_action('wp_head', [$this, 'preload_critical_resources'], 1);
        add_action('wp_head', [$this, 'dns_prefetch'], 2);
        add_filter('script_loader_tag', [$this, 'add_defer_attribute'], 10, 2);
        add_filter('style_loader_tag', [$this, 'add_preload_for_styles'], 10, 2);
        add_action('wp_enqueue_scripts', [$this, 'optimize_scripts_styles'], 999);
        add_filter('wp_img_tag_add_loading_attr', [$this, 'add_loading_lazy'], 10, 3);
        add_action('init', [$this, 'enable_gzip_compression']);
        add_action('wp_head', [$this, 'add_resource_hints']);
    }
    
    /**
     * Preload critical resources for faster LCP
     */
    public function preload_critical_resources() {
        // Preload critical Hebrew fonts
        echo '<link rel="preload" href="https://fonts.gstatic.com/s/heebo/v21/NGSpv5_NC0k9P_v6ZUCbLRAHxK1EiS2cUyI.woff2" as="font" type="font/woff2" crossorigin>' . "\n";
        echo '<link rel="preload" href="https://fonts.gstatic.com/s/assistant/v18/2sDPZGJYnIjSi6H75xXGZO1CkqQ.woff2" as="font" type="font/woff2" crossorigin>' . "\n";
        
        // Preload critical CSS
        echo '<link rel="preload" href="' . get_stylesheet_directory_uri() . '/style.css" as="style">' . "\n";
        
        // Preload hero image if exists
        if (is_front_page()) {
            $hero_image = get_stylesheet_directory_uri() . '/assets/images/hero-bg.jpg';
            echo '<link rel="preload" href="' . $hero_image . '" as="image">' . "\n";
        }
    }
    
    /**
     * DNS prefetch for external resources
     */
    public function dns_prefetch() {
        $prefetch_domains = [
            '//fonts.googleapis.com',
            '//fonts.gstatic.com',
            '//www.google-analytics.com',
            '//www.googletagmanager.com',
            '//connect.facebook.net'
        ];
        
        foreach ($prefetch_domains as $domain) {
            echo '<link rel="dns-prefetch" href="' . $domain . '">' . "\n";
        }
    }
    
    /**
     * Add defer attribute to non-critical scripts
     */
    public function add_defer_attribute($tag, $handle) {
        $defer_scripts = [
            'rslawfirm-seo-enhancements',
            'jquery-ui-core',
            'contact-form-7'
        ];
        
        if (in_array($handle, $defer_scripts)) {
            return str_replace(' src', ' defer src', $tag);
        }
        
        return $tag;
    }
    
    /**
     * Preload critical stylesheets
     */
    public function add_preload_for_styles($html, $handle) {
        $critical_styles = [
            'hello-elementor-theme-style',
            'hello-elementor-child-style'
        ];
        
        if (in_array($handle, $critical_styles)) {
            $html = str_replace("rel='stylesheet'", "rel='preload' as='style' onload=\"this.onload=null;this.rel='stylesheet'\"", $html);
            $html .= '<noscript>' . str_replace(' onload="this.onload=null;this.rel=\'stylesheet\'"', '', $html) . '</noscript>';
        }
        
        return $html;
    }
    
    /**
     * Optimize scripts and styles loading
     */
    public function optimize_scripts_styles() {
        // Remove unused WordPress default styles/scripts
        if (!is_admin()) {
            wp_dequeue_style('wp-block-library');
            wp_dequeue_style('wp-block-library-theme');
            wp_dequeue_style('wc-blocks-style');
            wp_dequeue_script('wp-embed');
        }
        
        // Combine and minify CSS (if not using a plugin)
        if (!defined('WP_DEBUG') || !WP_DEBUG) {
            $this->minify_inline_css();
        }
    }
    
    /**
     * Add loading="lazy" to images
     */
    public function add_loading_lazy($loading_attr, $tag_name, $context) {
        if ('img' === $tag_name && 'the_content' === $context) {
            return 'lazy';
        }
        return $loading_attr;
    }
    
    /**
     * Enable Gzip compression
     */
    public function enable_gzip_compression() {
        if (!ob_get_level() && !ini_get('output_buffering')) {
            ob_start([$this, 'gzip_output']);
        }
    }
    
    /**
     * Gzip output buffer
     */
    public function gzip_output($buffer) {
        if (function_exists('gzencode') && !headers_sent()) {
            $encoding = $this->get_encoding();
            if ($encoding) {
                header('Content-Encoding: ' . $encoding);
                if ($encoding === 'gzip') {
                    return gzencode($buffer);
                } elseif ($encoding === 'deflate') {
                    return gzdeflate($buffer);
                }
            }
        }
        return $buffer;
    }
    
    /**
     * Get best encoding method
     */
    private function get_encoding() {
        if (isset($_SERVER['HTTP_ACCEPT_ENCODING'])) {
            $accept_encoding = $_SERVER['HTTP_ACCEPT_ENCODING'];
            if (strpos($accept_encoding, 'gzip') !== false) {
                return 'gzip';
            } elseif (strpos($accept_encoding, 'deflate') !== false) {
                return 'deflate';
            }
        }
        return false;
    }
    
    /**
     * Add resource hints
     */
    public function add_resource_hints() {
        // Preconnect to external domains
        echo '<link rel="preconnect" href="https://fonts.googleapis.com">' . "\n";
        echo '<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>' . "\n";
        
        // Add viewport meta for mobile optimization
        if (!has_action('wp_head', 'wp_site_icon')) {
            echo '<meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">' . "\n";
        }
    }
    
    /**
     * Minify inline CSS
     */
    private function minify_inline_css() {
        ob_start(function($buffer) {
            // Simple CSS minification
            $buffer = preg_replace('/\/\*.*?\*\//s', '', $buffer);
            $buffer = preg_replace('/\s+/', ' ', $buffer);
            $buffer = str_replace(['; ', ' {', '{ ', ' }', '} ', ': '], [';', '{', '{', '}', '}', ':'], $buffer);
            return trim($buffer);
        });
    }
    
    /**
     * Critical CSS for above-the-fold content
     */
    public static function get_critical_css() {
        return "
        body{font-family:'Heebo','Assistant','Rubik',Arial,sans-serif;line-height:1.6;color:#333;margin:0;padding:0}
        .value-proposition{background:linear-gradient(135deg,#007cba 0%,#0056b3 100%);color:#fff;padding:40px;border-radius:12px;margin:30px 0;text-align:center}
        .value-proposition h1{font-size:2.5em;margin-bottom:20px;font-weight:700}
        .primary-cta{display:inline-block;background:linear-gradient(135deg,#28a745 0%,#20c997 100%);color:#fff;padding:15px 30px;border-radius:50px;text-decoration:none;font-weight:600}
        .mobile-sticky-cta{position:fixed;bottom:0;left:0;right:0;z-index:9999;background:#fff;box-shadow:0 -4px 20px rgba(0,0,0,0.15)}
        @media (max-width:768px){.value-proposition{padding:30px 20px}.value-proposition h1{font-size:2em}}
        ";
    }
}

// Initialize performance optimization
new RSLawFirm_Performance();

/**
 * Add critical CSS inline
 */
function rslawfirm_add_critical_css() {
    echo '<style id="rslawfirm-critical-css">' . RSLawFirm_Performance::get_critical_css() . '</style>' . "\n";
}
add_action('wp_head', 'rslawfirm_add_critical_css', 3);

/**
 * WebP image support
 */
function rslawfirm_add_webp_support() {
    ?>
    <script>
    (function() {
        var webP = new Image();
        webP.onload = webP.onerror = function() {
            if (webP.height === 2) {
                document.documentElement.classList.add('webp-support');
            }
        };
        webP.src = 'data:image/webp;base64,UklGRjoAAABXRUJQVlA4IC4AAACyAgCdASoCAAIALmk0mk0iIiIiIgBoSygABc6WWgAA/veff/0PP8bA//LwYAAA';
    })();
    </script>
    <?php
}
add_action('wp_head', 'rslawfirm_add_webp_support', 4);

/**
 * Service Worker for caching (basic implementation)
 */
function rslawfirm_add_service_worker() {
    if (!is_admin()) {
        ?>
        <script>
        if ('serviceWorker' in navigator) {
            window.addEventListener('load', function() {
                navigator.serviceWorker.register('<?php echo home_url('/sw.js'); ?>')
                    .then(function(registration) {
                        console.log('SW registered: ', registration);
                    })
                    .catch(function(registrationError) {
                        console.log('SW registration failed: ', registrationError);
                    });
            });
        }
        </script>
        <?php
    }
}
add_action('wp_footer', 'rslawfirm_add_service_worker');

/**
 * Generate service worker file
 */
function rslawfirm_generate_service_worker() {
    $sw_content = "
const CACHE_NAME = 'rslawfirm-v1';
const urlsToCache = [
    '/',
    '/wp-content/themes/hello-theme-child-master/style.css',
    '/wp-content/themes/hello-theme-child-master/assets/js/seo-enhancements.js'
];

self.addEventListener('install', function(event) {
    event.waitUntil(
        caches.open(CACHE_NAME)
            .then(function(cache) {
                return cache.addAll(urlsToCache);
            })
    );
});

self.addEventListener('fetch', function(event) {
    event.respondWith(
        caches.match(event.request)
            .then(function(response) {
                if (response) {
                    return response;
                }
                return fetch(event.request);
            }
        )
    );
});
    ";
    
    file_put_contents(ABSPATH . 'sw.js', $sw_content);
}
add_action('init', 'rslawfirm_generate_service_worker');

/**
 * Optimize database queries
 */
function rslawfirm_optimize_queries() {
    // Remove unnecessary queries
    remove_action('wp_head', 'wp_generator');
    remove_action('wp_head', 'wlwmanifest_link');
    remove_action('wp_head', 'rsd_link');
    remove_action('wp_head', 'wp_shortlink_wp_head');
    remove_action('wp_head', 'adjacent_posts_rel_link_wp_head');
    
    // Disable emojis
    remove_action('wp_head', 'print_emoji_detection_script', 7);
    remove_action('admin_print_scripts', 'print_emoji_detection_script');
    remove_action('wp_print_styles', 'print_emoji_styles');
    remove_action('admin_print_styles', 'print_emoji_styles');
    remove_filter('the_content_feed', 'wp_staticize_emoji');
    remove_filter('comment_text_rss', 'wp_staticize_emoji');
    remove_filter('wp_mail', 'wp_staticize_emoji_for_email');
}
add_action('init', 'rslawfirm_optimize_queries');

/**
 * Hebrew font optimization
 */
function rslawfirm_optimize_hebrew_fonts() {
    wp_enqueue_style('rslawfirm-hebrew-fonts', 'https://fonts.googleapis.com/css2?family=Heebo:wght@300;400;600;700&family=Assistant:wght@300;400;600;700&display=swap', [], null);
}
add_action('wp_enqueue_scripts', 'rslawfirm_optimize_hebrew_fonts', 1);

/**
 * Lazy load images with intersection observer
 */
function rslawfirm_lazy_load_images($content) {
    if (is_admin() || is_feed() || defined('DOING_AJAX')) {
        return $content;
    }
    
    // Add loading="lazy" and data-src for intersection observer
    $content = preg_replace_callback('/<img([^>]+)>/i', function($matches) {
        $img_tag = $matches[0];
        
        // Skip if already has loading attribute
        if (strpos($img_tag, 'loading=') !== false) {
            return $img_tag;
        }
        
        // Add loading="lazy"
        $img_tag = str_replace('<img', '<img loading="lazy"', $img_tag);
        
        return $img_tag;
    }, $content);
    
    return $content;
}
add_filter('the_content', 'rslawfirm_lazy_load_images');

/**
 * Preload key pages
 */
function rslawfirm_preload_key_pages() {
    $key_pages = [
        home_url('/labor-law'),
        home_url('/personal-injury'),
        home_url('/contact')
    ];
    
    foreach ($key_pages as $url) {
        echo '<link rel="prefetch" href="' . esc_url($url) . '">' . "\n";
    }
}
add_action('wp_head', 'rslawfirm_preload_key_pages', 5);
