<?php get_header(); ?>
	<section id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

		<?php if ( have_posts() ) : ?>

			<header class="page-header">
				<h1 class="page-title"><?php printf( __( 'Search Results for: %s', 'arylex' ), get_search_query() ); ?></h1>
			</header><!-- .page-header -->

			<?php
			// Start the loop.
			while ( have_posts() ) : the_post(); 
				$thumb = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'thumbnail_size' );
				$img_post = $thumb['0'];
			?>
				<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                	<img src="<?php echo $img_post;?>" width="50" height="50"/>
                    <header class="entry-header">
                        <?php the_title( sprintf( '<h2 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' ); ?>
                    </header><!-- .entry-header -->
                
                    <div class="entry-summary">
                        <?php the_excerpt(); ?>
                    </div>
                </article>
            <?php    
			endwhile;
		else :
		?>
        	<section class="no-results not-found">
                <header class="page-header">
                    <h1 class="page-title"><?php _e( 'Nothing Found', 'arylex' ); ?></h1>
                </header><!-- .page-header -->
            
                <div class="page-content">
            
                    <?php if ( is_search() ) : ?>
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

		</main><!-- .site-main -->
	</section><!-- .content-area -->
<?php get_footer(); ?>
