<?php 

function wpb_lastupdated_posts() { 

// Параметры запроса
$lastupdated_args = array(
	'post_type' => 'films',
'orderby' => 'modified',
'ignore_sticky_posts' => '1'
);

//Loop to display 5 recently updated posts
$lastupdated_loop = new WP_Query( $lastupdated_args );
$counter = 1;

while( $lastupdated_loop->have_posts() && $counter < 6 ) : $lastupdated_loop->the_post();
?>


<a href="<?php echo (get_post_permalink( $films->ID, false, true ));?>">
<h3><?php the_title(); ?></h3></a>
<div>
	<a href="' . get_permalink( $lastupdated_loop->post->ID ) . '"><? ' .get_the_title( $lastupdated_loop->post->ID ) . '?></a>
</div>
<div style="float:top; margin: 10px">
	<?php the_post_thumbnail( array(100,100) ); ?>
</div>
<div class="entry-content  ">
	<?php the_content(); ?>
</div>

<?$counter++;
endwhile; 

wp_reset_postdata(); 



 }

//add a shortcode
add_shortcode('lastupdated-posts', 'wpb_lastupdated_posts');









