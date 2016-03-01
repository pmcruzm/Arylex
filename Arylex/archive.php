<?php get_header(); ?>

	<div class="archive-post">
		<?php if ( have_posts() ) : ?>
			<div class="page-header">
				<?php
					the_archive_title( '<h1 class="page-title">', '</h1>' );
					the_archive_description( '<div class="taxonomy-description">', '</div>' );
					$this_category = get_category($cat);
					//print_r($this_category);
				?>
			</div><!-- .page-header -->

			<?php
				echo do_shortcode('[ajax_load_more post_type="post" repeater="news" posts_per_page="6" category="'.$this_category->slug.'" transition="fade" button_label="SHOW MORE"]');
			
		// If no content, include the "No posts found" template.
		else :
		?>
			<section class="no-results not-found">
				<header class="page-header">
					<h1 class="page-title"><?php _e( 'Nothing Found', 'arylex' ); ?></h1>
				</header><!-- .page-header -->
			
				<div class="page-content">
			
					<?php if ( is_home() && current_user_can( 'publish_posts' ) ) : ?>
			
						<p><?php printf( __( 'Ready to publish your first post? <a href="%1$s">Get started here</a>.', 'arylex' ), esc_url( admin_url( 'post-new.php' ) ) ); ?></p>
			
					<?php elseif ( is_search() ) : ?>
			
						<p><?php _e( 'Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'arylex' ); ?></p>
						<?php get_search_form(); ?>
			
					<?php else : ?>
			
						<p><?php _e( 'It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.', 'arylex' ); ?></p>
						<?php get_search_form(); ?>
			
					<?php endif; ?>
			
				</div><!-- .page-content -->
			</section><!-- .no-results -->
        <?php    
		endif;
		?>
	</div>

<?php get_footer(); ?>
