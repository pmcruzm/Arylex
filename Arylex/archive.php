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
					//En caso de que no sea una taxonomía y sea una categoría
			?>	
            		<?php
						 $this_category = get_category($cat);	
						 $args = array('post_type' => 'page','pagename' =>'faq');
						 query_posts($args);	
						 if ( have_posts() ) : while ( have_posts() ) : the_post();
							$thumb = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'thumbnail_size' );
							$cover_top = $thumb['0'];
					?>
            		<header class="header-img" style="background-image:url(<?php echo $cover_top;?>)">
                        <span class="furrows"></span>
                        <div class="title-top">
                            <h2><?php the_title();?></h2>
                        </div>
                    </header>
                    <?php
					   endwhile; endif;wp_reset_query();
					?>
                    
                    <main id="main" role="main" class="news">
                    
                        <article class="news-list" data-max-items="6" data-more-items="2">
                    
                            <div class="news-category">
                              <p><?php _e('Category','arylex' )?></p>
                              <h2><?php echo mb_strtoupper($this_category->slug, 'UTF-8');?></h2>
                            </div>
                    
                            <div class="row">
                                <div class="col-md-8">
                                    <div class="row">
                                        <?php
											$args = array('post_type' => 'post','order'=>'DESC','posts_per_page' => -1,'category_name' => $this_category->slug);
											$new = new WP_Query($args);
											$cont=0;
											$array_dest= array();
											while ($new->have_posts()) : $new->the_post();
												$thumb = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'thumbnail_size' );
												$cover_top = $thumb['0'];
												//the_post_thumbnail();
										 ?>
											<div class="col-sm-6">
												<div class="news-item">
													<a href="<?php the_permalink(); ?>"><?php the_post_thumbnail('list-news', array('class' => 'img-responsive center-block')); ?></a>
													<p class="meta-category">
														<?php
															$post_cat=get_the_category();
															$list_cat="";
															foreach($post_cat as $single_cat){
																$category_id = get_cat_ID($single_cat->name);
																$category_link = get_category_link( $category_id );
																$list_cat.='<a href="'.$category_link.'">'.$single_cat->name.'</a> - ';
															}
															echo substr($list_cat, 0, -3);
														?>
													</p>
													<h3><a href="<?php the_permalink(); ?>"><?php the_title();?></a></h3>
													<p><?php the_excerpt();?></p>
												</div>
											</div>
										 <?php
											$cont++;
											if($cont%2==0 && $cont>0){echo '<div class="clearfix"></div>';}
											endwhile;
										 ?> 
                                    </div>
                                    <div class="load-more hidden">
                                        <span><?php _e('LOAD MORE','arylex');?></span>
                                    </div>
                                </div>
                                <div class="col-md-4">
                    
                                    <div class="mod-categories">
                                        <h3><?php _e('CATEGORIES','arylex');?></h3>
                                        <ul>
                                            <?php wp_list_categories('title_li=');?>
                                        </ul>
                                    </div>
                    
                                    <div class="mod-register">
                                        <form class="bulletin-form" data-msg-success="<?php _e('Error!','arylex');?>" data-msg-error="<?php _e('Error!','arylex');?>" data-msg-error-email="<?php _e('Email ya suscrito!','arylex' );?>">
                                            <h3><?php _e('BULLETIN','arylex' );?></h3>
                                            <p><?php _e('Register here to get the latest news and opinions straight to your inbox','arylex');?></p>
                                            <input type="text" name="email" data-error="<?php _e('El email no es válido','arylex' )?>">
                                            <p class="errors"></p>
                                            <div class="submit">
                                                <input type="hidden" name="lang" value="<?php echo ICL_LANGUAGE_CODE;?>">
                                                <input type="submit" class="submit" value="<?php _e('SUBSCRIBE','arylex' )?>">
                                            </div>
                                        </form>
                                    </div>
                    
                    
                                </div>
                            </div>
                        </article>
                    
                    </main>
            			
            <?php            	
				}
			
		// If no content, include the "No posts found" template.
		else :
		?>
        <article class="container search-results">
            <div class="row">
                <div class="col-md-4 search-term">
                    <p><?php _e( '<i class="icon-search-results"></i> Nothing Found', 'arylex' );?></p>
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
<?php get_footer(); ?>
