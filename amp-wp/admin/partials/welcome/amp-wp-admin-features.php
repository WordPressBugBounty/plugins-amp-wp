<?php
/**
 * Features Admin View
 *
 * @link        https://pixelative.co
 * @since       1.4.0
 *
 * @package     Amp_WP
 * @subpackage  Amp_WP/admin/partials/welcome
 */
?>
<div id="welcome-features" class="amp-wp-vtabs-content">
    <div class="amp-wp-vtabs-header">
        <div class="amp-wp-vtabs-title">
            <h2><?php _e('Features', 'amp-wp'); ?></h2>
        </div>
    </div>
    <div class="amp-wp-vtabs-body">
        <div class="amp-wp-about">
            <p class="mb-20"><?php _e('Automagically add Accelerated Mobile Page (Google AMP Project) functionality to your site. Make your site load 5X faster on mobile by using features of the open source AMP project.', 'amp-wp'); ?></p>

            <picture>
                <source media="(max-width: 500px)" srcset="<?php echo AMP_WP_DIR_URL.'admin/images/welcome-image.svg'; ?>">
                <img src="<?php echo AMP_WP_DIR_URL; ?>admin/images/about/welcome-image.svg" alt="Welcome AMP WP" />
            </picture>

            <hr class="amp-wp-section-sep">
            <h2><?php _e('UI Components:', 'amp-wp'); ?></h2>
            <hr class="amp-wp-section-sep">
            
            <div class="amp-wp-boxes amp-wp-boxes-6-col">
                <div class="amp-wp-box amp-wp-box-w-img gray-scale">
                    <div class="amp-wp-box-header">
                        <h3><?php _e('Header'); ?></h3>
                    </div>
                    <img src="<?php echo AMP_WP_DIR_URL; ?>admin/images/about/header-sidebar.svg" alt="<?php _e('Header'); ?>" />
                    <div class="amp-wp-box-body">
                        <p><?php _e('Header with search and native sidebar AMP component that includes <strong>Logo</strong>, <strong>Slogan</strong>, <strong>Menu</strong>, <strong>Social Links</strong> and <strong>Copyright message</strong>. Option to make header <strong>Sticky</strong>.', 'amp-wp'); ?></p>
                    </div>
                </div>
                
                <div class="amp-wp-box amp-wp-box-w-img gray-scale">
                    <div class="amp-wp-box-header">
                        <h3><?php _e('Footer'); ?></h3>
                    </div>
                    <img src="<?php echo AMP_WP_DIR_URL; ?>admin/images/about/footer.svg" alt="<?php _e('Footer'); ?>" />
                    <div class="amp-wp-box-body">
                        <p><?php _e('Footer that includes <strong>Menu</strong>, <strong>Social Icons</strong> and <strong>Copyright Message</strong>. Components can also be turned off from the settings panel.'); ?></p>
                    </div>
                </div>
                
                <div class="amp-wp-box amp-wp-box-w-img gray-scale">
                    <div class="amp-wp-box-header">
                        <h3><?php _e('Posts Slider', 'amp-wp'); ?></h3>
                    </div>
                    <img src="<?php echo AMP_WP_DIR_URL; ?>admin/images/about/slider.svg" alt="<?php _e('Slider Support', 'amp-wp'); ?>" />
                    <div class="amp-wp-box-body">
                        <p><?php _e('A slider which shows the <strong>Recent Posts</strong>. The slider can also be turned off from the settings panel.', 'amp-wp'); ?></p>
                    </div>
                </div>
                
                <div class="amp-wp-box amp-wp-box-w-img gray-scale">
                    <div class="amp-wp-box-header">
                        <h3><?php _e('Related Posts'); ?></h3>
                    </div>
                    <img src="<?php echo AMP_WP_DIR_URL; ?>admin/images/about/related-posts.svg" alt="<?php _e('Related Posts'); ?>" />
                    <div class="amp-wp-box-body">
                        <p><?php _e('You can display related posts by <strong>Category</strong>, by <strong>Tag</strong>, by <strong>Category & Tag</strong>, by <strong>Category, Tag & Author</strong> or <strong>Randomly</strong> on single post\'s page. Can also be turned off.', 'amp-wp'); ?></p>
                    </div>
                </div>
                
                <div class="amp-wp-box amp-wp-box-w-img gray-scale">
                    <div class="amp-wp-box-header">
                        <h3><?php _e('Comments'); ?></h3>
                    </div>
                    <img src="<?php echo AMP_WP_DIR_URL; ?>admin/images/about/comments.svg" alt="<?php _e('Comments'); ?>" />
                    <div class="amp-wp-box-body">
                        <p><?php _e('You can display <strong>Recent Comments</strong> on single post page. They can also be turned off from the settings panel.', 'amp-wp'); ?></p>
                    </div>
                </div>
                
                <div class="amp-wp-box amp-wp-box-w-img gray-scale">
                    <div class="amp-wp-box-header">
                        <h3><?php _e('Post Listing Layouts'); ?></h3>
                    </div>
                    <img src="<?php echo AMP_WP_DIR_URL; ?>admin/images/about/list-and-classic-view.svg" alt="">
                    <div class="amp-wp-box-body">
                        <p><?php _e('Includes <strong>2 different layouts</strong> for listing posts on Home page and Archive page. Both can have different layouts, configured from the settings panel.'); ?></p>
                    </div>
                </div>
                
                <div class="amp-wp-box amp-wp-box-w-img gray-scale">
                    <div class="amp-wp-box-header">
                        <h3><?php _e('Gallery & Light Box'); ?></h3>
                    </div>
                    <img src="<?php echo AMP_WP_DIR_URL; ?>admin/images/about/gallery-&-lightbox.svg" alt="">
                    <div class="amp-wp-box-body">
                        <p><?php _e('Built-in support for the native <strong>WordPress Gallery Shortcode</strong> with a lightbox.'); ?></p>
                    </div>
                </div>
                <div class="amp-wp-box amp-wp-box-w-img gray-scale">
                    <div class="amp-wp-box-header">
                        <h3><?php _e('Embed Media'); ?></h3>
                    </div>
                    <img src="<?php echo AMP_WP_DIR_URL; ?>admin/images/about/embed-media.svg" alt="">
                    <div class="amp-wp-box-body">
                        <p><?php _e('Built-in support for <strong>Audios</strong>, <strong>Videos</strong>, <strong>iFrames</strong>, <strong>YouTube</strong>, <strong>Vimeo</strong>, <strong>Vine</strong>, <strong>Tweets</strong>, <strong>Facebook</strong>, <strong>SoundCloud</strong>, and <strong>Instagram Posts</strong>.'); ?></p>
                    </div>
                </div>
                <div class="amp-wp-box amp-wp-box-w-img gray-scale">
                    <div class="amp-wp-box-header">
                        <h3><?php _e('Native AMP Search'); ?></h3>
                    </div>
                    <img src="<?php echo AMP_WP_DIR_URL; ?>admin/images/about/native-amp-search.svg" alt="">
                    <div class="amp-wp-box-body">
                        <p><?php _e('Includes native AMP version for the <strong>Search Pages</strong>. The search link in header can also be turned off from the settings panel.'); ?></p>
                    </div>
                </div>
                
                <div class="amp-wp-box amp-wp-box-w-img gray-scale">
                    <div class="amp-wp-box-header">
                        <h3><?php _e('Share Box'); ?></h3>
                    </div>
                    <img src="<?php echo AMP_WP_DIR_URL; ?>admin/images/about/share-box.svg" alt="">
                    <div class="amp-wp-box-body">
                        <p><?php _e('Built-in <strong>Native Social Sharing</strong> box for single post pages. Social sharing links can be configured from the settings panel.'); ?></p>
                    </div>
                </div>
                
                <div class="amp-wp-box amp-wp-box-w-img gray-scale">
                    <div class="amp-wp-box-header">
                        <h3><?php _e('Notice Bar & GDPR'); ?></h3>
                    </div>
                    <img src="<?php echo AMP_WP_DIR_URL; ?>admin/images/about/notice-bar.svg" alt="">
                    <div class="amp-wp-box-body">
                        <p><?php _e('Built-in <strong>GDPR Compliance</strong>. Can also show a <strong>Notice Bar</strong> that can be used to display cookie policy notices.'); ?></p>
                    </div>
                </div>
            </div>
            
            <hr class="amp-wp-section-sep">
            <h2><?php _e('Other Features:', 'amp-wp'); ?></h2>
            <hr class="amp-wp-section-sep">            

            
            <div class="amp-wp-boxes amp-wp-boxes-6-col">
                <div class="amp-wp-box amp-wp-box-w-icon">
                    <div class="amp-wp-box-icon">
                        <img src="<?php echo AMP_WP_DIR_URL; ?>admin/images/about/icons/amp-theme-customizer.svg" alt="<?php _e('AMP Theme Customizer'); ?>" />
                        <h3><?php _e('Customize AMP Theme'); ?></h3>
                    </div>
                    <div class="amp-wp-box-content">
                        <p><?php _e('Highly flexible and easy-to-customize AMP theme.', 'amp-wp'); ?></p>
                    </div>
                </div>
                
                <div class="amp-wp-box amp-wp-box-w-icon">
                    <div class="amp-wp-box-icon">
                        <img src="<?php echo AMP_WP_DIR_URL; ?>admin/images/about/icons/analytics.svg" alt="">
                        <h3><?php _e('Analytics'); ?></h3>
                    </div>
                    <div class="amp-wp-box-content">
                        <p><?php _e('3<sup>rd</sup> party analytics to track Visitors, e.g. Google Analytics, Facebook Pixel +8 more.'); ?></p>
                    </div>
                </div>
                
                <div class="amp-wp-box amp-wp-box-w-icon">
                    <div class="amp-wp-box-icon">
                        <img src="<?php echo AMP_WP_DIR_URL; ?>admin/images/about/icons/enable-disable-amp-on-specific-pages.svg" alt="">
                        <h3><?php _e('Enable/Disable AMP'); ?></h3>
                    </div>
                    <div class="amp-wp-box-content">
                        <p><?php _e('Enable/Disable AMP on Home Page, Search Page, Post Types or Specific URLs'); ?></p>
                    </div>
                </div>
                
                <div class="amp-wp-box amp-wp-box-w-icon">
                    <div class="amp-wp-box-icon">
                        <img src="<?php echo AMP_WP_DIR_URL; ?>admin/images/about/icons/show-hide-components.svg" alt="">
                        <h3><?php _e('Show/Hide UI Components'); ?></h3>
                    </div>
                    <div class="amp-wp-box-content">
                        <p><?php _e('Easily show/hide UI components from the settings panel.'); ?></p>
                    </div>
                </div>
                
                <div class="amp-wp-box amp-wp-box-w-icon">
                    <div class="amp-wp-box-icon">
                        <img src="<?php echo AMP_WP_DIR_URL; ?>admin/images/about/icons/auto-redirect-mobile-users-to-amp.svg" alt="">
                        <h3><?php _e('Auto Redirect Mobile Users to AMP'); ?></h3>
                    </div>
                    <div class="amp-wp-box-content">
                        <p><?php _e('Automatically redirect all mobile users to the AMP version of the site.'); ?></p>
                    </div>
                </div>
                
                <div class="amp-wp-box amp-wp-box-w-icon">
                    <div class="amp-wp-box-icon">
                        <img src="<?php echo AMP_WP_DIR_URL; ?>admin/images/about/icons/translations.svg" alt="">
                        <h3><?php _e('Translations'); ?></h3>
                    </div>
                    <div class="amp-wp-box-content">
                        <p><?php _e('Built-in support for translating your AMP theme.'); ?></p>
                    </div>
                </div>
                
                <div class="amp-wp-box amp-wp-box-w-icon">
                    <div class="amp-wp-box-icon">
                        <img src="<?php echo AMP_WP_DIR_URL; ?>admin/images/about/icons/100-valid-amp-contents.svg" alt="">
                        <h3><?php _e('100% Valid AMP'); ?></h3>
                    </div>
                    <div class="amp-wp-box-content">
                        <p><?php _e('100% Validated AMP components and theme.'); ?></p>
                    </div>
                </div>
                
                <div class="amp-wp-box amp-wp-box-w-icon">
                    <div class="amp-wp-box-icon">
                        <img src="<?php echo AMP_WP_DIR_URL; ?>admin/images/about/icons/100-rtl-compatible.svg" alt="">
                        <h3><?php _e('100% RTL Compatible'); ?></h3>
                    </div>
                    <div class="amp-wp-box-content">
                        <p><?php _e('Built-in support for RTL version of your AMP theme.'); ?></p>
                    </div>
                </div>
                
                <div class="amp-wp-box amp-wp-box-w-icon">
                    <div class="amp-wp-box-icon">
                        <img src="<?php echo AMP_WP_DIR_URL; ?>admin/images/about/icons/auto-ads-for-amp-support.svg" alt="">
                        <h3><?php _e('AdSense Auto Ads'); ?></h3>
                    </div>
                    <div class="amp-wp-box-content">
                        <p><?php _e('Built-in support for integrating AdSense Auto Ads in your AMP theme.'); ?></p>
                    </div>
                </div>
                
                <div class="amp-wp-box amp-wp-box-w-icon">
                    <div class="amp-wp-box-icon">
                        <img src="<?php echo AMP_WP_DIR_URL; ?>admin/images/about/icons/100-yoast-seo-compatible.svg" alt="">
                        <h3><?php _e('100% Yoast SEO Compatible'); ?></h3>
                    </div>
                    <div class="amp-wp-box-content">
                        <p><?php _e('100% compatibility with Yoast SEO plugin.'); ?></p>
                    </div>
                </div>
                
                <div class="amp-wp-box amp-wp-box-w-icon">
                    <div class="amp-wp-box-icon">
                        <img src="<?php echo AMP_WP_DIR_URL; ?>admin/images/about/icons/internal-amp-linking.svg" alt="">
                        <h3><?php _e('Internal AMP Linking'); ?></h3>
                    </div>
                    <div class="amp-wp-box-content">
                        <p><?php _e('All links in the AMP theme go to AMP version of your site.'); ?></p>
                    </div>
                </div>
                
                <div class="amp-wp-box amp-wp-box-w-icon">
                    <div class="amp-wp-box-icon">
                        <img src="<?php echo AMP_WP_DIR_URL; ?>admin/images/about/icons/custom-html-css-support.svg" alt="">
                        <h3><?php _e('Custom HTML/CSS'); ?></h3>
                    </div>
                    <div class="amp-wp-box-content">
                        <p><?php _e('Easily add custom HTML tags or CSS code in your AMP theme.'); ?></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="amp-wp-vtabs-footer">
        <div class="amp-wp-vtabs-title">
            <h2><?php _e('Features', 'amp-wp'); ?></h2>
        </div>
    </div>
</div>