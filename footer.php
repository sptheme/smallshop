<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package SmallShop
 */

?>
			<?php wpsp_hook_content_bottom(); ?>

		</div><!-- #content -->

		<?php wpsp_hook_content_after(); ?>

		<?php wpsp_hook_wrap_bottom(); ?>

	</div> <!-- #wrap -->
	
	<?php wpsp_hook_wrap_after(); ?>

</div><!-- #page -->

<?php wpsp_outer_wrap_after(); ?>

<?php wp_footer(); ?>

</body>
</html>
