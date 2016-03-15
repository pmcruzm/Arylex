        <footer class="footer">
            <div class="container">
                <div class="row">

                    <div class="col-sm-7 col-sm-push-5">
                        <nav class="nav-footer">
                            <ul>
                                <li><a href="home.html">Arylex Active</a></li>
                                <li><a href="dow.html">Dow AgroSciences</a></li>
                                <li><a href="news.html">News &amp; Views</a></li>
                                <li><a href="products.html">Products</a></li>
                                <li><a href="faqs.html">FAQ</a></li>
                                <li><a href="contact.html">Contact</a></li>
                            </ul>
                        </nav>

                        <?php get_search_form(); ?>	

                    </div>

                    <div class="col-sm-5 col-sm-pull-7">
                        <p><?php _e('Bulletin','arylex' )?></p>
                        <form class="bulletin-form" data-msg-success="<?php _e('Éxito!','arylex' )?>" data-msg-error="<?php _e('Error!','arylex' )?>" data-msg-error-email="<?php _e('Email ya suscrito!','arylex' )?>">
                            <input type="text" name="email" id="email" class="email-field" data-error="<?php _e('El email no es válido','arylex' )?>">
                            <input type="hidden" name="lang" value="<?php echo ICL_LANGUAGE_CODE;?>">
                            <button type="submit" class="bulletin-submit"><?php _e('Subscribe','arylex' )?></button>
                        </form>
                        <br>

                        <p><?php _e('Follow us','arylex' )?></p>
                        <ul class="rrss">
                            <li><a href="https://twitter.com/dowagroeu" target="_blank" class="twitter">Twitter</a></li>
                            <li><a href="https://www.facebook.com/DowAgroSciencesEU" target="_blank" class="facebook">Facebook</a></li>
                            <li><a href="#" target="_blank" class="youtube">Youtube</a></li>
                            <li><a href="https://www.linkedin.com/company/arylex%E2%84%A2-active" target="_blank" class="linkedin">LinkedIn</a></li>
                        </ul>
                    </div>

                </div>

                <div class="copyright">
                    <img src="<?php bloginfo('template_url'); ?>/img/logo-dow.png" alt="<?php _e('DOW','arylex' )?>">
                    <img src="<?php bloginfo('template_url'); ?>/img/logo-solutions.png" alt="<?php _e('Solutions for the Growing World','arylex' )?>">
                    <span><?php _e('Copyright © The Dow Chemical Company (1995-2016). All Rights Reserved. ®™ Trademark of The Dow Chemical Company ("Dow") or an affiliated company of Dow','arylex' )?></span>
                </div>

            </div>
        </footer>
		<script type="text/javascript"> 
		ajaxurl = '<?php $aux=admin_url( 'admin-ajax.php');echo $aux; ?>';
    	</script>
    </div>
	<?php wp_footer(); ?> 
</body>
</html>