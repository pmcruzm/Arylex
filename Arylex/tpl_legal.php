<?php
/**
 * @template name: Legal
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
                </div>
            </div>
        </div>
    </div>
</header>


<main id="main" role="main">

    <article class="container">
        <div class="row">
            <?php the_content();?>
        </div>
    </article>

</main>
<?php
    endwhile; endif;wp_reset_query();
?>
<?php get_footer(); ?>