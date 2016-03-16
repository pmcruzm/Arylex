<?php
/**
 * @template name: Registration
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
            <div class="col-sm-6 col-sm-offset-3">
				<?php
                    //Obtener el rol del usuario
                    $info_user=get_user_by( 'login',$_GET['user']);
                	if (!is_user_logged_in()) { 
                        if(!empty( $info_user->roles) && $info_user->roles[0]=='new_user_init'){
                ?>
                <form id="form-registration" class="form-type">
                    <legend><?php the_title();?></legend>
                    <div>
                        <label for="reset-password"><?php _e('New password','arylex' )?></label>
                        <input type="password" name="password" id="reset-password">
                    </div>
                    <div>
                        <label for="reset-password-confirm" class="required"><?php _e('Repeat new password','arylex' )?></label>
                        <input type="password" name="password-repeat" id="reset-password-confirm">
                    </div>
                    <p><?php _e('HINT: The password should be al least twelve characters long. To make it stronger, use upper and lower case letters, numbers, and symbols like ! " ? $ % ^ & ).','arylex' )?></p>
                    <input type="hidden" name="user" id="user" value="<?php echo $_GET['user'];?>">
                    <input type="submit" value="<?php _e('SEND','arylex' )?>">
                    <div class="errors"></div>
                </form>
                <?php
                		}
					}else{
						_e('You are already signed in.','arylex' );
					}
				?>

            </div>
        </div>
    </article>

</main>
<?php
    endwhile; endif;wp_reset_query();
?>
<?php get_footer(); ?>