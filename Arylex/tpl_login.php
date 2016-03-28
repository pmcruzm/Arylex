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
               <div><label for="username"><?php _e('Username','arylex' )?></label> <input name="username" id="username" type="text" /></div>
               <div><label for="password"><?php _e('Password','arylex' )?></label> <input name="password" id="password" type="password" /></div>
               <?php wp_nonce_field( 'ajax-login-nonce', 'security' ); ?>
               <input class="right inputnew" type="submit" title="Send" value="<?php _e('SEND','arylex' )?>" />
           </form>
           <a href="<?php echo wp_lostpassword_url(); ?>" class="new_password"><?php _e('Reset Password','arylex' )?></a>
        </div>
        <?php
        /*$args = array(
			//'redirect' => admin_url(), 
			'form_id' => 'loginform-custom',
			'label_username' => __( 'Username custom text' ),
			'label_password' => __( 'Password custom text' ),
			'label_remember' => __( 'Remember Me custom text' ),
			'label_log_in' => __( 'Log In custom text' ),
			'remember' => true
		);
		wp_login_form( $args );*/
		?>
    <?php
	}else{
	?>
   		<h4><?php _e('You are already signed in.','arylex' )?></h4>
    <?php
	}
	?>
<?php get_footer(); ?>