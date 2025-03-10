/**
 * Emar Timeline Slider - Public JavaScript
 *
 * @since      1.0.0
 * @package    Emar
 */

(function($) {
    'use strict';

    /**
     * Initialize Timeline Sliders
     */
    function initTimelineSliders() {
        $('.emar-timeline-slider').each(function() {
            var $slider = $(this);
            var settings = $slider.data('settings');
            
            // Skip if already initialized
            if ($slider.hasClass('slick-initialized')) {
                return;
            }
            
            // Skip if no settings found
            if (!settings) {
                return;
            }
            
            // Add navigation arrows if enabled
            if (settings.arrows) {
                settings.prevArrow = '<button type="button" class="emar-timeline-slider-prev"><i class="eicon-chevron-left"></i></button>';
                settings.nextArrow = '<button type="button" class="emar-timeline-slider-next"><i class="eicon-chevron-right"></i></button>';
            }
            
            // Initialize slider with settings
            $slider.slick({
                slidesToShow: settings.slides_to_show,
                slidesToScroll: 1,
                vertical: false,  // Ensure this is set to false
                rtl: is_rtl(),
                // other settings
            });
            
            // Initialize events after slider is ready
            $slider.on('init', function(event, slick) {
                updateTimelineProgress(slick);
            });
            
            // Update timeline on slide change
            $slider.on('beforeChange', function(event, slick, currentSlide, nextSlide) {
                updateTimelineProgress(slick, nextSlide);
            });
            
            // Manually trigger init since we're initializing after the DOM is ready
            var slick = $slider.slick('getSlick');
            updateTimelineProgress(slick);
            
            // Timeline markers click event
            $('.emar-timeline-marker').on('click', function() {
                var index = $(this).data('index');
                var slideIndex = parseInt(index) - 1;
                $slider.slick('slickGoTo', slideIndex);
            });
        });
    }
    
    /**
     * Update timeline progress indicator
     */
    function updateTimelineProgress(slick, currentSlide) {
        currentSlide = currentSlide || slick.currentSlide;
        var slideCount = slick.slideCount;
        var progress = (currentSlide / (slideCount - 1)) * 100;
        
        $('.emar-timeline-line-active').css('width', progress + '%');
        $('.emar-timeline-marker').removeClass('active');
        $('.emar-timeline-marker[data-index="' + sprintf('%02d', currentSlide + 1) + '"]').addClass('active');
    }
    
    /**
     * Helper function for formatting numbers with leading zeros
     */
    function sprintf(format, number) {
        return format.replace(/%(\d+)d/, function(match, precision) {
            var value = number.toString();
            var padding = precision - value.length;
            
            if (padding > 0) {
                return '0'.repeat(padding) + value;
            }
            
            return value;
        });
    }
    
    /**
     * Play video when play button is clicked
     */
    function setupVideoPlayButtons() {
        $('.emar-timeline-slide-play-button').on('click', function(e) {
            e.preventDefault();
            
            var $this = $(this);
            var $slide = $this.closest('.emar-timeline-slide');
            var postId = $slide.find('.emar-timeline-slide-index').data('index');
            
            // Here you would typically open a modal with the video
            // This is just a placeholder that could be expanded in future versions
            
            console.log('Play video for post ID: ' + postId);
            
            // Example of how you could trigger a custom event for other scripts to handle
            $(document).trigger('emar_video_play', [postId, $slide]);
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
                        }
                    });
                }
            });
        }
    }
    
    /**
     * Initialize everything when the DOM is ready
     */
    $(document).ready(function() {
        // Check if slick carousel is available
        if (typeof $.fn.slick !== 'undefined') {
            initTimelineSliders();
            setupVideoPlayButtons();
            handleResponsiveBehavior();
            
            // Handle window resize
            $(window).on('resize', function() {
                handleResponsiveBehavior();
            });
        } else {
            console.error('Emar Timeline Slider: Slick carousel not found. Please make sure Elementor includes it.');
        }
    });
    
    // Support for Elementor frontend
    $(window).on('elementor/frontend/init', function() {
        elementorFrontend.hooks.addAction('frontend/element_ready/emar_timeline_slider.default', function($element) {
            // Reinitialize slider when it becomes visible in Elementor editor
            initTimelineSliders();
            setupVideoPlayButtons();
            handleResponsiveBehavior();
        });
    });

})(jQuery);