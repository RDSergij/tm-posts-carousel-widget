<?php
/**
 * Plugin Name:  TM Posts Carousel Widget
 * Plugin URI: https://github.com/RDSergij
 * Description: Posts carousel widget
 * Version: 1.0.0
 * Author: Osadchyi Serhii
 * Author URI: https://github.com/RDSergij
 * Text Domain: photolab-base-tm
 *
 * @package TM_Posts_Widget
 *
 * @since 1.0.0
 */

if ( ! class_exists( 'TM_Posts_Carousel_Widget' ) ) {
	/**
	 * Set constant text domain.
	 *
	 * @since 1.0.0
	 */
	if ( ! defined( 'PHOTOLAB_BASE_TM_ALIAS' ) ) {
		define( 'PHOTOLAB_BASE_TM_ALIAS', 'photolab-base-tm' );
	}

	/**
	 * Set constant path of text domain.
	 *
	 * @since 1.0.0
	 */
	if( ! defined( 'PHOTOLAB_BASE_TM_PATH' ) ) {
		define( 'PHOTOLAB_BASE_TM_PATH', dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
	}

	/**
	 * Adds register_tm_posts_widget widget.
	 */
	class TM_Posts_Carousel_Widget extends WP_Widget {

		/**
		 * Default settings
		 *
		 * @var type array
		 */
		private $instance_default = array();
		/**
		 * Register widget with WordPress.
		 */
		function __construct() {
			parent::__construct(
				'tm_posts_carousel_widget', // Base ID
				__( 'TM Posts Carousel Widget', PHOTOLAB_BASE_TM_ALIAS ),
				array( 'description' => __( 'Posts carousel widget', PHOTOLAB_BASE_TM_ALIAS ) )
			);
			// Set default settings
			$this->instance_default = array(
				'title'				=> __( 'List', PHOTOLAB_BASE_TM_ALIAS ),
				'categories'		=> 0,
				'count'				=> 4,
				'slides_per_view'	=> 2,
				'length'			=> 5,
			);
		}

		/**
		 * Load languages
		 *
		 * @since 1.0.0
		 */
		public function include_languages() {
			load_plugin_textdomain( PHOTOLAB_BASE_TM_ALIAS, false, PHOTOLAB_BASE_TM_PATH );
		}

		/**
		 * Frontend view
		 *
		 * @param type $args array.
		 * @param type $instance array.
		 */
		public function widget( $args, $instance ) {
			foreach ( $this->instance_default as $key => $value ) {
				$$key = ! empty( $instance[ $key ] ) ? $instance[ $key ] : $value;
			}

			// Swiper js
			wp_register_script( 'tm-post-carousel-script-swiper', plugins_url( 'assets/js/swiper.min.js', __FILE__ ), '', '', true );
			wp_enqueue_script( 'tm-post-carousel-script-swiper' );

			// Custom js
			wp_register_script( 'tm-post-carousel-script-frontend', plugins_url( 'assets/js/frontend.min.js', __FILE__ ), '', '', true );
			wp_localize_script( 'tm-post-carousel-script-frontend', 'TMWidgetParam', array( 'slidesPerView' => $slides_per_view ) );
			wp_enqueue_script( 'tm-post-carousel-script-frontend' );

			// Swiper styles
			wp_register_style( 'tm-post-carousel-swiper', plugins_url( 'assets/css/swiper.min.css', __FILE__ ) );
			wp_enqueue_style( 'tm-post-carousel-swiper' );

			// Custom styles
			wp_register_style( 'tm-post-carousel-frontend', plugins_url( 'assets/css/frontend.min.css', __FILE__ ) );
			wp_enqueue_style( 'tm-post-carousel-frontend' );

			$query = new WP_Query( array( 'posts_per_page' => $count, 'cat' => $categories ) );

			if ( $query->have_posts() ) {
				require __DIR__ . '/views/frontend.php';
			}
		}

		/**
		 * Create admin form for widget
		 *
		 * @param type $instance array.
		 */
		public function form( $instance ) {
			foreach ( $this->instance_default as $key => $value ) {
				$$key = ! empty( $instance[ $key ] ) ? $instance[ $key ] : $value;
			}

			// Custom styles
			wp_register_style( 'tm-post-carousel-admin', plugins_url( 'assets/css/admin.min.css', __FILE__ ) );
			wp_enqueue_style( 'tm-post-carousel-admin' );

			// include ui-elements
			require_once __DIR__ . '/admin/lib/ui-elements/ui-text/ui-text.php';
			require_once __DIR__ . '/admin/lib/ui-elements/ui-select/ui-select.php';

			$title_field = new UI_Text(
							array(
									'id'            => $this->get_field_id( 'title' ),
									'type'          => 'text',
									'name'          => $this->get_field_name( 'title' ),
									'placeholder'   => __( 'New title', PHOTOLAB_BASE_TM_ALIAS ),
									'value'         => $title,
									'label'         => __( 'Title widget', PHOTOLAB_BASE_TM_ALIAS ),
							)
					);
			$title_html = $title_field->render();

			$categories_list = get_categories( array( 'hide_empty' => 0 ) );
			$categories_array = array( '0' => 'not selected' );
			foreach ( $categories_list as $category_item ) {
				$categories_array[ $category_item->term_id ] = $category_item->name;
			}

			$categories_field = new UI_Select(
							array(
								'id'				=> $this->get_field_id( 'categories' ),
								'name'				=> $this->get_field_name( 'categories' ),
								'value'				=> $categories,
								'options'			=> $categories_array,
							)
						);
			$categories_html = $categories_field->render();

			$count_field = new UI_Text(
							array(
									'id'            => $this->get_field_id( 'count' ),
									'type'          => 'text',
									'name'          => $this->get_field_name( 'count' ),
									'placeholder'   => __( 'posts count', PHOTOLAB_BASE_TM_ALIAS ),
									'value'         => $count,
									'label'         => __( 'Count of posts', PHOTOLAB_BASE_TM_ALIAS ),
							)
					);
			$count_html = $count_field->render();

			$slides_per_view_field = new UI_Text(
							array(
									'id'            => $this->get_field_id( 'slides_per_view' ),
									'type'          => 'text',
									'name'          => $this->get_field_name( 'slides_per_view' ),
									'placeholder'   => __( 'slides per view', PHOTOLAB_BASE_TM_ALIAS ),
									'value'         => $slides_per_view,
									'label'         => __( 'Items per view', PHOTOLAB_BASE_TM_ALIAS ),
							)
					);
			$slides_per_view_html = $slides_per_view_field->render();

			$length_field = new UI_Text(
							array(
									'id'            => $this->get_field_id( 'length' ),
									'type'          => 'text',
									'name'          => $this->get_field_name( 'length' ),
									'placeholder'   => __( 'words length', PHOTOLAB_BASE_TM_ALIAS ),
									'value'         => $length,
									'label'         => __( 'Words length', PHOTOLAB_BASE_TM_ALIAS ),
							)
					);
			$length_html = $length_field->render();

			// show view
			require 'views/widget-form.php';
		}

		/**
		 * Update settings
		 *
		 * @param type $new_instance array.
		 * @param type $old_instance array.
		 * @return type array
		 */
		public function update( $new_instance, $old_instance ) {
			$instance = array();
			foreach ( $this->instance_default as $key => $value ) {
				$instance[ $key ] = ! empty( $new_instance[ $key ] ) ? $new_instance[ $key ] : $value;
			}

			return $instance;
		}
	}

	/**
	 * Register widget
	 */
	function register_tm_carousel_widget() {
		register_widget( 'tm_posts_carousel_widget' );
	}
	add_action( 'widgets_init', 'register_tm_carousel_widget' );

}
