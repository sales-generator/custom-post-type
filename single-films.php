<?php
/*
Template Name: single-films
*/

get_header(); ?>

<div id="primary">
	<div id="content" role="main">
	<!-- Cycle through all posts -->
	<?php while ( have_posts() ) : the_post(); ?>
		<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
			<header class="entry-header">

				<!-- Display featured image in right-aligned floating div -->
				
		
				<h1><?php the_title(); ?></h1>
				
				<div style="float:top; margin: 10px">
					<?php the_post_thumbnail( array(200,200) ); ?>
				</div>

			</header>
			<!-- контент область -->
			<div class="entry-content"><?php the_content(); ?>

							
			<p><?php the_terms( $films->ID, 'genres', 'Жанр: '); ?></p>
			<p><?php the_terms( $films->ID, 'countries', 'Страна: '); ?></p>
			<p><?php the_terms( $films->ID, 'year', 'Год выхода: '); ?></p>
			<p><?php the_terms( $films->ID, 'actors', 'Актеры: '); ?></p>



				<p><b>Стоимость: </b><?php echo ( get_post_meta( get_the_ID(), 'price', true ) ); ?> </p>
							
				<p><b>Дата выхода в прокат: </b><?php echo ( get_post_meta( get_the_ID(), 'dateRelise', true ) ); ?></p>

			


			</div>
<!-- 
			<footer class="entry-meta">	
			</footer>
 -->

<?php endwhile; ?>
		</article>

		<hr/>
	
	</div>
</div>
<?php wp_reset_query(); ?>
<?php get_footer(); ?>
<?


/*
get_header(); ?>

<div class="content-main">

  <div class="content">
    <div id="page">

      <?php  ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
      <h1 class="post-title"><?php the_title(); ?></h1>
      <div class="post-text"><?php the_content(); ?></div>

      <?php endwhile; ?>

    
    </div>
  </div>

  <?php get_sidebar(); ?>

</div>

<?php get_footer(); ?>*/