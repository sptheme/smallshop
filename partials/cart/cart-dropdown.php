<?php
/**
 * Header cart dropdown
 *
 * @package Small_Shop
 */ ?>

<div id="current-shop-items-dropdown" class="clear">

	<div id="current-shop-items-inner" class="clear">

		<?php
		// Display WooCommerce cart
		the_widget( 'WC_Widget_Cart' ); ?>

	</div><!-- #current-shop-items-inner -->
	
</div><!-- #current-shop-items-dropdown -->