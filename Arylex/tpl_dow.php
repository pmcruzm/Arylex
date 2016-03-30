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
	$page = get_posts( array('name'=> 'products','post_type' => 'page'));
	$id_page=apply_filters( 'wpml_object_id', $page[0]->ID, 'attachment', FALSE, ICL_LANGUAGE_CODE);
	$post = get_post($id_page);
	$exc_prod=$post->post_excerpt;
	$title_prod=$post->post_title;
	$link_prod=get_permalink($post->ID);
?> 
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
            <div class="col-md-4 page-content">
                <h2><?php echo types_render_field("title-top-box",array("output"=>"raw"));?></h2>
                <?php echo types_render_field("content-top-box",array("output"=>"html"));?>
            </div>
            <div class="col-md-6 col-md-offset-1">
                <img src="<?php echo types_render_field("image-top-box",array("output"=>"raw"));?>" class="img-responsive center-block">
            </div>
        </div>
    </article>


        <article class="jumbotron-products">
        <div class="content">
            <h2><?php echo  $title_prod;?></h2>
            <p><?php echo  $exc_prod;?></p>
            <a href="<?php echo  $link_prod;?>"><?php _e('View products','arylex');?></a>
        </div>
    </article>



    <article class="container">
        <div class="row">
            <div class="col-md-4 col-md-push-8 page-content">
                <h2><?php echo types_render_field("title-bottom-box", array("output"=>"raw"));?></h2>
                <?php echo types_render_field("content-bottom-box", array("output"=>"html"));?>
            </div>
            <div class="col-md-7 col-md-pull-4">
                <img src="<?php echo types_render_field("image-bottom-box",array("output"=>"raw"));?>" class="img-responsive center-block">
            </div>
        </div>
    </article>


</main>
<?php
       endwhile; endif;wp_reset_query();
?>
<?php get_footer(); ?>