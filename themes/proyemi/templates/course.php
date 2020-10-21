<?php
    /* 
    * duracion tag [ duration h="5"]
    * resources tag [ resources n="5"]
    * lesson tag [ lesson n="5"]
    **/
    
    add_shortcode('duration', 'duration');
    add_shortcode('resources', 'resources');
    add_shortcode('lesson', 'lesson');

    function duration($atts = array()) { return $atts['h']; }
    function resources($atts = array()) { return $atts['n']; }
    function lesson($atts = array()) { return $atts['n']; }

    preg_match('/\[.*\]/',get_post_field('post_content', $post->ID, 'edit'), $match );

    $match = explode(',',$match[0]);
    $duration = $match[0];
    $resources = $match[1];
    $lesson_ = $match[2];
    
    /* boton de continuar */
    $lesson_back = $lessons;
    $url = array_shift($lesson_back); 
    $boton = '<a  href="'.$url['permalink'].'" style="border-radius: 4px;background:#F25116;color:#fff;text-align:center;display:block;height:45px;line-height:45px;" >VER CURSO</a>';
    /* url actual */
    $current_url="http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
    /* Imagen del curso */
    global $post;
    $thumbID = get_post_thumbnail_id( $post->ID );
    $img = wp_get_attachment_url( $thumbID );
    /* Autor */
    $author_id = $post->post_author;
    $img_autor = the_author_meta( 'avatar' , $author_id );
    // $name_autor = the_author_meta( 'user_nicename' , $author_id );
?>
<link rel="stylesheet" href="<?php echo plugins_url( 'themes/proyemi/assets/css/style-course.css', LEARNDASH_LMS_PLUGIN_DIR . 'index.php' ); ?>">
<div class="image-desktop">
    <div class="image-poster" style="width:99%;height:280px;margin:auto;border-radius: 5px;overflow: hidden;">
        <img src="<?php echo $img;?>" style="width:100%;height:100%;">
    </div>
    <div class="course-action-dsk">
        <?php echo do_shortcode('[student course_id="'.$post->ID.'"]'.$boton.'[/student]'); ?>
        <?php echo do_shortcode('[learndash_payment_buttons course_id="'.$post->ID.'"]'); ?>
        <?php echo do_shortcode('[student course_id="'.$post->ID.'"]<style>.compartir{margin-top: 0px !important;}</style>[/student]'); ?>
        <a class="btn-join compartir" href="https://www.facebook.com/sharer.php?u=<?php echo $current_url; ?>" style="margin-top: 15px;background: #84BFB9 !important;" onclick="window.open(this.href, 'mywin','left=20,top=20,width=500,height=500,toolbar=1,resizable=0'); return false;" >Compartir</a>
        <?php if(!is_user_logged_in()) :?>
        <div class="already">
            Ya tienes una cuenta? <a href="https://proyemi.com/sign-in/">Inicia Sesión</a>
        </div>
        <?php endif; ?>
    </div>
</div>
<div class="course-container">
    <div class="course-image-poster">
        <div class="image-poster">
            <img src="<?php echo $img;?>" alt="">
        </div>
    </div>
    <div class="course-position-container">
        <div class="top-container">
            <h1><?php the_title(); ?></h1>
            <div class="course-description">
                <p>Creado por: <?php the_author_meta( 'user_nicename' , $author_id ); ?></p>
                <p>
                    <span>
                        <svg width="15" height="16" viewBox="0 0 15 16" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M6.5 6.00388L6.74821 5.56984C6.59347 5.48135 6.40331 5.48193 6.24911 5.57138C6.09491 5.66083 6 5.82562 6 6.00388H6.5ZM6.5 10.007H6C6 10.1852 6.09491 10.35 6.24911 10.4395C6.40331 10.5289 6.59347 10.5295 6.74821 10.441L6.5 10.007ZM10 8.00543L10.2482 8.43947C10.4039 8.35043 10.5 8.1848 10.5 8.00543C10.5 7.82606 10.4039 7.66044 10.2482 7.57139L10 8.00543ZM7.5 14.5109C3.91051 14.5109 1 11.5986 1 8.00543H0C0 12.1502 3.3575 15.5109 7.5 15.5109V14.5109ZM14 8.00543C14 11.5986 11.0895 14.5109 7.5 14.5109V15.5109C11.6425 15.5109 15 12.1502 15 8.00543H14ZM7.5 1.5C11.0895 1.5 14 4.41222 14 8.00543H15C15 3.86066 11.6425 0.5 7.5 0.5V1.5ZM7.5 0.5C3.3575 0.5 0 3.86066 0 8.00543H1C1 4.41222 3.91051 1.5 7.5 1.5V0.5ZM6 6.00388V10.007H7V6.00388H6ZM6.74821 10.441L10.2482 8.43947L9.75179 7.57139L6.25179 9.57295L6.74821 10.441ZM10.2482 7.57139L6.74821 5.56984L6.25179 6.43792L9.75179 8.43947L10.2482 7.57139Z" fill="#333333"/></svg>
                    </span>
                    <?php echo do_shortcode($duration); ?> min de Video bajo demanda</p>
                <p>
                    <span>
                        <svg width="13" height="15" viewBox="0 0 13 15" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M1.5 6.5V6H1V6.5H1.5ZM5.5 6.5V6H5V6.5H5.5ZM5.5 10.5H5V11H5.5V10.5ZM12.5 3.5H13V3.29289L12.8536 3.14645L12.5 3.5ZM9.5 0.5L9.85355 0.146447L9.70711 0H9.5V0.5ZM1.5 7H2.5V6H1.5V7ZM2 11V8.5H1V11H2ZM2 8.5V6.5H1V8.5H2ZM2.5 8H1.5V9H2.5V8ZM3 7.5C3 7.77614 2.77614 8 2.5 8V9C3.32843 9 4 8.32843 4 7.5H3ZM2.5 7C2.77614 7 3 7.22386 3 7.5H4C4 6.67157 3.32843 6 2.5 6V7ZM5 6.5V10.5H6V6.5H5ZM5.5 11H6.5V10H5.5V11ZM8 9.5V7.5H7V9.5H8ZM6.5 6H5.5V7H6.5V6ZM8 7.5C8 6.67157 7.32843 6 6.5 6V7C6.77614 7 7 7.22386 7 7.5H8ZM6.5 11C7.32843 11 8 10.3284 8 9.5H7C7 9.77614 6.77614 10 6.5 10V11ZM9 6V11H10V6H9ZM9.5 7H12V6H9.5V7ZM9.5 9H11V8H9.5V9ZM1 5V1.5H0V5H1ZM12 3.5V5H13V3.5H12ZM1.5 1H9.5V0H1.5V1ZM9.14645 0.853553L12.1464 3.85355L12.8536 3.14645L9.85355 0.146447L9.14645 0.853553ZM1 1.5C1 1.22386 1.22386 1 1.5 1V0C0.671573 0 0 0.671573 0 1.5H1ZM0 12V13.5H1V12H0ZM1.5 15H11.5V14H1.5V15ZM13 13.5V12H12V13.5H13ZM11.5 15C12.3284 15 13 14.3284 13 13.5H12C12 13.7761 11.7761 14 11.5 14V15ZM0 13.5C0 14.3284 0.671573 15 1.5 15V14C1.22386 14 1 13.7761 1 13.5H0Z" fill="#333333"/></svg>
                    </span>
                    <?php echo do_shortcode($resources); ?> Recursos descargables</p>
                <p>
                    <span>
                        <svg width="15" height="15" viewBox="0 0 15 15" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M4 7.5L7 10L11 5M7.5 14.5C3.63401 14.5 0.5 11.366 0.5 7.5C0.5 3.63401 3.63401 0.5 7.5 0.5C11.366 0.5 14.5 3.63401 14.5 7.5C14.5 11.366 11.366 14.5 7.5 14.5Z" stroke="#333333"/></svg>
                    </span>
                    <?php echo do_shortcode($lesson_); ?> Clases online</p>
                <p>
                    <span>
                        <svg width="12" height="14" viewBox="0 0 12 14" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M0 4.57212L1.20521 0L2.48228 1.29815C4.81933 -0.198748 7.94481 0.0874064 9.98043 2.15661L9.02991 3.12281C7.52286 1.59089 5.24776 1.3155 3.46458 2.29665L4.49789 3.34702L0 4.57212Z" fill="#333333"/><path d="M11.2052 8.5L10 13.0721L8.72292 11.774C6.38587 13.2709 3.26039 12.9847 1.22478 10.9155L2.1753 9.9493C3.68235 11.4812 5.95744 11.7566 7.74063 10.7755L6.70731 9.72509L11.2052 8.5Z" fill="#333333"/></svg>
                    </span>
                    Acceso ilimitado</p>
                <p>
                    <span>
                        <svg width="15" height="15" viewBox="0 0 15 15" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M4 14.5H11M7.5 14.5V9.5M7.5 9.5C9.70914 9.5 11.5 7.70914 11.5 5.5V1.5C11.5 0.947715 11.0523 0.5 10.5 0.5H4.5C3.94772 0.5 3.5 0.947715 3.5 1.5V5.5C3.5 7.70914 5.29086 9.5 7.5 9.5ZM3.5 2.5H2.5C1.39543 2.5 0.5 3.39543 0.5 4.5C0.5 5.60457 1.39543 6.5 2.5 6.5H3.5M11.5 2.5H12.5C13.6046 2.5 14.5 3.39543 14.5 4.5C14.5 5.60457 13.6046 6.5 12.5 6.5H11.5" stroke="#333333"/></svg>
                    </span>
                    Certificado de finalización
                </p>
            </div>
            <div class="course-action">
                <?php echo do_shortcode('[student course_id="'.$post->ID.'"]'.$boton.'[/student]'); ?>
                <?php echo do_shortcode('[learndash_payment_buttons course_id="'.$post->ID.'"]'); ?>
                <a class="btn-join" href="https://www.facebook.com/sharer.php?u=<?php echo $current_url; ?>" style="margin-top: 20px;background: #84BFB9 !important;" onclick="window.open(this.href, 'mywin','left=20,top=20,width=500,height=500,toolbar=1,resizable=0'); return false;" >Compartir</a>
                <?php if(!is_user_logged_in()) :?>
                <div class="already">
                    Ya tienes una cuenta? <a href="https://proyemi.com/sign-in/">Inicia Sesión</a>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<div class="course-body">
    <div class="autor-course-content">
        <div class="line-inner">
            <hr>
        </div>
        <div class="autor-course">
            <div class="autor-course-info">
                <h2>Dictado por</h2>
                <h2 style="margin:0px;text-transform:capitalize;"><?php the_author_meta( 'user_nicename' , $author_id ); ?></h2>
                <h5>Diseñadora y Creativa</h5>
            </div>
            <div class="autor-course-avatar">
                <div class="avatar">
                    <?php echo get_avatar($img_autor); ?>
                </div>
            </div>
        </div>
    </div>
    <div class="course-body-content">
        <div class="course-body-left">
            <?php echo preg_replace('/\[.*\]/','',get_post_field('post_content', $post->ID, 'edit')); ?>
            <?php /* echo do_shortcode('[ld_lesson_list course_id="'.$post->ID.'" orderby="menu_order" order="ASC"]'); */ ?>
            <!-- <a class="ld-item-name ld-primary-color-hover" href="<?php echo esc_url( learndash_get_step_permalink( get_the_ID() ) ); ?>"><?php echo esc_html( get_the_title() ); ?></a> -->
            <div class="card-content">
                <h1>Contenido</h1>
                <?php foreach($lessons as $lesson) : ?>
                <div class='post-<?php echo esc_attr( $lesson['post']->ID ); ?> <?php echo esc_attr( $lesson['sample'] ); ?>'>
                    <div class="list-count">
                        <p><a href="<?php echo $lesson['permalink']; ?>"><?php echo $lesson['post']->post_title; ?></a></p>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>
<!-- <script src="<?php echo plugins_url( 'themes/proyemi/assets/js/main.js', LEARNDASH_LMS_PLUGIN_DIR . 'index.php' ); ?>"></script> -->
<?php
    // echo do_shortcode('[learndash_payment_buttons course_id="'.$post->ID.'"]');
?>