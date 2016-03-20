<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta content="IE=10" http-equiv="X-UA-Compatible">
    <meta name="viewport" content="initial-scale=1.0, width=device-width">
    <title><?php wp_title(); ?></title>

    <link rel="shortcut icon" href="<?php bloginfo('template_url'); ?>/img/favicon.png">
	<?php if ( is_singular() && pings_open( get_queried_object() ) ) : ?>
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
    
	<?php endif; ?>
    <!--[if lte IE 8]>
        <script src="<?php bloginfo('template_url'); ?>/js/respond.min.js"></script>
    <![endif]-->
	
	<?php wp_head(); ?>
</head>
<body data-lang="<?php echo ICL_LANGUAGE_CODE;?>">

    <header class="header-nav">
        <div class="container">

            <div class="logo-top">
                <span class="menu-toggle"><?php _e('Menu','arylex' )?></span>
                <h1><a href="<?php echo esc_url( home_url( '/' ) ); ?>" style="background-image:url('<?php bloginfo('template_url'); ?>/img/logo.png');"><?php _e('Arylex Active','arylex' )?></a></h1>
            </div>

            <nav class="nav-main" role="navigation">
            	<?php wp_nav_menu(array('menu' => 'Main_menu', 'theme_location' => 'Main_menu', 'depth' => 1, 'container' => 'false')); ?> 
            </nav>

            <?php get_search_form(); ?>	

            <nav class="nav-top" role="navigation">
                <ul>
                    <li class="global">
                        <a href="http://www.dowagro.com" target="_blank"><?php _e('Dow AgroSciences Global','arylex' )?></a>
                    </li>
                    <li class="login">
                    <?php if (!is_user_logged_in()) { ?>
					<?php
                        //Obtenemos datos de productos 
                        $args = array('post_type' => 'page','pagename' =>'user-login');
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
                        <a href="<?php echo wp_logout_url(home_url());?>"><?php _e('Log Out','arylex' )?></a>	
                    <?php		
                        }	
                    ?>
                    </li>
                    <li class="language"><a href="#"><?php echo ICL_LANGUAGE_NAME;?></a>
                        <?php
                        $languages = icl_get_languages('skip_missing=0&orderby=code');
                        if(!empty($languages)){
                            echo '<ul class="hidden">';
                            foreach($languages as $l){
                                 if(ICL_LANGUAGE_NAME!=$l['native_name']){
									 echo '<li>';
                                     echo '<a href="'.$l['url'].'">';
									 echo icl_disp_language($l['native_name']);
                                     echo '</a>';
									 echo '</li>';
                                }
                            }
                            echo '</ul>';
                        }
						?>
                    </li>
                </ul>
            </nav>

        </div>

    </header>


    <div id="wrap">