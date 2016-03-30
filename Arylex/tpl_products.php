<?php
/**
 * @template name: Products
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
<header class="header-img" style="background-image:url(<?php echo $cover_top;?>)">
    <span class="furrows"></span>
    <div class="highlight">
        <div class="container">
            <div class="row">
                <div class="col-md-8">
                    <h2><?php the_title();?></h2>
                    <?php the_content();?>
                </div>
            </div>
        </div>
    </div>
</header>


<main id="main" role="main">

    <article class="container">
        <div class="row">
            <div class="col-md-4">
                <?php echo types_render_field("text-products",array("output"=>"html"));?>
                <p><img src="<?php bloginfo('template_url'); ?>/img/logo-grey.png" class="img-responsive"></p>
            </div>
            <div class="col-md-6 col-md-offset-1">
                <img src="<?php echo types_render_field("image-products",array("output"=>"raw"));?>" class="img-responsive center-block">
            </div>
        </div>
    </article>
    
    <article class="container product-list">
        <div class="row">
        	<?php
					$args = array('post_type' => 'single-product');
					$new = new WP_Query($args);
					while ($new->have_posts()) : $new->the_post();
					$thumb = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'thumbnail_size' );
					$cover_top = $thumb['0'];
				?>
                	 <div class="col-sm-4">
                        <a href="<?php echo get_permalink($post->ID); ?>">
                            <h3><?php the_title();?></h3>
                            <?php the_content();?>
                            <p><img src="<?php echo $cover_top;?>" class="img-responsive" alt="<?php the_title();?>"></p>
                        </a>
                    </div>  
                <?php	
					endwhile;
				?>
        </div>
    </article>

</main>
<?php
    endwhile; endif;wp_reset_query();
?>
<?php get_footer(); ?>