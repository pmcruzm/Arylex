<?php
/**
 * @template name: News&Views
 * @package WordPress
 * @subpackage Arylex_theme
 * @since Arylex Theme 1.0
 */
?>
<?php get_header(); ?>
<?php
   if ( have_posts() ) : while ( have_posts() ) : the_post();
		$thumb = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'thumbnail_size' );
		$cover_top = $thumb['0'];
?>
<header class="header-img" style="background-image:url(<?php echo $cover_top;?>)">
    <span class="furrows"></span>
    <div class="title-top">
        <h2><?php the_title();?></h2>
    </div>
</header>
<?php
    endwhile; endif;wp_reset_query();
?>

<main id="main" role="main" class="news">

    <article class="news-featured">
        <div class="row">
        	<?php
				$args = array('post_type' => 'post','order'=>'DESC','posts_per_page' => -1);
				$new = new WP_Query($args);
				$cont=1;
				$array_dest= array();
				while ($new->have_posts()) : $new->the_post();
					$thumb = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'thumbnail_size' );
					$cover_top = $thumb['0'];
					$destacado=types_render_field("highlight-post",array("output"=>"raw"));
					if($destacado==1){
						if($cont<4){
		     				if($cont==1){
			 ?>
             					<div class="col-md-8">
                                    <div class="news-item-featured-big" style="background-image:url(<?php echo $cover_top;?>)">
                                        <a href="<?php the_permalink(); ?>" class="gradient">
                                            <div class="content">
                                            	<?php
													$post_cat=get_the_category();
													$list_cat="";
													foreach($post_cat as $single_cat){
														$category_id = get_cat_ID($single_cat->name);
														$category_link = get_category_link( $category_id );
														$list_cat.=$single_cat->name.' - ';
													}
													echo '<p class="meta-category">'.substr($list_cat, 0, -1).'</p>';
												?>
                                                
                                                <h3><?php the_title();?></h3>
                                                <p><?php the_excerpt();?></p>
                                            </div>
                                        </a>
                                    </div>
                                </div>
             <?php
							}else{
								if($cont==2){	
			 ?>
             						<div class="col-md-4">
                                        <div class="news-item-featured-small" style="background-image:url(<?php echo $cover_top;?>)">
                                            <a href="<?php the_permalink(); ?>" class="gradient">
                                                <div class="content">
                                                    <?php
													$post_cat=get_the_category();
													$list_cat="";
													foreach($post_cat as $single_cat){
														$category_id = get_cat_ID($single_cat->name);
														$category_link = get_category_link( $category_id );
														$list_cat.=$single_cat->name.' - ';
													}
													echo '<p class="meta-category">'.substr($list_cat, 0, -3).'</p>';
												?>
                                                    <h3><?php the_title();?></h3>
                                                </div>
                                            </a>
                                        </div>
             <?php
								}else{
			?>
            						<div class="news-item-featured-small" style="background-image:url(<?php echo $cover_top;?>)">
                                        <a href="<?php the_permalink(); ?>" class="gradient">
                                            <div class="content">
                                                <?php
													$post_cat=get_the_category();
													$list_cat="";
													foreach($post_cat as $single_cat){
														$category_id = get_cat_ID($single_cat->name);
														$category_link = get_category_link( $category_id );
														$list_cat.=$single_cat->name.' - ';
													}
													echo '<p class="meta-category">'.substr($list_cat, 0, -3).'</p>';
												?>
                                                <h3><?php the_title();?></h3>
                                            </div>
                                        </a>
                                    </div>
                                </div>
            <?php					
								}
							}
						 $array_dest[]=$post->ID;
						 $cont++; 
						}
					}
			endwhile;
		?>  
        </div>
    </article>

    <article class="news-list" data-max-items="2" data-more-items="2">
        <div class="row">
            <div class="col-md-8">
                <div class="row">
                	<?php
						$args = array('post_type' => 'post','order'=>'DESC','posts_per_page' => -1,'post__not_in' =>$array_dest);
						$new = new WP_Query($args);
						$cont=0;
						$array_dest= array();
						while ($new->have_posts()) : $new->the_post();
							$thumb = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'thumbnail_size' );
							$cover_top = $thumb['0'];
							//the_post_thumbnail();
					 ?>
                     	<div class="col-sm-6">
                            <div class="news-item">
                                <a href="<?php the_permalink(); ?>"><img src="<?php echo $cover_top;?>" class="img-responsive center-block"></a>
                                <p class="meta-category">
                                	<?php
										$post_cat=get_the_category();
										$list_cat="";
										foreach($post_cat as $single_cat){
											$category_id = get_cat_ID($single_cat->name);
											$category_link = get_category_link( $category_id );
											$list_cat.='<a href="'.$category_link.'">'.$single_cat->name.'</a> - ';
										}
										echo substr($list_cat, 0, -3);
									?>
                                </p>
                                <h3><a href="<?php the_permalink(); ?>"><?php the_title();?></a></h3>
                                <p><?php the_excerpt();?></p>
                            </div>
                        </div>
					 <?php
					 	$cont++;
						if($cont%2==0 && $cont>0){echo '<div class="clearfix"></div>';}
					 	endwhile;
					 ?>  
                </div>
                <div class="load-more hidden">
                    <span><?php _e('LOAD MORE','arylex');?></span>
                </div>
            </div>
            <div class="col-md-4">

               <div class="mod-categories">
                    <h3><?php _e('CATEGORIES','arylex');?></h3>
                    <ul>
                    	<?php wp_list_categories('title_li=');?>
                    </ul>
                </div>

               <div class="mod-register">
                    <form class="bulletin-form" data-msg-success="<?php _e('Error!','arylex');?>" data-msg-error="<?php _e('Error!','arylex');?>" data-msg-error-email="<?php _e('Email ya suscrito!','arylex' );?>">
                        <h3><?php _e('BULLETIN','arylex' );?></h3>
                        <p><?php _e('Register here to get the latest news and opinions straight to your inbox','arylex');?></p>
                        <input type="text" name="email" data-error="<?php _e('El email no es válido','arylex' )?>">
                        <p class="errors"></p>
                        <div class="submit">
                            <input type="hidden" name="lang" value="<?php echo ICL_LANGUAGE_CODE;?>">
                            <input type="submit" class="submit" value="<?php _e('SUBSCRIBE','arylex' )?>">
                        </div>
                    </form>
                </div>


            </div>
        </div>
    </article>

</main>
<?php get_footer(); ?>