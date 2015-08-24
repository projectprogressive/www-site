<?php
/**
 * The template for displaying Search Results pages.
 *
 * @package GeneratePress
 */

get_header(); ?>

	<section id="primary" <?php generate_content_class(); ?> itemprop="mainContentOfPage">
		<main id="main" <?php generate_main_class(); ?> itemtype="http://schema.org/SearchResultsPage" itemscope="itemscope" role="main">
		<?php do_action('generate_before_main_content'); ?>
		<?php if ( have_posts() ) : ?>

			<header class="page-header">
				<h1 class="page-title"><?php printf( __( 'Search Results for: %s', 'generate' ), '<span>' . get_search_query() . '</span>' ); ?></h1>
			</header><!-- .page-header -->

			<?php /* Start the Loop */ ?>
			<?php while ( have_posts() ) : the_post(); ?>

				<?php get_template_part( 'content', 'search' ); ?>

			<?php endwhile; ?>

			<?php generate_content_nav( 'nav-below' ); ?>

		<?php else : ?>

			<?php get_template_part( 'no-results', 'search' ); ?>

		<?php endif; ?>
		<?php do_action('generate_after_main_content'); ?>
		</main><!-- #main -->
	</section><!-- #primary -->

<?php do_action('generate_sidebars'); ?>
<?php get_footer(); ?>