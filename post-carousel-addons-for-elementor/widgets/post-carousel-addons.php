<?php

namespace Elementor;

use Elementor\Core\Kits\Documents\Tabs\Global_Colors;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;

class Post_Carousel_Addons extends Widget_Base {

    public $custom_function;

    public function __construct($data = [], $args = null) {
        parent::__construct($data, $args);
        $this->custom_function = new \Eshuzu_Post_Carousel_Custom_Function();
    }

    /**
     * Get widget name.
     * @return string Widget name.
     * @since 1.0.0
     * @access public
     *
     */
    public function get_name() {
        return 'post-carousel-addons';
    }

    /**
     * Get widget title.
     * @return string Widget title.
     * @since 1.0.0
     * @access public
     *
     */
    public function get_title() {
        return 'Post Carousel Addons';
    }

    /**
     * Get widget icon.
     * @return string Widget icon.
     * @since 1.0.0
     * @access public
     *
     */
    public function get_icon() {
        return 'eicon-posts-carousel';
    }

    /**
     * Get widget categories.
     * @return array Widget categories.
     * @since 1.0.0
     * @access public
     *
     */
    public function get_categories() {
        return ['pro-elements'];
    }

    /**
     * Get widget keywords.
     * @return array Widget keywords.
     * @since 1.0.0
     * @access public
     *
     */
    public function get_keywords() {
        return ['posts', 'cpt', 'item', 'loop', 'query', 'cards', 'custom post type', 'slider', 'post slider', 'carousel', 'post carousel'];
    }

    protected function render_date() {
        // _deprecated_function( __METHOD__, '3.0.0', 'Skin_Base::render_date_by_type()' );
        $this->render_date_by_type();
    }

    protected function render_date_by_type($type = 'publish') {
        ?>
        <span class="esz_post_date">
			<?php
            switch ($type) :
                case 'modified':
                    $date = get_the_modified_date();
                    break;
                default:
                    $date = get_the_date();
            endswitch;
            /** This filter is documented in wp-includes/general-template.php */
            echo apply_filters('the_date', $date, get_option('date_format'), '', '');
            ?>
		</span>
        <?php
    }

    /**
     * Register widget controls.
     * @since 1.0.0
     * @access protected
     */
    protected function _register_controls() {
        /**
         *  Here you can add your controls. The controls below are only examples.
         *  Check this: https://developers.elementor.com/elementor-controls/
         *
         **/

        $this->start_controls_section(
            'slider_configuration',
            [
                'label' => __('Slider', 'post-slider-for-elementor'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );
        $controller_slides_count = range(1, 6);
        $controller_slides_count = array_combine($controller_slides_count, $controller_slides_count);
        $this->add_responsive_control(
            'slide_count',
            [
                'label' => __('Slide To Show', 'post-carousel-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'devices' => ['desktop', 'tablet', 'mobile'],
                'desktop_default' => 3,
                'tablet_default' => 2,
                'mobile_default' => 1,
                'options' => $controller_slides_count,
                'frontend_available' => true,
            ]
        );
        $this->add_responsive_control(
            'slide_scroll',
            [
                'label' => __('Slide To Scroll', 'post-carousel-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'devices' => ['desktop', 'tablet', 'mobile'],
                'desktop_default' => 1,
                'tablet_default' => 1,
                'mobile_default' => 1,
                'options' => $controller_slides_count,
                'frontend_available' => true,
            ]
        );

        /**
         * Center Mode Features.
         *
         *
         * @since 1.0.2
         * @access protected
         */
        $this->add_control(
            'center_mode',
            [
                'label' => __('Center Mode', 'post-slider-for-elementor'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'post-slider-for-elementor'),
                'label_off' => esc_html__('No', 'post-slider-for-elementor'),
                'return_value' => 'yes',
                'default' => 'No',
            ]
        );

        $this->add_control(
            'arrow_title',
            [
                'label' => __('Arrow', 'post-carousel-addons-for-elementor'),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'display_arrow',
            [
                'label' => __('Show Arrow', 'post-slider-for-elementor'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'post-slider-for-elementor'),
                'label_off' => esc_html__('No', 'post-slider-for-elementor'),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );

        $this->start_controls_tabs('slider_arrow_tabs');

        $this->start_controls_tab('left_arrow_tab',
            [
                'label' => __('Left Arrow', 'post-carousel-addons-for-elementor'),
                'condition' => [
                    'display_arrow' => 'yes',
                ]
            ]
        );
        $this->add_control(
            'left_arrow_icon',
            [
                'label' => __('Icon', 'elementor'),
                'type' => Controls_Manager::ICONS,
                'fa4compatibility' => 'icon',
                'default' => [
                    'value' => 'fas fa-arrow-left',
                    'library' => 'fa-solid',
                ],
                'condition' => [
                    'display_arrow' => 'yes',
                ]
            ]
        );
        $this->end_controls_tab();

        $this->start_controls_tab('right_arrow_tab',
            [
                'label' => __('Right Arrow', 'post-carousel-addons-for-elementor'),
                'condition' => [
                    'display_arrow' => 'yes',
                ]
            ]
        );

        $this->add_control(
            'right_arrow_icon',
            [
                'label' => __('Icon', 'post-carousel-addons-for-elementor'),
                'type' => Controls_Manager::ICONS,
                'fa4compatibility' => 'icon',
                'default' => [
                    'value' => 'fas fa-arrow-right',
                    'library' => 'fa-solid',
                ],
                'condition' => [
                    'display_arrow' => 'yes',
                ]
            ]
        );
        $this->end_controls_tab();
        $this->end_controls_tabs();

        $this->add_control(
            'dots_title',
            [
                'label' => __('Dots', 'post-carousel-addons-for-elementor'),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );
        $this->add_control(
            'display_dots',
            [
                'label' => __('Show Dots', 'post-slider-for-elementor'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'post-slider-for-elementor'),
                'label_off' => esc_html__('No', 'post-slider-for-elementor'),
                'return_value' => 'yes',
                'default' => 'yes',

            ]
        );
        $this->add_control(
            'slider_config_title',
            [
                'label' => __('Slider Configuration', 'post-carousel-addons-for-elementor'),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );
        $this->add_control(
            'autoplay_carousel',
            [
                'label' => __('Auto PLay', 'post-slider-for-elementor'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'post-slider-for-elementor'),
                'label_off' => esc_html__('No', 'post-slider-for-elementor'),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );
        $this->add_control(
            'autoplay_speed',
            [
                'label' => __('Auto Play Speed', 'post-carousel-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'default' => 5000,
            ]
        );
        $this->add_control(
            'infinite_carousel',
            [
                'label' => __('Infinite Slide', 'post-slider-for-elementor'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'post-slider-for-elementor'),
                'label_off' => esc_html__('No', 'post-slider-for-elementor'),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );

        $this->end_controls_section();
        $this->start_controls_section(
            'item_configuration',
            [
                'label' => __('Slide', 'post-slider-for-elementor'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'display_image',
            [
                'label' => __('Show Image', 'post-slider-for-elementor'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'post-slider-for-elementor'),
                'label_off' => esc_html__('No', 'post-slider-for-elementor'),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Image_Size::get_type(),
            [
                'name' => 'thumbnail_size',
                'default' => 'medium',
                'condition' => [
                    'display_image' => 'yes',
                ]
            ]
        );
        $this->add_responsive_control(
            'post_thumbnail_ratio',
            [
                'label' => esc_html__('Thumbnail Ratio', 'product-filter-widget-for-elementor'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['%', 'px'],
                'range' => [
                    '%' => [
                        'min' => 2,
                        'max' => 300,
                    ],
                    'px' => [
                        'min' => 10,
                        'max' => 500,
                    ],
                ],
                'default' => [
                    'size' => 100,
                    'unit' => '%',
                ],
                'selectors' => [
                    '{{WRAPPER}} .esz_post_thumb' => 'padding-bottom: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'meta_data',
            [
                'label' => __('Meta Data', 'post-carousel-addons-for-elementor'),
                'label_block' => true,
                'type' => Controls_Manager::SELECT2,
                'default' => ['date', 'comments'],
                'multiple' => true,
                'options' => [
                    'author' => __('Author', 'post-carousel-addons-for-elementor'),
                    'date' => __('Date', 'post-carousel-addons-for-elementor'),
                    'time' => __('Time', 'post-carousel-addons-for-elementor'),
                    'comments' => __('Comments', 'post-carousel-addons-for-elementor'),
                    'modified' => __('Date Modified', 'post-carousel-addons-for-elementor'),
                ],
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'meta_separator',
            [
                'label' => __('Separator Between', 'post-carousel-addons-for-elementor'),
                'type' => Controls_Manager::TEXT,
                'default' => '///',
                'selectors' => [
                    '{{WRAPPER}} .elementor-post__meta-data span + span:before' => 'content: "{{VALUE}}"',
                ],
                'condition' => [
                    'meta_data!' => []
                ],
            ]
        );

        $this->add_control(
            'display_excerpt',
            [
                'label' => __('Show Excerpt', 'post-slider-for-elementor'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'post-slider-for-elementor'),
                'label_off' => esc_html__('No', 'post-slider-for-elementor'),
                'return_value' => 'yes',
                'default' => 'yes',
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'excerpt_length',
            [
                'label' => __('Excerpt Length', 'post-carousel-addons-for-elementor'),
                'type' => Controls_Manager::NUMBER,
                /** This filter is documented in wp-includes/formatting.php */
                'default' => apply_filters('excerpt_length', 25),
                'condition' => [
                    'display_excerpt' => 'yes'
                ],
            ]
        );

        $this->add_control(
            'display_link',
            [
                'label' => __('Show Link', 'post-slider-for-elementor'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'post-slider-for-elementor'),
                'label_off' => esc_html__('No', 'post-slider-for-elementor'),
                'return_value' => 'yes',
                'default' => 'yes',
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'read_more_text',
            [
                'label' => __('Read More:', 'plugin-name'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__('Read More', 'post-slider-for-elementor'),
                // 'label_block' => true,
                'description' => 'Change Read More Text from Here',
                'condition' => [
                    'display_link' => 'yes'
                ],
            ]
        );

        $this->add_control(
            'open_in_new_window',
            [
                'label' => __('Open in new window', 'post-slider-for-elementor'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'post-slider-for-elementor'),
                'label_off' => esc_html__('No', 'post-slider-for-elementor'),
                'return_value' => 'yes',
                'default' => 'yes',
                'condition' => [
                    'display_link' => 'yes'
                ],
            ]
        );

        $this->end_controls_section();

        // Create a section
        $this->start_controls_section(
            'query_configuration',
            [
                'label' => __('Query', 'eshuzu-themes-widget'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );
        // Create a control inside the section above
        $this->add_control(
            'post_type',
            [
                'label' => __('Post Type', 'post-carousel-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'post',
                'options' => $this->custom_function->eshuzu_get_post_type(),
            ]
        );
        $this->add_control(
            'posts_per_page',
            [
                'label' => __('Posts Per Page', 'post-carousel-addons-for-elementor'),
                'type' => Controls_Manager::NUMBER,
                /** This filter is documented in wp-includes/formatting.php */
                'min' => 0,
                'step' => 1,
                'default' => 6,
                'description' => 'For all Post enter 0',

            ]
        );
        $this->start_controls_tabs('posts_query_tabs');
        $this->start_controls_tab('posts_query_include_by_tab',
            [
                'label' => __('Include By', 'post-carousel-addons-for-elementor'),
            ]
        );
        $this->add_control(
            'include_by',
            [
                'label' => __('Include By', 'post-carousel-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::SELECT2,
                'multiple' => true,
                'options' => [
                    'term' => __('Term', 'post-carousel-addons-for-elementor'),
                    'author' => __('Author', 'post-carousel-addons-for-elementor'),
                ],
                'conditions' => [
                    'relation' => 'and',
                    'terms' => [
                        ['name' => 'post_type', 'operator' => '==', 'value' => 'post'],
                    ]
                ],

                'default' => [''],
            ]
        );
        $this->add_control(
            'include_select_taxonomies',
            [
                'label' => __('Select Taxonomy', 'post-carousel-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::SELECT2,
                'multiple' => true,
                'options' => ['category' => 'Category', 'post_tags' => 'Tags'],
                'conditions' => [
                    'relation' => 'and',
                    'terms' => [
                        ['name' => 'post_type', 'operator' => '==', 'value' => 'post'],
                        ['name' => 'include_by', 'operator' => 'contains', 'value' => 'term'],
                    ],
                ],
                'default' => ['category'],

            ]
        );
        $this->add_control(
            'include_select_term',
            [
                'label' => __('Select Category', 'post-carousel-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::SELECT2,
                'multiple' => true,
                'options' => $this->custom_function->eshuzu_get_term_list(),
                'default' => [],
                'conditions' => [
                    'relation' => 'and',
                    'terms' => [
                        ['name' => 'post_type', 'operator' => '==', 'value' => 'post'],
                        ['name' => 'include_by', 'operator' => 'contains', 'value' => 'term'],
                        ['name' => 'include_select_taxonomies', 'operator' => 'contains', 'value' => 'category'],
                    ],
                ],
            ]
        );
        $this->add_control(
            'include_select_tags',
            [
                'label' => __('Select Tags', 'post-carousel-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::SELECT2,
                'multiple' => true,
                'options' => $this->custom_function->eshuzu_get_tag_list(),
                'default' => [],
                'conditions' => [
                    'relation' => 'and',
                    'terms' => [
                        ['name' => 'post_type', 'operator' => '==', 'value' => 'post'],
                        ['name' => 'include_by', 'operator' => 'contains', 'value' => 'term'],
                        ['name' => 'include_select_taxonomies', 'operator' => 'contains', 'value' => 'post_tags'],
                    ],
                ],
            ]
        );

        $this->add_control(
            'include_select_author',
            [
                'label' => __('Select Author', 'post-carousel-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::SELECT2,
                'multiple' => true,
                'options' => $this->custom_function->eshuzu_get_author_list(),
                'default' => [],
                'conditions' => [
                    'relation' => 'and',
                    'terms' => [
                        ['name' => 'post_type', 'operator' => '==', 'value' => 'post'],
                        ['name' => 'include_by', 'operator' => 'contains', 'value' => 'author'],
                    ],
                ],
            ]
        );

        $this->end_controls_tab();
        $this->start_controls_tab('posts_query_exclude_by_tab',
            [
                'label' => __('Exclude By', 'post-carousel-addons-for-elementor'),
            ]
        );
        $this->add_control(
            'exclude_by',
            [
                'label' => __('Exclude By', 'post-carousel-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::SELECT2,
                'multiple' => true,
                'options' => [
                    'term' => __('Term', 'post-carousel-addons-for-elementor'),
                    'author' => __('Author', 'post-carousel-addons-for-elementor'),
                ],
                'conditions' => [
                    'relation' => 'and',
                    'terms' => [
                        ['name' => 'post_type', 'operator' => '==', 'value' => 'post'],
                    ]
                ],

                'default' => [''],
            ]
        );
        $this->add_control(
            'exclude_select_taxonomies',
            [
                'label' => __('Select Taxonomy', 'post-carousel-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::SELECT2,
                'multiple' => true,
                'options' => ['category' => 'Category', 'post_tags' => 'Tags'],
                'conditions' => [
                    'relation' => 'and',
                    'terms' => [
                        ['name' => 'post_type', 'operator' => '==', 'value' => 'post'],
                        ['name' => 'exclude_by', 'operator' => 'contains', 'value' => 'term'],
                    ],
                ],
                'default' => ['category'],

            ]
        );
        $this->add_control(
            'exclude_select_term',
            [
                'label' => __('Select Category', 'post-carousel-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::SELECT2,
                'multiple' => true,
                'options' => $this->custom_function->eshuzu_get_term_list(),
                'default' => [],
                'conditions' => [
                    'relation' => 'and',
                    'terms' => [
                        ['name' => 'post_type', 'operator' => '==', 'value' => 'post'],
                        ['name' => 'exclude_by', 'operator' => 'contains', 'value' => 'term'],
                        ['name' => 'exclude_select_taxonomies', 'operator' => 'contains', 'value' => 'category'],
                    ],
                ],
            ]
        );
        $this->add_control(
            'exclude_select_tags',
            [
                'label' => __('Select Tags', 'post-carousel-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::SELECT2,
                'multiple' => true,
                'options' => $this->custom_function->eshuzu_get_tag_list(),
                'default' => [],
                'conditions' => [
                    'relation' => 'and',
                    'terms' => [
                        ['name' => 'post_type', 'operator' => '==', 'value' => 'post'],
                        ['name' => 'exclude_by', 'operator' => 'contains', 'value' => 'term'],
                        ['name' => 'exclude_select_taxonomies', 'operator' => 'contains', 'value' => 'post_tags'],
                    ],
                ],
            ]
        );
        $this->add_control(
            'exclude_select_author',
            [
                'label' => __('Select Author', 'post-carousel-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::SELECT2,
                'multiple' => true,
                'options' => $this->custom_function->eshuzu_get_author_list(),
                'default' => [],
                'conditions' => [
                    'relation' => 'and',
                    'terms' => [
                        ['name' => 'post_type', 'operator' => '==', 'value' => 'post'],
                        ['name' => 'exclude_by', 'operator' => 'contains', 'value' => 'author'],
                    ],
                ],
            ]
        );
        $this->end_controls_tab();
        $this->end_controls_tabs();

        $this->add_control(
            'post_order_by',
            [
                'label' => __('Order By', 'post-carousel-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'options' => [
                    'post_date' => __('Date', 'post-carousel-addons-for-elementor'),
                    'post_title' => __('Title', 'post-carousel-addons-for-elementor'),
                    'menu_order' => __('Menu Order', 'post-carousel-addons-for-elementor'),
                    'rand' => __('Random', 'post-carousel-addons-for-elementor'),
                ],
                'default' => 'post_date',
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'post_order',
            [
                'label' => __('Order', 'post-carousel-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'options' => [
                    'asc' => __('ASC', 'post-carousel-addons-for-elementor'),
                    'desc' => __('DESC', 'post-carousel-addons-for-elementor'),
                ],
                'default' => 'desc',
            ]
        );

        $this->add_control(
            'ignore_sticky_post',
            [
                'label' => __('Ignore Sticky Posts', 'post-slider-for-elementor'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'post-slider-for-elementor'),
                'label_off' => esc_html__('No', 'post-slider-for-elementor'),
                'return_value' => 'yes',
                'default' => 'yes',
                'description' => 'Sticky-posts ordering is visible on frontend only',
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'layout',
            [
                'label' => __('Layout', 'text-domain'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );
        $this->start_controls_tabs(
            'layout_tab'
        );

        $this->add_control(
            'slide_column_spacing',
            [
                'label' => __('Slide Column Spacing', 'post-carousel-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'description' => 'Note : Refresh or Resize editor for see effect of changes ',
                'min' => 0,
                'max' => 100,
                'step' => 1,
                'default' => 15,
                'selectors' => [
                    '{{WRAPPER}} .slick-slide' => 'margin-left: {{VALUE}}px;margin-right:{{VALUE}}px',
                    '{{WRAPPER}} .eshuzu_post_carousel_frame ' => 'margin-left: -{{VALUE}}px;margin-right: -{{VALUE}}px',
                ],
            ]
        );

        $this->add_responsive_control(
            'align',
            [
                'label' => __('Alignment', 'post-carousel-addons-for-elementor'),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'left' => [
                        'title' => __('Left', 'post-carousel-addons-for-elementor'),
                        'icon' => 'eicon-text-align-left',
                    ],
                    'center' => [
                        'title' => __('Center', 'post-carousel-addons-for-elementor'),
                        'icon' => 'eicon-text-align-center',
                    ],
                    'right' => [
                        'title' => __('Right', 'post-carousel-addons-for-elementor'),
                        'icon' => 'eicon-text-align-right',
                    ],
                ],
                'default' => 'left',
                'selectors' => [
                    '{{WRAPPER}} .eshuzu_post_carousel_frame ' => 'text-align: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'img_order',
            [
                'label' => __('Image Position', 'post-carousel-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'min' => 1,
                'max' => 10,
                'step' => 1,
                'default' => 1,
                'selectors' => [
                    '{{WRAPPER}} .esz_post_thumb' => 'order: {{VALUE}}',
                ],
                'condition' => [
                    'display_image' => 'yes'
                ],

            ]
        );
        $this->add_control(
            'title_order',
            [
                'label' => __('Title Position', 'post-carousel-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'min' => 1,
                'max' => 10,
                'step' => 1,
                'default' => 2,
                'selectors' => [
                    '{{WRAPPER}} .esz_post_title' => 'order: {{VALUE}}',
                ],

            ]
        );
        $this->add_control(
            'meta_order',
            [
                'label' => __('Excerpt Position', 'post-carousel-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'min' => 1,
                'max' => 10,
                'step' => 1,
                'default' => 3,
                'selectors' => [
                    '{{WRAPPER}} .esz_post_meta' => 'order: {{VALUE}}',
                ],
                'condition' => [
                    'meta_data!' => []
                ],

            ]
        );
        $this->add_control(
            'excerpt_order',
            [
                'label' => __('Excerpt Position', 'post-carousel-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'min' => 1,
                'max' => 10,
                'step' => 1,
                'default' => 4,
                'selectors' => [
                    '{{WRAPPER}} .esz_post_excerpt' => 'order: {{VALUE}}',
                ],
                'condition' => [
                    'display_excerpt' => 'yes'
                ],

            ]
        );
        $this->add_control(
            'link_order',
            [
                'label' => __('Link Position', 'post-carousel-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'min' => 1,
                'max' => 10,
                'step' => 1,
                'default' => 5,
                'selectors' => [
                    '{{WRAPPER}} .esz_post_link' => 'order: {{VALUE}}',
                ],
                'separator' => 'after',
                'condition' => [
                    'display_link' => 'yes'
                ],

            ]
        );

        $this->end_controls_tabs();
        $this->end_controls_section();

        $this->start_controls_section(
            'section_design_box',
            [
                'label' => __('Box', 'post-carousel-addons-for-elementor'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'box_border_width',
            [
                'label' => __('Border Width', 'post-carousel-addons-for-elementor'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 50,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .esz_post_slide' => 'border-style: solid; border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
                ],
            ]
        );

        $this->add_control(
            'box_border_radius',
            [
                'label' => __('Border Radius', 'post-carousel-addons-for-elementor'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', '%'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 200,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .esz_post_slide' => 'border-radius: {{SIZE}}{{UNIT}}',
                ],
            ]
        );

        $this->add_control(
            'box_padding',
            [
                'label' => __('Padding', 'post-carousel-addons-for-elementor'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 50,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .esz_post_slide .esz_slide_box' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
                ],
            ]
        );

        $this->add_control(
            'content_padding',
            [
                'label' => __('Content Padding', 'post-carousel-addons-for-elementor'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 50,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .esz_post_title' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
                    '{{WRAPPER}} .esz_post_meta' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
                    '{{WRAPPER}} .esz_post_excerpt' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
                    '{{WRAPPER}} .esz_post_link' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
                ],
            ]
        );

        $this->start_controls_tabs('bg_effects_tabs');

        $this->start_controls_tab('classic_style_normal',
            [
                'label' => __('Normal', 'post-carousel-addons-for-elementor'),
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'box_shadow',
                'selector' => '{{WRAPPER}} .esz_post_slide .esz_slide_box',
            ]
        );

        $this->add_control(
            'box_bg_color',
            [
                'label' => __('Background Color', 'post-carousel-addons-for-elementor'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .esz_post_slide' => 'background-color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'box_border_color',
            [
                'label' => __('Border Color', 'post-carousel-addons-for-elementor'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .esz_post_slide' => 'border-color: {{VALUE}}',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab('classic_style_hover',
            [
                'label' => __('Hover', 'post-carousel-addons-for-elementor'),
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'box_shadow_hover',
                'selector' => '{{WRAPPER}} .esz_post_slide:hover',
            ]
        );

        $this->add_control(
            'box_bg_color_hover',
            [
                'label' => __('Background Color', 'post-carousel-addons-for-elementor'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .esz_post_slide:hover' => 'background-color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'box_border_color_hover',
            [
                'label' => __('Border Color', 'post-carousel-addons-for-elementor'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .esz_post_slide:hover' => 'border-color: {{VALUE}}',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->add_control(
            'slide_padding',
            [
                'label' => __('Slide Padding', 'post-carousel-addons-for-elementor'),
                'type' => Controls_Manager::DIMENSIONS,
                'description' => 'Add Spacing in slide if box shadow enable for box <br> Note: Decrease Spacing Layout Style of "Slide Column Spacing"',
                'size_units' => ['px'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 50,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .esz_post_slide' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_style_image',
            [
                'label' => __('Image', 'post-carousel-addons-for-elementor'),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'display_image' => 'yes'
                ],
            ]
        );

        $this->add_responsive_control(
            'image_space',
            [
                'label' => __('Spacing', 'post-carousel-addons-for-elementor'),
                'type' => Controls_Manager::SLIDER,
                'default' => [
                    'size' => 15,
                ],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .esz_post_thumb' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'image_border_radius',
            [
                'label' => __('Border Radius', 'post-carousel-addons-for-elementor'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .esz_post_thumb' => 'border-radius: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'hover_animation',
            [
                'label' => __('Hover Animation', 'post-carousel-addons-for-elementor'),
                'type' => Controls_Manager::HOVER_ANIMATION,
            ]
        );

        $this->start_controls_tabs('image_effects');

        $this->start_controls_tab('normal',
            [
                'label' => __('Normal', 'post-carousel-addons-for-elementor'),
            ]
        );

        $this->add_group_control(
            Group_Control_Css_Filter::get_type(),
            [
                'name' => 'css_filters',
                'selector' => '{{WRAPPER}} .esz_post_thumb img',
            ]
        );

        $this->add_control(
            'image_opacity',
            [
                'label' => __('Opacity', 'post-carousel-addons-for-elementor'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'max' => 1,
                        'min' => 0.10,
                        'step' => 0.01,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .esz_post_thumb img' => 'opacity: {{SIZE}};',
                ],
            ]
        );

        $this->add_control(
            'background_hover_transition',
            [
                'label' => __('Transition Duration', 'post-carousel-addons-for-elementor'),
                'type' => Controls_Manager::SLIDER,
                'default' => [
                    'size' => 0.3,
                ],
                'range' => [
                    'px' => [
                        'max' => 3,
                        'step' => 0.1,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .esz_post_thumb img' => 'transition-duration: {{SIZE}}s',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab('hover',
            [
                'label' => __('Hover', 'post-carousel-addons-for-elementor'),
            ]
        );

        $this->add_group_control(
            Group_Control_Css_Filter::get_type(),
            [
                'name' => 'css_filters_hover',
                'selector' => '{{WRAPPER}}:hover .esz_post_thumb img',
            ]
        );

        $this->add_control(
            'image_opacity_hover',
            [
                'label' => __('Opacity', 'post-carousel-addons-for-elementor'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'max' => 1,
                        'min' => 0.10,
                        'step' => 0.01,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}}:hover .esz_post_thumb img' => 'opacity: {{SIZE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->end_controls_section();
        $this->start_controls_section(
            'slide_content_style',
            [
                'label' => __('Content', 'post-carousel-addons-for-elementor'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_control(
            'heading_title',
            [
                'label' => __('Title', 'post-carousel-addons-for-elementor'),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );
        $this->add_responsive_control(
            'title_bottom_space',
            [
                'label' => __('Spacing', 'post-carousel-addons-for-elementor'),
                'type' => Controls_Manager::SLIDER,
                'default' => [
                    'size' => 15,
                ],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .esz_post_title' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        $this->add_control(
            'title_color',
            [
                'label' => __('Color', 'post-carousel-addons-for-elementor'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .esz_post_title' => 'color: {{VALUE}};',
                ],
                'global' => [
                    'default' => Global_Colors::COLOR_PRIMARY,
                ],

            ]
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'title_typography',
                'global' => [
                    'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
                ],
                'selector' => '{{WRAPPER}} .esz_post_title',
            ]
        );

        $this->add_group_control(
            Group_Control_Text_Shadow::get_type(),
            [
                'name' => 'title_shadow',
                'selector' => '{{WRAPPER}} .esz_post_title',
            ]
        );

        $this->add_control(
            'heading_meta',
            [
                'label' => __('Meta', 'post-carousel-addons-for-elementor'),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
                'condition' => [
                    'meta_data!' => []
                ],
            ]
        );

        $this->add_responsive_control(
            'meta_bottom_space',
            [
                'label' => __('Spacing', 'post-carousel-addons-for-elementor'),
                'type' => Controls_Manager::SLIDER,
                'default' => [
                    'size' => 15,
                ],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .esz_post_meta' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [
                    'meta_data!' => []
                ],
            ]
        );

        $this->add_control(
            'meta_color',
            [
                'label' => __('Color', 'post-carousel-addons-for-elementor'),
                'type' => Controls_Manager::COLOR,
                'default' => '#66666',
                'selectors' => [
                    '{{WRAPPER}} .esz_post_meta' => 'color: {{VALUE}};',
                ],
                'condition' => [
                    'meta_data!' => []
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'meta_typography',
                'global' => [
                    'default' => Global_Typography::TYPOGRAPHY_SECONDARY,
                ],
                'selector' => '{{WRAPPER}} .esz_post_meta',
                'condition' => [
                    'meta_data!' => []
                ],
            ]
        );

        $this->add_control(
            'heading_excerpt',
            [
                'label' => __('Excerpt', 'post-carousel-addons-for-elementor'),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
                'condition' => [
                    'display_excerpt' => 'yes'
                ],
            ]
        );

        $this->add_responsive_control(
            'excerpt_bottom_space',
            [
                'label' => __('Spacing', 'post-carousel-addons-for-elementor'),
                'type' => Controls_Manager::SLIDER,
                'default' => [
                    'size' => 15,
                ],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .esz_post_excerpt' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [
                    'display_excerpt' => 'yes'
                ],
            ]
        );

        $this->add_control(
            'excerpt_color',
            [
                'label' => __('Color', 'post-carousel-addons-for-elementor'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .esz_post_excerpt' => 'color: {{VALUE}};',
                ],
                'global' => [
                    'default' => Global_Colors::COLOR_TEXT,
                ],
                'condition' => [
                    'display_excerpt' => 'yes'
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'excerpt_typography',
                'global' => [
                    'default' => Global_Typography::TYPOGRAPHY_TEXT,
                ],
                'selector' => '{{WRAPPER}} .esz_post_excerpt',
                'condition' => [
                    'display_excerpt' => 'yes'
                ],
            ]
        );

        $this->add_control(
            'heading_link',
            [
                'label' => __('Link', 'post-carousel-addons-for-elementor'),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
                'condition' => [
                    'display_link' => 'yes'
                ],
            ]
        );

        $this->add_responsive_control(
            'link_bottom_space',
            [
                'label' => __('Spacing', 'post-carousel-addons-for-elementor'),
                'type' => Controls_Manager::SLIDER,
                'default' => [
                    'size' => 15,
                ],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .esz_post_link' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [
                    'display_link' => 'yes'
                ],
            ]
        );

        $this->add_control(
            'link_color',
            [
                'label' => __('Color', 'post-carousel-addons-for-elementor'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .esz_post_link a' => 'color: {{VALUE}};',
                ],
                'global' => [
                    'default' => Global_Colors::COLOR_ACCENT,
                ],
                'condition' => [
                    'display_link' => 'yes'
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'link_typography',
                'global' => [
                    'default' => Global_Typography::TYPOGRAPHY_ACCENT,
                ],
                'selector' => '{{WRAPPER}} .esz_post_link',
                'condition' => [
                    'display_link' => 'yes'
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'slide_navigation_style',
            [
                'label' => __('Navigation', 'post-carousel-addons-for-elementor'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'arrow_style_title',
            [
                'label' => __('Arrow', 'post-carousel-addons-for-elementor'),
                'type' => Controls_Manager::HEADING,
                'condition' => [
                    'display_arrow' => 'yes'
                ],
            ]
        );

        $this->add_responsive_control(
            'align_arrow',
            [
                'label' => __('Alignment', 'post-carousel-addons-for-elementor'),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'left' => [
                        'title' => __('Left', 'post-carousel-addons-for-elementor'),
                        'icon' => 'eicon-text-align-left',
                    ],
                    'center' => [
                        'title' => __('Center', 'post-carousel-addons-for-elementor'),
                        'icon' => 'eicon-text-align-center',
                    ],
                    'right' => [
                        'title' => __('Right', 'post-carousel-addons-for-elementor'),
                        'icon' => 'eicon-text-align-right',
                    ],
                ],
                'default' => 'center',
                'selectors' => [
                    '{{WRAPPER}} .carousel_nav' => 'text-align: {{VALUE}};',
                ],
                'condition' => [
                    'display_arrow' => 'yes'
                ],
            ]
        );

        $this->add_responsive_control(
            'arrow_size',
            [
                'label' => __('Icon Size', 'post-carousel-addons-for-elementor'),
                'type' => Controls_Manager::SLIDER,
                'default' => [
                    'size' => 20,
                ],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .carousel_nav i' => 'font-size: {{SIZE}}{{UNIT}}; width: {{SIZE}}{{UNIT}} ;',
                    '{{WRAPPER}} .eshuzu_post_carousel_section' => 'padding-top: {{SIZE}}{{UNIT}};padding-bottom: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [
                    'display_arrow' => 'yes'
                ],
            ]
        );

        $this->add_responsive_control(
            'arrow_spacing',
            [
                'label' => __('Arrow Spacing', 'post-carousel-addons-for-elementor'),
                'type' => Controls_Manager::SLIDER,
                'default' => [
                    'size' => 0,
                ],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .carousel_nav .slick-arrow' => 'margin-left: {{SIZE}}{{UNIT}}; margin-right: {{SIZE}}{{UNIT}} ;',
                ],
                'condition' => [
                    'display_arrow' => 'yes'
                ],
            ]
        );

        $this->add_control(
            'arrow_border_width',
            [
                'label' => __('Border Width', 'post-carousel-addons-for-elementor'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px'],
                'default' => [
                    'size' => '1',
                    'unit' => 'px',
                ],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 50,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .slick-arrow' => 'border-style: solid; border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
                ],
                'condition' => [
                    'display_arrow' => 'yes'
                ],
            ]
        );

        $this->add_control(
            'arrow_border_radius',
            [
                'label' => __('Border Radius', 'post-carousel-addons-for-elementor'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', '%'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 200,
                    ],
                ],
                'default' => [
                    'size' => '50',
                    'unit' => '%',
                ],
                'selectors' => [
                    '{{WRAPPER}} .slick-arrow' => 'border-radius: {{SIZE}}{{UNIT}}',
                ],
                'condition' => [
                    'display_arrow' => 'yes'
                ],
            ]
        );

        $this->add_control(
            'arrow_margin',
            [
                'label' => __('Margin', 'post-carousel-addons-for-elementor'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 50,
                    ],
                ],
                'default' => [
                    'size' => '10',
                    'unit' => 'px',
                ],
                'selectors' => [
                    '{{WRAPPER}} .slick-arrow i' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
                ],
                'condition' => [
                    'display_arrow' => 'yes'
                ],
            ]
        );

        $this->start_controls_tabs('arrow_effect_tabs');

        $this->start_controls_tab('arrow_style_normal',
            [
                'label' => __('Normal', 'post-carousel-addons-for-elementor'),
                'condition' => [
                    'display_arrow' => 'yes'
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'arrow_box_shadow',
                'selector' => '{{WRAPPER}} .slick-arrow',
                'condition' => [
                    'display_arrow' => 'yes'
                ],
            ]
        );

        $this->add_control(
            'arrow_bg_color',
            [
                'label' => __('Background Color', 'post-carousel-addons-for-elementor'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .slick-arrow' => 'background-color: {{VALUE}}',
                ],
                'condition' => [
                    'display_arrow' => 'yes'
                ],
            ]
        );

        $this->add_control(
            'arrow_border_color',
            [
                'label' => __('Border Color', 'post-carousel-addons-for-elementor'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .slick-arrow' => 'border-color: {{VALUE}}',
                ],
                'condition' => [
                    'display_arrow' => 'yes'
                ],
            ]
        );

        $this->add_control(
            'arrow_color',
            [
                'label' => __('Arrow Color', 'post-carousel-addons-for-elementor'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .slick-arrow' => 'color: {{VALUE}}',
                ],
                'condition' => [
                    'display_arrow' => 'yes'
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab('arrow_style_hover',
            [
                'label' => __('Hover', 'post-carousel-addons-for-elementor'),
                'condition' => [
                    'display_arrow' => 'yes'
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'arrow_box_shadow_hover',
                'selector' => '{{WRAPPER}} .slick-arrow:hover',
                'condition' => [
                    'display_arrow' => 'yes'
                ],
            ]
        );

        $this->add_control(
            'arrow_bg_color_hover',
            [
                'label' => __('Background Color', 'post-carousel-addons-for-elementor'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .slick-arrow:hover' => 'background-color: {{VALUE}}',
                ],
                'condition' => [
                    'display_arrow' => 'yes'
                ],
            ]
        );

        $this->add_control(
            'arrow_border_color_hover',
            [
                'label' => __('Border Color', 'post-carousel-addons-for-elementor'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .slick-arrow:hover' => 'border-color: {{VALUE}}',
                ],
                'condition' => [
                    'display_arrow' => 'yes'
                ],
            ]
        );
        $this->add_control(
            'arrow_color_hover',
            [
                'label' => __('Arrow Color', 'post-carousel-addons-for-elementor'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .slick-arrow:hover' => 'color: {{VALUE}}',
                ],
                'condition' => [
                    'display_arrow' => 'yes'
                ],
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->add_control(
            'dots_style_title',
            [
                'label' => __('Dots', 'post-carousel-addons-for-elementor'),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
                'condition' => [
                    'display_dots' => 'yes'
                ],
            ]
        );

        $this->add_control(
            'dots_spacing',
            [
                'label' => __('Dots Spacing', 'post-carousel-addons-for-elementor'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'default' => [
                    'size' => '5',
                    'unit' => 'px',
                ],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 200,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .slick-dots li' => 'margin-left: {{SIZE}}{{UNIT}};margin-right: {{SIZE}}{{UNIT}}',
                ],
                'condition' => [
                    'display_dots' => 'yes'
                ],
            ]
        );

        $this->start_controls_tabs('dots_effect_tabs');
        $this->start_controls_tab('dots_style_normal',
            [
                'label' => __('Normal', 'post-carousel-addons-for-elementor'),
                'condition' => [
                    'display_dots' => 'yes'
                ],
            ]
        );

        $this->add_control(
            'dots_bg_color',
            [
                'label' => __('Dots Color', 'post-carousel-addons-for-elementor'),
                'type' => Controls_Manager::COLOR,
                'default' => 'rgba(0,0,0,0.5)',
                'selectors' => [
                    '{{WRAPPER}} .slick-dots li button:before' => 'background-color: {{VALUE}}',
                ],
                'condition' => [
                    'display_dots' => 'yes'
                ],
            ]
        );

        $this->add_control(
            'dots_size',
            [
                'label' => __('Dots Size', 'post-carousel-addons-for-elementor'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'default' => [
                    'size' => '6',
                    'unit' => 'px',
                ],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 200,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .slick-dots li button:before' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [
                    'display_dots' => 'yes'
                ],
            ]
        );

        $this->end_controls_tab();
        $this->start_controls_tab('dots_style_hover',
            [
                'label' => __('Hover', 'post-carousel-addons-for-elementor'),
                'condition' => [
                    'display_dots' => 'yes'
                ],
            ]
        );
        $this->add_control(
            'dots_bg_color_hover',
            [
                'label' => __('Dots Color', 'post-carousel-addons-for-elementor'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .slick-dots li button:hover:before' => 'background-color: {{VALUE}}',
                ],
                'condition' => [
                    'display_dots' => 'yes'
                ],
            ]
        );

        $this->end_controls_tab();
        $this->start_controls_tab('dots_style_active',
            [
                'label' => __('Active', 'post-carousel-addons-for-elementor'),
                'condition' => [
                    'display_dots' => 'yes'
                ],
            ]
        );
        $this->add_control(
            'dots_bg_color_active',
            [
                'label' => __('Dots Color', 'post-carousel-addons-for-elementor'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .slick-dots li.slick-active button:before' => 'background-color: {{VALUE}}',
                ],
                'condition' => [
                    'display_dots' => 'yes'
                ],
            ]
        );
        $this->add_control(
            'dots_size_active',
            [
                'label' => __('Dots Size', 'post-carousel-addons-for-elementor'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'default' => [
                    'size' => '8',
                    'unit' => 'px',
                ],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 200,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .slick-dots li button:before' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [
                    'display_dots' => 'yes'
                ],
            ]
        );
        $this->end_controls_tab();
        $this->end_controls_tabs();

        $this->end_controls_section();
    }

    /**
     * Render widget output on the frontend.
     *
     * Written in PHP and used to generate the final HTML.
     *
     * @since 1.0.0
     * @access protected
     */
    protected function render() {
        /**
         *  Here you can output your control data and build your content.
         **/
        $settings = $this->get_settings_for_display();
        $the_query = $this->custom_function->eshuzu_posts_query($settings);
        ?>
        <div class="eshuzu_post_carousel_section">
            <?php if ($the_query->have_posts()) { ?>
                <div class="eshuzu_post_carousel_frame "
                     data-slide_count="<?php echo esc_html($settings['slide_count']); ?>"
                     data-slide_count_tablet="<?php echo esc_html($settings['slide_count_tablet']); ?>"
                     data-slide_count_mobile="<?php echo esc_html($settings['slide_count_mobile']); ?>"
                     data-slide_scroll="<?php echo esc_html($settings['slide_scroll']); ?>"
                     data-slide_scroll_tablet="<?php echo esc_html($settings['slide_scroll_tablet']); ?>"
                     data-slide_scroll_mobile="<?php echo esc_html($settings['slide_scroll_mobile']); ?>"
                     data-dots_show="<?php if ($settings['display_dots'] == 'yes') : echo esc_html(1); endif; ?>"
                     data-arrow_show="<?php if ($settings['display_arrow'] == 'yes') : echo esc_html(1); endif; ?>"
                     data-center_mode="<?php if ($settings['center_mode'] == 'yes') : echo esc_html(1); endif; ?>"
                     data-autoplay="<?php if ($settings['autoplay_carousel'] == 'yes') : echo esc_html(1); endif; ?>"
                     data-autoplaySpeed="<?php echo esc_html($settings['autoplay_speed']); ?>"
                     data-infinite="<?php if ($settings['infinite_carousel'] == 'yes') : echo esc_html(1); endif; ?>"
                >
                    <?php while ($the_query->have_posts()) {
                        $the_query->the_post(); ?>
                        <div id="epc_<?php the_ID() ?>" class="esz_post_slide">
                            <div class="esz_slide_box">
                                <?php if (get_the_post_thumbnail_url() && $settings['display_image'] == 'yes') :
                                    $thumbnail = Group_Control_Image_Size::get_attachment_image_src(get_post_thumbnail_id(), 'thumbnail_size', $settings); ?>
                                    <div class="esz_post_thumb">
                                        <img class="esz_post_thumb_img elementor-animation-<?php echo esc_html($settings['hover_animation']); ?>"
                                             src="<?php echo esc_url($thumbnail); ?>" alt="">
                                    </div>
                                <?php endif; ?>
                                <h3 class="esz_post_title"><?php the_title(); ?></h3>
                                <div class="esz_post_meta">
                                    <?php $this->render_meta_data($settings['meta_data']); ?>
                                </div>
                                <?php if ($settings['display_excerpt'] == 'yes') : ?>
                                    <div class="esz_post_excerpt">
                                        <?php echo esc_html(wp_trim_words(get_the_excerpt(), $settings['excerpt_length'], "...")); ?>
                                    </div>
                                <?php endif;
                                if ($settings['display_link'] == 'yes') : ?>
                                    <div class="esz_post_link">
                                        <a class=""
                                           href="<?php the_permalink(); ?>"><?php echo esc_html($settings['read_more_text']) ?> </a>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                        <?php
                    } ?>
                </div>
            <?php } ?>
            <?php if ($settings['display_arrow'] == 'yes'): ?>
                <div class="carousel_nav">
                    <a href="javascript:void(0)" class="previous_arrow">
                        <i class="<?php echo esc_html($settings['left_arrow_icon']['value']) ?>"></i>
                    </a>
                    <a href="javascript:void(0)" class="next_arrow">
                        <i class="<?php echo esc_html($settings['right_arrow_icon']['value']) ?>"></i>
                    </a>
                </div>
            <?php endif; ?>
        </div>
        <?php
        /* Restore original Post Data */
        wp_reset_postdata();
        wp_reset_query();
    }

    protected function render_meta_data($settings) {
        /** @var array $settings e.g. [ 'author', 'date', ... ] */

        if (empty($settings)) {
            return;
        }
        ?>
        <div class="elementor-post__meta-data">
            <?php
            if (in_array('author', $settings)) {
                $this->render_author();
            }

            if (in_array('date', $settings)) {
                $this->render_date_by_type();
            }

            if (in_array('time', $settings)) {
                $this->render_time();
            }

            if (in_array('comments', $settings)) {
                $this->render_comments();
            }
            if (in_array('modified', $settings)) {
                $this->render_date_by_type('modified');
            }
            ?>
        </div>
        <?php
    }

    protected function render_author() {
        ?>
        <span class="esz_post_author">
			<?php the_author(); ?>
		</span>
        <?php
    }

    protected function render_time() {
        ?>
        <span class="esz_post_time">
			<?php the_time(); ?>
		</span>
        <?php
    }

    protected function render_comments() {
        ?>
        <span class="esz_post_avatar">
			<?php comments_number(); ?>
		</span>
        <?php
    }
}

    