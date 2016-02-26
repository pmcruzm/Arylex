<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="http://gmpg.org/xfn/11">
     
    <!--Favicon-->
    <link rel="shortcut icon" href="<?php bloginfo('template_url'); ?>/img/favicon.ico" type="image/x-icon"/>
    <link rel="icon" href="<?php bloginfo('template_url'); ?>/img/favicon.ico" type="image/x-icon"/>
    
	<?php if ( is_singular() && pings_open( get_queried_object() ) ) : ?>
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
	<?php endif; ?>
	<?php wp_head(); ?>
</head>
  <body>
  	<div id="wrapper">
    	<!--Cabecera-->
    	<div id="cabecera">
        	<div class="contenedor">
            	<div id="logo_top">
                	<a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php _e('Arylex Active','arylex' )?></a>
                </div>
            	<div id="menu_top">
                	<?php wp_nav_menu(array('menu' => 'Main_menu', 'theme_location' => 'Main_menu', 'depth' => 1, 'container' => 'false','menu_class' => 'mobile_menu_list')); ?>   
                </div>
                <div class="group_top">
                	<!--Selector de Idioma-->
                    <!--Enlace de Login-->
                    <div class="search_box">
                    	<?php get_search_form(); ?>	
                    </div>
                </div>
                <!--Enlace de login-->
                <div class="head_login">
                <?php if (!is_user_logged_in()) { ?>
                <?php
					//Obtenemos datos de productos 
					$args = array('post_type' => 'page','pagename' =>'login');
					query_posts($args);
					if ( have_posts() ) : while ( have_posts() ) : the_post();
				?>
					<a href="<?php echo get_the_permalink();?>"><?php _e('Login','arylex' )?></a>
				<?php	
                    endwhile; endif;wp_reset_query();
				?> 
                <?php
					}else{
						global $current_user;
                        get_currentuserinfo();
				?>
                	<p>Wellcome <?php echo $current_user->user_firstname.' '.$current_user->user_lastname.'!';?></p>
                    <p><a href="<?php echo wp_logout_url(home_url());?>"><?php _e('Close Session','arylex' )?></a></p>		
                <?php		
					}	
				?>
                </div> 
                <!--Selector de idioma-->
                <?php do_action('wpml_add_language_selector'); ?>   
            </div>
        </div>
        <!--Fin Cabecera-->
        <!--Cuerpo-->
        <div id="cuerpo">
        	<div class="contenedor">