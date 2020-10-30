<?php
/* 
* duracion tag [ videopro id="5"]
**/

add_shortcode('videopro', 'videopro');

function videopro($atts = array()) { return $atts['id']; }

preg_match('/\[.*\]/',get_post_field('post_content', $post->ID, 'edit'), $match );

$match = explode(',',$match[0]);

$videopro = $match[0];


function get_comentarios($atts){
	$args = array('post_id' => get_the_ID());
    $comments = get_comments( $args );
	$comentario = '<div class="comentarios_total">';
 	foreach ( $comments as $comment ) :
        $comentario .= '<div class="comentario">
                            <div class="autor_avatar">
                                <img src="'.esc_url( get_avatar_url($comment->user_id) ).'" alt="">
                            </div>
                            <div class="autor_coment">
                                <div class="autor_meta">
                                    <div class="commentario_autor">'.$comment->comment_author. '</div>
                                    <div class="date_autor">'.$comment->comment_date. '</div>
                                </div>
                                <div class="comentario_contenido">' . $comment->comment_content.'</div>
                            </div>
                        </div>';
	endforeach;
	$comentario .= '</div>';
	
	return $comentario;
}

/* seccion del curso */
function learndash_30_get_course_sections( $course_id = null ) {

    if ( empty( $course_id ) ) {
        $course_id = get_the_ID();
    }

    if ( get_post_type( $course_id ) != 'sfwd-courses' ) {
        $course_id = learndash_get_course_id( $course_id );
    }

    $sections       = array();
    $sections_index = array();

    $sections_raw = get_post_meta( $course_id, 'course_sections', true );

    if ( ! $sections_raw || empty( $sections_raw ) ) {
        return false;
    }

    /**
     * Because sections only store total order, but lessons might be paginated -- we need to pass them in relative to their parent. Not great for performance.
     *
     * @var [type]
     */

    $sections_raw = json_decode( $sections_raw );

    if ( ! is_array( $sections_raw ) ) {
        return false;
    }

    $lessons = learndash_get_course_lessons_list( $course_id, null, array( 'num' => -1 ) );

    if ( ! $lessons || empty( $lessons ) || ! is_array( $lessons ) ) {
        return false;
    }

    $lessons = array_values( $lessons );
    $i       = 0;

    foreach ( $lessons as $lesson ) {
        foreach ( $sections_raw as $section ) {
            if ( $section->order == $i ) {
                $sections[ $lesson['post']->ID ] = $section;
                $i++;
            }
        }
        $i++;
    }

    return $sections;

}


add_shortcode('comments_wp','get_comentarios');

?>
<link href="https://vjs.zencdn.net/7.8.4/video-js.css" rel="stylesheet" />
<link rel="stylesheet" href="<?php echo plugins_url( 'themes/proyemi/assets/css/lesson-course.css', LEARNDASH_LMS_PLUGIN_DIR . 'index.php' ); ?>">
<div class="course-container">
    <div class="content-course-leeson">
        <div class="tabs">
            <div class="tab-header">
                <div class="tab1 active">Modulos</div>
                <div class="tab2">Contenido</div>
                <div class="tab3">Comentarios</div>
            </div>
            <div class="tab-content">
                <div class="pad1 active">
                    <?php  $lessons = learndash_get_course_lessons_list( $course_id ); ?>

                    <?php $sections = learndash_30_get_course_sections( $course_id ); ?>
                    <?php foreach($lessons as $lesson) : ?>

                        <?php if ( isset( $sections[ $lesson['post']->ID ] ) ): ?>
                        <div class="heading">
                            <span>
                                <svg width="15" height="15" viewBox="0 0 15 15" fill="none" xmlns="http://www.w3.org/2000/svg"><g opacity="0.5"><path d="M1 5L7.5 12L14 5" stroke="#333333" stroke-linecap="square"/></g></svg>
                            </span>
                            <?php echo $sections[$lesson['post']->ID]->post_title; ?>
                        </div>
                        <?php endif; ?>

                        <p><a href="<?php echo $lesson['permalink']; ?>"><?php echo $lesson['post']->post_title; ?></a></p>
                    <?php endforeach; ?>
                </div>
                <div class="pad2">
                    <?php echo preg_replace('/\[.*\]/','',get_post_field('post_content', $post->ID, 'edit')); ?>
                </div>
                <div class="pad3">
                    <?php echo do_shortcode( '[comments_wp]' ); ?>
                    <form action="https://proyemi.com/wp-comments-post.php" method="post" id="commentform" class="comment-form" novalidate="">
                        <div class="comment-textarea">
                            <label for="comment" class="screen-reader-text">Comentario</label>
                            <textarea name="comment" id="comment" cols="39" rows="4" tabindex="0" class="textarea-comment" placeholder="Tu comentario aquí..."></textarea>
                        </div>
                        <p class="form-submit">
                            <input name="submit" type="submit" id="comment-submit" class="submit" value="Enviar">
                            <input type="hidden" name="comment_post_ID" value="<?php echo $post->ID; ?>" id="comment_post_ID">
                            <input type="hidden" name="comment_parent" id="comment_parent" value="0">
                        </p>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="content-course-player">
        <div class="video-content-play">
            <video
                id="my-video"
                class="video-js vjs-big-play-centered"
                controls
                preload="auto"
            >
                <source src="<?php echo do_shortcode($videopro); ?>" type='video/mp4'>
                <p class="vjs-no-js">
                    To view this video please enable JavaScript, and consider upgrading to a
                    web browser that
                    <a href="https://videojs.com/html5-video-support/" target="_blank">supports HTML5 video</a>
                </p>
            </video>
        </div>
        <form id="sfwd-mark-complete" class="sfwd-mark-complete" method="post" action="">
            <input type="hidden" value="<?php echo $post->ID; ?>" name="post">
            <input type="hidden" value="<?php echo $course_id; ?>" name="course_id">
            <input type="hidden" value="<?php echo wp_create_nonce( 'sfwd_mark_complete_' . get_current_user_id() . '_' . $post->ID ); ?>" name="sfwd_mark_complete">
            <input type="submit" id="learndash_mark_complete_button" value="Siguiente" class="learndash_mark_complete_button">
        </form>
    </div>
</div>
<script src="https://vjs.zencdn.net/7.8.4/video.js"></script>
<script src="<?php echo plugins_url( 'themes/proyemi/assets/js/main.js', LEARNDASH_LMS_PLUGIN_DIR . 'index.php' ); ?>"></script>
<?php 
global $post;
// $thumbID = get_post_thumbnail_id( $post->ID );
// $imgDestacada = wp_get_attachment_url( $thumbID );
// echo $imgDestacada;
// get_post_field('post_content', $post->ID, 'edit');

/* echo preg_replace('/\[.*\]/','',get_post_field('post_content', $post->ID, 'edit'));

preg_match('/\[.*\]/',get_post_field('post_content', $post->ID, 'edit'), $matches );

add_shortcode('proy_course', 'testf');

function testf($atts = array()){
    return "hola shorcode {$atts['duration']}";
}

echo do_shortcode($matches[0]); */

?>