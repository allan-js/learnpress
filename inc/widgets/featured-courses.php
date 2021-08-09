<?php
/**
 * Feature Courses Widget.
 *
 * @author  ThimPress
 * @category Widgets
 * @package  Learnpress/Widgets
 * @version  4.0.0
 * @extends  LP_Widget
 */

defined( 'ABSPATH' ) || exit();

if ( ! class_exists( 'LP_Widget_Featured_Courses' ) ) {

	/**
	 * Class LP_Widget_Featured_Courses
	 */
	class LP_Widget_Featured_Courses extends LP_Widget {

		public function __construct() {
			$this->widget_cssclass    = 'learnpress widget_course_featured';
			$this->widget_description = esc_html__( 'Display the Featured courses', 'learnpress' );
			$this->widget_id          = 'learnpress_widget_course_featured';
			$this->widget_name        = esc_html__( 'LearnPress - Featured Courses', 'learnpress' );
			$this->settings           = array(
				'title'                  => array(
					'label' => __( 'Title', 'learnpress' ),
					'type'  => 'text',
					'std'   => __( 'Featured Courses', 'learnpress' ),
				),
				'show_teacher'           => array(
					'label' => __( 'Show teacher', 'learnpress' ),
					'type'  => 'checkbox',
					'std'   => 1,
				),
				'show_lesson'            => array(
					'label' => __( 'Show lesson', 'learnpress' ),
					'type'  => 'checkbox',
					'std'   => 1,
				),
				'show_thumbnail'         => array(
					'label' => __( 'Show Thumbnail', 'learnpress' ),
					'type'  => 'checkbox',
					'std'   => 1,
				),
				'limit'                  => array(
					'label' => __( 'Limit', 'learnpress' ),
					'type'  => 'number',
					'min'   => 1,
					'std'   => 4,
				),
				'desc_length'            => array(
					'label' => __( 'Description Length', 'learnpress' ),
					'type'  => 'number',
					'min'   => 0,
					'std'   => 10,
				),
				'show_enrolled_students' => array(
					'label' => __( 'Show Enrolled Students', 'learnpress' ),
					'type'  => 'checkbox',
					'std'   => 1,
				),
				'show_price'             => array(
					'label' => __( 'Show Price', 'learnpress' ),
					'type'  => 'checkbox',
					'std'   => 1,
				),
				'css_class'              => array(
					'label' => __( 'CSS Class', 'learnpress' ),
					'type'  => 'text',
					'std'   => '',
				),
				'bottom_link_text'       => array(
					'label' => __( 'Go to Courses', 'learnpress' ),
					'type'  => 'text',
					'std'   => 'LP Courses',
				),
			);

			parent::__construct();
		}

		/**
		 * Send content for API
		 *
		 * @param array $instance Widget Instance
		 * @param array $params RestAPI param need for content.
		 * @return string || WP_Error
		 */
		public function lp_rest_api_content( $instance, $params ) {
			$filter        = new LP_Course_Filter();
			$filter->limit = $instance['limit'] ?? 4;

			$courses = LP_Course_DB::getInstance()->get_featured_courses( $filter );

			$data = learn_press_get_template_content(
				'widgets/featured-courses.php',
				array(
					'courses'  => $courses,
					'instance' => $instance,
				)
			);

			return $data;
		}
	}
}
