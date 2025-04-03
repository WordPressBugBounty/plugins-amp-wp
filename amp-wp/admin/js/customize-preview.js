/**
 * Script load in customizer preview (iframe)
 */
/*
 * Script run inside a Customizer preview frame.
 */
(function ($) {
    "use strict";

    function closeSidebar() {
        if ($("amp-sidebar").attr("open") === "open") {
            $(".navbar-toggle").click();
        }
    }

    function openSidebar() {
        if ($("amp-sidebar").attr("open") !== "open") {
            $(".navbar-toggle").click();
        }
    }

    function scrollToEnd() {
        $("html, body").animate({ scrollTop: $(document).height() }, 500);
    }

    $(document).ready(function () {
        var c = wp.customize;

        // Modify Header Height.
        c("amp-wp-header-height", function (control) {
            control.bind(function (to) {
                $(".site-header").css("height", to + "px");
                $(".sticky-nav").css("padding-top", to + "px");
            });
        });

        /* ===================== Sidebar ======================================= */
        c("amp-wp-sidebar-logo-text", function (value) {
            value.bind(function (to) {
                openSidebar();
                $(".sidebar-brand .brand-name").html(to);
            });
        });
        c("amp-wp-sidebar-logo-img", function (value) {
            value.bind(openSidebar);
        });

        /* ============================ Colors Section =========================== */
        c("amp-wp-color-theme", function (value) {
            value.bind(function (to) {
                $(
                    ".pagination .nav-links .page-numbers.prev,.pagination .nav-links .page-numbers.next,.listing-item a.post-read-more,.post-terms.cats .term-type,.post-terms a:hover,.search-form .search-submit,.amp-wp-main-link a,.post-categories li a,.amp-btn,.amp-btn:active,.amp-btn:focus,.amp-btn:hover"
                ).css("background", to);
                //$('.entry-content ul.amp-wp-shortcode-list li:before, a').css('color', to);
                $(".amp-btn,.amp-btn:active,.amp-btn:focus,.amp-btn:hover, .post-terms.tags a:hover,.post-terms.tags a:focus,.post-terms.tags a:active").css(
                    "border-color",
                    to
                );
            });
        });

        // Change Header Text Color.
        c("amp-wp-header-text-color", function (control) {
            control.bind(function (to) {
                $(".site-header .logo a, .site-header .header-nav > li > a, .site-header .header-nav > li .navbar-toggle").css("color", to);
            });
        });

        // Change header background color.
        c("amp-wp-header-background-color", function (control) {
            control.bind(function (to) {
                $(".site-header").css("background", to);
            });
        });

        c("amp-wp-color-bg", function (value) {
            value.bind(function (to) {
                $("body.body").css("background", to);
            });
        });

        c("amp-wp-color-text", function (value) {
            value.bind(function (to) {
                $("body.body, .entry-content").css("color", to);
            });
        });

        c("amp-wp-color-footer-nav-bg", function (value) {
            value.bind(function (to) {
                scrollToEnd();
                $(".amp-wp-footer-nav").css("background", to);
            });
        });

        c("amp-wp-color-footer-bg", function (value) {
            value.bind(function (to) {
                scrollToEnd();
                $(".amp-wp-copyright").css("background", to);
            });
        });
    });
})(jQuery);
