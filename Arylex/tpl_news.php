<?php
/**
 * @template name: News&Views
 * @package WordPress
 * @subpackage Arylex_theme
 * @since Arylex Theme 1.0
 */
?>
<?php get_header(); ?>
	
	<?php
      if ( have_posts() ) : while ( have_posts() ) : the_post();
		$thumb = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'thumbnail_size' );
		$cover_top = $thumb['0'];
	?>
	<div id="cover_top" style="background-image:url(<?php echo $cover_top;?>)">
    	<p><?php the_title();?></p>
        <!--Info del player-->
        <?php
        	$title_vid=types_render_field("title-video",array("output"=>"raw"));
			$url_vid=types_render_field("url-video",array("output"=>"raw"));
			if($title_vid!="" && $url_vid!="" ){
				echo '<p>'.$title_vid.'</p>';
				echo '<a href="'.$url_vid.'" target="_blank">Play Video</a>';
			}
		?>
    </div>
    <div class="destacado_post">
    	<h3>Post Destacados</h3>
        <?php
			$args = array('post_type' => 'post','order'=>'DESC','posts_per_page' => -1);
			$new = new WP_Query($args);
			$cont=1;
			$array_dest= array();
			while ($new->have_posts()) : $new->the_post();
				$destacado=types_render_field("highlight-post",array("output"=>"raw"));
				if($destacado==1){
					if($cont<4){
		?>
           <div class="box-destacado">
           	  <!--Categorías-->	
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
					$array_dest[]=$post->ID;
				?>
              </div>
              <!--Título-->
              <h4><?php the_title();?></h4>
              <!--Excerpt-->
			  <p><?php the_excerpt();?></p>
           </div>      
        <?php
					$cont++;
					}
				}
			endwhile;
			//print_r($array_dest);
		?>  
    </div>
    <?php
       endwhile; endif;wp_reset_query();
	?>
    <div class="body-news">
    	<div class="right-news">
        	<div class="news-suscripcion">
            	<p><?php _e('Bulletin','arylex' )?></p>	
                <form id="form-bulletin">
                   <label for="email">Email Address *</label> <input name="email" id="email" type="text" />
                   <input type="hidden" name="language" id="language" value="<?php echo ICL_LANGUAGE_CODE;?>">
                   <input class="right inputnew" type="submit" title="Send" value="Send" />
               </form>
            </div>
			<div class="news-categories">
        		<?php wp_list_categories();?>
            </div>
        </div>
        <div class="left-news">
        	<!--Resto de post menos los destacados arriba-->
            <?php 
				echo do_shortcode('[ajax_load_more post_type="post" repeater="news" posts_per_page="6" exclude="'.implode(",",$array_dest).'" transition="fade" button_label="LOAD MORE"]');
			?>
        </div>
    </div>
<?php get_footer(); ?>