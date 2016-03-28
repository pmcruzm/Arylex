<?php
/**
 * @template name: Home
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
<header class="header-img header-home" style="background-image:url(<?php echo $cover_top;?>)">
    <span class="furrows"></span>
    <div class="highlight">
        <div class="container">
            <div class="row">
                <div class="col-md-8 col-sm-9">
                	<br>
                	<h2><?php the_title();?></h2>
                    <p><?php the_content();?></p>
                </div>
                <?php
					$title_vid=types_render_field("title-video",array("output"=>"raw"));
					$url_vid=types_render_field("url-video",array("output"=>"raw"));
					if($title_vid!="" && $url_vid!="" ){
				?>	
                	<div class="col-md-4 col-sm-3">
                        <div class="video-arylex">
                            <a href="<?php echo $url_vid;?>" class="youtube-fullview">
                                <i class="icon-video"></i>
                                <?php echo $title_vid;?>
                            </a>
                        </div>
                    </div>	
				<?php
                	}
				?>
            </div>
        </div>
    </div>
</header>


<main id="main" role="main" class="home">

    <article class="container page-content">
        <div class="row">
            <div class="col-md-6 page-content">
                <h2><?php echo types_render_field("title-top-box",array("output"=>"raw"));?></h2>
                <?php echo types_render_field("content-top-box",array("output"=>"html"));?>
            </div>
            <div class="col-md-6">
                <img src="<?php echo types_render_field("image-top-box",array("output"=>"raw"));?>" class="img-responsive center-block">
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 col-md-push-6">
                <h2><?php echo types_render_field("title-bottom-box", array("output"=>"raw"));?></h2>
                <?php echo types_render_field("content-bottom-box", array("output"=>"html"));?>
                <p><img src="<?php bloginfo('template_url'); ?>/svg/logo_howitworks.svg" class="img-responsive hidden-xs" alt="<?php _e('Arylex Active: The next generation of weed control','arylex' );?>"></p>
            </div>
            <div class="col-md-6 col-md-pull-6">
                <img src="<?php echo types_render_field("image-bottom-box",array("output"=>"raw"));?>" class="img-responsive center-block">
            </div>
        </div>
    </article>

        <article class="jumbotron-products">
        <div class="content">
            <h2><?php echo  $title_prod;?></h2>
            <p><?php echo  $exc_prod;?></p>
            <a href="<?php echo  $link_prod;?>"><?php _e('View products','arylex' );?></a>
        </div>
    </article>


    <article class="key-benefits page-content">
    	<?php
        	//Video de Key Benefits
			$title_vid_key=types_render_field("title-video-key-benefits",array("output"=>"raw"));
			$url_vid_key=types_render_field("url-video-key-benefits",array("output"=>"raw"));
		?>
        <h2><?php _e('Key Benefits','arylex' );?></h2>
        <div class="row">
            <div class="col-md-4 col-lg-3 nav">
                <ul>
                	<?php
						$cont=1;
						$args = array('post_type' => 'key-benefit');
						$new = new WP_Query($args);
						while ($new->have_posts()) : $new->the_post();
					?>
					  <li><a href="#key-<?php echo $cont;?>"><?php echo get_the_title();?></a></li>      
					<?php	
						$cont++;
						endwhile;
					?>  
                </ul>
            </div>
            <div class="col-md-6 content">
				<?php
					$args = array('post_type' => 'key-benefit');
					$new = new WP_Query($args);
					$cont=1;
					while ($new->have_posts()) : $new->the_post();
				?>
                  <div id="key-<?php echo $cont;?>">
                  	<h3><?php the_title();?></h3>
                  	<?php the_content();?>
                  </div>      
                <?php	
					$cont++;
					endwhile;
				?>
            </div>
            <div class="col-md-2 col-lg-3">
                <div class="video-arylex-attributes">
                    <a href="<?php echo $url_vid_key;?>" class="youtube-fullview">
                        <i class="icon-video"></i>
                        <?php echo $title_vid_key;?>
                    </a>
                </div>
            </div>
        </div>
    </article>

</main>
<?php
    endwhile; endif;wp_reset_query();
?>
<?php get_footer(); ?>
