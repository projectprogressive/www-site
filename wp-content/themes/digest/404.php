<?php get_header(); ?>

	<div id="container">
		<div id="content" role="main">

			<div id="post-0" class="post error404 not-found">
				<h1 class="entry-title"><?php _e( 'Error 404 &mdash; Not Found', 'digest'); ?></h1>
				<div class="entry-content">
					<p><?php _e( 'You are trying to reach a page that does not exist here. Either it has been moved or you typed a wrong address.', 'digest' ); ?></p>
				
				</div><!-- .entry-content -->
			</div><!-- #post-0 -->

		</div><!-- #content -->
	</div><!-- #container -->
	<?php get_sidebar(); ?>

<?php get_footer(); ?>