<?php
/**
 * The template for displaying services posts on the front page
 *
 * @package Blakely
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<div class="hentry-inner">
		<?php blakely_post_thumbnail( array(80, 80), 'html', true, false ); ?>

		<div class="entry-container">
			<header class="entry-header">
				<?php the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">','</a></h2>' ); ?>
			</header>

			<?php
			$excerpt = get_the_excerpt();

			echo '<div class="entry-summary"><p>' . $excerpt . '</p></div><!-- .entry-summary -->';
			 ?>
		</div><!-- .entry-container -->
	</div> <!-- .hentry-inner -->
</article> <!-- .article -->
