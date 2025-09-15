<?php
/**
 * Template Name: מפת האתר - HTML Sitemap
 * RS Law Firm - Hebrew HTML Sitemap
 */

get_header(); ?>

<main id="main" class="site-main" role="main" lang="he-IL">
    
    <div class="container" style="max-width: 1000px; margin: 0 auto; padding: 20px;">
        
        <h1>מפת האתר - כל הדפים באתר</h1>
        <p>מפת האתר מציגה את כל הדפים והתכנים הזמינים באתר שלנו לנוחותכם.</p>
        
        <div class="sitemap-grid" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 30px; margin-top: 30px;">
            
            <!-- Main Pages -->
            <section class="sitemap-section">
                <h2 style="color: #007cba; border-bottom: 2px solid #007cba; padding-bottom: 10px;">דפים ראשיים</h2>
                <ul style="list-style: none; padding: 0;">
                    <li style="margin-bottom: 8px;">
                        <a href="<?php echo home_url('/'); ?>" style="color: #007cba; text-decoration: none; font-weight: 500;">🏠 עמוד הבית</a>
                    </li>
                    <li style="margin-bottom: 8px;">
                        <a href="<?php echo home_url('/about'); ?>" style="color: #007cba; text-decoration: none; font-weight: 500;">👥 אודותינו</a>
                    </li>
                    <li style="margin-bottom: 8px;">
                        <a href="<?php echo home_url('/contact'); ?>" style="color: #007cba; text-decoration: none; font-weight: 500;">📞 יצירת קשר</a>
                    </li>
                    <li style="margin-bottom: 8px;">
                        <a href="<?php echo home_url('/consultation'); ?>" style="color: #007cba; text-decoration: none; font-weight: 500;">💬 קביעת ייעוץ</a>
                    </li>
                </ul>
            </section>

            <!-- Legal Services - Updated to match actual website -->
            <section class="sitemap-section">
                <h2 style="color: #007cba; border-bottom: 2px solid #007cba; padding-bottom: 10px;">תחומי התמחות</h2>
                <ul style="list-style: none; padding: 0;">
                    <li style="margin-bottom: 8px;">
                        <a href="<?php echo home_url('/divorce'); ?>" style="color: #007cba; text-decoration: none; font-weight: 500;">👨‍👩‍👧‍👦 גירושין</a>
                        <ul style="margin-top: 5px; padding-right: 15px;">
                            <li><a href="<?php echo home_url('/divorce#child-support'); ?>" style="color: #666; font-size: 0.9em;">מזונות ילדים</a></li>
                            <li><a href="<?php echo home_url('/divorce#property-division'); ?>" style="color: #666; font-size: 0.9em;">חלוקת רכוש</a></li>
                            <li><a href="<?php echo home_url('/divorce#custody'); ?>" style="color: #666; font-size: 0.9em;">אחריות הורית</a></li>
                        </ul>
                    </li>
                    <li style="margin-bottom: 8px;">
                        <a href="<?php echo home_url('/wills-inheritance'); ?>" style="color: #007cba; text-decoration: none; font-weight: 500;">📜 צוואות וירושה</a>
                        <ul style="margin-top: 5px; padding-right: 15px;">
                            <li><a href="<?php echo home_url('/wills-inheritance#will-objection'); ?>" style="color: #666; font-size: 0.9em;">הגשת התנגדות לצוואה</a></li>
                            <li><a href="<?php echo home_url('/wills-inheritance#will-defense'); ?>" style="color: #666; font-size: 0.9em;">הגנה על צוואה</a></li>
                            <li><a href="<?php echo home_url('/wills-inheritance#remote-deposit'); ?>" style="color: #666; font-size: 0.9em;">הפקדת צוואה מרחוק</a></li>
                            <li><a href="<?php echo home_url('/wills-inheritance#creating-will'); ?>" style="color: #666; font-size: 0.9em;">עריכת צוואה עצמאית</a></li>
                            <li><a href="<?php echo home_url('/wills-inheritance#property-registration'); ?>" style="color: #666; font-size: 0.9em;">רישום נכס בירושה</a></li>
                        </ul>
                    </li>
                    <li style="margin-bottom: 8px;">
                        <a href="<?php echo home_url('/guardianship'); ?>" style="color: #007cba; text-decoration: none; font-weight: 500;">🛡️ אפוטרופסות</a>
                        <ul style="margin-top: 5px; padding-right: 15px;">
                            <li><a href="<?php echo home_url('/guardianship#enduring-power'); ?>" style="color: #666; font-size: 0.9em;">ייפוי כוח מתמשך</a></li>
                            <li><a href="<?php echo home_url('/guardianship#appointment'); ?>" style="color: #666; font-size: 0.9em;">מינוי אפוטרופוס</a></li>
                        </ul>
                    </li>
                    <li style="margin-bottom: 8px;">
                        <a href="<?php echo home_url('/prenuptial-agreements'); ?>" style="color: #007cba; text-decoration: none; font-weight: 500;">💍 הסכמי ממון</a>
                    </li>
                    <li style="margin-bottom: 8px;">
                        <a href="<?php echo home_url('/common-law-partnerships'); ?>" style="color: #007cba; text-decoration: none; font-weight: 500;">🤝 ידועים בציבור</a>
                    </li>
                    <li style="margin-bottom: 8px;">
                        <a href="<?php echo home_url('/real-estate'); ?>" style="color: #007cba; text-decoration: none; font-weight: 500;">🏘️ דיני מקרקעין</a>
                        <ul style="margin-top: 5px; padding-right: 15px;">
                            <li><a href="<?php echo home_url('/real-estate#property-purchase'); ?>" style="color: #666; font-size: 0.9em;">רכישת נכסים</a></li>
                            <li><a href="<?php echo home_url('/real-estate#rental-law'); ?>" style="color: #666; font-size: 0.9em;">דיני שכירות</a></li>
                        </ul>
                    </li>
                    <li style="margin-bottom: 8px;">
                        <a href="<?php echo home_url('/mediation'); ?>" style="color: #007cba; text-decoration: none; font-weight: 500;">🤝 גישור</a>
                    </li>
                </ul>
            </section>

            <!-- Legal Resources -->
            <section class="sitemap-section">
                <h2 style="color: #007cba; border-bottom: 2px solid #007cba; padding-bottom: 10px;">משאבים משפטיים</h2>
                <ul style="list-style: none; padding: 0;">
                    <li style="margin-bottom: 8px;">
                        <a href="<?php echo home_url('/faq'); ?>" style="color: #007cba; text-decoration: none; font-weight: 500;">❓ שאלות ותשובות</a>
                    </li>
                    <li style="margin-bottom: 8px;">
                        <a href="<?php echo home_url('/legal-forms'); ?>" style="color: #007cba; text-decoration: none; font-weight: 500;">📋 טפסים משפטיים</a>
                    </li>
                    <li style="margin-bottom: 8px;">
                        <a href="<?php echo home_url('/legal-guides'); ?>" style="color: #007cba; text-decoration: none; font-weight: 500;">📖 מדריכים משפטיים</a>
                    </li>
                    <li style="margin-bottom: 8px;">
                        <a href="<?php echo home_url('/legal-news'); ?>" style="color: #007cba; text-decoration: none; font-weight: 500;">📰 חדשות משפטיות</a>
                    </li>
                    <li style="margin-bottom: 8px;">
                        <a href="<?php echo home_url('/case-studies'); ?>" style="color: #007cba; text-decoration: none; font-weight: 500;">📊 מקרי מבחן</a>
                    </li>
                </ul>
            </section>

            <!-- Legal Information -->
            <section class="sitemap-section">
                <h2 style="color: #007cba; border-bottom: 2px solid #007cba; padding-bottom: 10px;">מידע משפטי</h2>
                <ul style="list-style: none; padding: 0;">
                    <li style="margin-bottom: 8px;">
                        <a href="<?php echo home_url('/privacy'); ?>" style="color: #007cba; text-decoration: none; font-weight: 500;">🔒 מדיניות פרטיות</a>
                    </li>
                    <li style="margin-bottom: 8px;">
                        <a href="<?php echo home_url('/terms'); ?>" style="color: #007cba; text-decoration: none; font-weight: 500;">📜 תנאי שימוש</a>
                    </li>
                    <li style="margin-bottom: 8px;">
                        <a href="<?php echo home_url('/disclaimer'); ?>" style="color: #007cba; text-decoration: none; font-weight: 500;">⚠️ הסתייגות משפטית</a>
                    </li>
                    <li style="margin-bottom: 8px;">
                        <a href="<?php echo home_url('/attorney-profiles'); ?>" style="color: #007cba; text-decoration: none; font-weight: 500;">👨‍⚖️ פרופילי עורכי דין</a>
                    </li>
                    <li style="margin-bottom: 8px;">
                        <a href="<?php echo home_url('/office-locations'); ?>" style="color: #007cba; text-decoration: none; font-weight: 500;">📍 מיקום המשרדים</a>
                    </li>
                </ul>
            </section>

            <!-- Recent Posts -->
            <section class="sitemap-section">
                <h2 style="color: #007cba; border-bottom: 2px solid #007cba; padding-bottom: 10px;">פוסטים אחרונים</h2>
                <ul style="list-style: none; padding: 0;">
                    <?php
                    $recent_posts = get_posts(array(
                        'numberposts' => 10,
                        'post_status' => 'publish'
                    ));
                    
                    if ($recent_posts) {
                        foreach ($recent_posts as $post) {
                            echo '<li style="margin-bottom: 8px;">';
                            echo '<a href="' . get_permalink($post->ID) . '" style="color: #007cba; text-decoration: none; font-weight: 500;">';
                            echo '📝 ' . get_the_title($post->ID);
                            echo '</a>';
                            echo '<br><small style="color: #666; font-size: 0.8em;">' . get_the_date('d/m/Y', $post->ID) . '</small>';
                            echo '</li>';
                        }
                    } else {
                        echo '<li style="color: #666;">אין פוסטים זמינים כרגע</li>';
                    }
                    wp_reset_postdata();
                    ?>
                </ul>
            </section>

            <!-- Legal Categories -->
            <section class="sitemap-section">
                <h2 style="color: #007cba; border-bottom: 2px solid #007cba; padding-bottom: 10px;">קטגוריות</h2>
                <ul style="list-style: none; padding: 0;">
                    <?php
                    $categories = get_categories(array(
                        'orderby' => 'name',
                        'order' => 'ASC',
                        'hide_empty' => false
                    ));
                    
                    if ($categories) {
                        foreach ($categories as $category) {
                            echo '<li style="margin-bottom: 8px;">';
                            echo '<a href="' . get_category_link($category->term_id) . '" style="color: #007cba; text-decoration: none; font-weight: 500;">';
                            echo '🏷️ ' . $category->name;
                            echo '</a>';
                            echo ' <small style="color: #666;">(' . $category->count . ' פוסטים)</small>';
                            echo '</li>';
                        }
                    } else {
                        echo '<li style="color: #666;">אין קטגוריות זמינות כרגע</li>';
                    }
                    ?>
                </ul>
            </section>

        </div>

        <!-- Search Section -->
        <section class="sitemap-search" style="margin: 40px 0; padding: 30px; background: #f8f9fa; border-radius: 8px; text-align: center;">
            <h2 style="color: #007cba;">לא מצאתם מה שחיפשתם?</h2>
            <p>השתמשו בחיפוש כדי למצוא תכנים ספציפיים באתר</p>
            <form role="search" method="get" action="<?php echo home_url('/'); ?>" style="margin-top: 20px;">
                <input type="search" name="s" placeholder="הקלידו כאן את מונח החיפוש..." 
                       style="padding: 12px; width: 300px; max-width: 100%; border: 1px solid #ddd; border-radius: 4px; font-size: 16px;" 
                       value="<?php echo get_search_query(); ?>" />
                <button type="submit" class="primary-cta" style="margin-right: 10px; padding: 12px 20px;">חיפוש</button>
            </form>
        </section>

        <!-- Contact CTA -->
        <section class="sitemap-cta" style="text-align: center; margin: 40px 0; padding: 30px; background: #007cba; color: #fff; border-radius: 8px;">
            <h2 style="color: #fff;">זקוקים לעזרה משפטית?</h2>
            <p style="font-size: 1.1em; margin-bottom: 20px;">
                אנחנו כאן לעזור לכם בכל נושא משפטי. קבלו ייעוץ מקצועי ומדויק.
            </p>
            <div>
                <a href="tel:+972-XX-XXXXXXX" class="primary-cta" style="background: #fff; color: #007cba; margin: 10px;">
                    📞 התקשרו עכשיו
                </a>
                <a href="https://wa.me/972XXXXXXXXX" class="primary-cta" style="background: #25d366; margin: 10px;">
                    💬 וואטסאפ
                </a>
                <a href="<?php echo home_url('/contact'); ?>" class="primary-cta" style="background: #28a745; margin: 10px;">
                    ✉️ שלחו הודעה
                </a>
            </div>
        </section>

        <!-- XML Sitemap Link -->
        <div style="text-align: center; margin-top: 30px; padding: 20px; background: #e9ecef; border-radius: 4px;">
            <p><strong>למנועי חיפוש:</strong> <a href="<?php echo home_url('/sitemap_index.xml'); ?>" target="_blank">מפת האתר XML</a></p>
        </div>

    </div>
</main>

<?php get_footer(); ?>
