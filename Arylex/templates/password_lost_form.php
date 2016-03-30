<?php
	//Obtenemos datos de user-password-lost 
	$args = array('post_type' => 'page','pagename' =>'user-password-lost');
	query_posts($args);
	if ( have_posts() ) : while ( have_posts() ) : the_post();
	//$thumb = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'thumbnail_size' );
	$cover_top = get_the_post_thumbnail_url(); 
?>	
<header class="header-img" style="background-image:url(<?php echo $cover_top;?>)">
    <span class="furrows"></span>
    <div class="highlight">
        <div class="container">
            <div class="row">
                <div class="col-md-8">
                    <h2><?php _e( 'Forgot password', 'personalize-login' ); ?></h2>
                </div>
            </div>
        </div>
    </div>
</header>


<main id="main" role="main">

    <article class="container">
        <div class="row">
            <div class="col-sm-6 col-sm-offset-3">
                <form id="lostpasswordform" action="<?php echo wp_lostpassword_url(); ?>" method="POST" class="form-type" >
                    <legend><?php _e( 'Forgot password', 'personalize-login' ); ?></legend>
                    <p><?php _e("Enter your email address and we'll send you a link you can use to pick a new password.", 'personalize-login' ); ?></p>
                    <?php if ( count( $attributes['errors'] ) > 0 ) : ?>
						<?php foreach ( $attributes['errors'] as $error ) : ?>
                            <p>
                                <?php echo $error; ?>
                            </p>
                        <?php endforeach; ?>
                    <?php endif; ?>
                    <div>
                        <label for="user_login"><?php _e( 'Email', 'personalize-login' ); ?></label>
						<input type="text" name="user_login" id="user_login">
                    </div>
                    <input type="hidden" name="lang" value="<?php echo ICL_LANGUAGE_CODE;?>">
                    <input type="submit" name="submit" class="lostpassword-button" value="<?php _e( 'RESET PASSWORD', 'personalize-login' ); ?>"/>
                    <div class="errors"></div>
                </form>

            </div>
        </div>
    </article>

</main>
<?php
    	endwhile; endif;wp_reset_query();
?>