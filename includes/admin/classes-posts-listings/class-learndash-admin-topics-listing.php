<?php
/**
 * LearnDash Topics (sfwd-topic) Posts Listing Class.
 *
 * @package LearnDash
 * @subpackage admin
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ( class_exists( 'Learndash_Admin_Posts_Listing' ) ) && ( ! class_exists( 'Learndash_Admin_Topics_Listing' ) ) ) {
	/**
	 * Class for LearnDash Topics Listing Pages.
	 */
	class Learndash_Admin_Topics_Listing extends Learndash_Admin_Posts_Listing {

		/**
		 * Public constructor for class
		 */
		public function __construct() {
			$this->post_type = 'sfwd-topic';

			parent::__construct();
		}

		/**
		 * Call via the WordPress load sequence for admin pages.
		 */
		public function on_load_edit() {
			global $typenow, $post;

			if ( ( empty( $typenow ) ) || ( $typenow !== $this->post_type ) ) {
				return;
			}

			$this->post_type_selectors = array(
				'course_id' => array(
					'query_args'       => array(
						'post_type' => learndash_get_post_type_slug( 'course' ),
					),
					'query_arg'        => 'course_id',
					'selected'         => 0,
					'field_name'       => 'course_id',
					'field_id'         => 'course_id',
					'show_all_value'   => '',
					'show_all_label'   => sprintf(
						// translators: placeholder: Courses.
						esc_html_x( 'Show All %s', 'placeholder: Courses', 'learndash' ),
						LearnDash_Custom_Label::get_label( 'courses' )
					),
					'lazy_load'        => true,
					//'show_empty_value' => 'empty',
					//'show_empty_label' => sprintf(
					//	// translators: placeholder: Courses.
					//	esc_html_x( '-- No %s --', 'placeholder: Courses', 'learndash' ),
					//	LearnDash_Custom_Label::get_label( 'courses' )
					//),
				),
				'lesson_id' => array(
					'query_args'       => array(
						'post_type' => learndash_get_post_type_slug( 'lesson' ),
					),
					'query_arg'        => 'lesson_id',
					'selected'         => 0,
					'field_name'       => 'lesson_id',
					'field_id'         => 'lesson_id',
					'show_all_value'   => '',
					'show_all_label'   => sprintf(
						// translators: placeholder: Lessons.
						esc_html_x( 'Show All %s', 'placeholder: Lessons', 'learndash' ),
						LearnDash_Custom_Label::get_label( 'lessons' )
					),
					'lazy_load'        => false,
				),

			);
			parent::on_load_edit();

			add_filter( 'learndash_show_post_type_selector_filter', array( $this, 'filter_quiz_lesson_selector' ), 30, 2 );
			//add_action( 'learndash_post_listing_after_option', array( $this, 'learndash_post_listing_after_option' ), 30, 3 );
		}

		/**
		 * Filter the selector filters. 
		 *
		 * @param array $query_args Query Args for Selector.
		 * @param string $post_type Post Type slug for selector.
		 */
		public function filter_quiz_lesson_selector( $query_args = array(), $post_type = '' ) {
			global $sfwd_lms;

			// Check that the selector post type matches for out listing post type.
			if ( $post_type === $this->post_type ) {
				if ( isset( $query_args['post_type'] ) ) {
					if ( ( ( is_string( $query_args['post_type'] ) ) && ( learndash_get_post_type_slug( 'lesson' ) === $query_args['post_type'] ) ) || ( ( is_array( $query_args['post_type'] ) ) && ( in_array( learndash_get_post_type_slug( 'lesson' ), $query_args['post_type'] ) ) ) ) {

						if ( ( isset( $_GET['course_id'] ) ) && ( ! empty( $_GET['course_id'] ) ) ) {
							$lessons_items = $sfwd_lms->select_a_lesson_or_topic( absint( $_GET['course_id'] ), false, false );
							if ( ! empty( $lessons_items ) ) {
								$query_args['post__in'] = array_keys( $lessons_items );
								$query_args['orderby'] = 'post__in';
							} else {
								$query_args['post__in'] = array( 0 );
							}
						} else {
							$query_args['post__in'] = array( 0 );
						}
					}
				}
			}

			return $query_args;
		}

		public function learndash_post_listing_after_option( $post, $query_args = array(), $post_type = '' ) {
			global $sfwd_lms;

			// Check that the selector post type matches for out listing post type.
			if ( $post_type === $this->post_type ) {
				if ( ( ( is_string( $query_args['post_type'] ) ) && ( learndash_get_post_type_slug( 'lesson' ) === $query_args['post_type'] ) ) || ( ( is_array( $query_args['post_type'] ) ) && ( in_array( learndash_get_post_type_slug( 'lesson' ), $query_args['post_type'] ) ) ) ) {
					if ( ( isset( $_GET['course_id'] ) ) && ( ! empty( $_GET['course_id'] ) ) ) {
						$lessons_topics = learndash_get_topic_list( $post->ID, absint( $_GET['course_id'] ) );
						if ( ! empty( $lessons_topics ) ) {
							foreach ( $lessons_topics as $topic ) {
								$selected = '';
								if ( ( isset( $_GET['lesson_id'] ) ) && ( ! empty( $_GET['lesson_id']) ) ) {
									$selected = selected( absint( $_GET['lesson_id'] ), $topic->ID, false );
								}
								echo '<option value="' . absint( $topic->ID ) . '" ' . $selected . '>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' . apply_filters( 'the_title', $topic->post_title, $topic->ID ) . '</option>';
							}
						}
					}
				}
			}
		}

		/**
		 * Add custom link to row action array.
		 *
		 * @since 3.2.0
		 *
		 * @param array   $row_actions Existing Row actions for course.
		 * @param WP_Post $post        LEsson Post object for current row.
		 *
		 * @return array $row_actions
		 */
		public function post_row_actions( $row_actions = array(), $post = null ) {
			global $typenow;

			if ( $typenow === $this->post_type ) {
				// Set the Primary Course for the post.
				if ( LearnDash_Settings_Section::get_section_setting( 'LearnDash_Settings_Courses_Builder', 'shared_steps' ) == 'yes' ) {
					$course_id = learndash_get_primary_course_for_step( $post->ID );
					if ( empty( $course_id ) ) {
						$post_courses = learndash_get_courses_for_step( $post->ID );
						if ( ( isset( $post_courses['secondary'] ) ) && ( ! empty( $post_courses['secondary'] ) ) ) {
							foreach ( $post_courses['secondary'] as $course_id => $course_title ) {
								learndash_set_primary_course_for_step( $post->ID, $course_id );
								break;
							}
						}
					}
				}
			}

			return $row_actions;
		}

		// End of functions.
	}
}
new Learndash_Admin_Topics_Listing();
