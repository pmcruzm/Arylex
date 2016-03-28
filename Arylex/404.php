<?php get_header(); ?>
<header class="header-img" style="background-image:url('<?php bloginfo('template_url'); ?>/img/header-7.jpg');">
    <span class="furrows"></span>
    <div class="highlight">
        <div class="container">
            <div class="row">
                <div class="col-md-8">
                    <h2><?php _e('Can’t find that page','arylex');?></h2>
                </div>
            </div>
        </div>
    </div>
</header>


<main id="main" role="main">

    <article class="container">
    	<p><?php _e( 'Sorry, there’s no content on this address, visit the <a href="'.esc_url( home_url( '/' ) ).'">homepage</a> or try a search on the top', 'arylex' ); ?></p>
    </article>

</main>
<?php get_footer(); ?>
