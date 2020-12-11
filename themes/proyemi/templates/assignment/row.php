<?php
/**
 * Assignment list individual row
 *
 * Available Variables:
 *
 * $course_step_post: WP_Post object for the Lesson/Topic being shown
 *
 * @since 3.0
 *
 * @package LearnDash\Lesson
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$assignment_points = learndash_get_points_awarded_array( $assignment->ID ); ?>

<div class="ld-table-list-item">
	<div class="ld-table-list-item-preview">

		<?php
		/**
		 * Fires before the assignment list.
		 *
		 * @since 3.0.0
		 *
		 * @param WP_Post $assignment WP_Post object for assignment.
		 * @param int     $post_id    Post ID.
		 * @param int     $course_id  Course ID.
		 * @param int     $user_id    User ID.
		 */
		do_action( 'learndash-assignment-row-before', $assignment, get_the_ID(), $course_id, $user_id );
		?>

		<div class="ld-table-list-title">

			<?php
			/**
			 * Fires before the assignment delete link.
			 *
			 * @since 3.0.0
			 *
			 * @param WP_Post $assignment WP_Post object for assignment.
			 * @param int     $post_id    Post ID.
			 * @param int     $course_id  Course ID.
			 * @param int     $user_id    User ID.
			 */
			do_action( 'learndash-assignment-row-delete-before', $assignment, get_the_ID(), $course_id, $user_id );

			/**
			 * Delete assignment link
			 *
			 */
			if ( ! learndash_is_assignment_approved_by_meta( $assignment->ID ) ) :
				if ( ( isset( $post_settings['lesson_assignment_deletion_enabled'] ) && 'on' === $post_settings['lesson_assignment_deletion_enabled'] && absint( $assignment->post_author ) === absint( $user_id ) ) || ( learndash_is_admin_user( $user_id ) ) || ( learndash_is_group_leader_of_user( $user_id, $post->post_author ) ) ) :
					?>
				<a href="<?php echo esc_url( add_query_arg( 'learndash_delete_attachment', $assignment->ID ) ); ?>" class="close_file" title="<?php esc_html_e( 'Delete this uploaded Assignment', 'learndash' ); ?>">
					<!-- <span class="ld-icon ld-icon-delete" aria-label="<?php esc_html_e( 'Delete Assignment', 'learndash' ); ?>"></span> -->
					<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 32" class="svg_file"><rect x="32" y="4" width="2" height="32" rx="1" transform="rotate(90 32 4)"></rect><rect x="6" y="32" width="2" height="27" rx="1" transform="rotate(-180 6 32)"></rect><rect x="28" y="32" width="2" height="27" rx="1" transform="rotate(-180 28 32)"></rect><rect x="5" y="32" width="2" height="23" rx="1" transform="rotate(-90 5 32)"></rect><rect x="9" y="2" width="2" height="14" rx="1" transform="rotate(-90 9 2)"></rect><rect x="9" width="2" height="5" rx="1"></rect><rect x="21" width="2" height="5" rx="1"></rect><rect x="21" y="11" width="2" height="15" rx="1"></rect><rect x="9" y="11" width="2" height="15" rx="1"></rect><rect x="15" y="9" width="2" height="18" rx="1"></rect></svg>
				</a>
					<?php
				endif;
			endif;

			/**
			 * Fires before the assignment title and link.
			 *
			 * @since 3.0.0
			 *
			 * @param WP_Post $assignment WP_Post object for assignment.
			 * @param int     $post_id    Post ID.
			 * @param int     $course_id  Course ID.
			 * @param int     $user_id    User ID.
			 */
			do_action( 'learndash-assignment-row-title-before', $assignment, get_the_ID(), $course_id, $user_id );
			?>

			<a href='<?php echo esc_url( get_post_meta( $assignment->ID, 'file_link', true ) ); ?>' class="close_file" style="margin-left: 4px; margin-right: 4px;" target="_blank">
				<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" class="svg_file" title="Vista previa"><path d="M256,96C144.341,96,47.559,161.021,0,256c47.559,94.979,144.341,160,256,160c111.656,0,208.439-65.021,256-160C464.441,161.021,367.656,96,256,96z M382.225,180.852c30.082,19.187,55.572,44.887,74.719,75.148c-19.146,30.261-44.639,55.961-74.719,75.148C344.428,355.257,300.779,368,256,368c-44.78,0-88.428-12.743-126.225-36.852c-30.08-19.188-55.57-44.888-74.717-75.148c19.146-30.262,44.637-55.962,74.717-75.148c1.959-1.25,3.938-2.461,5.929-3.65C130.725,190.866,128,205.613,128,221c0,70.691,57.308,128,128,128c70.691,0,128-57.309,128-128c0-15.387-2.725-30.134-7.703-43.799C378.285,178.39,380.266,179.602,382.225,180.852z M256,205c0,26.51-21.49,48-48,48s-48-21.49-48-48s21.49-48,48-48S256,178.49,256,205z"></path></svg>
				<!-- <span class="ld-item-icon">
					<span class="ld-icon ld-icon-download" aria-label="<?php esc_html_e( 'Download Assignment', 'learndash' ); ?>"></span>
				</span> -->
			</a>

			<?php
			$assignment_link = ( true === (bool) $assignment_post_type_object->publicly_queryable ? get_permalink( $assignment->ID ) : get_post_meta( $assignment->ID, 'file_link', true ) );
			?>

			<a href="<?php echo esc_url( $assignment_link ); ?>">1. Archivo Subido <?php //echo esc_html( get_the_title( $assignment->ID ) ); ?></a>

			<?php
			/**
			 * Fires after the assignment title and link.
			 *
			 * @since 3.0.0
			 *
			 * @param WP_Post $assignment WP_Post object for assignment.
			 * @param int     $post_id    Post ID.
			 * @param int     $course_id  Course ID.
			 * @param int     $user_id    User ID.
			 */
			do_action( 'learndash-assignment-row-title-after', $assignment, get_the_ID(), $course_id, $user_id );
			?>

		</div> <!--/.ld-table-list-title-->

		<div class="ld-table-list-columns">

			<?php
			// Use an array so it can be filtered later
			$row_columns = array();

			/**
			 * Fires before the assignment post link.
			 *
			 * @since 3.0.0
			 *
			 * @param WP_Post $assignment WP_Post object for assignment.
			 * @param int     $post_id    Post ID.
			 * @param int     $course_id  Course ID.
			 * @param int     $user_id    User ID.
			 */
			do_action( 'learndash-assignment-row-columns-before', $assignment, get_the_ID(), $course_id, $user_id );

			ob_start();
			?>

			<?php
			/**
			 * Fires before assignment comment count & link.
			 *
			 * @since 3.0.0
			 *
			 * @param WP_Post $assignment WP_Post object for assignment.
			 * @param int     $post_id    Post ID.
			 * @param int     $course_id  Course ID.
			 * @param int     $user_id    User ID.
			 */
			do_action( 'learndash-assignment-row-comments-before', $assignment, get_the_ID(), $course_id, $user_id );

			/** This filter is documented in https://developer.wordpress.org/reference/hooks/comments_open/ */


			if ( post_type_supports( 'sfwd-assignment', 'comments' ) && apply_filters( 'comments_open', $assignment->comment_status, $assignment->ID ) ) { // phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedHooknameFound -- WP Core filter
				?>| 
				<a href='<?php echo esc_url( get_comments_link( $assignment->ID ) ); ?>' data-ld-tooltip="
					<?php
					echo sprintf(
						// translators: placeholder: comment count.
						esc_html_x( '%d Comments', 'placeholder: comment count', 'learndash' ),
						esc_html( get_comments_number( $assignment->ID ) ) // get_comments_number returns a number. Adding escaping just in case somebody changes the template.
					);
					?>
				"><?php echo esc_html( get_comments_number( $assignment->ID ) ); ?>
					<span class="ld-icon ld-icon-comments">
						<img src="https://proyemi.com/wp-content/uploads/2020/12/comments.png" alt="">
					</span>
				</a>
				<?php
			} else {
				echo '';
			};

			// Add the markup to the array
			$row_columns['comments'] = ob_get_clean();
			ob_flush();

			/**
			 * Fires after the assignment comment count & link.
			 *
			 * @since 3.0.0
			 *
			 * @param WP_Post $assignment WP_Post object for assignment.
			 * @param int     $post_id    Post ID.
			 * @param int     $course_id  Course ID.
			 * @param int     $user_id    User ID.
			 */
			do_action( 'learndash-assignment-row-comments-after', $assignment, get_the_ID(), $course_id, $user_id );

			if ( ! learndash_is_assignment_approved_by_meta( $assignment->ID ) && ! $assignment_points ) :
				ob_start();
				?>

				<span class="ld-status ld-status-waiting ld-tertiary-background">
					<span class="ld-icon ld-icon-calendar"></span>
					<span class="ld-text"><?php esc_html_e( 'Revisión', 'learndash' ); ?></span>
				</span> <!--/.ld-status-waiting-->

				<?php
				$row_columns['status'] = ob_get_clean();
				ob_flush();

			elseif ( $assignment_points || learndash_is_assignment_approved_by_meta( $assignment->ID ) ) :

				ob_start();
				?>
				<!-- aprobado -->
				<span class="ld-status ld-status-complete">
					<span class="ld-icon ld-icon-checkmark"></span>
					<?php
					if ( $assignment_points ) :
						echo sprintf(
							// translators: placeholders: points current, points max.
							esc_html_x( '%1$s/%2$s Points Awarded ', 'placeholders: points current, points max', 'learndash' ),
							esc_html( $assignment_points['current'] ),
							esc_html( $assignment_points['max'] )
						) . ' - ';
					endif;

					esc_html_e( 'Approved', 'learndash' );
					?>
				</span>

				<?php
				$row_columns['status'] = ob_get_clean();
				ob_flush();

			endif;

			/**
			 * Filters assignment list columns content.
			 *
			 * @param array $row_columns Array of assignment row columns content
			 */
			$row_columns = apply_filters( 'learndash-assignment-list-columns-content', $row_columns );
			if ( ! empty( $row_columns ) ) :
				foreach ( $row_columns as $slug => $content ) :

					/**
					 * Fires before an assignment row.
					 *
					 * The dynamic part of the hook `$slug` refers to the slug of the column.
					 *
					 * @param WP_Post $assignment WP_Post object for assignment.
					 * @param int     $post_id    Post ID.
					 * @param int     $course_id  Course ID.
					 * @param int     $user_id    User ID.
					 */
					do_action( 'learndash-assignment-row-' . $slug . '-before', $assignment, get_the_ID(), $course_id, $user_id );
					?>
				<div class="<?php echo esc_attr( 'ld-table-list-column ld-' . $slug . '-column' ); ?>">
					<?php
					/**
					 * Fires before an assignment row content.
					 *
					 * The dynamic part of the hook `$slug` refers to the slug of the column.
					 *
					 * @param WP_Post $assignment WP_Post object for assignment.
					 * @param int     $post_id    Post ID.
					 * @param int     $course_id  Course ID.
					 * @param int     $user_id    User ID.
					 */
					do_action( 'learndash-assignment-row-' . $slug . '-inside-before', $assignment, get_the_ID(), $course_id, $user_id );

					echo wp_kses_post( $content );

					/**
					 * Fires after an assignment row content.
					 *
					 * The dynamic part of the hook `$slug` refers to the slug of the column.
					 *
					 * @param WP_Post $assignment WP_Post object for assignment.
					 * @param int     $post_id    Post ID.
					 * @param int     $course_id  Course ID.
					 * @param int     $user_id    User ID.
					 */
					do_action( 'learndash-assignment-row-' . $slug . '-inside-after', $assignment, get_the_ID(), $course_id, $user_id );
					?>
				</div>
					<?php

					/**
					 * Fires after an assignment row.
					 *
					 * The dynamic part of the hook `$slug` refers to the slug of the column.
					 *
					 * @param WP_Post $assignment WP_Post object for assignment.
					 * @param int     $post_id    Post ID.
					 * @param int     $course_id  Course ID.
					 * @param int     $user_id    User ID.
					 */
					do_action( 'learndash-assignment-row-' . $slug . '-after', $assignment, get_the_ID(), $course_id, $user_id );
					?>
					<?php
				endforeach;
			endif;
			?>

		</div> <!--/.ld-table-list-columns-->

	<?php
	/**
	 * Fires after all the assignment row content.
	 *
	 * @since 3.0.0
	 *
	 * @param WP_Post $assignment WP_Post object for assignment.
	 * @param int     $post_id    Post ID.
	 * @param int     $course_id  Course ID.
	 * @param int     $user_id    User ID.
	 */
	do_action( 'learndash-assignment-row-after', $assignment, get_the_ID(), $course_id, $user_id );
	?>
	</div>
</div>
