<?php
/**
 * Emar Timeline Slider Widget
 *
 * @since      1.0.0
 * @package    Emar
 * @subpackage Emar/widgets
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

/**
 * Timeline Slider Widget.
 */
class Emar_Timeline_Slider extends \Elementor\Widget_Base {

    /**
     * Get widget name.
     *
     * @since 1.0.0
     * @access public
     * @return string Widget name.
     */
    public function get_name() {
        return 'emar_timeline_slider';
    }

    /**
     * Get widget title.
     *
     * @since 1.0.0
     * @access public
     * @return string Widget title.
     */
    public function get_title() {
        return __('Timeline Slider', 'emar');
    }

    /**
     * Get widget icon.
     *
     * @since 1.0.0
     * @access public
     * @return string Widget icon.
     */
    public function get_icon() {
        return 'eicon-time-line';
    }

    /**
     * Get widget categories.
     *
     * @since 1.0.0
     * @access public
     * @return array Widget categories.
     */
    public function get_categories() {
        return ['emar'];
    }

    /**
     * Get widget keywords.
     *
     * @since 1.0.0
     * @access public
     * @return array Widget keywords.
     */
    public function get_keywords() {
        return ['timeline', 'slider', 'carousel', 'posts', 'emar'];
    }

    /**
     * Register widget controls.
     *
     * @since 1.0.0
     * @access protected
     */
    protected function register_controls() {

        /*
         * Content Settings
         */
        $this->start_controls_section(
            'section_content',
            [
                'label' => __('Content Settings', 'emar'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        // Post Type
        $this->add_control(
            'post_type',
            [
                'label' => __('Data Source', 'emar'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'post',
                'options' => $this->get_post_types(),
            ]
        );

        // Post Categories
        $this->add_control(
            'post_categories',
            [
                'label' => __('Categories', 'emar'),
                'type' => \Elementor\Controls_Manager::SELECT2,
                'options' => $this->get_all_categories(),
                'multiple' => true,
                'condition' => [
                    'post_type' => 'post',
                ],
            ]
        );

        // Post Tags
        $this->add_control(
            'post_tags',
            [
                'label' => __('Tags', 'emar'),
                'type' => \Elementor\Controls_Manager::SELECT2,
                'options' => $this->get_all_tags(),
                'multiple' => true,
                'condition' => [
                    'post_type' => 'post',
                ],
            ]
        );

        // Number of Posts
        $this->add_control(
            'posts_per_page',
            [
                'label' => __('Number of Items', 'emar'),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'min' => 1,
                'max' => 50,
                'step' => 1,
                'default' => 10,
            ]
        );

        // Order By
        $this->add_control(
            'order_by',
            [
                'label' => __('Order By', 'emar'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'date',
                'options' => [
                    'date' => __('Date', 'emar'),
                    'title' => __('Title', 'emar'),
                    'rand' => __('Random', 'emar'),
                    'menu_order' => __('Menu Order', 'emar'),
                ],
            ]
        );

        // Order
        $this->add_control(
            'order',
            [
                'label' => __('Order', 'emar'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'DESC',
                'options' => [
                    'DESC' => __('Descending', 'emar'),
                    'ASC' => __('Ascending', 'emar'),
                ],
            ]
        );

        // Show Title
        $this->add_control(
            'show_title',
            [
                'label' => __('Show Title', 'emar'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => __('Show', 'emar'),
                'label_off' => __('Hide', 'emar'),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );

        // Show Excerpt
        $this->add_control(
            'show_excerpt',
            [
                'label' => __('Show Excerpt', 'emar'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => __('Show', 'emar'),
                'label_off' => __('Hide', 'emar'),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );

        // Excerpt Length
        $this->add_control(
            'excerpt_length',
            [
                'label' => __('Excerpt Length', 'emar'),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'min' => 10,
                'max' => 200,
                'step' => 5,
                'default' => 25,
                'condition' => [
                    'show_excerpt' => 'yes',
                ],
            ]
        );

        // Show Read More Button
        $this->add_control(
            'show_read_more',
            [
                'label' => __('Show Read More', 'emar'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => __('Show', 'emar'),
                'label_off' => __('Hide', 'emar'),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );

        // Read More Text
        $this->add_control(
            'read_more_text',
            [
                'label' => __('Read More Text', 'emar'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __('Read More', 'emar'),
                'condition' => [
                    'show_read_more' => 'yes',
                ],
            ]
        );

        $this->end_controls_section();

        /*
         * Slider Settings
         */
        $this->start_controls_section(
            'section_slider',
            [
                'label' => __('Slider Settings', 'emar'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        // Autoplay
        $this->add_control(
            'autoplay',
            [
                'label' => __('Autoplay', 'emar'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => __('Yes', 'emar'),
                'label_off' => __('No', 'emar'),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );

        // Autoplay Speed
        $this->add_control(
            'autoplay_speed',
            [
                'label' => __('Autoplay Speed', 'emar'),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'min' => 1000,
                'max' => 10000,
                'step' => 500,
                'default' => 3000,
                'condition' => [
                    'autoplay' => 'yes',
                ],
            ]
        );

        // Animation Type
        $this->add_control(
            'animation_type',
            [
                'label' => __('Animation Type', 'emar'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'slide',
                'options' => [
                    'slide' => __('Slide', 'emar'),
                    'fade' => __('Fade', 'emar'),
                    'zoom' => __('Zoom', 'emar'),
                ],
            ]
        );

        // Animation Speed
        $this->add_control(
            'animation_speed',
            [
                'label' => __('Animation Speed (ms)', 'emar'),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'min' => 100,
                'max' => 3000,
                'step' => 100,
                'default' => 500,
            ]
        );

        // Show Navigation Arrows
        $this->add_control(
            'show_arrows',
            [
                'label' => __('Show Arrows', 'emar'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => __('Show', 'emar'),
                'label_off' => __('Hide', 'emar'),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );

        // Show Navigation Dots
        $this->add_control(
            'show_dots',
            [
                'label' => __('Show Dots', 'emar'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => __('Show', 'emar'),
                'label_off' => __('Hide', 'emar'),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );

        // Pause on Hover
        $this->add_control(
            'pause_on_hover',
            [
                'label' => __('Pause on Hover', 'emar'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => __('Yes', 'emar'),
                'label_off' => __('No', 'emar'),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );

        // Enable Dragging
        $this->add_control(
            'draggable',
            [
                'label' => __('Draggable', 'emar'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => __('Yes', 'emar'),
                'label_off' => __('No', 'emar'),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );

        // Items to Show
        $this->add_control(
            'slides_to_show',
            [
                'label' => __('Items to Show', 'emar'),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'min' => 1,
                'max' => 10,
                'step' => 1,
                'default' => 5,
                'description' => __('Number of items to show at once', 'emar'),
            ]
        );

        // Center Mode
        $this->add_control(
            'center_mode',
            [
                'label' => __('Center Mode', 'emar'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => __('Yes', 'emar'),
                'label_off' => __('No', 'emar'),
                'return_value' => 'yes',
                'default' => 'yes',
                'description' => __('Enable center mode for emphasized active slide', 'emar'),
            ]
        );

        $this->end_controls_section();

        /*
         * Style Tab - Slider
         */
        $this->start_controls_section(
            'section_style_slider',
            [
                'label' => __('Slider', 'emar'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        // Slider Background
        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' => 'slider_background',
                'label' => __('Background', 'emar'),
                'types' => ['classic', 'gradient'],
                'selector' => '{{WRAPPER}} .emar-timeline-slider',
            ]
        );

        // Slider Padding
        $this->add_responsive_control(
            'slider_padding',
            [
                'label' => __('Padding', 'emar'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .emar-timeline-slider' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        // Slider Border
        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'slider_border',
                'label' => __('Border', 'emar'),
                'selector' => '{{WRAPPER}} .emar-timeline-slider',
            ]
        );

        // Slider Border Radius
        $this->add_responsive_control(
            'slider_border_radius',
            [
                'label' => __('Border Radius', 'emar'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .emar-timeline-slider' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        // Slider Box Shadow
        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'slider_box_shadow',
                'label' => __('Box Shadow', 'emar'),
                'selector' => '{{WRAPPER}} .emar-timeline-slider',
            ]
        );

        $this->end_controls_section();

        /*
         * Style Tab - Slides
         */
        $this->start_controls_section(
            'section_style_slides',
            [
                'label' => __('Slides', 'emar'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        // Slide Background
        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' => 'slide_background',
                'label' => __('Background', 'emar'),
                'types' => ['classic', 'gradient'],
                'selector' => '{{WRAPPER}} .emar-timeline-slide',
            ]
        );

        // Slide Padding
        $this->add_responsive_control(
            'slide_padding',
            [
                'label' => __('Padding', 'emar'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .emar-timeline-slide' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        // Slide Margin
        $this->add_responsive_control(
            'slide_margin',
            [
                'label' => __('Margin', 'emar'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .emar-timeline-slide' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        // Slide Border
        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'slide_border',
                'label' => __('Border', 'emar'),
                'selector' => '{{WRAPPER}} .emar-timeline-slide',
            ]
        );

        // Slide Border Radius
        $this->add_responsive_control(
            'slide_border_radius',
            [
                'label' => __('Border Radius', 'emar'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .emar-timeline-slide' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        // Slide Box Shadow
        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'slide_box_shadow',
                'label' => __('Box Shadow', 'emar'),
                'selector' => '{{WRAPPER}} .emar-timeline-slide',
            ]
        );

        // Active Slide Scale
        $this->add_control(
            'active_slide_scale',
            [
                'label' => __('Active Slide Scale', 'emar'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => [''],
                'range' => [
                    '' => [
                        'min' => 1,
                        'max' => 2,
                        'step' => 0.1,
                    ],
                ],
                'default' => [
                    'unit' => '',
                    'size' => 1.2,
                ],
                'selectors' => [
                    '{{WRAPPER}} .emar-timeline-slider .slick-center .emar-timeline-slide' => 'transform: scale({{SIZE}});',
                ],
                'condition' => [
                    'center_mode' => 'yes',
                ],
            ]
        );

        $this->end_controls_section();

        /*
         * Style Tab - Title
         */
        $this->start_controls_section(
            'section_style_title',
            [
                'label' => __('Title', 'emar'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
                'condition' => [
                    'show_title' => 'yes',
                ],
            ]
        );

        // Title Typography
        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'title_typography',
                'label' => __('Typography', 'emar'),
                'selector' => '{{WRAPPER}} .emar-timeline-slide-title',
            ]
        );

        // Title Color
        $this->add_control(
            'title_color',
            [
                'label' => __('Text Color', 'emar'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .emar-timeline-slide-title' => 'color: {{VALUE}};',
                ],
            ]
        );

        // Title Margin
        $this->add_responsive_control(
            'title_margin',
            [
                'label' => __('Margin', 'emar'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .emar-timeline-slide-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        /*
         * Style Tab - Excerpt
         */
        $this->start_controls_section(
            'section_style_excerpt',
            [
                'label' => __('Excerpt', 'emar'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
                'condition' => [
                    'show_excerpt' => 'yes',
                ],
            ]
        );

        // Excerpt Typography
        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'excerpt_typography',
                'label' => __('Typography', 'emar'),
                'selector' => '{{WRAPPER}} .emar-timeline-slide-excerpt',
            ]
        );

        // Excerpt Color
        $this->add_control(
            'excerpt_color',
            [
                'label' => __('Text Color', 'emar'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .emar-timeline-slide-excerpt' => 'color: {{VALUE}};',
                ],
            ]
        );

        // Excerpt Margin
        $this->add_responsive_control(
            'excerpt_margin',
            [
                'label' => __('Margin', 'emar'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .emar-timeline-slide-excerpt' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        /*
         * Style Tab - Read More Button
         */
        $this->start_controls_section(
            'section_style_read_more',
            [
                'label' => __('Read More Button', 'emar'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
                'condition' => [
                    'show_read_more' => 'yes',
                ],
            ]
        );

        // Button Typography
        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'button_typography',
                'label' => __('Typography', 'emar'),
                'selector' => '{{WRAPPER}} .emar-timeline-slide-button',
            ]
        );

        // Button Tabs (Normal/Hover)
        $this->start_controls_tabs('button_tabs');

        // Normal Tab
        $this->start_controls_tab(
            'button_normal_tab',
            [
                'label' => __('Normal', 'emar'),
            ]
        );

        // Button Text Color
        $this->add_control(
            'button_text_color',
            [
                'label' => __('Text Color', 'emar'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .emar-timeline-slide-button' => 'color: {{VALUE}};',
                ],
            ]
        );

        // Button Background Color
        $this->add_control(
            'button_background_color',
            [
                'label' => __('Background Color', 'emar'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .emar-timeline-slide-button' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        // Button Border
        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'button_border',
                'label' => __('Border', 'emar'),
                'selector' => '{{WRAPPER}} .emar-timeline-slide-button',
            ]
        );

        $this->end_controls_tab();

        // Hover Tab
        $this->start_controls_tab(
            'button_hover_tab',
            [
                'label' => __('Hover', 'emar'),
            ]
        );

        // Button Text Hover Color
        $this->add_control(
            'button_text_hover_color',
            [
                'label' => __('Text Color', 'emar'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .emar-timeline-slide-button:hover' => 'color: {{VALUE}};',
                ],
            ]
        );

        // Button Background Hover Color
        $this->add_control(
            'button_background_hover_color',
            [
                'label' => __('Background Color', 'emar'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .emar-timeline-slide-button:hover' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        // Button Border Hover Color
        $this->add_control(
            'button_border_hover_color',
            [
                'label' => __('Border Color', 'emar'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .emar-timeline-slide-button:hover' => 'border-color: {{VALUE}};',
                ],
            ]
        );

        // Button Hover Transition
        $this->add_control(
            'button_hover_transition',
            [
                'label' => __('Transition Duration', 'emar'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'max' => 3,
                        'step' => 0.1,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .emar-timeline-slide-button' => 'transition-duration: {{SIZE}}s',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        // Button Padding
        $this->add_responsive_control(
            'button_padding',
            [
                'label' => __('Padding', 'emar'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .emar-timeline-slide-button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'separator' => 'before',
            ]
        );

        // Button Border Radius
        $this->add_control(
            'button_border_radius',
            [
                'label' => __('Border Radius', 'emar'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .emar-timeline-slide-button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        /*
         * Style Tab - Thumbnail
         */
        $this->start_controls_section(
            'section_style_thumbnail',
            [
                'label' => __('Thumbnail', 'emar'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        // Thumbnail Border
        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'thumbnail_border',
                'label' => __('Border', 'emar'),
                'selector' => '{{WRAPPER}} .emar-timeline-slide-thumbnail img',
            ]
        );

        // Thumbnail Border Radius
        $this->add_control(
            'thumbnail_border_radius',
            [
                'label' => __('Border Radius', 'emar'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .emar-timeline-slide-thumbnail img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        // Thumbnail Overlay
        $this->add_control(
            'thumbnail_overlay',
            [
                'label' => __('Overlay', 'emar'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .emar-timeline-slide-thumbnail:before' => 'content: ""; position: absolute; top: 0; left: 0; width: 100%; height: 100%; background-color: {{VALUE}}; opacity: 0.5; transition: opacity 0.3s;',
                    '{{WRAPPER}} .emar-timeline-slide:hover .emar-timeline-slide-thumbnail:before' => 'opacity: 0;',
                ],
            ]
        );

        // Thumbnail Box Shadow
        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'thumbnail_box_shadow',
                'label' => __('Box Shadow', 'emar'),
                'selector' => '{{WRAPPER}} .emar-timeline-slide-thumbnail img',
            ]
        );

        // Thumbnail Aspect Ratio
        $this->add_responsive_control(
            'thumbnail_aspect_ratio',
            [
                'label' => __('Aspect Ratio', 'emar'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'options' => [
                    '1:1' => '1:1',
                    '3:2' => '3:2',
                    '4:3' => '4:3',
                    '16:9' => '16:9',
                ],
                'default' => '16:9',
                'selectors' => [
                    '{{WRAPPER}} .emar-timeline-slide-thumbnail' => 'padding-bottom: calc(var(--aspect-ratio-height) / var(--aspect-ratio-width) * 100%);',
                    '{{WRAPPER}} .emar-timeline-slide-thumbnail[data-aspect-ratio="1:1"]' => '--aspect-ratio-width: 1; --aspect-ratio-height: 1;',
                    '{{WRAPPER}} .emar-timeline-slide-thumbnail[data-aspect-ratio="3:2"]' => '--aspect-ratio-width: 3; --aspect-ratio-height: 2;',
                    '{{WRAPPER}} .emar-timeline-slide-thumbnail[data-aspect-ratio="4:3"]' => '--aspect-ratio-width: 4; --aspect-ratio-height: 3;',
                    '{{WRAPPER}} .emar-timeline-slide-thumbnail[data-aspect-ratio="16:9"]' => '--aspect-ratio-width: 16; --aspect-ratio-height: 9;',
                ],
            ]
        );

        $this->end_controls_section();

        /*
         * Style Tab - Timeline
         */
        $this->start_controls_section(
            'section_style_timeline',
            [
                'label' => __('Timeline', 'emar'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        // Timeline Height
        $this->add_responsive_control(
            'timeline_height',
            [
                'label' => __('Height', 'emar'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range' => [
                    'px' => [
                        'min' => 1,
                        'max' => 20,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 3,
                ],
                'selectors' => [
                    '{{WRAPPER}} .emar-timeline-line' => 'height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        // Timeline Color
        $this->add_control(
            'timeline_color',
            [
                'label' => __('Color', 'emar'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .emar-timeline-line' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        // Timeline Active Color
        $this->add_control(
            'timeline_active_color',
            [
                'label' => __('Active Color', 'emar'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .emar-timeline-line-active' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        // Timeline Margin
        $this->add_responsive_control(
            'timeline_margin',
            [
                'label' => __('Margin', 'emar'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .emar-timeline-container' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        /*
         * Style Tab - Navigation Arrows
         */
        $this->start_controls_section(
            'section_style_navigation',
            [
                'label' => __('Navigation Arrows', 'emar'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
                'condition' => [
                    'show_arrows' => 'yes',
                ],
            ]
        );

        // Arrows Size
        $this->add_control(
            'arrows_size',
            [
                'label' => __('Size', 'emar'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range' => [
                    'px' => [
                        'min' => 20,
                        'max' => 60,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .emar-timeline-slider-prev, {{WRAPPER}} .emar-timeline-slider-next' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        // Arrows Icon Size
        $this->add_control(
            'arrows_icon_size',
            [
                'label' => __('Icon Size', 'emar'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range' => [
                    'px' => [
                        'min' => 10,
                        'max' => 40,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .emar-timeline-slider-prev i, {{WRAPPER}} .emar-timeline-slider-next i' => 'font-size: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        // Arrows Tabs
        $this->start_controls_tabs('arrows_tabs');

        // Normal Tab
        $this->start_controls_tab(
            'arrows_normal_tab',
            [
                'label' => __('Normal', 'emar'),
            ]
        );

        // Arrows Color
        $this->add_control(
            'arrows_color',
            [
                'label' => __('Color', 'emar'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .emar-timeline-slider-prev, {{WRAPPER}} .emar-timeline-slider-next' => 'color: {{VALUE}};',
                ],
            ]
        );

        // Arrows Background
        $this->add_control(
            'arrows_background',
            [
                'label' => __('Background', 'emar'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .emar-timeline-slider-prev, {{WRAPPER}} .emar-timeline-slider-next' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        // Arrows Border
        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'arrows_border',
                'label' => __('Border', 'emar'),
                'selector' => '{{WRAPPER}} .emar-timeline-slider-prev, {{WRAPPER}} .emar-timeline-slider-next',
            ]
        );

        $this->end_controls_tab();

        // Hover Tab
        $this->start_controls_tab(
            'arrows_hover_tab',
            [
                'label' => __('Hover', 'emar'),
            ]
        );

        // Arrows Hover Color
        $this->add_control(
            'arrows_hover_color',
            [
                'label' => __('Color', 'emar'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .emar-timeline-slider-prev:hover, {{WRAPPER}} .emar-timeline-slider-next:hover' => 'color: {{VALUE}};',
                ],
            ]
        );

        // Arrows Hover Background
        $this->add_control(
            'arrows_hover_background',
            [
                'label' => __('Background', 'emar'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .emar-timeline-slider-prev:hover, {{WRAPPER}} .emar-timeline-slider-next:hover' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        // Arrows Hover Border Color
        $this->add_control(
            'arrows_hover_border_color',
            [
                'label' => __('Border Color', 'emar'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .emar-timeline-slider-prev:hover, {{WRAPPER}} .emar-timeline-slider-next:hover' => 'border-color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        // Arrows Border Radius
        $this->add_control(
            'arrows_border_radius',
            [
                'label' => __('Border Radius', 'emar'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .emar-timeline-slider-prev, {{WRAPPER}} .emar-timeline-slider-next' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'separator' => 'before',
            ]
        );

        // Arrows Padding
        $this->add_responsive_control(
            'arrows_padding',
            [
                'label' => __('Padding', 'emar'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .emar-timeline-slider-prev, {{WRAPPER}} .emar-timeline-slider-next' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        // Arrows Box Shadow
        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'arrows_box_shadow',
                'label' => __('Box Shadow', 'emar'),
                'selector' => '{{WRAPPER}} .emar-timeline-slider-prev, {{WRAPPER}} .emar-timeline-slider-next',
            ]
        );

        $this->end_controls_section();

        /*
         * Style Tab - Play Button
         */
        $this->start_controls_section(
            'section_style_play_button',
            [
                'label' => __('Play Button', 'emar'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        // Play Button Size
        $this->add_control(
            'play_button_size',
            [
                'label' => __('Size', 'emar'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range' => [
                    'px' => [
                        'min' => 30,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .emar-timeline-slide-play-button' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        // Play Button Icon Size
        $this->add_control(
            'play_button_icon_size',
            [
                'label' => __('Icon Size', 'emar'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range' => [
                    'px' => [
                        'min' => 10,
                        'max' => 50,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .emar-timeline-slide-play-button i' => 'font-size: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        // Play Button Tabs
        $this->start_controls_tabs('play_button_tabs');

        // Normal Tab
        $this->start_controls_tab(
            'play_button_normal_tab',
            [
                'label' => __('Normal', 'emar'),
            ]
        );

        // Play Button Color
        $this->add_control(
            'play_button_color',
            [
                'label' => __('Color', 'emar'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .emar-timeline-slide-play-button' => 'color: {{VALUE}};',
                ],
            ]
        );

        // Play Button Background
        $this->add_control(
            'play_button_background',
            [
                'label' => __('Background', 'emar'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .emar-timeline-slide-play-button' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        // Hover Tab
        $this->start_controls_tab(
            'play_button_hover_tab',
            [
                'label' => __('Hover', 'emar'),
            ]
        );

        // Play Button Hover Color
        $this->add_control(
            'play_button_hover_color',
            [
                'label' => __('Color', 'emar'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .emar-timeline-slide-play-button:hover' => 'color: {{VALUE}};',
                ],
            ]
        );

        // Play Button Hover Background
        $this->add_control(
            'play_button_hover_background',
            [
                'label' => __('Background', 'emar'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .emar-timeline-slide-play-button:hover' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        // Play Button Border Radius
        $this->add_control(
            'play_button_border_radius',
            [
                'label' => __('Border Radius', 'emar'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .emar-timeline-slide-play-button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'separator' => 'before',
            ]
        );

        // Play Button Opacity
        $this->add_control(
            'play_button_opacity',
            [
                'label' => __('Opacity', 'emar'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'max' => 1,
                        'min' => 0.10,
                        'step' => 0.01,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .emar-timeline-slide-play-button' => 'opacity: {{SIZE}};',
                ],
            ]
        );

        // Play Button Box Shadow
        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'play_button_box_shadow',
                'label' => __('Box Shadow', 'emar'),
                'selector' => '{{WRAPPER}} .emar-timeline-slide-play-button',
            ]
        );

        $this->end_controls_section();
    }

    /**
     * Get all post types available
     *
     * @return array
     */
    private function get_post_types() {
        $post_types = get_post_types([
            'public' => true,
        ], 'objects');

        $options = [];
        
        foreach ($post_types as $post_type) {
            $options[$post_type->name] = $post_type->label;
        }
        
        return $options;
    }

    /**
     * Get all categories
     *
     * @return array
     */
    private function get_all_categories() {
        $categories = get_categories([
            'orderby' => 'name',
            'order' => 'ASC',
            'hide_empty' => false,
        ]);
        
        $options = [];
        
        foreach ($categories as $category) {
            $options[$category->term_id] = $category->name;
        }
        
        return $options;
    }

    /**
     * Get all tags
     *
     * @return array
     */
    private function get_all_tags() {
        $tags = get_tags([
            'orderby' => 'name',
            'order' => 'ASC',
            'hide_empty' => false,
        ]);
        
        $options = [];
        
        foreach ($tags as $tag) {
            $options[$tag->term_id] = $tag->name;
        }
        
        return $options;
    }

    /**
     * Get post thumbnail with specified size
     *
     * @param int $post_id
     * @param string $size
     * @return string
     */
    private function get_post_thumbnail($post_id, $size = 'large') {
        if (has_post_thumbnail($post_id)) {
            return get_the_post_thumbnail_url($post_id, $size);
        }
        
        // Return a placeholder image if no thumbnail is available
        return EMAR_PLUGIN_URL . 'assets/images/placeholder.jpg';
    }

    /**
     * Get custom excerpt
     *
     * @param int $post_id
     * @param int $length
     * @return string
     */
    private function get_custom_excerpt($post_id, $length = 25) {
        $post = get_post($post_id);
        
        if (!$post) {
            return '';
        }
        
        if (has_excerpt($post_id)) {
            $excerpt = wp_strip_all_tags(get_the_excerpt($post_id));
        } else {
            $excerpt = wp_strip_all_tags($post->post_content);
        }
        
        $excerpt = wp_trim_words($excerpt, $length, '...');
        
        return $excerpt;
    }

    /**
     * Render the widget output on the frontend.
     *
     * @since 1.0.0
     * @access protected
     */
    protected function render() {
        $settings = $this->get_settings_for_display();
        
        // Generate a unique ID for this slider instance
        $slider_id = 'emar-timeline-slider-' . $this->get_id();
        
        // Check if we have access to placeholder image
        $placeholder_url = EMAR_PLUGIN_URL . 'assets/images/placeholder.jpg';
        
        // Ensure the placeholder directory exists - create it if not
        $placeholder_dir = EMAR_PLUGIN_PATH . 'assets/images';
        if (!file_exists($placeholder_dir)) {
            wp_mkdir_p($placeholder_dir);
        }
        
        // Create a placeholder image if it doesn't exist
        if (!file_exists($placeholder_dir . '/placeholder.jpg')) {
            // This is a simplistic way - in production, you'd want to properly create a JPG
            copy(plugin_dir_path(dirname(__FILE__)) . 'assets/images/placeholder.jpg', $placeholder_dir . '/placeholder.jpg');
        }
        
        // Prepare query arguments
        $args = [
            'post_type' => $settings['post_type'],
            'posts_per_page' => $settings['posts_per_page'],
            'orderby' => $settings['order_by'],
            'order' => $settings['order'],
            'post_status' => 'publish', // Ensure we only get published posts
        ];
        
        // Add category filter if set
        if (!empty($settings['post_categories']) && $settings['post_type'] === 'post') {
            $args['category__in'] = $settings['post_categories'];
        }
        
        // Add tag filter if set
        if (!empty($settings['post_tags']) && $settings['post_type'] === 'post') {
            $args['tag__in'] = $settings['post_tags'];
        }
        
        // Run the query
        $query = new \WP_Query($args);
        
        if ($query->have_posts()) {
            // Slider attributes
            $slider_options = [
                'slidesToShow' => absint($settings['slides_to_show']),
                'slidesToScroll' => 1,
                'autoplay' => ($settings['autoplay'] === 'yes'),
                'autoplaySpeed' => absint($settings['autoplay_speed']),
                'speed' => absint($settings['animation_speed']),
                'arrows' => ($settings['show_arrows'] === 'yes'),
                'dots' => ($settings['show_dots'] === 'yes'),
                'pauseOnHover' => ($settings['pause_on_hover'] === 'yes'),
                'draggable' => ($settings['draggable'] === 'yes'),
                'centerMode' => ($settings['center_mode'] === 'yes'),
                'centerPadding' => '50px',
                'rtl' => is_rtl(),
                'cssEase' => 'cubic-bezier(0.7, 0, 0.3, 1)',
                'respondTo' => 'slider',
                'vertical' => false,
                'infinite' => true,
                'adaptiveHeight' => true,
                'responsive' => [
                    [
                        'breakpoint' => 991,
                        'settings' => [
                            'slidesToShow' => min(absint($settings['slides_to_show']), 3),
                            'slidesToScroll' => 1
                        ]
                    ],
                    [
                        'breakpoint' => 767,
                        'settings' => [
                            'slidesToShow' => min(absint($settings['slides_to_show']), 2),
                            'slidesToScroll' => 1
                        ]
                    ],
                    [
                        'breakpoint' => 479,
                        'settings' => [
                            'slidesToShow' => 1,
                            'slidesToScroll' => 1
                        ]
                    ]
                ]
            ];
            
            // Animation type
            if ($settings['animation_type'] === 'fade') {
                $slider_options['fade'] = true;
                $slider_options['slidesToShow'] = 1;
            } elseif ($settings['animation_type'] === 'zoom') {
                $slider_options['cssEase'] = 'cubic-bezier(0.7, 0, 0.3, 1)';
            }
            
            // Encode slider options for JavaScript
            $slider_options_json = htmlspecialchars(wp_json_encode($slider_options), ENT_QUOTES, 'UTF-8');
            
            // Slider container
            ?>
            <div id="<?php echo esc_attr($slider_id); ?>" class="emar-timeline-slider" data-settings='<?php echo $slider_options_json; ?>'>
                <?php
                // Output posts as slides
                $index = 1;
                while ($query->have_posts()) {
                    $query->the_post();
                    
                    $post_id = get_the_ID();
                    $post_title = get_the_title();
                    $post_permalink = get_permalink();
                    $post_thumbnail = $this->get_post_thumbnail($post_id);
                    $post_excerpt = $this->get_custom_excerpt($post_id, $settings['excerpt_length']);
                    $aspect_ratio = $settings['thumbnail_aspect_ratio'];
                    
                    // Slide output
                    ?>
                    <div class="emar-timeline-slide">
                        <div class="emar-timeline-slide-inner">
                            <div class="emar-timeline-slide-thumbnail" data-aspect-ratio="<?php echo esc_attr($aspect_ratio); ?>">
                                <img src="<?php echo esc_url($post_thumbnail); ?>" alt="<?php echo esc_attr($post_title); ?>">
                                <div class="emar-timeline-slide-play-button">
                                    <i class="eicon-play" aria-hidden="true"></i>
                                </div>
                            </div>
                            
                            <?php if ($settings['show_title'] === 'yes') : ?>
                                <h3 class="emar-timeline-slide-title">
                                    <a href="<?php echo esc_url($post_permalink); ?>"><?php echo esc_html($post_title); ?></a>
                                </h3>
                            <?php endif; ?>
                            
                            <?php if ($settings['show_excerpt'] === 'yes') : ?>
                                <div class="emar-timeline-slide-excerpt">
                                    <?php echo esc_html($post_excerpt); ?>
                                </div>
                            <?php endif; ?>
                            
                            <?php if ($settings['show_read_more'] === 'yes') : ?>
                                <a href="<?php echo esc_url($post_permalink); ?>" class="emar-timeline-slide-button">
                                    <?php echo esc_html($settings['read_more_text']); ?>
                                </a>
                            <?php endif; ?>
                            
                            <div class="emar-timeline-slide-index" data-index="<?php echo esc_attr(sprintf('%02d', $index)); ?>"></div>
                        </div>
                    </div>
                    <?php
                    $index++;
                }
                
                wp_reset_postdata();
                ?>
            </div>
            
            <?php if ($settings['show_dots'] === 'yes') : ?>
                <div class="emar-timeline-container">
                    <div class="emar-timeline-line"></div>
                    <div class="emar-timeline-line-active"></div>
                    <div class="emar-timeline-markers">
                        <?php
                        for ($i = 1; $i <= $query->post_count; $i++) {
                            echo '<div class="emar-timeline-marker" data-index="' . esc_attr(sprintf('%02d', $i)) . '">' . esc_html(sprintf('%02d', $i)) . '</div>';
                        }
                        ?>
                    </div>
                </div>
            <?php endif; ?>
            
            <script>
                jQuery(document).ready(function($) {
                    var $slider = $('#<?php echo esc_attr($slider_id); ?>');
                    
                    // Safety check to ensure settings are properly loaded
                    var sliderOptions = $slider.data('settings');
                    if (!sliderOptions || typeof sliderOptions !== 'object') {
                        sliderOptions = <?php echo wp_json_encode($slider_options); ?>;
                    }
                    
                    $slider.on('init', function(event, slick) {
                        updateTimelineProgress(slick);
                    });
                    
                    $slider.on('beforeChange', function(event, slick, currentSlide, nextSlide) {
                        updateTimelineProgress(slick, nextSlide);
                    });
                    
                    $slider.slick(sliderOptions);
                    
                    // Timeline markers click event
                    $('.emar-timeline-marker').on('click', function() {
                        var index = $(this).data('index');
                        var slideIndex = parseInt(index) - 1;
                        $slider.slick('slickGoTo', slideIndex);
                    });
                    
                    // Update timeline progress
                    function updateTimelineProgress(slick, currentSlide) {
                        currentSlide = currentSlide || slick.currentSlide;
                        var slideCount = slick.slideCount;
                        var progress = (currentSlide / (slideCount - 1)) * 100;
                        
                        $('.emar-timeline-line-active').css('width', progress + '%');
                        $('.emar-timeline-marker').removeClass('active');
                        $('.emar-timeline-marker[data-index="' + sprintf('%02d', currentSlide + 1) + '"]').addClass('active');
                    }
                    
                    // Helper function for formatting numbers with leading zeros
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
                });
            </script>
            <?php
        } else {
            echo '<div class="emar-timeline-slider-empty">' . __('No posts found.', 'emar') . '</div>';
        }
    }
}