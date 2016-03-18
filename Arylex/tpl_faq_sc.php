<?php
/**
 * @template name: FAQ SC
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
					$args = array('post_type' => 'faqs');
					$new = new WP_Query($args);
					while ($new->have_posts()) : $new->the_post();
				?>
                  	<h4><?php the_title();?></h4>
                	<div class="page-content">
                  		<?php the_content();?>  
                    </div>    
                <?php	
					endwhile;
				?>
            </div>
            <div class="col-md-4 col-md-pull-8">
                <div class="mod-register ask-the-experts">
                    <h3><?php _e('ASK THE EXPERTS','arylex' )?></h3>
                    <p><?php _e('If you don’t find answers to your question here, please send us your question and we will get back to you as soon as possible.','arylex' )?></p>
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
<?php get_footer(); ?>