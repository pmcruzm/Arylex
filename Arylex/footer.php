        <footer class="footer">
            <div class="container">
                <div class="row">

                    <div class="col-sm-7 col-sm-push-5">
                        <nav class="nav-footer">
                            <?php wp_nav_menu(array('menu' => 'Main_menu', 'theme_location' => 'Main_menu', 'depth' => 1, 'container' => 'false')); ?> 
                        </nav>

                        <?php get_search_form(); ?>	

                    </div>

                    <div class="col-sm-5 col-sm-pull-7">
                        <p><?php _e('Bulletin','arylex' )?></p>
                        <form class="bulletin-form" data-msg-success="<?php _e('Thanks for subscribing!','arylex');?>" data-msg-error="<?php _e('Error!','arylex');?>" data-msg-error-email="<?php _e('That email is already subscribed.','arylex' );?>">
                            <input type="text" name="email" id="email" class="email-field" data-error="<?php _e('Email is invalid','arylex');?>">
                            <input type="hidden" name="lang" value="<?php echo ICL_LANGUAGE_CODE;?>">
                            <button type="submit" class="bulletin-submit"><?php _e('Subscribe','arylex' )?></button>
                            <div class="errors"></div>
                        </form>
                        <br>

                        <p><?php _e('Follow us','arylex' )?></p>
                        <ul class="rrss">
                            <li><a href="https://twitter.com/dowagroeu" target="_blank" class="twitter">Twitter</a></li>
                            <li><a href="https://www.facebook.com/DowAgroSciencesEU" target="_blank" class="facebook">Facebook</a></li>
                            <li><a href="https://www.youtube.com/user/DowAgroSciences" target="_blank" class="youtube">Youtube</a></li>
                            <li><a href="https://www.linkedin.com/company/arylex%E2%84%A2-active" target="_blank" class="linkedin">LinkedIn</a></li>
                        </ul>
                    </div>

                </div>

                <div class="copyright">
                    <span class="logo-footer logo-dow"><?php _e('DOW','arylex' );?></span>
                    <span class="logo-footer logo-solutions"><?php _e('Solutions for the Growing World','arylex' );?></span>
                    	<?php
							//Obtenemos datos de productos 
							$page = get_posts( array('name'=> 'legal-terms','post_type' => 'page'));
							$id_page=apply_filters( 'wpml_object_id', $page[0]->ID, 'attachment', FALSE, ICL_LANGUAGE_CODE);
							$post = get_post($id_page);
							$title_term=$post->post_title;
							$link_term=get_permalink($post->ID);
						?> 	
                    	<span><?php _e('Copyright © The Dow Chemical Company (1995-2016). All Rights Reserved. ®™ Trademark of The Dow Chemical Company ("Dow") or an affiliated company of Dow','arylex' );?> <a href="<?php echo $link_term;?>"><?php echo $title_term;?></a></span>
                </div>

            </div>
        </footer>
		<script type="text/javascript"> 
		ajaxurl = '<?php $aux=admin_url( 'admin-ajax.php');echo $aux; ?>';
    	</script>
        <script>
		  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
		  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
		  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
		  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');
		
		  ga('create', 'UA-75705950-1', 'auto');
		  ga('send', 'pageview');
		
		</script>
    </div>
	<?php wp_footer(); ?> 
</body>
</html>