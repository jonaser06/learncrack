<?php
/**
 * lesson/topic assignment upload form.
 *
 * If the lesson/topic is set to be an assignment there will be an upload form displayed to the user.
 *
 * Available Variables:
 *
 * $course_step_post: WP_Post object for the Lesson/Topic being shown
 * $user_id: Current user ID
 * $assignment_upload_error_message: string of previous upload error. Will be empty if no previous upload attempt
 *
 * @since 3.0
 *
 * @package LearnDash\Lesson
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Identify the max upload file size. Compares the server enviornment limit to what's configured through LD
 * @var $php_max_upload (int)
 */

$php_max_upload = ini_get( 'upload_max_filesize' );

if ( isset( $post_settings['assignment_upload_limit_size'] ) && ! empty( $post_settings['assignment_upload_limit_size'] ) ) {
	if ( learndash_return_bytes_from_shorthand( $post_settings['assignment_upload_limit_size'] ) < learndash_return_bytes_from_shorthand( $php_max_upload ) ) {
		$php_max_upload = $post_settings['assignment_upload_limit_size'];
	}
}

/**
 * Set the upload message based on upload size limit and limit of approved file extensions
 *
 * @var $upload_message (string)
 */

$upload_message = sprintf(
	// translators: placeholder: PHP file upload size.
	esc_html_x( 'Tamaño máximo : %s', 'placeholder: PHP file upload size', 'learndash' ),
	$php_max_upload
);

if ( isset( $post_settings['assignment_upload_limit_extensions'] ) && ! empty( $post_settings['assignment_upload_limit_extensions'] ) ) {
	$limit_file_exts = learndash_validate_extensions( $post_settings['assignment_upload_limit_extensions'] );
	if ( ! empty( $limit_file_exts ) ) {
		$upload_message .= ' ' . sprintf(
			// translators: placeholder: Comma separated list of file extentions
			esc_html_x( 'Archivos permitidos: %s', 'placeholder: Comma separated list of file extentions', 'learndash' ),
			implode( ', ', $limit_file_exts )
		);
	}
}

/**
 * Check to see if the user has uploaded the maximium number of assignments
 *
 * @var null
 */


if ( isset( $post_settings['assignment_upload_limit_count'] ) ) {
	$assignment_upload_limit_count = intval( $post_settings['assignment_upload_limit_count'] );
	if ( $assignment_upload_limit_count > 0 ) {
		$assignments = learndash_get_user_assignments( get_the_ID(), $user_id );

		if ( ! empty( $assignments ) && count( $assignments ) >= $assignment_upload_limit_count ) {
			return;
		}
	}
}

/**
 * Fires before the assignment uploads.
 *
 * @param int $course_step_post_id Post ID for the Lesson/Topic being shown.
 * @param int $course_id           Course ID.
 * @param int $user_id             User ID.
 */
do_action( 'learndash-assignment-uploads-before', get_the_ID(), $course_id, $user_id ); ?>

<div class="ld-file-upload">

	<div class="ld-file-upload-heading">
		<h5 class="title_assigment">Subida de tarea</h5>
		<?php
		/**
		 * Fires before the assignment upload heading.
		 *
		 * @param int $course_step_post_id Post ID for the Lesson/Topic being shown.
		 * @param int $course_id           Course ID.
		 * @param int $user_id             User ID.
		 */
		do_action( 'learndash-assignment-uploads-heading-before', get_the_ID(), $course_id, $user_id );

		// esc_html_e( 'Upload Assignment', 'learndash' );
		?>
		<span><?php echo esc_html( '(' . $upload_message . ')' ); ?></span>

		<?php

		/**
		 * Fires after the assignment uploads.
		 *
		 * @param int $course_step_post_id Post ID for the Lesson/Topic being shown.
		 * @param int $course_id           Course ID.
		 * @param int $user_id             User ID.
		 */
		do_action( 'learndash-assignment-uploads-heading-after', get_the_ID(), $course_id, $user_id );
		?>
	</div>

	<form name="uploadfile" id="uploadfile_form" class="ld-file-upload-form" method="POST" enctype="multipart/form-data" action="" accept-charset="utf-8" >

		<input type="file" class="ld-file-input" name="uploadfiles[]" id="uploadfiles">

		<div class="submit_group">
			<label for="uploadfiles" class="zone-upload">
				<strong><?php echo esc_html_e( 'Buscar', 'learndash' ); ?></strong>
				<span class="span_file"><?php echo esc_html_e( ': Ningún archivo', 'learndash' ); ?></span>
			</label>
	
			<?php
			/**
			 * Fires inside the assignment upload form.
			 *
			 * @param int $course_step_post_id Post ID for the Lesson/Topic being shown.
			 * @param int $course_id           Course ID.
			 * @param int $user_id             User ID.
			 */
			do_action( 'learndash-assignment-uploads-form', get_the_ID(), $course_id, $user_id ); 
			?>
	
			<input class="ld-button" type="submit" value="<?php esc_html_e( 'Upload', 'learndash' ); ?>" name="submit" id="uploadfile_btn">
		</div>


		<input type="hidden" name="MAX_FILE_SIZE" value="'. learndash_return_bytes_from_shorthand( $php_max_upload ) .'" />
		<input type="hidden" value="<?php echo esc_attr( get_the_ID() ); ?>" name="post"/>
		<input type="hidden" value="<?php echo esc_attr( learndash_get_course_id( get_the_ID() ) ); ?>" name="course_id"/>
		<input type="hidden" name="uploadfile" value="<?php echo esc_attr( wp_create_nonce( 'uploadfile_' . get_current_user_id() . '_' . get_the_ID() ) ); ?>"  />

	</form>

	<div class="ld-file-upload-message">
		<?php
		/**
		 * Fires inside assignment upload message wrapper.
		 *
		 * @param int $course_step_post_id Post ID for the Lesson/Topic being shown.
		 * @param int $course_id           Course ID.
		 * @param int $user_id             User ID.
		 */
		do_action( 'learndash-assignment-uploads-message', get_the_ID(), $course_id, $user_id );
		?>
	</div>

	<?php
	/**
	 * Fires after the assignments upload message.
	 *
	 * @since 3.0.0
	 *
	 * @param int $course_step_post_id Post ID for the Lesson/Topic being shown.
	 * @param int $course_id           Course ID.
	 * @param int $user_id             User ID.
	 */
	do_action( 'learndash-assignment-uploads-message-after', get_the_ID(), $course_id, $user_id );
	?>

</div> <!--/.ld-file-upload-->
