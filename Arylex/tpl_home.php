<?php
/**
 * @template name: Home
 * @package WordPress
 * @subpackage Arylex_theme
 * @since Arylex Theme 1.0
 */
?>
<?php get_header(); ?>
	<div class="box-main">
    	<div class="left_box">
            <h3><?php echo types_render_field("title-top-box-home",array("output"=>"html"))?></h3>
            <p><?php echo types_render_field("content-top-box-home",array("output"=>"html"))?></p>
        </div>
        <div class="right_box">
        	<?php echo types_render_field("image-top-box-home",array("output"=>"normal","alt"=>"Texto alternativo"))?>
        </div>
    </div>
    <div class="box-main">
    	<div class="left_box">
         	<img src="<?php echo types_render_field("image-bottom-home-box",array("output"=>"raw"))?>">   
        </div>
        <div class="right_box">
        	<h3><?php echo types_render_field("title-bottom-home-box", array("output"=>"html"))?></h3>
            <p><?php echo types_render_field("content-bottom-home-box", array("output"=>"html"))?></p>	
        </div>
    </div>
    <!--Banner Products-->
    <div id="poducts_banner clear">
    	<h3></h3>
        <p></p>
        <a href="#"><?php _e('VIEW PRODUCTS','arylex' )?></a>
    </div>
    <!--Key Benefits-->
    <div class="box_KB">
    	<div class="left_box">
        	<!--Menús Key Benefits-->
            <h3></h3>
        </div>
        <div class="right_box">
        </div>
    </div>
<?php get_footer(); ?>