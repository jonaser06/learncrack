<!-- holamundo -->
<?php
/**
 * Displays a user's profile.
 * 
 * Available Variables:
 * 
 * $user_id 		: Current User ID
 * $current_user 	: (object) Currently logged in user object
 * $user_courses 	: Array of course ID's of the current user
 * $quiz_attempts 	: Array of quiz attempts of the current user
 * $shortcode_atts 	: Array of values passed to shortcode
 * 
 * @since 2.1.0
 * 
 * @package LearnDash\User
 */
?>
<?php
	global $learndash_assets_loaded;
	if ( !isset( $learndash_assets_loaded['scripts']['learndash_template_script_js'] ) ) {
		$filepath = SFWD_LMS::get_template( 'learndash_template_script.js', null, null, true );
		if ( !empty( $filepath ) ) {
			wp_enqueue_script( 'learndash_template_script_js', learndash_template_url_from_path( $filepath ), array( 'jquery' ), LEARNDASH_SCRIPT_VERSION_TOKEN, true );
			$learndash_assets_loaded['scripts']['learndash_template_script_js'] = __FUNCTION__;

			$data = array();
			$data['ajaxurl'] = admin_url('admin-ajax.php');
			$data = array( 'json' => json_encode( $data ) );
			wp_localize_script( 'learndash_template_script_js', 'sfwd_data', $data );
		}
	}
	LD_QuizPro::showModalWindow();

	$url = $_SERVER["REQUEST_URI"];
	$url = explode('/', $url);
	$url = $url[count($url) - 2];
?>
<div class="squeart-container" style="margin-bottom: 10px;">
	<div class="squart-option <?php if($url=='my-account'): ?>active<?php endif; ?>">
		<a href="<?php echo get_site_url(null, '/my-account/'); ?>">
			<span><svg style="transform: scale(0.7);" width="42" height="42" viewBox="0 0 42 42" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M-3.67176e-07 32.2001L14 32.2001M-1.34631e-06 9.8001C2.73367 9.8001 7 9.8001 7 9.8001L14 9.8001M-1.34631e-06 21.0001L7 21.0001M7 21.0001L7 37.8001C7 39.3465 8.2536 40.6001 9.8 40.6001L37.8 40.6001C39.3464 40.6001 40.6 39.3465 40.6 37.8001L40.6 4.2001C40.6 2.6537 39.3464 1.4001 37.8 1.4001L9.8 1.4001C8.2536 1.4001 7 2.65371 7 4.2001L7 21.0001ZM7 21.0001L14 21.0001" stroke="#FEFEFE" stroke-width="2"/></svg></span>
		</a>
		<div class="title-opcion">
			Mis Cursos
		</div>
	</div>
	<div class="squart-option <?php if($url=='orders'): ?>active<?php endif; ?>" style="padding-top: 15px;">
		<a href="<?php echo get_site_url(null, '/my-account/orders/'); ?>">
			<span><svg style="transform: scale(0.7);" width="44" height="35" viewBox="0 0 44 35" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M1 0C0.447715 0 0 0.447715 0 1C0 1.55228 0.447715 2 1 2V0ZM42.1244 10.2424L42.9885 10.7457L42.1244 10.2424ZM33.7438 24.631L34.608 25.1343L33.7438 24.631ZM18.7335 24.4115L17.7746 24.6953L18.7335 24.4115ZM10.0678 1.51325L9.19427 2L10.0678 1.51325ZM19.6923 26.1277H32.8797V24.1277H19.6923V26.1277ZM34.608 25.1343L42.9885 10.7457L41.2603 9.73906L32.8797 24.1277L34.608 25.1343ZM9.19427 2L13.2206 9.22581L14.9677 8.25231L10.9414 1.0265L9.19427 2ZM13.1352 9.0229L17.7746 24.6953L19.6923 24.1277L15.053 8.45522L13.1352 9.0229ZM41.2603 7.73906H14.0941V9.73906H41.2603V7.73906ZM9.19427 0H1V2H9.19427V0ZM42.9885 10.7457C43.7651 9.41234 42.8033 7.73906 41.2603 7.73906V9.73906L41.2603 9.73906L42.9885 10.7457ZM32.8797 26.1277C33.5915 26.1277 34.2497 25.7493 34.608 25.1343L32.8797 24.1277L32.8797 24.1277V26.1277ZM19.6923 24.1277L19.6923 24.1277L17.7746 24.6953C18.0261 25.5448 18.8064 26.1277 19.6923 26.1277V24.1277ZM10.9414 1.0265C10.5882 0.392811 9.91969 0 9.19427 0V2L9.19427 2L10.9414 1.0265Z" fill="#FEFEFE"/><ellipse cx="33.1711" cy="31.383" rx="2.68085" ry="2.68085" fill="#FEFEFE"/><ellipse cx="18.8723" cy="31.383" rx="2.68085" ry="2.68085" fill="#FEFEFE"/></svg></span>
		</a>
		<div class="title-opcion">
			Pedidos
		</div>
	</div>
	<div class="squart-option <?php if($url=='downloads'): ?>active<?php endif; ?>" style="padding-top: 5px;">
		<a href="<?php echo get_site_url(null, '/my-account/downloads/'); ?>">
			<span><svg style="transform: scale(0.7);" width="45" height="45" viewBox="0 0 45 45" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M22.5 31.5L12.75 22.5M22.5 31.5L31.5 22.5M22.5 31.5V3M40.5 21V40.5H4.5V21" stroke="white" stroke-width="1.8"/></svg></span>
		</a>
		<div class="title-opcion">
			Descargas
		</div>
	</div>
	<div class="squart-option <?php if($url=='edit-account'): ?>active<?php endif; ?>">
		<a href="<?php echo get_site_url(null, '/my-account/edit-account/'); ?>">
			<span><svg style="transform: scale(0.7);" width="33" height="42" viewBox="0 0 33 42" fill="none" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" clip-rule="evenodd" d="M25.7547 10.4748C25.7547 15.708 21.599 19.9495 16.4717 19.9495C11.3444 19.9495 7.18868 15.708 7.18868 10.4748C7.18868 5.24153 11.3444 1 16.4717 1C21.599 1 25.7547 5.24153 25.7547 10.4748Z" stroke="white" stroke-width="1.8" stroke-linecap="square"/><path fill-rule="evenodd" clip-rule="evenodd" d="M31.9434 41H1C1 38.756 1 36.6213 1 34.6881C1 29.4519 5.15615 25.2087 10.283 25.2087H22.6604C27.7872 25.2087 31.9434 29.4519 31.9434 34.6881C31.9434 36.6213 31.9434 38.756 31.9434 41Z" stroke="white" stroke-width="1.8" stroke-linecap="square"/></svg></span>
		</a>
		<div class="title-opcion">
			Mi Cuenta
		</div>
	</div>
	<div class="squart-option <?php if($url=='customer-logout'): ?>active<?php endif; ?>" style="padding-top: 5px;">
		<a href="<?php echo get_site_url(null, '/my-account/customer-logout/'); ?>">
			<span><svg style="transform: scale(0.7);" width="45" height="45" viewBox="0 0 45 45" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M27.178 0.49168C32.5936 1.64281 37.3947 4.75029 40.6626 9.21958C43.9305 13.6889 45.4359 19.2062 44.8906 24.7159C44.3454 30.2255 41.7878 35.3407 37.7072 39.0828C33.6267 42.8249 28.3097 44.931 22.7735 44.9983C17.2373 45.0656 11.8707 43.0893 7.70035 39.4476C3.53004 35.8058 0.848885 30.7543 0.169857 25.2595C-0.509171 19.7647 0.861609 14.2124 4.01993 9.66501C7.17825 5.1176 11.9023 1.89433 17.2884 0.611899L17.766 2.61788C12.8736 3.78278 8.58244 6.71065 5.71357 10.8413C2.84471 14.972 1.59955 20.0154 2.21635 25.0066C2.83315 29.9978 5.26858 34.5864 9.0567 37.8944C12.8448 41.2024 17.7196 42.9976 22.7484 42.9364C27.7772 42.8753 32.607 40.9622 36.3135 37.563C40.0201 34.1639 42.3433 29.5175 42.8386 24.5128C43.3339 19.508 41.9665 14.4964 38.9981 10.4367C36.0296 6.377 31.6686 3.55431 26.7493 2.50868L27.178 0.49168Z" fill="white"/><line x1="22" x2="22" y2="28" stroke="white" stroke-width="2"/></svg></span>
		</a>
		<div class="title-opcion">
			Salir
		</div>
	</div>
</div>
<div id="learndash_profile" style="overflow: hidden; box-shadow: none; padding-bottom: 5px;">

    <div class="expand_collapse">
        <a href="#" onClick='return flip_expand_all("#course_list");'><?php esc_html_e( 'Expand All', 'learndash' ); ?></a> | <a href="#" onClick='return flip_collapse_all("#course_list");'><?php esc_html_e( 'Collapse All', 'learndash' ); ?></a>
    </div>

	<?php if ( ( isset( $shortcode_atts['show_header'] ) ) && ( 'yes' === $shortcode_atts['show_header'] ) ) { ?>

	<div class="learndash_profile_heading">
		<span><?php esc_html_e( 'Profile', 'learndash' ); ?></span>
	</div>

	<div class="profile_info clear_both">
		<div class="profile_avatar">
			<?php echo get_avatar( $current_user->user_email, 96 ); ?>
			<?php
			/** This filter is documented in themes/ld30/templates/shortcodes/profile.php */
			if ( ( current_user_can( 'read' ) ) && ( isset( $shortcode_atts['profile_link'] ) ) && ( true === $shortcode_atts['profile_link'] ) && ( apply_filters( 'learndash_show_profile_link', $shortcode_atts['profile_link'] ) ) ) {
				?>
				<div class="profile_edit_profile" align="center">
					<a href='<?php echo esc_url( get_edit_user_link() ); ?>'><?php esc_html_e( 'Edit profile', 'learndash' ); ?></a>
				</div>
				<?php
			}
			?>
		</div>

		<div class="learndash_profile_details">
			<?php if ( ( ! empty( $current_user->user_lastname) ) || ( ! empty( $current_user->user_firstname ) ) ): ?>
				<div><b><?php esc_html_e( 'Name', 'learndash' ); ?>:</b> <?php echo $current_user->user_firstname . ' ' . $current_user->user_lastname; ?></div>
			<?php endif; ?>
			<div><b><?php esc_html_e( 'Username', 'learndash' ); ?>:</b> <?php echo $current_user->user_login; ?></div>
			<div><b><?php esc_html_e( 'Email', 'learndash' ); ?>:</b> <?php echo $current_user->user_email; ?></div>
			
			<?php if ( ( isset( $shortcode_atts['course_points_user'] ) ) && ( $shortcode_atts['course_points_user'] == 'yes' ) ) { ?>
				<?php echo do_shortcode('[ld_user_course_points user_id="'. $current_user->ID .'" context="ld_profile"]'); ?>
			<?php } ?>
			<a href="<?php echo get_site_url(null, '/my-account/'); ?>" class="my_courses">Mis Cursos</a>
			<a href="<?php echo get_site_url(null, '/my-account/orders/'); ?>" class="my_pedidos">Mis Pedidos</a>
			<a href="<?php echo get_site_url(null, '/my-account/downloads/'); ?>" class="my_orders">Mis Descargas</a>
			<a href="<?php echo get_site_url(null, '/my-account/edit-account/'); ?>" class="my_account">Mi Cuenta</a>
			<a href="<?php echo get_site_url(null, '/my-account/customer-logout/'); ?>" class="logout">Salir</a>
		</div>
	</div>

	<?php } ?>

	<div class="learndash_profile_heading no_radius clear_both">
		<span class="ld_profile_course"><?php
		// translators: placeholder: Courses.
		// printf( esc_html_x( 'Registered %s', 'placeholder: Courses', 'learndash' ), LearnDash_Custom_Label::get_label( 'courses' ) ); 
		?>Cursos Matriculados</span>
		<span class="ld_profile_status"><?php esc_html_e( 'Status', 'learndash' ); ?></span>
		<span class="ld_profile_certificate"><?php esc_html_e( 'Certificate', 'learndash' ); ?></span>
	</div>

	<div id="course_list">
		<?php 
			if($url == 'orders' || $url == 'downloads' || $url == 'edit-address' || $url == 'edit-account' | $url == 'customer-logout' ):
				echo do_shortcode('[woocommerce_my_account]');
			else:
		?>
			<!-- cursos -->
			<?php if ( ! empty( $user_courses ) ) : ?>

				<?php foreach ( $user_courses as $course_id ) : ?>

				<?php
					$course = get_post( $course_id);

					$course_link = get_permalink( $course_id );

					$progress = learndash_course_progress( array(
						'user_id'   => $user_id,
						'course_id' => $course_id,
						'array'     => true
					) );

					$status = ( $progress['percentage'] == 100 ) ? 'completed' : 'notcompleted';

					$thumbID = get_post_thumbnail_id( $course->ID );
					$img = (wp_get_attachment_url( $thumbID ))?wp_get_attachment_url( $thumbID ):'null';
					
				?>

				<div class="list-course_">
					<div class="list-course-cover">
						<img src="<?php echo $img; ?>" alt="">
					</div>
					<div class="list-course-content">
						<div class="list-course-title">
							<a href="<?php echo esc_url( $course_link ); ?>"><h5><?php echo $course->post_title; ?></h5></a>
						</div>
						<div class="list-course-progress">
							<div class="percent-coourse" style="width:<?php echo $progress['percentage']; ?>% !important;"></div>
						</div>
						<div class="list-course-status">
							<?php echo $progress['percentage']; ?>%
						</div>
					</div>
				</div>

				<?php endforeach; ?>

			<?php endif; ?>
		
		<?php endif; ?>
	</div>
</div>
<?php
echo SFWD_LMS::get_template( 
	'learndash_pager.php', 
	array(
	'pager_results' => $profile_pager, 
	'pager_context' => 'profile'
	) 
);
?>
<?php
/** This filter is documented in themes/ld30/templates/course.php */
if ( apply_filters('learndash_course_steps_expand_all', $shortcode_atts['expand_all'], 0, 'profile_shortcode' ) ) { ?>
	<script>
		jQuery(document).ready(function() {
			setTimeout(function(){
				jQuery("#learndash_profile .list_arrow").trigger('click');
			}, 1000);
		});
	</script>	
<?php }
