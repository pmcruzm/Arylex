<?php get_header(); ?>
    <div class="error404 clear">
        <div class="error404_meta">ERROR 404</div>
        <div class="error404_text">
            <p>La página <span><?php echo $_SERVER['REQUEST_URI']; ?></span> no se ha localizado.<br/>Recomendamos utilizar la barra de menús para navegar por el site.<br/>¡Gracias!</p>
            <a href="<?php bloginfo('home'); ?>" class="error404_back">Volver a la página principal</a>
        </div>
    </div>
<?php get_footer(); ?>
