			</div>
        </div>
        <!--Fin Cuerpo-->
        <!--Pie-->
        <div id="pie">
        	<div class="contenedor">
             	<div id="menu_bottom">
                	<?php wp_nav_menu(array('menu' => 'Main_menu', 'theme_location' => 'Main_menu', 'depth' => 1, 'container' => 'false','menu_class' => 'mobile_menu_list')); ?>
                </div>
                <div class="search_bottom">
                	<?php get_search_form(); ?>
                </div>
                <div class="left_bottom_box">
                	<div class="box_bulletin">
                    	
                    </div>
                    <div class="box_rrss">
                    	<p><?php _e('Follow us','arylex' )?></p>	
                        <ul>
                        	<li><a href="#" target="_blank">Twitter</a></li>
                            <li><a href="#" target="_blank">Facebook</a></li>
                            <li><a href="#" target="_blank">Youtube</a></li>
                            <li><a href="#" target="_blank">Linkedin</a></li>
                    	</ul>
                    </div>
                </div>
                <p><?php _e('Copyright 2016','arylex' )?></p>
            </div>   
        </div>
	</div><!--Fin wrapper-->   
    <?php wp_footer(); ?> 
</body>
</html>