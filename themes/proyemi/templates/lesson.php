<?php

function get_comentarios($atts){
	//$args = array('post_id' => $atts['id']);
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
                    <?php foreach($lessons as $lesson) : ?>
                        <p><a href="<?php echo $lesson['permalink']; ?>"><?php echo $lesson['post']->post_title; ?></a></p>
                    <?php endforeach; ?>
                    <form id="sfwd-mark-complete" class="sfwd-mark-complete" method="post" action="">
                        <input type="hidden" value="<?php echo $post->ID; ?>" name="post">
                        <input type="hidden" value="<?php echo $course_id; ?>" name="course_id">
                        <input type="hidden" value="e1c192a96c" name="sfwd_mark_complete">
                        <input type="submit" id="learndash_mark_complete_button" value="Completar" class="learndash_mark_complete_button">
                    </form>
                </div>
                <div class="pad2">
                    <?php echo preg_replace('/\[.*\]/','',get_post_field('post_content', $post->ID, 'edit')); ?>
                </div>
                <div class="pad3">
                    <?php echo do_shortcode( '[comments_wp]' ); ?>
                    <form action="http://localhost/learndash/wp-comments-post.php" method="post" id="commentform" class="comment-form" novalidate="">
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
        <video
            id="my-video"
            class="video-js"
            controls
            preload="auto"
            width="640"
            height="364"
            poster="MY_VIDEO_POSTER.jpg"
            data-setup="{}"
        >
        <source src="https://drive.google.com/u/0/uc?export=download&confirm=_MeU&id=1pKwraLEfxQOZLlMQ2HYm7hspSYiefJTz" type='video/mp4'>
        <p class="vjs-no-js">
            To view this video please enable JavaScript, and consider upgrading to a
            web browser that
            <a href="https://videojs.com/html5-video-support/" target="_blank">supports HTML5 video</a>
        </p>
    </video>
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