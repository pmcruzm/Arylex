<?php
	//Obtenemos datos de user-login 
	$args = array('post_type' => 'page','pagename' =>'user-password-reset');
	query_posts($args);
	if ( have_posts() ) : while ( have_posts() ) : the_post();
	$cover_top = get_the_post_thumbnail_url(); 
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
            <div class="col-sm-6 col-sm-offset-3">
                <form name="resetpassform" id="resetpassform" action="<?php echo site_url( 'wp-login.php?action=resetpass' ); ?>" method="post" autocomplete="off" class="form-type">
                    <legend><?php the_title();?></legend>
                    <input type="hidden" id="user_login" name="rp_login" value="<?php echo esc_attr( $attributes['login'] ); ?>" autocomplete="off" />
					<input type="hidden" name="rp_key" value="<?php echo esc_attr( $attributes['key'] ); ?>" />
                    <?php if ( count( $attributes['errors'] ) > 0 ) : ?>
						<?php foreach ( $attributes['errors'] as $error ) : ?>
                            <p>
                                <?php echo $error; ?>
                            </p>
                        <?php endforeach; ?>
                    <?php endif; ?>
                    <div>
                        <label for="pass1"><?php _e( 'New password', 'personalize-login' ) ?></label>
                        <input type="password" name="pass1" id="pass1" class="input" value="" autocomplete="off">
                    </div>
                    <div>
                        <label for="pass2" class="required"><?php _e( 'Repeat new password', 'personalize-login' ) ?></label>
                        <input  type="password" name="pass2" id="pass2" class="input" value="" autocomplete="off">
                    </div>
                    <p><?php echo wp_get_password_hint(); ?></p>
                    <input type="hidden" name="lang" value="<?php echo ICL_LANGUAGE_CODE;?>">
                    <input type="submit" value="<?php _e( 'RESET PASSWORD ', 'personalize-login' ); ?>">
                    <div class="errors"></div>
                </form>

            </div>
        </div>
    </article>

</main>
<?php
    endwhile; endif;wp_reset_query();
?>