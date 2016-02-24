<?php
/**
 * @template name: Dow
 * @package WordPress
 * @subpackage Arylex_theme
 * @since Arylex Theme 1.0
 */
?>
<?php get_header(); ?>
	<?php
		//Obtenemos datos de productos 
		 $args = array('post_type' => 'page','pagename' =>'products');
		 query_posts($args);
		 if ( have_posts() ) : while ( have_posts() ) : the_post();
			$exc_prod=get_the_excerpt();
			$title_prod=get_the_title();
			$link_prod=get_the_permalink();
		 endwhile; endif;wp_reset_query();
	?> 
	<?php
      if ( have_posts() ) : while ( have_posts() ) : the_post();
		$thumb = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'thumbnail_size' );
		$cover_top = $thumb['0'];
	?>
	<div id="cover_top" style="background-image:url(<?php echo $cover_top;?>)">
    	<p><?php the_content();?></p>
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
	<div class="box-main">
    	<div class="left_box">
            <h3><?php echo types_render_field("title-top-box",array("output"=>"html"));?></h3>
            <p><?php echo types_render_field("content-top-box",array("output"=>"html"));?></p>
        </div>
        <div class="right_box">
        	<?php echo types_render_field("image-top-box",array("output"=>"normal","alt"=>__('Texto alternativo','arylex')));?>
        </div>
    </div>
    <div class="box-main">
    	<div class="left_box">
         	<?php echo types_render_field("image-bottom-box",array("output"=>"normal","alt"=>__('Texto alternativo','arylex')));?>  
        </div>
        <div class="right_box">
        	<h3><?php echo types_render_field("title-bottom-box", array("output"=>"html"));?></h3>
            <p><?php echo types_render_field("content-bottom-box", array("output"=>"html"));?></p>	
        </div>
    </div>
    <!--Banner Products-->
    <div id="poducts_banner" class="clear">
       <h3><?php echo  $title_prod;?></h3>
       <p><?php echo  $exc_prod;?></p>
       <a href="<?php echo  $link_prod;?>"><?php _e('VIEW PRODUCTS','arylex' )?></a>
    </div>
    <?php
       endwhile; endif;wp_reset_query();
	?>
<?php get_footer(); ?>