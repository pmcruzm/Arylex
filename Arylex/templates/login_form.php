<?php if ( true ) : ?>
	<?php
	//Obtenemos datos de user-login 
	$args = array('post_type' => 'page','pagename' =>'user-login');
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
                        <h2><?php the_title();?></h2>
                        <p><?php the_excerpt();?></p>
                    </div>
                </div>
            </div>
        </div>
    </header>
    
    
    <main id="main" role="main">
    
        <article class="container">
            <div class="row">
                <div class="col-sm-6 col-sm-offset-3">
                    <form method="POST" action="<?php echo wp_login_url(); ?>" class="form-type" >
                        <legend><?php the_title();?></legend>
                        <!-- Show errors if there are any -->
						<?php if ( count( $attributes['errors'] ) > 0 ) : ?>
                            <?php foreach ( $attributes['errors'] as $error ) : ?>
                                <p class="login-error">
                                    <?php echo $error; ?>
                                </p>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    
                        <!-- Show logged out message if user just logged out -->
                        <?php if ( $attributes['logged_out'] ) : ?>
                            <p class="login-info">
                                <?php _e( 'You have signed out. Would you like to sign in again?', 'personalize-login' ); ?>
                            </p>
                        <?php endif; ?>
                    
                        <?php if ( $attributes['registered'] ) : ?>
                            <p class="login-info">
                                <?php
                                    printf(
                                        __( 'You have successfully registered to <strong>%s</strong>. We have emailed your password to the email address you entered.', 'personalize-login' ),
                                        get_bloginfo( 'name' )
                                    );
                                ?>
                            </p>
                        <?php endif; ?>
                    
                        <?php if ( $attributes['lost_password_sent'] ) : ?>
                            <p class="login-info">
                                <?php _e( 'Check your email for a link to reset your password.', 'personalize-login' ); ?>
                            </p>
                        <?php endif; ?>
                    
                        <?php if ( $attributes['password_updated'] ) : ?>
                            <p class="login-info">
                                <?php _e( 'Your password has been changed. You can sign in now.', 'personalize-login' ); ?>
                            </p>
                        <?php endif; ?>
                        <div>
                            <label for="user_login"><?php _e( 'Email', 'personalize-login' ); ?></label>
                            <input type="text" name="log" id="user_login">
                        </div>
                        <div>
                            <label for="user_pass"><?php _e( 'Password', 'personalize-login' ); ?></label>
                            <input type="password" name="pwd" id="user_pass">
                        </div>
                        <div class="legal">
                            <input type="checkbox" name="remember-me" id="login-remember">
                            <label for="login-remember"><?php _e( 'Remember me on this computer', 'personalize-login' ); ?></label>
                        </div>
                        <input type="hidden" name="lang" value="<?php echo ICL_LANGUAGE_CODE;?>">
                        <input type="submit" value="<?php _e( 'SIGN IN', 'personalize-login' ); ?>">
                        <div class="errors"></div>
                    </form>
    
                    <p><a href="<?php echo wp_lostpassword_url();?>"><?php _e( 'Forgot your password?', 'personalize-login' ); ?></a></p>
    
                </div>
            </div>
        </article>
    
    </main>
	<?php
    	endwhile; endif;wp_reset_query();
	?>
<?php else : ?>

	<?php
	//Obtenemos datos de user-login 
	$args = array('post_type' => 'page','pagename' =>'user-login');
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
                        <p><?php the_excerpt();?></p>
                    </div>
                </div>
            </div>
        </div>
    </header>
    
    
    <main id="main" role="main">
    
        <article class="container">
            <div class="row">
                <div class="col-sm-6 col-sm-offset-3">
                    <form method="POST" action="<?php echo wp_login_url(); ?>" class="form-type" >
                        <legend><?php the_title();?></legend>
                        <!-- Show errors if there are any -->
						<?php if ( count( $attributes['errors'] ) > 0 ) : ?>
                            <?php foreach ( $attributes['errors'] as $error ) : ?>
                                <p class="login-error">
                                    <?php echo $error; ?>
                                </p>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    
                        <!-- Show logged out message if user just logged out -->
                        <?php if ( $attributes['logged_out'] ) : ?>
                            <p class="login-info">
                                <?php _e( 'You have signed out. Would you like to sign in again?', 'personalize-login' ); ?>
                            </p>
                        <?php endif; ?>
                    
                        <?php if ( $attributes['registered'] ) : ?>
                            <p class="login-info">
                                <?php
                                    printf(
                                        __( 'You have successfully registered to <strong>%s</strong>. We have emailed your password to the email address you entered.', 'personalize-login' ),
                                        get_bloginfo( 'name' )
                                    );
                                ?>
                            </p>
                        <?php endif; ?>
                    
                        <?php if ( $attributes['lost_password_sent'] ) : ?>
                            <p class="login-info">
                                <?php _e( 'Check your email for a link to reset your password.', 'personalize-login' ); ?>
                            </p>
                        <?php endif; ?>
                    
                        <?php if ( $attributes['password_updated'] ) : ?>
                            <p class="login-info">
                                <?php _e( 'Your password has been changed. You can sign in now.', 'personalize-login' ); ?>
                            </p>
                        <?php endif; ?>
                        <div>
                            <label for="user_login"><?php _e( 'Email', 'personalize-login' ); ?></label>
                            <input type="text" name="log" id="user_login">
                        </div>
                        <div>
                            <label for="user_pass"><?php _e( 'Password', 'personalize-login' ); ?></label>
                            <input type="password" name="pwd" id="user_pass">
                        </div>
                        <div class="legal">
                            <input type="checkbox" name="remember-me" id="login-remember">
                            <label for="login-remember"><?php _e( 'Remember me on this computer', 'personalize-login' ); ?></label>
                        </div>
                        <input type="hidden" name="lang" value="<?php echo ICL_LANGUAGE_CODE;?>">
                        <input type="submit" value="<?php _e( 'SIGN IN', 'personalize-login' ); ?>">
                        <div class="errors"></div>
                    </form>
    
                    <p><a href="<?php echo wp_lostpassword_url(); ?>"><?php _e( 'Forgot your password?', 'personalize-login' ); ?></a></p>
    
                </div>
            </div>
        </article>
    
    </main>
	<?php
    	endwhile; endif;wp_reset_query();
	?>
<?php endif; ?>
