<?php
/**
 * @template name: FAQ
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
    <!--Categorias FAQS-->
    <ul class="menu-faqs">
    <?php
    	// Get all the taxonomies for this post type
		 $terms = get_terms('categories-faq');
		 foreach( $terms as $term ){
			echo '<li><a href="#" rel="'.$term->slug.'">'.$term->name.'</a></li>';
    	 }
		//print_r($terms);
	?>
    </ul>
	<!--Listamos las preguntas-->
    <?php 
		echo do_shortcode('[ajax_load_more post_type="faqs" repeater="default" posts_per_page="3" taxonomy="categories-faq" transition="fade" button_label="Load More FAQs"]');
	?>
	<?php
		//$args = array('post_type' => 'faqs');
		//$new = new WP_Query($args);
		//while ($new->have_posts()) : $new->the_post();
	?>
      <!--<div class="box-faq">
      	<h3><?php the_title();?></h3>
        <p></p>
        <div class="desplegable-faq">
        	<?php the_content();?>
        </div>
      </div>-->     
    <?php	
	//endwhile;
	?> 
<?php get_footer(); ?>