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
	//Obtenemos info de Legal Terms
	//$page = get_page_by_title( 'Legal Terms' );
	$page = get_posts( array('name'=> 'legal-terms','post_type' => 'page'));
	$id_page=apply_filters( 'wpml_object_id', $page[0]->ID, 'attachment', FALSE, ICL_LANGUAGE_CODE);
	$post = get_post($id_page);
	$url_page=get_permalink($post->ID);
?>
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
                <div class="col-md-8 col-lg-7">
                    <h2><?php the_title();?></h2>
                    <?php the_content();?>
                </div>
            </div>
        </div>
    </div>
</header>
<?php
    endwhile; endif;wp_reset_query();
?>
<main id="main" role="main">

    <article class="container">
        <div class="row">
            <div class="col-sm-6">

                <form method="POST" action="" class="form-type" data-validate="true" data-msg-success="<?php _e('Success!','arylex');?>" data-msg-error="<?php _e('Error!','arylex' )?>Error!">
                    <legend><?php _e('Contact us','arylex');?></legend>
                    <div>
                        <label for="contact-name" class="required"><?php _e('Name','arylex' )?></label>
                        <input type="text" name="name" id="contact-name" data-validation="not-empty" data-error-msg="<?php _e('Enter name','arylex');?>">
                    </div>
                    <div>
                        <label for="contact-email" class="required"><?php _e('Email Address','arylex' )?></label>
                        <input type="email" name="email" id="contact-email" data-validation="email" data-error-msg="<?php _e('Email is not valid','arylex');?>">
                    </div>
                    <div>
                        <label for="contact-email-repeat" class="required"><?php _e('Confirm email','arylex' )?></label>
                        <input type="email" name="email-check" id="contact-email-repeat" data-validation="repeat" data-repeat-field="#contact-email" data-error-msg="<?php _e('Email does not match','arylex');?>">
                    </div>
                    <div>
                        <label for="contact-telephone"><?php _e('Telephone','arylex');?></label>
                        <input type="text" name="telephone" id="contact-telephone">
                    </div>
                    <p class="hint-required"><?php _e('* Required','arylex');?></p>
                    <legend><?php _e('Please choose a subject and write your question','arylex');?></legend>
                    <div>
                        <select id="subjet" class="selectpicker" name="subjet" data-validation="select" data-error-msg="<?php _e('Choose a subject','arylex');?>">
                            <option value=""><?php _e('Choose one of this options','arylex');?></option>
                            <?php
								$args = array('post_type' => 'contact-subject');
								$new = new WP_Query($args);
								while ($new->have_posts()) : $new->the_post();
							?>
								<option value="<?php the_title();?>"><?php the_title();?></option>
							<?php
								endwhile;
							?>
                        </select>
                    </div>
                    <div>
                        <label for="contact-question"><?php _e('Question','arylex');?></label>
                        <textarea id="contact-question" name="question"></textarea>
                    </div>
                    <div class="legal">
                        <input type="checkbox" name="bbll" id="contact-legal-check" data-validation="checkbox" data-error-msg="<?php _e('Must accept legal terms','arylex');?>">
                        <label for="contact-legal-check"><a href="<?php echo $url_page;?>" target="_blank"><?php _e('Accept legal terms','arylex');?></a></label>
                    </div>
                    <input type="hidden" name="language" value="<?php echo ICL_LANGUAGE_CODE;?>">
                    <input type="submit" value="<?php _e('SEND QUESTION','arylex');?>">
                    <div class="errors"></div>
                </form>

            </div>
        </div>
    </article>

</main>
<?php get_footer(); ?>