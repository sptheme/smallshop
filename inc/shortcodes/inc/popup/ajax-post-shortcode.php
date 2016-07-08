<?php

add_action('wp_ajax_wpsp_post_shortcode_ajax', 'wpsp_post_shortcode_ajax' );

function wpsp_post_shortcode_ajax(){
	$defaults = array(
		'post' => null
	);
	$args = array_merge( $defaults, $_GET );
	?>

	<div id="sc-post-form">
			<table id="sc-post-table" class="form-table">
				<tr>
					<?php $field = 'term_id'; ?>
					<th><label for="<?php echo $field; ?>"><?php _e( 'Select category: ', 'smallshop' ); ?></label></th>
					<td>
						<?php $args = array(
								'id'            => $field,
							  	'hide_empty'	=> 0,
							  	'orderby' 		=> 'name',
							  	// 'depth' 		=> 1,
							  	'hierarchical'   => 1,
							  	'taxonomy'		=> 'category'
							  );

							  wp_dropdown_categories( $args ); ?>
					</td>
				</tr>
				<tr>
					<?php $field = 'post_format'; ?>
					<th><label for="<?php echo $field; ?>"><?php _e( 'Select post format: ', 'smallshop' ); ?></label></th>
					<td>
						<select name="<?php echo $field; ?>" id="<?php echo $field; ?>">
							<option class="level-0" value="post-format-standard"><?php _e( 'Standard', 'smallshop' ); ?></option>
							<option class="level-0" value="post-format-video"><?php _e( 'Video', 'smallshop' ); ?></option>
							<option class="level-0" value="post-format-gallery"><?php _e( 'Gallery', 'smallshop' ); ?></option>
						</select>
					</td>
				</tr>
				<tr>
					<?php $field = 'post_meta'; ?>
					<th><label for="<?php echo $field; ?>"><?php _e( 'Show post meta: ', 'smallshop' ); ?></label></th>
					<td>
						<select name="<?php echo $field; ?>" id="<?php echo $field; ?>">
							<option class="level-0" value="1"><?php _e( 'Show', 'smallshop' ); ?></option>
							<option class="level-0" value="0"><?php _e( 'Hide', 'smallshop' ); ?></option>
						</select>
					</td>
				</tr>
				<tr>
					<?php $field = 'post_excerpt'; ?>
					<th><label for="<?php echo $field; ?>"><?php _e( 'Show post excerpt: ', 'smallshop' ); ?></label></th>
					<td>
						<select name="<?php echo $field; ?>" id="<?php echo $field; ?>">
							<option class="level-0" value="1"><?php _e( 'Show', 'smallshop' ); ?></option>
							<option class="level-0" value="0"><?php _e( 'Hide', 'smallshop' ); ?></option>
						</select>
					</td>
				</tr>
				<tr>
					<?php $field = 'post_style'; ?>
					<th><label for="<?php echo $field; ?>"><?php _e( 'Post style: ', 'smallshop' ); ?></label></th>
					<td>
						<select name="<?php echo $field; ?>" id="<?php echo $field; ?>">
							<option class="level-0" value=""><?php _e( 'Simple', 'smallshop' ); ?></option>
							<option class="level-0" value="post-highlight"><?php _e( 'Highlight Blue', 'smallshop' ); ?></option>
							<option class="level-0" value="post-highlight-green"><?php _e( 'Highlight Green', 'smallshop' ); ?></option>
							<option class="level-0" value="post-highlight-gray"><?php _e( 'Highlight Gray', 'smallshop' ); ?></option>
							<option class="level-0" value="overlay-2"><?php _e( 'Effect', 'smallshop' ); ?></option>
						</select>
					</td>
				</tr>
				<tr>
					<?php $field = 'post_offset'; ?>
					<th><label for="<?php echo $field; ?>"><?php _e( 'Post offset: ', 'smallshop' ); ?></label></th>
					<td>
						<input type="text" name="<?php echo $field; ?>" id="<?php echo $field; ?>" value="" /> <smal>(number of post to displace or pass over)</small>
					</td>
				</tr>
				<tr>
					<?php $field = 'post_count'; ?>
					<th><label for="<?php echo $field; ?>"><?php _e( 'Number of post: ', 'smallshop' ); ?></label></th>
					<td>
						<input type="text" name="<?php echo $field; ?>" id="<?php echo $field; ?>" value="4" /> <smal>(-1 for show all)</small>
					</td>
				</tr>
				<tr>
					<?php $field = 'cols'; ?>
					<th><label for="<?php echo $field; ?>"><?php _e( 'Columns: ', 'smallshop' ); ?></label></th>
					<td>
						<select name="<?php echo $field; ?>" id="<?php echo $field; ?>">
							<option class="level-0" value="1">None</option>
							<option class="level-0" value="2">2</option>
							<option class="level-0" selected="selected" value="3">3</option>
							<option class="level-0" value="4">4</option>
						</select>
					</td>
				</tr>
			</table>
			<p class="submit">
				<input type="button" id="option-submit" class="button-primary" value="<?php _e( 'Add Post', 'smallshop' ); ?>" name="submit" />
			</p>
	</div>			

	<?php
	exit();	
}
?>