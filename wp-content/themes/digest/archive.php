<?php get_header(); ?>

		<div id="container">
			<div id="content" role="main" style="margin-left:0px">

<?php	if ( have_posts() ) the_post(); ?>

			<h1 class="page-title" style="padding-left:15px">
<?php if ( is_day() ) : ?>
				<?php printf( __( 'Archive for: <span>%s</span>', 'digest' ), get_the_date() ); ?>
<?php elseif ( is_month() ) : ?>
				<?php printf( __( 'Archive for: <span>%s</span>', 'digest' ), get_the_date( 'F Y' ) ); ?>
<?php elseif ( is_year() ) : ?>
				<?php printf( __( 'Archive for: <span>%s</span>', 'digest' ), get_the_date( 'Y' ) ); ?>
<?php else : ?>
				<?php _e( 'Archive', 'digest' ); ?>
<?php endif; ?>
			</h1>

<?php
	rewind_posts();
	get_template_part( 'loop', 'archive' );
?>

			</div><!-- #content -->
		</div><!-- #container -->
		<?php get_sidebar(); ?>
<?php get_footer(); ?>
