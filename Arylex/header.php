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
                <!--Texto cabecera-->
                <p></p>
                <!--Enlace video cabecera-->
                
            </div>
        </div>
        <!--Fin Cabecera-->
        <!--Cuerpo-->
        <div id="cuerpo">
        	<div class="contenedor">