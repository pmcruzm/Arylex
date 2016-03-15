<?php get_header(); ?>
		<?php if ( have_posts() ) : ?>
			<?php
				//Comprobamos si es taxonomía(FAQ)
				if(is_tax($cat)){
					$tax = $wp_query->get_queried_object();
			?>
            <?php
				 $args = array('post_type' => 'page','pagename' =>'faq');
				 query_posts($args);	
				 if ( have_posts() ) : while ( have_posts() ) : the_post();
					$thumb = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'thumbnail_size' );
					$cover_top = $thumb['0'];
			?>
                    <header class="header-img" style="background-image:url(<?php echo $cover_top;?>)">
                        <span class="furrows"></span>
                        <div class="highlight">
                            <div class="container">
                                <div class="row">
                                    <div class="col-md-8">
                                        <h2><?php the_title();?></h2>
                                        <p><?php the_content();?></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </header>
			<?php
			   endwhile; endif;wp_reset_query();
			?>
			
			
			<main id="main" role="main">
			
				<article class="container">
					<div class="row">
						<div class="col-md-8 col-md-push-4 faqs">
							<?php
								$args = array('post_type' => 'faqs','tax_query' => array(array('taxonomy' => 'categories-faq','field'=> 'slug','terms'=> $tax->slug)));
								$new = new WP_Query($args);
								while ($new->have_posts()) : $new->the_post();
							?>
								<h4><?php the_title();?></h4>
								<div>
									<?php the_content();?>  
								</div>    
							<?php	
								endwhile;
							?>
						</div>
						<div class="col-md-4 col-md-pull-8">
							<div class="mod-categories">
								<h3><?php _e('TOPICS','arylex' )?></h3>
								<ul>
								<?php
									// Get all the taxonomies for this post type
									 $terms = get_terms('categories-faq');
									 foreach( $terms as $term ){
										$term_link = get_term_link( $term ); 
										echo '<li><a href="'.$term_link.'" rel="'.$term->slug.'">'.$term->name.'</a></li>';
									 }
								?>
								</ul>
							</div>
							<div class="mod-register ask-the-experts">
								<h3><?php _e('ASK THE EXPERTS','arylex' )?></h3>
								<p><?php _e('If you don’t find answers to your question here ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore.','arylex' )?></p>
								<div class="submit">
									<?php $page = get_page_by_title( 'Contact' );
										  $link_page=get_page_link($page->ID); 
									?>
									<a href="<?php echo $link_page;?>" class="submit"><?php _e('SEND QUESTION','arylex' )?></a>
								</div>
							</div>
						</div>
					</div>
				</article>

			</main>			
			<?php			
				}else{
					//En caso de que no sea una taxonomía
			?>	
            			<div class="">
							<?php
                                the_archive_title( '<h1 class="page-title">', '</h1>' );
                                the_archive_description( '<div class="taxonomy-description">', '</div>' );
                            ?>
                        </div><!-- .page-header -->	
            <?php            	
						$this_category = get_category($cat);
						echo do_shortcode('[ajax_load_more post_type="post" repeater="news" posts_per_page="6" category="'.$this_category->slug.'" transition="fade" button_label="SHOW MORE"]');
				}
			
		// If no content, include the "No posts found" template.
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
<?php get_footer(); ?>
