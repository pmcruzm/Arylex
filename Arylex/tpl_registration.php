<?php
/**
 * @template name: Registration
 * @package WordPress
 * @subpackage Arylex_theme
 * @since Arylex Theme 1.0
 */
?>
<?php get_header(); ?>
	<?php // if (!is_user_logged_in()) { ?>
        <div class="box_registration">
        	<p></p>
            <form id="form-registration">
               <div><label for="password">Password</label> <input name="password" id="password" type="password" /></div>
               <div><label for="rep_password">Repeat Password</label> <input name="rep_password" id="rep_password" type="password" /></div>
               <input type="hidden" name="hash" id="hash" value="<?php $_GET['hash'];?>">
               <input class="right inputnew" type="submit" title="Send" value="Send" />
           </form>
        </div>
    <?php
	//}else{
	?>
   		<h4>El usuario ya está registrado</h4>
    <?php
	//}
	?>
<?php get_footer(); ?>