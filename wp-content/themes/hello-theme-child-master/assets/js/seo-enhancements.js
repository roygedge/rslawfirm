/**
 * RS Law Firm - SEO & AEO Enhancement Scripts
 * Hebrew Law Firm Technical SEO + Answer Engine Optimization
 */

jQuery(document).ready(function($) {
    'use strict';
    
    // Initialize all SEO enhancements
    RSLawFirm.init();
});

var RSLawFirm = {
    
    /**
     * Initialize all components
     */
    init: function() {
        this.initMobileStickyCTA();
        this.initPerformanceOptimizations();
        this.initAccessibilityEnhancements();
        this.initFAQInteractions();
        this.initContactTracking();
        this.initLazyLoading();
        this.initSearchEngineOptimizations();
    },
    
    /**
     * Mobile Sticky CTA Enhancement
     */
    initMobileStickyCTA: function() {
        var $stickyCTA = $('#rslawfirm-mobile-sticky-cta');
        var $body = $('body');
        
        // Show/hide based on screen size
        function toggleStickyCTA() {
            if ($(window).width() <= 768) {
                $stickyCTA.show();
                $body.css('padding-bottom', '80px'); // Prevent content overlap
            } else {
                $stickyCTA.hide();
                $body.css('padding-bottom', '0');
            }
        }
        
        toggleStickyCTA();
        $(window).resize(RSLawFirm.debounce(toggleStickyCTA, 250));
        
        // Track CTA clicks for analytics
        $stickyCTA.find('a').on('click', function() {
            var action = $(this).hasClass('cta-phone') ? 'phone_call' : 'whatsapp_click';
            RSLawFirm.trackEvent('mobile_cta', action, 'sticky_footer');
        });
    },
    
    /**
     * Performance Optimizations
     */
    initPerformanceOptimizations: function() {
        // Preload critical resources
        this.preloadCriticalResources();
        
        // Optimize images
        this.optimizeImages();
        
        // Defer non-critical scripts
        this.deferNonCriticalScripts();
        
        // Implement intersection observer for animations
        this.initIntersectionObserver();
    },
    
    /**
     * Preload critical resources
     */
    preloadCriticalResources: function() {
        // Preload Hebrew fonts
        var hebrewFonts = [
            'https://fonts.googleapis.com/css2?family=Heebo:wght@300;400;600;700&display=swap',
            'https://fonts.googleapis.com/css2?family=Assistant:wght@300;400;600;700&display=swap'
        ];
        
        hebrewFonts.forEach(function(font) {
            var link = document.createElement('link');
            link.rel = 'preload';
            link.as = 'style';
            link.href = font;
            document.head.appendChild(link);
        });
    },
    
    /**
     * Optimize images for better performance
     */
    optimizeImages: function() {
        // Add loading="lazy" to images that don't have it
        $('img:not([loading])').attr('loading', 'lazy');
        
        // Add proper alt texts for SEO (if missing)
        $('img:not([alt])').each(function() {
            var $img = $(this);
            var altText = $img.attr('title') || $img.closest('figure').find('figcaption').text() || 'תמונה';
            $img.attr('alt', altText);
        });
        
        // Implement WebP fallback
        this.implementWebPFallback();
    },
    
    /**
     * WebP image format fallback
     */
    implementWebPFallback: function() {
        // Check WebP support
        var webpSupport = false;
        var webP = new Image();
        webP.onload = webP.onerror = function() {
            webpSupport = (webP.height === 2);
            if (webpSupport) {
                $('body').addClass('webp-support');
            }
        };
        webP.src = 'data:image/webp;base64,UklGRjoAAABXRUJQVlA4IC4AAACyAgCdASoCAAIALmk0mk0iIiIiIgBoSygABc6WWgAA/veff/0PP8bA//LwYAAA';
    },
    
    /**
     * Accessibility Enhancements
     */
    initAccessibilityEnhancements: function() {
        // Add ARIA labels to navigation
        $('nav:not([aria-label])').attr('aria-label', 'תפריט ראשי');
        
        // Enhance form accessibility
        $('form input, form textarea, form select').each(function() {
            var $field = $(this);
            var $label = $('label[for="' + $field.attr('id') + '"]');
            
            if ($label.length === 0) {
                var placeholder = $field.attr('placeholder');
                if (placeholder) {
                    $field.attr('aria-label', placeholder);
                }
            }
        });
        
        // Add skip link
        this.addSkipLink();
        
        // Enhance keyboard navigation
        this.enhanceKeyboardNavigation();
    },
    
    /**
     * Add skip link for accessibility
     */
    addSkipLink: function() {
        if ($('#skip-link').length === 0) {
            $('body').prepend('<a id="skip-link" class="sr-only" href="#main">דלג לתוכן הראשי</a>');
            
            $('#skip-link').on('focus', function() {
                $(this).removeClass('sr-only').css({
                    'position': 'fixed',
                    'top': '10px',
                    'left': '10px',
                    'z-index': '10000',
                    'background': '#007cba',
                    'color': '#fff',
                    'padding': '10px',
                    'border-radius': '4px',
                    'text-decoration': 'none'
                });
            }).on('blur', function() {
                $(this).addClass('sr-only').removeAttr('style');
            });
        }
    },
    
    /**
     * Enhance keyboard navigation
     */
    enhanceKeyboardNavigation: function() {
        // Add focus indicators
        $('a, button, input, textarea, select').on('focus', function() {
            $(this).addClass('keyboard-focus');
        }).on('blur', function() {
            $(this).removeClass('keyboard-focus');
        });
        
        // Handle escape key for modals/dropdowns
        $(document).on('keydown', function(e) {
            if (e.keyCode === 27) { // Escape key
                $('.modal, .dropdown-menu').hide();
                $('[aria-expanded="true"]').attr('aria-expanded', 'false');
            }
        });
    },
    
    /**
     * FAQ Interactions for better UX
     */
    initFAQInteractions: function() {
        // Smooth accordion animation
        $('details').each(function() {
            var $details = $(this);
            var $summary = $details.find('summary');
            
            $summary.on('click', function(e) {
                // Track FAQ interactions
                var question = $summary.text().trim();
                RSLawFirm.trackEvent('faq_interaction', 'question_opened', question);
            });
        });
        
        // Add FAQ search functionality
        this.addFAQSearch();
    },
    
    /**
     * Add FAQ search functionality
     */
    addFAQSearch: function() {
        var $faqSection = $('.faq-section');
        if ($faqSection.length > 0) {
            var searchHTML = '<div class="faq-search" style="margin-bottom: 20px;">' +
                '<input type="text" placeholder="חפש בשאלות נפוצות..." ' +
                'style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px;">' +
                '</div>';
            
            $faqSection.prepend(searchHTML);
            
            $('.faq-search input').on('input', RSLawFirm.debounce(function() {
                var searchTerm = $(this).val().toLowerCase();
                
                $('details').each(function() {
                    var $details = $(this);
                    var text = $details.text().toLowerCase();
                    
                    if (text.includes(searchTerm) || searchTerm === '') {
                        $details.show();
                    } else {
                        $details.hide();
                    }
                });
            }, 300));
        }
    },
    
    /**
     * Contact tracking for analytics
     */
    initContactTracking: function() {
        // Track phone calls
        $('a[href^="tel:"]').on('click', function() {
            var phone = $(this).attr('href').replace('tel:', '');
            RSLawFirm.trackEvent('contact', 'phone_call', phone);
        });
        
        // Track WhatsApp clicks
        $('a[href*="wa.me"], a[href*="whatsapp.com"]').on('click', function() {
            RSLawFirm.trackEvent('contact', 'whatsapp_click', 'consultation');
        });
        
        // Track form submissions
        $('form').on('submit', function() {
            var formName = $(this).attr('id') || $(this).attr('class') || 'contact_form';
            RSLawFirm.trackEvent('form', 'submission', formName);
        });
    },
    
    /**
     * Lazy loading enhancements
     */
    initLazyLoading: function() {
        // Enhanced lazy loading with intersection observer
        if ('IntersectionObserver' in window) {
            var lazyImageObserver = new IntersectionObserver(function(entries, observer) {
                entries.forEach(function(entry) {
                    if (entry.isIntersecting) {
                        var lazyImage = entry.target;
                        lazyImage.src = lazyImage.dataset.src;
                        lazyImage.classList.remove('lazy');
                        lazyImageObserver.unobserve(lazyImage);
                    }
                });
            });
            
            $('.lazy').each(function() {
                lazyImageObserver.observe(this);
            });
        }
    },
    
    /**
     * Search Engine Optimizations
     */
    initSearchEngineOptimizations: function() {
        // Add structured data for user interactions
        this.trackUserBehavior();
        
        // Enhance internal linking
        this.enhanceInternalLinking();
        
        // Add breadcrumb navigation
        this.addBreadcrumbNavigation();
    },
    
    /**
     * Track user behavior for SEO insights
     */
    trackUserBehavior: function() {
        // Track scroll depth
        var scrollDepth = 0;
        $(window).on('scroll', RSLawFirm.throttle(function() {
            var currentScroll = $(window).scrollTop();
            var documentHeight = $(document).height() - $(window).height();
            var currentDepth = Math.round((currentScroll / documentHeight) * 100);
            
            if (currentDepth > scrollDepth && currentDepth % 25 === 0) {
                scrollDepth = currentDepth;
                RSLawFirm.trackEvent('engagement', 'scroll_depth', scrollDepth + '%');
            }
        }, 500));
        
        // Track time on page
        var startTime = Date.now();
        $(window).on('beforeunload', function() {
            var timeSpent = Math.round((Date.now() - startTime) / 1000);
            RSLawFirm.trackEvent('engagement', 'time_on_page', timeSpent + 's');
        });
    },
    
    /**
     * Enhance internal linking
     */
    enhanceInternalLinking: function() {
        // Add related links based on content
        var currentPage = window.location.pathname;
        var relatedLinks = {
            '/labor-law': ['דיני עבודה', 'personal-injury', 'family-law'],
            '/personal-injury': ['נזקי גוף', 'labor-law', 'criminal-law'],
            '/real-estate': ['דיני מקרקעין', 'debt-collection', 'family-law'],
            '/criminal-law': ['דיני פלילי', 'personal-injury', 'labor-law'],
            '/debt-collection': ['הוצאה לפועל', 'real-estate', 'labor-law'],
            '/family-law': ['דיני משפחה', 'labor-law', 'real-estate']
        };
        
        // Add related links section
        if (relatedLinks[currentPage]) {
            this.addRelatedLinksSection(relatedLinks[currentPage]);
        }
    },
    
    /**
     * Add related links section
     */
    addRelatedLinksSection: function(links) {
        var relatedHTML = '<div class="related-links" style="margin: 40px 0; padding: 30px; background: #f8f9fa; border-radius: 8px;">' +
            '<h3 style="color: #007cba; margin-bottom: 20px;">תחומים קשורים</h3>' +
            '<ul style="list-style: none; padding: 0;">';
        
        links.forEach(function(link) {
            relatedHTML += '<li style="margin-bottom: 10px;">' +
                '<a href="/' + link + '" style="color: #007cba; text-decoration: none; font-weight: 500;">' +
                '← ' + link + '</a></li>';
        });
        
        relatedHTML += '</ul></div>';
        
        // Insert before footer or at end of main content
        var $main = $('main, .main-content, .content');
        if ($main.length > 0) {
            $main.append(relatedHTML);
        }
    },
    
    /**
     * Add breadcrumb navigation
     */
    addBreadcrumbNavigation: function() {
        if ($('.breadcrumbs').length === 0 && !$('body').hasClass('home')) {
            var breadcrumbHTML = '<nav class="breadcrumbs" aria-label="נתיב ניווט">' +
                '<ul>' +
                '<li><a href="/">בית</a></li>' +
                '<li>' + document.title.split(' - ')[0] + '</li>' +
                '</ul>' +
                '</nav>';
            
            var $main = $('main, .main-content, .content');
            if ($main.length > 0) {
                $main.prepend(breadcrumbHTML);
            }
        }
    },
    
    /**
     * Initialize intersection observer for animations
     */
    initIntersectionObserver: function() {
        if ('IntersectionObserver' in window) {
            var animationObserver = new IntersectionObserver(function(entries) {
                entries.forEach(function(entry) {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('animate-in');
                    }
                });
            }, {
                threshold: 0.1,
                rootMargin: '0px 0px -50px 0px'
            });
            
            $('.step-item, .case-example, .tldr').each(function() {
                animationObserver.observe(this);
            });
        }
    },
    
    /**
     * Event tracking utility
     */
    trackEvent: function(category, action, label) {
        // Google Analytics 4
        if (typeof gtag !== 'undefined') {
            gtag('event', action, {
                'event_category': category,
                'event_label': label
            });
        }
        
        // Facebook Pixel
        if (typeof fbq !== 'undefined') {
            fbq('track', 'CustomEvent', {
                category: category,
                action: action,
                label: label
            });
        }
        
        // Console log for debugging
        console.log('Event tracked:', category, action, label);
    },
    
    /**
     * Utility functions
     */
    debounce: function(func, wait) {
        var timeout;
        return function executedFunction() {
            var context = this;
            var args = arguments;
            var later = function() {
                timeout = null;
                func.apply(context, args);
            };
            clearTimeout(timeout);
            timeout = setTimeout(later, wait);
        };
    },
    
    throttle: function(func, limit) {
        var inThrottle;
        return function() {
            var args = arguments;
            var context = this;
            if (!inThrottle) {
                func.apply(context, args);
                inThrottle = true;
                setTimeout(function() {
                    inThrottle = false;
                }, limit);
            }
        };
    }
};

// Add CSS animations
var animationCSS = `
    .animate-in {
        animation: slideInUp 0.6s ease-out forwards;
    }
    
    @keyframes slideInUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    .keyboard-focus {
        outline: 2px solid #007cba !important;
        outline-offset: 2px !important;
    }
    
    .webp-support .lazy[data-src$=".jpg"],
    .webp-support .lazy[data-src$=".png"] {
        /* WebP optimization can be added here */
    }
`;

// Inject animation CSS
var style = document.createElement('style');
style.textContent = animationCSS;
document.head.appendChild(style);
