<?php get_header(); ?>
<?php
      if ( have_posts() ) : while ( have_posts() ) : the_post();
?>
<div class="page-content">
	<?php the_content();?>
</div>	
<?php
       endwhile; endif;wp_reset_query();
?>
<?php get_footer(); ?>
