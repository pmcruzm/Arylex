<?php
/**
 * @template name: Whitepapers
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
    </div>
    <?php
       endwhile; endif;wp_reset_query();
	?>
    <div class="docu-whitepapers">
    <?php
		$args = array('post_type' => 'whitepaper');
		$new = new WP_Query($args);
		while ($new->have_posts()) : $new->the_post();
	?>
          <div class="box-whitepaper">
          <?php echo types_render_field("icon-file",array("output"=>"normal","alt"=>__('Texto alternativo','arylex')));?>
		  <p><?php the_title();?></p>
		  <p><?php the_content();?></p>
          <a href="<?php echo types_render_field("file", array("output"=>"raw"));?>"><?php _e('Download','arylex' )?></a>
          </div>      
     <?php	
		endwhile;
	 ?>
     </div> 
<?php get_footer(); ?>