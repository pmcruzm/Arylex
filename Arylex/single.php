<?php get_header(); ?>
<?php
	//Obtenemos datos de views&news 
	$page = get_posts( array('name'=> 'news-views','post_type' => 'page'));
	$id_page=apply_filters( 'wpml_object_id', $page[0]->ID, 'attachment', FALSE, ICL_LANGUAGE_CODE);
	$post = get_post($id_page); 
	$title_page=$post->post_title;
	$thumb = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'thumbnail_size' );
	$cover_view = $thumb['0'];
?> 

<?php
      if ( have_posts() ) : while ( have_posts() ) : the_post();
		$thumb = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'thumbnail_size' );
		$cover_top = $thumb['0'];
?>
<header class="header-img" style="background-image:url('<?php echo $cover_view;?>');">
    <span class="furrows"></span>
    <div class="title-top">
        <h2><?php echo $title_page;?></h2>
    </div>
</header>


<main id="main" role="main" class="news">

    <article class="news-detail">
		<?php
			//Comprobamos si es un webinar
			$webinar=types_render_field("include-webinar",array("output"=>"raw"));
			if($webinar==1){
				echo '<div class="embed-responsive embed-responsive-16by9">'.types_render_field("url-webinar",array("output"=>"raw")).'</div>';	
			}else{
				//echo '<img src="'.$cover_top.'" class="img-responsive center-block">';
				the_post_thumbnail('cover-news', array('class' => 'img-responsive center-block')); 
			}
		?>

        <div class="row">
            <div class="col-md-8">
				
                <?php
					//Comprobamos si es un webinar
					$webinar=types_render_field("include-webinar",array("output"=>"raw"));
					if($webinar==1){
						//Si el post procede de un experto
						$parent_id = wpcf_pr_post_get_belongs(get_the_ID(), 'expert');
						if (!empty($parent_id)) {
							$parent = get_post($parent_id);
							$thumb = wp_get_attachment_image_src( get_post_thumbnail_id($parent->ID), 'thumbnail_size' );
							$expert_img = $thumb['0'];		
				?>
                        <div class="meta-date"><?php the_time("F d, Y"); ?></div>
        
                        <div class="meta-author">
                            <img src="<?php echo $expert_img;?>">
                            <span class="author-title"><?php _e('Hosted by','arylex');?></span>
                            <span class="author-name"><?php echo $parent->post_title;?></span>
                            <span class="author-description"><?php echo $parent->post_content;?></span>
                        </div>
                <?php
						}
					}else{
				?>		
				<?php
					//Si el post procede de un experto
					$parent_id = wpcf_pr_post_get_belongs(get_the_ID(), 'expert');
					if (!empty($parent_id)) {
						$parent = get_post($parent_id);
						$thumb = wp_get_attachment_image_src( get_post_thumbnail_id($parent->ID), 'thumbnail_size' );
						$expert_img = $thumb['0'];	
				?>		
                		<div class="meta-author meta-expert">
                            <img src="<?php echo $expert_img;?>">
                            <span class="author-title"><?php _e('Author','arylex');?></span>
                            <span class="author-name"><?php echo $parent->post_title;?></span>
                            <span class="author-description"><?php echo $parent->post_content;?></span>
                        </div>
				<?php
					}
				?>
                <div class="meta-date"><?php the_time("F d, Y"); ?></div>
				<?php
                	}
				?>
                

                <div class="page-content">
                    <h3><?php the_title();?></h3>
					<?php the_content();?>
                </div>

                <div class="meta-category">
                	<?php
						$post_cat=get_the_category();
						$list_cat="";
						foreach($post_cat as $single_cat){
							$category_id = get_cat_ID($single_cat->name);
							$category_link = get_category_link( $category_id );
							$list_cat.='<a href="'.$category_link.'">'.$single_cat->name.'</a>&#8226;';
						}
						$list_cat=html_entity_decode($list_cat);
						echo substr($list_cat, 0, -3);
					?>
                </div>

                <div class="meta-share">
                    <?php _e('SHARE','arylex');?>
                    <ul>
                        <li><a href="http://twitter.com/home?status=<?php the_title(); ?> <?php echo get_permalink($post->ID); ?>" target="_blank" class="share-twitter"><?php _e('Share Twitter','arylex');?></a></li>
                        <li><a href="http://facebook.com/share.php?u=<?php the_permalink() ?>&amp;t=<?php echo urlencode(the_title('','', false)) ?>" target="_blank" class="share-facebook"><?php _e('Share Facebook','arylex');?></a></li>
                        <li><a href="mailto:?subject=<?php the_title(); ?>&amp;body=<?php echo get_permalink($post->ID); ?>" target="_blank" class="share-email"><?php _e('Share email','arylex');?></a></li>
                    </ul>
                </div>
	

                <div class="related-articles">
                    <h3><?php _e('RELATED ARTICLES','arylex');?></h3>
                    <div class="row">
                    	<?php
							$tags = wp_get_post_categories($post->ID);
							if ($tags) {
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
                                 <div class="col-sm-6">
                                    <div class="news-item-related" style="background-image:url(<?php echo $related_img;?>)">
                                        <div class="gradient">
                                            <div class="content">
                                                <p class="category">
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
                                                <h4><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></h4>
                                            </div>
                                        </div>
                                    </div>
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
            <div class="col-md-4">

                   <div class="mod-categories">
                    <h3><?php _e('CATEGORIES','arylex');?></h3>
                    <ul>
                    	<?php wp_list_categories('title_li=');?>
                    </ul>
                </div>

                <div class="mod-register">
                    <form class="bulletin-form" data-msg-success="<?php _e('Thanks for subscribing!','arylex');?>" data-msg-error="<?php _e('Error!','arylex');?>" data-msg-error-email="<?php _e('This email is already registered.','arylex');?>">
                        <h3><?php _e('BULLETIN','arylex');?></h3>
                        <p><?php _e('Register here to get the latest news and opinions straight to your inbox','arylex');?></p>
                        <input type="text" name="email" data-error="<?php _e('Email is invalid','arylex');?>">
                        <p class="errors"></p>
                        <div class="submit">
                            <input type="hidden" name="lang" value="<?php echo ICL_LANGUAGE_CODE;?>">
                            <input type="submit" class="submit" value="<?php _e('SUBSCRIBE','arylex');?>">
                        </div>
                    </form>
                </div>


            </div>
        </div>
    </article>

</main>
<?php
       endwhile; endif;wp_reset_query();
?>
<?php get_footer(); ?>
