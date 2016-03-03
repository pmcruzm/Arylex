<?php get_header(); ?>
	<?php
      if ( have_posts() ) : while ( have_posts() ) : the_post();
		$thumb = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'thumbnail_size' );
		$cover_top = $thumb['0'];
	?>
	<div id="cover_top" style="background-image:url(<?php echo $cover_top;?>)">
    	<p><?php the_title();?></p>
        <?php
			$webinar=types_render_field("include-webinar",array("output"=>"raw"));
			if($webinar==1){
				echo types_render_field("url-webinar",array("output"=>"raw"));	
			}
		?>
        
        <!--Experto-->	
        <?php
			$parent_id = wpcf_pr_post_get_belongs(get_the_ID(), 'expert');
			if (!empty($parent_id)) {
				$parent = get_post($parent_id);
				$thumb = wp_get_attachment_image_src( get_post_thumbnail_id($parent->ID), 'thumbnail_size' );
				$expert_img = $thumb['0'];	
				echo '<div class="box-expert">';
				echo '<img src="'.$expert_img.'"/>';
				echo '<h3>'.$parent->post_title.'</h3>';
				echo '<p>'.$parent->post_content.'</p>';
				echo '</div>';
				//print_r($parent);
			}
		?>
    </div>
    <div class="body-news">
    	<div class="right-news">
        	<div class="news-categories">
        		<?php wp_list_categories();?>
            </div>
        	<div class="news-suscripcion">
            	<p><?php _e('Bulletin','arylex' )?></p>	
                <form id="form-bulletin">
                   <label for="email">Email Address *</label> <input name="email" id="email" type="text" />
                   <input type="hidden" name="language" id="language" value="<?php echo ICL_LANGUAGE_CODE;?>">
                   <input class="right inputnew" type="submit" title="Send" value="Send" />
               </form>
            </div>
        </div>
        <div class="left-news">
        	<!--Contenido-->
            <h2><?php the_title();?></h2>
            <p class="entry-meta"><?php the_time("F d, Y"); ?></p>
            <?php the_content();?>
            <hr/>
            <!--Categorias-->
            <div>
              	<?php
					//print_r(get_the_category());
                	$post_cat=get_the_category();
					foreach($post_cat as $single_cat){
						// Get the ID of a given category
    					$category_id = get_cat_ID($single_cat->name);

    					// Get the URL of this category
    					$category_link = get_category_link( $category_id );
						echo '<a href="'.$category_link.'">'.$single_cat->name.'</a><br/>';
					}
				?>
              </div>
            <hr/>
            <!--RRSS-->
            <div id="single_rrss">
               <a href="http://facebook.com/share.php?u=<?php the_permalink() ?>&amp;t=<?php echo urlencode(the_title('','', false)) ?>" target="_blank"><?php _e('Facebook','arylex' )?></a>
               <a href="http://twitter.com/home?status=<?php the_title(); ?> <?php echo get_permalink($post->ID); ?>" target="_blank" ><?php _e('Twitter','arylex' )?></a>
               <a href="mailto:?subject=<?php the_title(); ?>&amp;body=<?php echo get_permalink($post->ID); ?>" target="_blank" ><?php _e('Enviar por email','arylex' )?></a>
               <?php
               //if(function_exists('email_link')) { email_link(); }
			   ?>
             </div>
            <hr/>
            <!--Related Articles-->
            <div class="related-box">
			<?php
				
				$tags = wp_get_post_categories($post->ID);
				if ($tags) {
					echo _e('Related Post','arylex' ).'<br/>';
					$args=array(
					'category__in' => $tags,
					'post__not_in' => array($post->ID),
					'posts_per_page'=>2,
					'ignore_sticky_posts' => 1
					);
					
					$my_query = new WP_Query($args);
					if( $my_query->have_posts() ) {
						while ($my_query->have_posts()) : $my_query->the_post();
							$thumb = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'thumbnail_size' );
							$related_img = $thumb['0'];
					 ?>
                        <div class="related-img">
                        	<img src="<?php echo $related_img;?>" />
                        	<?php
								$post_cat=get_the_category();
								foreach($post_cat as $single_cat){
									// Get the ID of a given category
									$category_id = get_cat_ID($single_cat->name);
			
									// Get the URL of this category
									$category_link = get_category_link( $category_id );
									echo '<a href="'.$category_link.'">'.$single_cat->name.'</a><br/>';
								}
							?>
							<a href="<?php the_permalink() ?>" title=""><?php the_title(); ?></a>
						</div>
						<?php
						endwhile;
					}
					wp_reset_query();
				}
			?>
            </div>
        </div>
    </div>
    <?php
       endwhile; endif;wp_reset_query();
	?>
<?php get_footer(); ?>
