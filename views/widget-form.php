<?php
/**
 * Admin view
 * @package TM_Posts_Widget
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

?>

<div class="tm-post-slider-form-widget">
	<p>
		<?php echo $title_html ?>
	</p>

	<p>
		<label for="categories"><?php _e( 'Category', PHOTOLAB_BASE_TM_ALIAS ) ?></label>
		<?php echo $categories_html ?>
	</p>

	<p>
		<?php echo $count_html ?>
	</p>

	<p>
		<?php echo $slides_per_view_html ?>
	</p>

	<p>
		<?php echo $length_html ?>
	</p>

	<p>&nbsp;</p>
</div>
