<?php get_header(); ?>
<header class="header-img" style="background-image:url('<?php bloginfo('template_url'); ?>/img/header-8.jpg');">
    <span class="furrows"></span>
    <div class="highlight">
        <div class="container">
            <div class="row">
                <div class="col-md-8">
                    <h2><?php _e('Search','arylex' )?></h2>
                </div>
            </div>
        </div>
    </div>
</header>


<main id="main" role="main">
	<?php if ( have_posts() ) : ?>
    <article class="container search-results">
        <div class="row">
            <div class="col-md-4 search-term">
            	<p><?php printf( __( '<i class="icon-search-results"></i> Search results for <b>" %s "</b>', 'arylex' ), get_search_query() ); ?></p>
            </div>
            <div class="col-md-8 page-content">
            	<?php
				// Start the loop.
				while ( have_posts() ) : the_post(); 
					$thumb = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'thumbnail_size' );
					$img_post = $thumb['0'];
				?>
                <div class="row">
                    <a href="<?php the_permalink(); ?>">
                        <div class="col-sm-3">
                           <!-- <img src="img/news-2.jpg" class="img-responsive">-->
                           <?php the_post_thumbnail('list-news', array('class' => 'img-responsive')); ?>
                        </div>
                        <div class="col-sm-9">
                            <h3><?php the_title();?></h3>
                            <?php 
								$type=get_post_type();
								if($type=='post'){
							?>
                            <h4>
								<?php
									$post_cat=get_the_category();
									$list_cat="";
									foreach($post_cat as $single_cat){
										$category_id = get_cat_ID($single_cat->name);
										$category_link = get_category_link( $category_id );
										$list_cat.=$single_cat->name.' - ';
									}
									echo substr($list_cat, 0, -3);
								?>
                            </h4>
							<?php 
								}
							?>
                            <p><?php the_excerpt();?></p>
                        </div>
                    </a>
                </div>
                <?php    
				endwhile;
				?>
            </div>
        </div>
    </article>
	<?php
    else :
	?>
   	<article class="container search-results">
        <div class="row">
            <div class="col-md-4 search-term">
            	<p><?php printf( __( '<i class="icon-search-results"></i> Nothing Found for <b>" %s "</b>', 'arylex' ), get_search_query() ); ?></p>
            </div>
            <div class="col-md-8 page-content">
                <?php if ( is_search() ) : ?>
                        <p><?php _e( 'Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'arylex' ); ?></p>
                        <?php get_search_form(); ?>
                 <?php else : ?>
            
                        <p><?php _e( 'It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.', 'arylex' ); ?></p>
                        <?php get_search_form(); ?>
            
                  <?php endif; ?>
            </div>
        </div>
    </article>
    <?php
		endif;
	?>
</main>
<?php get_footer(); ?>
