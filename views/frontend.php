<?php
/**
 * Frontend view
 * @package TM_Posts_Widget
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}
?>
<!-- Swiper -->
<div class="swiper-container tm-post-carousel-widget">
	<h2><?php echo $title ?></h2>
	<div class="swiper-wrapper">
		<?php while ( $query->have_posts() ) : ?>
		<?php $query->the_post(); ?>
			<?php $images = wp_get_attachment_image_src( get_post_thumbnail_id(),'medium', true ) ?>
			<div class="swiper-slide" style="background: url(<?php echo $images[0] ?>) no-repeat; background-size: contain;">
				<a href="<?php echo get_the_permalink() ?>">
					<h4><?php echo get_the_title() ?></h4>
					<div class="slider-description">
						<?php echo wp_trim_words( get_the_excerpt(), $length ) ?>
					</div>
				</a>
			</div>
		<?php endwhile; ?>
	</div>
	<!-- Add Pagination -->
	<div class="swiper-pagination"></div>
</div>
