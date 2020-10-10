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
