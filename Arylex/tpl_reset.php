<?php
/**
 * @template name: Reset Password
 * @package WordPress
 * @subpackage Arylex_theme
 * @since Arylex Theme 1.0
 */
?>
<?php get_header(); ?>
	<?php if (!is_user_logged_in()) { ?>
        <div class="box_reset">
            <form id="form-reset">
               <div><label for="username">Username or email</label> <input name="username" id="username" type="text" /></div>
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