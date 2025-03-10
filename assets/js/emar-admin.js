/**
 * Emar Plugin - Admin JavaScript
 *
 * @since      1.0.0
 * @package    Emar
 */

(function($) {
    'use strict';
    
    /**
     * Emar Admin Object
     */
    var EmarAdmin = {
        
        /**
         * Initialize admin functionality
         */
        init: function() {
            this.bindEvents();
            this.initTabs();
            this.initTooltips();
        },
        
        /**
         * Bind events
         */
        bindEvents: function() {
            // Dismiss notices
            $(document).on('click', '.emar-admin-notice .notice-dismiss', this.dismissNotice);
            
            // Settings form submission
            $(document).on('submit', '.emar-admin-form', this.validateForm);
            
            // Color picker initialization
            if ($.fn.wpColorPicker) {
                $('.emar-color-picker').wpColorPicker();
            }
            
            // Media uploader
            $(document).on('click', '.emar-media-upload', this.openMediaUploader);
            $(document).on('click', '.emar-media-remove', this.removeMedia);
        },
        
        /**
         * Initialize tabs
         */
        initTabs: function() {
            var $tabs = $('.emar-admin-tabs a');
            var $tabContents = $('.emar-admin-tab-content');
            
            if ($tabs.length === 0) {
                return;
            }
            
            // Set first tab as active if none is active
            if ($tabs.filter('.active').length === 0) {
                $tabs.first().addClass('active');
                $tabContents.first().addClass('active');
            }
            
            // Tab click event
            $tabs.on('click', function(e) {
                e.preventDefault();
                
                var target = $(this).attr('href');
                
                // Remove active class from all tabs and content
                $tabs.removeClass('active');
                $tabContents.removeClass('active');
                
                // Add active class to current tab and content
                $(this).addClass('active');
                $(target).addClass('active');
                
                // Save active tab to localStorage
                if (window.localStorage) {
                    localStorage.setItem('emar_active_tab', target);
                }
            });
            
            // Load active tab from localStorage
            if (window.localStorage) {
                var activeTab = localStorage.getItem('emar_active_tab');
                if (activeTab && $(activeTab).length) {
                    $tabs.removeClass('active');
                    $tabContents.removeClass('active');
                    $tabs.filter('[href="' + activeTab + '"]').addClass('active');
                    $(activeTab).addClass('active');
                }
            }
        },
        
        /**
         * Initialize tooltips
         */
        initTooltips: function() {
            $('.emar-tooltip').each(function() {
                var $this = $(this);
                var tooltipContent = $this.data('tooltip');
                
                $this.append('<span class="emar-tooltip-content">' + tooltipContent + '</span>');
            });
            
            $(document).on('mouseenter', '.emar-tooltip', function() {
                $(this).find('.emar-tooltip-content').fadeIn(200);
            });
            
            $(document).on('mouseleave', '.emar-tooltip', function() {
                $(this).find('.emar-tooltip-content').fadeOut(200);
            });
        },
        
        /**
         * Dismiss admin notice
         */
        dismissNotice: function() {
            var $notice = $(this).closest('.emar-admin-notice');
            var noticeId = $notice.data('notice-id');
            
            if (!noticeId) {
                return;
            }
            
            $.ajax({
                url: emar_admin_params.ajax_url,
                type: 'POST',
                data: {
                    action: 'emar_dismiss_notice',
                    notice_id: noticeId,
                    nonce: emar_admin_params.nonce
                },
                success: function(response) {
                    if (response.success) {
                        $notice.slideUp(200, function() {
                            $notice.remove();
                        });
                    }
                }
            });
        },
        
        /**
         * Validate settings form
         */
        validateForm: function(e) {
            var isValid = true;
            var $form = $(this);
            var $requiredFields = $form.find('.required');
            
            // Check required fields
            $requiredFields.each(function() {
                var $field = $(this);
                var value = $field.val();
                
                if (!value || value.trim() === '') {
                    isValid = false;
                    $field.addClass('emar-error');
                    
                    // Add error message if not already present
                    if ($field.next('.emar-error-message').length === 0) {
                        $field.after('<span class="emar-error-message">' + emar_admin_params.required_field_message + '</span>');
                    }
                } else {
                    $field.removeClass('emar-error');
                    $field.next('.emar-error-message').remove();
                }
            });
            
            if (!isValid) {
                e.preventDefault();
                
                // Scroll to first error
                var $firstError = $form.find('.emar-error').first();
                if ($firstError.length) {
                    $('html, body').animate({
                        scrollTop: $firstError.offset().top - 100
                    }, 500);
                }
            }
        },
        
        /**
         * Open WordPress media uploader
         */
        openMediaUploader: function(e) {
            e.preventDefault();
            
            var $button = $(this);
            var $imageContainer = $button.prev('.emar-media-preview');
            var $hiddenInput = $button.siblings('input[type="hidden"]');
            
            // Create media frame if it doesn't exist
            if (!EmarAdmin.mediaFrame) {
                EmarAdmin.mediaFrame = wp.media({
                    title: emar_admin_params.media_title,
                    button: {
                        text: emar_admin_params.media_button
                    },
                    multiple: false
                });
                
                // Media frame selection handler
                EmarAdmin.mediaFrame.on('select', function() {
                    var attachment = EmarAdmin.mediaFrame.state().get('selection').first().toJSON();
                    
                    // Update hidden input with attachment ID
                    $hiddenInput.val(attachment.id);
                    
                    // Update preview
                    if (attachment.type === 'image') {
                        var imgSrc = attachment.sizes && attachment.sizes.thumbnail ? attachment.sizes.thumbnail.url : attachment.url;
                        $imageContainer.html('<img src="' + imgSrc + '" alt="' + attachment.title + '">');
                    } else {
                        $imageContainer.html('<div class="emar-file-preview">' + attachment.filename + '</div>');
                    }
                    
                    // Show remove button
                    $button.siblings('.emar-media-remove').show();
                });
            }
            
            // Open media frame
            EmarAdmin.mediaFrame.open();
        },
        
        /**
         * Remove media from field
         */
        removeMedia: function(e) {
            e.preventDefault();
            
            var $button = $(this);
            var $imageContainer = $button.siblings('.emar-media-preview');
            var $hiddenInput = $button.siblings('input[type="hidden"]');
            
            // Clear preview and hidden input
            $imageContainer.empty();
            $hiddenInput.val('');
            
            // Hide remove button
            $button.hide();
        },
        
        /**
         * Initialize dashboard widget
         */
        initDashboardWidget: function() {
            $('.emar-dashboard-widget-chart').each(function() {
                var $chart = $(this);
                var chartType = $chart.data('chart-type');
                var chartData = $chart.data('chart-data');
                
                if (!chartData || typeof Chart === 'undefined') {
                    return;
                }
                
                var ctx = $chart[0].getContext('2d');
                
                // Initialize appropriate chart type
                switch (chartType) {
                    case 'bar':
                        new Chart(ctx, {
                            type: 'bar',
                            data: chartData,
                            options: {
                                responsive: true,
                                maintainAspectRatio: false
                            }
                        });
                        break;
                    
                    case 'line':
                        new Chart(ctx, {
                            type: 'line',
                            data: chartData,
                            options: {
                                responsive: true,
                                maintainAspectRatio: false
                            }
                        });
                        break;
                    
                    case 'pie':
                        new Chart(ctx, {
                            type: 'pie',
                            data: chartData,
                            options: {
                                responsive: true,
                                maintainAspectRatio: false
                            }
                        });
                        break;
                }
            });
        }
    };
    
    // Initialize on document ready
    $(document).ready(function() {
        EmarAdmin.init();
        
        // Initialize dashboard widget if present
        if ($('.emar-dashboard-widget').length) {
            EmarAdmin.initDashboardWidget();
        }
    });
    
})(jQuery);