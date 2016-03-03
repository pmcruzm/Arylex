<?php
/**
 * @template name: Contact
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
    <div class="form-contact">
   		 <form id="form-contact" data-error-msg="<?php _e('Ha habido un error, por favor revisa los campos resaltados','arylex' )?>">
            <div><label for="name"><?php _e('Name *','arylex' )?></label> <input name="name" id="name" class="validation-rule-empty" type="text" /></div>
            <div><label for="email"><?php _e('Email Address *','arylex' )?></label> <input name="email" id="email" class="validation-rule-email-rep"  type="email" /></div>
            <div><label for="rep_email"><?php _e('Confirm email *','arylex' )?></label> <input name="rep_email" id="rep_email" class="validation-rule-email-rep"  type="email" /></div>
            <div><label for="telephone"><?php _e('Telephone *','arylex' )?></label> <input name="telephone" id="telephone" class="validation-rule-phone"  type="text" /></div>
            <div><label for="subjet"><?php _e('Subject *','arylex' )?></label>
            <select id="subjet" class="validation-rule-select" name="subjet" data-error-msg="<?php _e('Debe seleccionar un asunto.','arylex' )?>">
            	<option value="-1">Choose one of this options</option>
            	<option value="option 1" data-mail="">Option 1</option>
                <option value="option 2" data-mail="">Option 2</option>
                <option value="option 3" data-mail="">Option 3</option>
            </select></div>
            <div><label for="question"><?php _e('Question *','arylex' )?></label>
            <textarea id="question" name="question" class="validation-rule-empty"></textarea></div>
            <input type="checkbox" name="bbll" id="bbll" class="validation-rule-checkbox" data-error-msg="<?php _e('Debe aceptar política de privacidad.','arylex' )?>"><label for="bbll"><?php _e('Accept legal terms','arylex' )?></label>
            <input type="hidden" name="language" id="language" value="<?php echo ICL_LANGUAGE_CODE;?>">
            <div class="errores"></div>
            <input class="right inputnew" type="submit" value="<?php _e('SEND QUESTION','arylex' )?>" />
         </form> 
    </div>
<?php get_footer(); ?>