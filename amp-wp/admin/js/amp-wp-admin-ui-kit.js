/*!
 * AMP WP Admin UI Kit v0.0.1
 * 
 * Description: AMP WP Admin Dashboard UI Functions
 * Version: 0.0.1
 * Author: Arslan Akram <arslan@pixelative.co>
 *
 * Requires: jQuery
 */

;(function ($) {
    'use strict';
    
    var AMPWPAdminUIKit = {
        vTabs: function () {
            if ($(".amp-wp-vtabs").length) {
                var vTabsMenuEl = $(".amp-wp-vtabs-menu"),
                    vTabsLinksEl = vTabsMenuEl.find("a"),
                    vTabsContentEl = $(".amp-wp-vtabs-content"),
					vTabsURLEl = window.location.hash;
                
                vTabsContentEl.hide();
                
                vTabsLinksEl.on("click", function(e) {
                    e.preventDefault();
                    
                    var targetEl = $($(this).attr("href")),
                        hashId = $(this)[0].hash;
                    
                    // Set Hash Id
                    window.location.hash = hashId;
                    
                    vTabsLinksEl.removeClass("active");
                    $(this).addClass("active");
                    vTabsContentEl.hide();
                    targetEl.show();
                });
				
				if (window.location.hash.length > 0) {
					vTabsLinksEl.removeClass("active");
					$('a[href="' + vTabsURLEl + '"]').addClass('active');
					$(vTabsURLEl).show();
				} else {
					if( $(vTabsLinksEl).hasClass( "active" ) ) {
						$( $(vTabsLinksEl).attr('href') ).show();
					}
				}
            }
        },
        
        select2: function () {
			if ($(".amp-wp-select")) {
				$(".amp-wp-select").select2({
					width: '100%',
					containerCssClass: 'amp-wp-select-container',
					dropdownCssClass: 'amp-wp-select-dropdown'
				});
			}
		},
      
        // Toggles Children fields on Parents Checkbox state
        toggleParentChild: function () {
            if ($(".amp-wp-parent-child-field")) {
                var parentChildEl = $(".amp-wp-parent-child-field");
                
                parentChildEl.each(function() {
                    var el = $(this),
                        checkboxEl = el.find("> .switch input");
                    
                    checkboxEl.on("change", function() {
                        if ($(this).prop("checked")) {
                            el.addClass("active");
                        } else {
                            el.removeClass("active");
                        }
                    });
                });
            }
        },
        
        init: function () {
            this.vTabs();
            this.select2();
            this.toggleParentChild();
        }
    };

    $(document).ready(function () {
        AMPWPAdminUIKit.init();
    });
})(jQuery);