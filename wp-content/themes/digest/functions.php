<?php
if ( ! function_exists( 'dig_get_option' ) ) :	
  function dig_get_option($Aoption_name, $default = null)
  {
    return stripslashes(get_option($Aoption_name, $default));
  };
endif;
require_once ( get_stylesheet_directory() . '/theme-options.php' );


if (!is_admin()){
	add_action('wp_enqueue_scripts', 'dig_script_loader');
}    

if (!function_exists('dig_script_loader')) {
    function dig_script_loader() {
		wp_enqueue_script( 'jquery' );
		wp_enqueue_script( 'jquery_masonry', get_stylesheet_directory_uri().'/libs/jquery.masonry.min.js' );
		wp_enqueue_script('dig_custom', get_template_directory_uri().'/libs/jquery.us.js');
		if ( is_singular() ) wp_enqueue_script( 'comment-reply' );	
		
    }
}



if ( ! function_exists( 'dig_filter_wp_title' ) ) :	
function dig_filter_wp_title( $title ) {
	global $page, $paged;
    $site_name = get_bloginfo( 'name' );
    $filtered_title = $site_name . $title;
      return $filtered_title;
	  $site_description = get_bloginfo( 'description', 'display' );
	if ( $site_description && ( is_home() || is_front_page() ) )
		echo " | $site_description";
		if ( $paged >= 2 || $page >= 2 )
		echo ' | ' . sprintf( __( 'Page %s', 'digest' ), max( $paged, $page ) ); 
}
endif; 
add_filter( 'wp_title', 'dig_filter_wp_title' );


add_action( 'after_setup_theme', 'dig_setup' );

if ( ! function_exists( 'dig_setup' ) ):

function dig_setup() {
global $dig_content_width, $dig_favicon_url;
if ( ! isset( $content_width ) )
	$content_width = 700;
	add_editor_style();
	add_theme_support( 'post-thumbnails' );
	set_post_thumbnail_size( 220 );
	add_theme_support( 'automatic-feed-links' );
	add_image_size( 'homepage-thumb', 220 );
	load_theme_textdomain( 'digest', get_template_directory() . '/languages' );
	$locale = get_locale();
	$locale_file = get_template_directory(). "/languages/$locale.php";
	if ( is_readable( $locale_file ) )
		require_once( $locale_file );

	register_nav_menus
(
array(
		'header-left' => __( 'header-left', 'digest' ),
		'header-center' => __( 'header-center', 'digest' ),
		'header-right' => __( 'header-right', 'digest' ),	
));
		

}
endif;

	function dig_widgets_init() {
	register_sidebar(array(
		'name' => 'Sidebar',
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h4>',
		'after_title' => '</h4>',
		));
	}
  add_action('widgets_init', 'dig_widgets_init');


function dig_excerpt_length( $length ) {
	return 40;
}
add_filter( 'excerpt_length', 'dig_excerpt_length' );


function dig_auto_excerpt_more( $more ) {
	return '';
}
add_filter( 'excerpt_more', 'dig_auto_excerpt_more' );



	
if ( ! function_exists( 'dig_comment' ) ) :	
  function dig_comment( $comment, $args, $depth ) {
	$GLOBALS['comment'] = $comment;
	switch ( $comment->comment_type ) :
		case '' :
	?>
	<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
		<div id="comment-<?php comment_ID(); ?>">
		<div class="comment-author vcard">
			<?php echo get_avatar( $comment, 40 ); ?>
			<?php printf( __( '%s <span class="says">says:</span>', 'digest' ), sprintf( '<cite class="fn">%s</cite>', get_comment_author_link() ) ); ?>
		</div><!-- .comment-author .vcard -->
		<?php if ( $comment->comment_approved == '0' ) : ?>
			<em class="comment-awaiting-moderation"><?php _e( 'Your comment is awaiting moderation.', 'digest' ); ?></em>
			<br />
		<?php endif; ?>

		<div class="comment-meta commentmetadata"><a href="<?php echo sanitize_text_field(esc_url( get_comment_link( $comment->comment_ID ) )); ?>">
			<?php printf(__('<p class="comment-date">%s</p>'), get_comment_date('M j, Y')) ?></a><?php edit_comment_link( __( '(Edit)', 'digest' ), ' ' );
			?>
		</div><!-- .comment-meta .commentmetadata -->

		<div class="comment-body"><?php sanitize_text_field(comment_text()); ?></div>

		<div class="reply">
			<?php comment_reply_link( array_merge( $args, array( 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
		</div><!-- .reply -->
	</div><!-- #comment-##  -->

	<?php
			break;
		case 'pingback'  :
		case 'trackback' :
	?>
	<li class="post pingback">
		<p><?php _e( 'Pingback:', 'digest' ); ?> <?php comment_author_link(); ?><?php edit_comment_link( __( '(Edit)', 'digest' ), ' ' ); ?></p>
	<?php
			break;
	endswitch;
  };
  endif; 
 
  



?>