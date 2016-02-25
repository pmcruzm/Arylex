<?php
/**
 * @template name: Login
 * @package WordPress
 * @subpackage Arylex_theme
 * @since Arylex Theme 1.0
 */
?>
<?php get_header(); ?>
	<?php if (!is_user_logged_in()) { ?>
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
   		<h4>El usuario ya está registrado</h4>
    <?php
	}
	?>
<?php get_footer(); ?>