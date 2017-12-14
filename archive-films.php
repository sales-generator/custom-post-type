<?php

/* 
Template Name: archive-films
*/


get_header(); ?>
<?ad_block();?><!-- хук рекламного блока -->

	
		<main id="main" class="site-main" role="main">

		<?php if ( have_posts() ) : ?>

			<header class="page-header">
				<?php
					the_archive_title( '<h1 class="page-title">', '</h1>' );
					the_archive_description( '<div class="taxonomy-description">', '</div>' );
				?>
			</header><!-- .page-header -->

			<?php /* Start the Loop */ ?>
			<?php while ( have_posts() ) : the_post(); ?>
			
				<a href="<?php echo (get_post_permalink( $films->ID, false, true ));?>">
				<h2><?php the_title(); ?></h2></a>

				<div style="float:top; margin: 10px">
					<?php the_post_thumbnail( array(100,100) ); ?>
				</div>
				<p><b>Дата выхода: </b><?php echo ( get_post_meta( get_the_ID(), 'dateRelise', true ) ); ?></p>
				<div class="entry-content">
					<?php the_content(); ?>
				</div>
			
	
			<?php endwhile; ?>
			
			<!-- <?php unite_paging_nav(); ?> -->

		<?php else : ?>

			

		<?php endif; ?>


		</main><!-- #main -->

<hr/>

			<?ad_block();?><!-- хук рекламного блока -->
<?php get_footer(); ?>
