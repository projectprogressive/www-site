<?php if ( ! have_posts() ) : ?>
	<div id="post-0" class="post error404 not-found">
		<h1 class="entry-title"><?php _e('Not Found', 'digest'); ?></h1>
		<div class="entry-content">
			<p><?php _e( 'Sorry, but nothing matched your search criteria.', 'digest' ); ?></p>
			<?php get_search_form(); ?>
		</div><!-- .entry-content -->
	</div><!-- #post-0 -->
<?php endif; ?>



<div id="boxes">
<?php while ( have_posts() ) : the_post(); ?>

	<div class="box">
		<div class="rel">
			<a href="<?php the_permalink(); ?>"><?php the_post_thumbnail('homepage-thumb', array('alt' => '', 'title' => '')) ?></a>
			<h1><a href="<?php the_permalink(); ?>"><?php $title = get_the_title();
    if (strlen($title) == 0) echo '(no title)'; else echo $title; ?></a></h1>
			<div class="post-date"><?php the_time('F j, Y') ?> - <?php comments_number('No Comments', 'One Comment', '% Comments' ); ?></div>

		<?php the_excerpt() ?>
<div class="readmore"><a href="<?php the_permalink(); ?>"><?php _e('Read more &rarr;', 'digest'); ?></a></div>
			
		</div>
	</div>

<?php endwhile; ?>
</div>

<?php if ( $wp_query->max_num_pages > 1 ) : ?>

<div class="wrap-pagin">
	<div class="alignleft"><?php next_posts_link(esc_html__('Older Posts','digest')) ?></div>
	<div class="alignright"><?php previous_posts_link(esc_html__('Newer Posts', 'digest')) ?></div>
</div>


<?php endif; ?>