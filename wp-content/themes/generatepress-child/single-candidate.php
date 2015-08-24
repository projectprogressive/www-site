<?php
/*
Template Name: Candidate
@package GeneratePress
*/

get_header(); ?>

	<div id="primary" <?php generate_content_class();?> itemprop="mainContentOfPage">
		<main id="main" <?php generate_main_class(); ?> itemtype="http://schema.org/Blog" itemscope="itemscope" role="main">
		<?php do_action('generate_before_main_content'); ?>
		<?php while ( have_posts() ) : the_post(); ?>

			<?php echo '<h1>'.get_the_title().'</h1>'; ?>

			<?php if ( has_post_thumbnail() ) { // check if the post has a Post Thumbnail assigned to it.
				the_post_thumbnail('medium');
				} 
				
			$meta = get_post_meta( get_the_ID() ); 
			?> 
			<ul class="candidate-meta"> 
			<?php foreach( $meta as $key => $value ) {
				if( substr($key,0,1)==="_" )
				continue;
			?>
			<li class="<?php echo "candidate-{$key}"; ?> "> 
				<?php echo "<span class='post-meta-key'>$key:</span> "; ?>
				<?php if($key==="Website")
					{echo "<a href='{$value[0]}'>{$value[0]}</a>";}
				else
					{echo $value[0];} ?>
			</li>
			<?php } ?>
			</ul>

			<?php the_content(); ?>

			<?php
				// If comments are open or we have at least one comment, load up the comment template
				if ( comments_open() || '0' != get_comments_number() ) : ?>
					<div class="comments-area">
						<?php comments_template(); ?>
					</div>
			<?php endif; ?>

		<?php endwhile; // end of the loop. ?>
		<?php do_action('generate_after_main_content'); ?>
		</main><!-- #main -->
	</div><!-- #primary -->

<?php 
do_action('generate_sidebars');
get_footer();