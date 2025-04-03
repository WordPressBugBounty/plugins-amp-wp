(function($) {
    'use strict';

    $(function() {
        $('p:empty').remove();

        /** Analytics **/
        $('.analytic-switch').on('click', function() {
            if ($(this).is(':checked')) {
                $('.' + $(this).data('id')).animate(
                    {
                        width: ['toggle', 'swing'],
                        height: ['toggle', 'swing'],
                        opacity: 'toggle'
                    },
                    500,
                    'linear',
                    function() {
                        $('.' + $(this).data('id')).css('display', 'table-row');
                    }
                );
            } else {
                $('.' + $(this).data('id')).animate(
                    {
                        width: ['toggle', 'swing'],
                        height: ['toggle', 'swing'],
                        opacity: 'toggle'
                    },
                    500,
                    'linear',
                    function() {
                        $('.' + $(this).data('id')).css('display', 'none');
                    }
                );
            }
        });

        $('.analytic-switch').on('change', function() {
            if ($('.analytic-switch:checked').length > 0) {
                $('#section_analytics_settings').show('slow');
            } else {
                $('#section_analytics_settings').hide('slow');
            }
        });

        /** Notice Bar & GDPR **/
        $('.noticebar-gdpr-switch').on('click', function() {
            if ($(this).is(':checked')) {
                $('.' + $(this).data('id')).animate(
                    {
                        width: ['toggle', 'swing'],
                        height: ['toggle', 'swing'],
                        opacity: 'toggle'
                    },
                    500,
                    'linear',
                    function() {
                        $('.' + $(this).data('id')).css('display', 'table-row');
                    }
                );
            } else {
                $('.' + $(this).data('id')).animate(
                    {
                        width: ['toggle', 'swing'],
                        height: ['toggle', 'swing'],
                        opacity: 'toggle'
                    },
                    500,
                    'linear',
                    function() {
                        $('.' + $(this).data('id')).css('display', 'none');
                    }
                );
            }
        });

        // Starting the script on page load.
        var copyDebugReport;

        $('.help_tip').tipTip({
            attribute: 'data-tip'
        });

        $('a.help_tip').click(function() {
            return false;
        });

        $('a.debug-report').on('click', function() {
            var report = '';
            $(
                '.amp-wp-system-status table:not(.fusion-system-status-debug) thead, .amp-wp-system-status:not(.fusion-system-status-debug) tbody'
            ).each(function() {
                var label;

                if ($(this).is('thead')) {
                    label =
                        $(this)
                            .find('th:eq(0)')
                            .data('export-label') || $(this).text();
                    report = report + '\n### ' + $.trim(label) + ' ###\n\n';
                } else {
                    $('tr', $(this)).each(function() {
                        var label =
                                $(this)
                                    .find('td:eq(0)')
                                    .data('export-label') ||
                                $(this)
                                    .find('td:eq(0)')
                                    .text(),
                            theName = $.trim(label).replace(/(<([^>]+)>)/gi, ''), // Remove HTML.
                            theValueElement = $(this).find('td:eq(2)'),
                            theValue,
                            valueArray,
                            output,
                            tempLine;

                        if (1 <= $(theValueElement).find('img').length) {
                            theValue = $.trim(
                                $(theValueElement)
                                    .find('img')
                                    .attr('alt')
                            );
                        } else {
                            theValue = $.trim(
                                $(this)
                                    .find('td:eq(2)')
                                    .text()
                            );
                        }
                        valueArray = theValue.split(', ');

                        if (1 < valueArray.length) {
                            // If value have a list of plugins ','
                            // Split to add new line.
                            output = '';
                            tempLine = '';
                            $.each(valueArray, function(key, line) {
                                tempLine = tempLine + line + '\n';
                            });

                            theValue = tempLine;
                        }

                        report = report + '' + theName + ': ' + theValue + '\n';
                    });
                }
            });

            try {
                $('#debug-report').slideDown();
                $('#debug-report textarea')
                    .val(report)
                    .focus()
                    .select();
                $(this)
                    .parent()
                    .fadeOut();
                return false;
            } catch (e) {}

            return false;
        });

        $('#copy-for-support').tipTip({
            attribute: 'data-tip',
            activation: 'click',
            fadeIn: 50,
            fadeOut: 50,
            delay: 100,
            enter: function() {
                copyDebugReport();
            }
        });

        copyDebugReport = function() {
            var debugReportTextarea = document.getElementById('debug-report-textarea');
            $(debugReportTextarea).select();
            document.execCommand('Copy', false, null);
        };
    });
})(jQuery);
