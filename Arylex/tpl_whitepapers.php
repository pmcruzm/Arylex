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
    <?php if (!is_user_logged_in()) { ?>
    	<p>Necesitas estar logado para acceder a esta sección!!</p>
        <div class="box_login">
            <form id="form-login">
               <div><label for="username">Username</label> <input name="username" id="username" type="text" /></div>
               <div><label for="password">Password</label> <input name="password" id="password" type="password" /></div>
               <?php wp_nonce_field( 'ajax-login-nonce', 'security' ); ?>
               <input class="right inputnew" type="submit" title="Send" value="Send" />
           </form>
           <a href="<?php echo wp_lostpassword_url(); ?>" class="new_password"><?php _e('Reset Password','arylex' )?></a>
        </div>
    <?php
	}else{
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
    <?php
	}
	?>      
<?php get_footer(); ?>