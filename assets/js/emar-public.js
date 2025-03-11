/**
 * Emar Timeline Slider - Public JavaScript
 *
 * @since      1.0.0
 * @package    Emar
 */

(function($) {
    'use strict';

    /**
     * Helper function to check if RTL is active
     */
    function isRtl() {
        return $('html').attr('dir') === 'rtl';
    }

    /**
     * Format a number with leading zeros
     * @param {number} number - The number to format
     * @param {number} digits - The total number of digits
     * @return {string} - Formatted number with leading zeros
     */
    function formatNumber(number, digits) {
        let result = number.toString();
        while (result.length < digits) {
            result = '0' + result;
        }
        return result;
    }

    /**
     * Initialize Timeline Sliders
     */
    function initTimelineSliders() {
        $('.emar-timeline-slider:not(.slick-initialized)').each(function() {
            var $slider = $(this);
            var settings = $slider.data('settings') || {};
            
            // Default settings if none are provided
            if ($.isEmptyObject(settings)) {
                settings = {
                    slidesToShow: 3,
                    slidesToScroll: 1,
                    autoplay: true,
                    autoplaySpeed: 3000,
                    speed: 500,
                    arrows: true,
                    dots: false,
                    pauseOnHover: true,
                    draggable: true,
                    centerMode: true,
                    centerPadding: '50px'
                };
            }
            
            // Add navigation arrows if enabled
            if (settings.arrows !== false) {
                settings.prevArrow = '<button type="button" class="emar-timeline-slider-prev"><i class="eicon-chevron-left"></i></button>';
                settings.nextArrow = '<button type="button" class="emar-timeline-slider-next"><i class="eicon-chevron-right"></i></button>';
            }
            
            // Responsive settings
            var responsive = [
                {
                    breakpoint: 991,
                    settings: {
                        slidesToShow: Math.min(settings.slidesToShow || 3, 3),
                        slidesToScroll: 1
                    }
                },
                {
                    breakpoint: 767,
                    settings: {
                        slidesToShow: Math.min(settings.slidesToShow || 3, 2),
                        slidesToScroll: 1,
                        centerPadding: '30px'
                    }
                },
                {
                    breakpoint: 479,
                    settings: {
                        slidesToShow: 1,
                        slidesToScroll: 1,
                        centerPadding: '20px'
                    }
                }
            ];

            // Merge with existing responsive settings if they exist
            if (settings.responsive && Array.isArray(settings.responsive)) {
                responsive = settings.responsive;
            }
            
            // Ensure RTL is properly handled
            var rtl = isRtl();
            
            // Initialize slider with settings
            try {
                // Check if slick is available
                if (typeof $.fn.slick === 'undefined') {
                    console.error('Slick carousel not found. Make sure it is properly loaded.');
                    return;
                }
                
                // Configure final slick options
                var slickOptions = {
                    slidesToShow: settings.slidesToShow || 3,
                    slidesToScroll: settings.slidesToScroll || 1,
                    autoplay: settings.autoplay || false,
                    autoplaySpeed: settings.autoplaySpeed || 3000,
                    speed: settings.speed || 500,
                    arrows: settings.arrows !== false,
                    dots: settings.dots || false,
                    pauseOnHover: settings.pauseOnHover !== false,
                    draggable: settings.draggable !== false,
                    centerMode: settings.centerMode || false,
                    centerPadding: settings.centerPadding || '50px',
                    adaptiveHeight: true,
                    infinite: true,
                    vertical: false,
                    rtl: rtl,
                    prevArrow: settings.prevArrow,
                    nextArrow: settings.nextArrow,
                    cssEase: 'cubic-bezier(0.7, 0, 0.3, 1)',
                    responsive: responsive
                };
                
                // Animation type
                if (settings.animation_type === 'fade') {
                    slickOptions.fade = true;
                    slickOptions.slidesToShow = 1;
                }
                
                // Initialize slider
                $slider.slick(slickOptions);
                
                // Initialize events once slider is ready
                $slider.on('init', function(event, slick) {
                    updateTimelineProgress($slider, slick);
                });
                
                // Update timeline on slide change
                $slider.on('beforeChange', function(event, slick, currentSlide, nextSlide) {
                    updateTimelineProgress($slider, slick, nextSlide);
                });
                
                // Manually update timeline for the first time
                var slick = $slider.slick('getSlick');
                updateTimelineProgress($slider, slick);
                
            } catch (error) {
                console.error('Error initializing Emar Timeline Slider:', error);
            }
        });
        
        // Timeline markers click event
        $(document).off('click', '.emar-timeline-marker').on('click', '.emar-timeline-marker', function() {
            var $marker = $(this);
            var index = $marker.data('index');
            var $slider = $marker.closest('.emar-timeline-container').prev('.emar-timeline-slider');
            
            if ($slider.length && typeof index !== 'undefined') {
                var slideIndex = parseInt(index, 10) - 1;
                if (!isNaN(slideIndex) && slideIndex >= 0) {
                    $slider.slick('slickGoTo', slideIndex);
                }
            }
        });
    }
    
    /**
     * Update timeline progress indicator
     * @param {jQuery} $slider - The slider element
     * @param {Object} slick - The slick instance
     * @param {number} currentSlide - Current slide index (optional)
     */
    function updateTimelineProgress($slider, slick, currentSlide) {
        if (!slick || typeof slick.slideCount === 'undefined') return;
        
        var $container = $slider.next('.emar-timeline-container');
        if (!$container.length) return;
        
        currentSlide = typeof currentSlide !== 'undefined' ? currentSlide : slick.currentSlide;
        var slideCount = slick.slideCount;
        if (slideCount <= 1) return;
        
        var progress = (currentSlide / (slideCount - 1)) * 100;
        
        $container.find('.emar-timeline-line-active').css('width', progress + '%');
        $container.find('.emar-timeline-marker').removeClass('active');
        $container.find('.emar-timeline-marker[data-index="' + formatNumber(currentSlide + 1, 2) + '"]').addClass('active');
    }
    
    /**
     * Setup video play buttons
     */
    function setupVideoPlayButtons() {
        $(document).off('click', '.emar-timeline-slide-play-button').on('click', '.emar-timeline-slide-play-button', function(e) {
            e.preventDefault();
            e.stopPropagation();
            
            var $button = $(this);
            var $slide = $button.closest('.emar-timeline-slide');
            var postId = $slide.find('.emar-timeline-slide-index').data('index');
            
            // Trigger a custom event for other scripts to handle
            $(document).trigger('emar_video_play', [postId, $slide]);
            
            // Here you would typically open a modal with the video
            // This placeholder function can be extended in future versions
            console.log('Play button clicked for post ID:', postId);
        });
    }
    
    /**
     * Handle responsive behavior
     */
    function handleResponsiveBehavior() {
        var windowWidth = $(window).width();
        
        // Adjust timeline markers on small screens
        if (windowWidth < 768) {
            $('.emar-timeline-markers').each(function() {
                var $markers = $(this);
                var markerCount = $markers.children().length;
                
                // Hide some markers on mobile to avoid overcrowding
                if (markerCount > 5) {
                    $markers.children().each(function(index) {
                        // Show only first, last, and every third marker
                        if (index !== 0 && index !== markerCount - 1 && index % 3 !== 0) {
                            $(this).addClass('hidden-xs');
                        } else {
                            $(this).removeClass('hidden-xs');
                        }
                    });
                }
            });
        } else {
            // Show all markers on larger screens
            $('.emar-timeline-markers .hidden-xs').removeClass('hidden-xs');
        }
    }
    
    /**
     * Reinitialize slider after AJAX content loads
     */
    function reinitAfterAjax() {
        // Target common AJAX events
        $(document).on('ajaxComplete', function() {
            setTimeout(function() {
                initTimelineSliders();
            }, 100);
        });
    }
    
    /**
     * Initialize everything when the DOM is ready
     */
    $(document).ready(function() {
        // Check if Slick exists before initialization
        if (typeof $.fn.slick !== 'undefined') {
            console.log('Emar Timeline Slider: Slick carousel found. Initializing sliders...');
            initTimelineSliders();
            setupVideoPlayButtons();
            handleResponsiveBehavior();
            reinitAfterAjax();
            
            // Handle window resize
            $(window).on('resize', function() {
                handleResponsiveBehavior();
            });
        } else {
            console.error('Emar Timeline Slider: Slick carousel not found. Loading fallback...');
            
            // Try to load Slick from CDN as fallback
            var script = document.createElement('script');
            script.type = 'text/javascript';
            script.src = 'https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js';
            script.onload = function() {
                console.log('Slick loaded from CDN. Initializing sliders...');
                initTimelineSliders();
                setupVideoPlayButtons();
                handleResponsiveBehavior();
                reinitAfterAjax();
            };
            document.head.appendChild(script);
            
            // Also load CSS
            $('<link>')
                .appendTo('head')
                .attr({type: 'text/css', rel: 'stylesheet'})
                .attr('href', 'https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css');
            
            $('<link>')
                .appendTo('head')
                .attr({type: 'text/css', rel: 'stylesheet'})
                .attr('href', 'https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick-theme.css');
        }
    });
    
    // Support for Elementor frontend
    $(window).on('elementor/frontend/init', function() {
        if (typeof elementorFrontend !== 'undefined' && elementorFrontend.hooks) {
            elementorFrontend.hooks.addAction('frontend/element_ready/emar_timeline_slider.default', function($element) {
                // Reinitialize slider when it becomes visible in Elementor editor
                initTimelineSliders();
                setupVideoPlayButtons();
                handleResponsiveBehavior();
            });
        }
    });

})(jQuery);