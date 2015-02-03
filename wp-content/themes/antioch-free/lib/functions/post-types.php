<?php

/**
 * Post list shortcode
 * @shortcode post_list
 */
function churchthemes_posts_shortcode($atts, $content = null){
	global $post, $wp_query;
	extract(shortcode_atts(array(
		// Default behaviors
		'post_status' => 'publish',
		'num' => get_option( 'posts_per_page' ),
		'paging' => 'show',
		'images' => 'show',
		'offset' => '', // number of posts to displace
		'orderby' => 'date',
		'order' => 'DESC',
		'p' => '', // post ID
		'name' => '', // post slug
		'post__in' => '', // posts to retrieve, comma separated IDs
		'post__not_in' => '', // posts to ignore, comma separated IDs
		'year' => '', // 4 digit year (e.g. 2012)
		'monthnum' => '', // 1-12
		'w' => '', // 0-53
		'day' => '', // 1-31
		'hour' => '', // 0-23
		'minute' => '', // 0-60
		'second' => '', // 0-60
		'author' => '', // author ID
		'author_name' => '', // author username
		'tag' => '', // tag slug, if separated by "+" the functionality becomes identical to tag_slug__and
		'tag_id' => '', // tag ID
		'tag__and' => '', // posts that are tagged both x AND y, comma separated IDs
		'tag__in' => '', // posts that are tagged x OR y, comma separated IDs
		'tag__not_in' => '', // exclude posts with these tags, comma separated IDs
		'tag_slug__and' => '', // posts that are tagged both x AND y, comma separated slugs
		'tag_slug__in' => '', // posts that are tagged x OR y, comma separated slugs
		'cat' => '', // category ID
		'category_name' => '', // category slug
		'category__and' => '', // posts that are in both categories x AND y, comma separated IDs
		'category__in' => '', // posts that are in categories x OR y, comma separated IDs
		'category__not_in' => '', // exclude posts from these categories, comma separated IDs
	), $atts));

	if($orderby == 'views'): $orderby = 'meta_value_num'; endif;
	if($paging == 'hide'):
		$paged = null;
	else:
		$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
	endif;

	$args = array(
		'post_type' => 'post', // only return posts
		'post_status' => $post_status, // default: publish
		'posts_per_page' => $num, // default: Settings > Reading > Blog pages show at most
		'paged' => $paged, // default: paged
		'offset' => $offset,
		'orderby' => $orderby, // default: date
		'order' => $order, // default: DESC
		'p' => $p,
		'name' => $name,
		'year' => $year,
		'monthnum' => $monthnum,
		'w' => $w,
		'day' => $day,
		'hour' => $hour,
		'minute' => $minute,
		'second' => $second,
		'author' => $author,
		'author_name' => $author_name,
		'tag' => $tag,
		'cat' => $cat,
		'category_name' => $category_name,
	);

	// the following parameters require array values
	if ($orderby == 'meta_value_num') {
		$args = array_merge( $args, array( 'meta_key' => 'Views' ) );
	}
	if ($post__in) {
		$args = array_merge( $args, array( 'post__in' => explode(',', $post__in) ) );
	}
	if ($post__not_in) {
		$args = array_merge( $args, array( 'post__not_in' => explode(',', $post__not_in) ) );
	}
	if ($tag_id) {
		$args = array_merge( $args, array( 'tag_id' => explode(',', $tag_id) ) );
	}
	if ($tag__and) {
		$args = array_merge( $args, array( 'tag__and' => explode(',', $tag__and) ) );
	}
	if ($tag__in) {
		$args = array_merge( $args, array( 'tag__in' => explode(',', $tag__in) ) );
	}
	if ($tag__not_in) {
		$args = array_merge( $args, array( 'tag__not_in' => explode(',', $tag__not_in) ) );
	}
	if ($tag_slug__and) {
		$args = array_merge( $args, array( 'tag_slug__and' => explode(',', $tag_slug__and) ) );
	}
	if ($tag_slug__in) {
		$args = array_merge( $args, array( 'tag_slug__in' => explode(',', $tag_slug__in) ) );
	}
	if ($category__and) {
		$args = array_merge( $args, array( 'category__and' => explode(',', $category__and) ) );
	}
	if ($category__in) {
		$args = array_merge( $args, array( 'category__in' => explode(',', $category__in) ) );
	}
	if ($category__not_in) {
		$args = array_merge( $args, array( 'category__not_in' => explode(',', $category__not_in) ) );
	}

	query_posts($args);

	ob_start();
	if ( $images != 'hide' ) {
			include('shortcode-posts.php');
	}
	else {
		include('shortcode-posts-noimage.php');
	}
	if($paging != 'hide') {
		pagination();
	}
	wp_reset_query();
	$content = ob_get_clean();
	return $content;
}
add_shortcode( 'posts', 'churchthemes_posts_shortcode' );

// End Posts Shortcode


/* SLIDE */

// Register Post Type
add_action('init', 'sl_register');

function sl_register() {
	$labels = array(
		'name' => ( 'Slides' ),
		'singular_name' => ( 'Slide' ),
		'add_new' => _x( 'Add New', 'ct_slide' ),
		'add_new_item' => __( 'Add New Slide' ),
		'edit_item' => __( 'Edit Slide' ),
		'new_item' => __( 'New Slide' ),
		'view_item' => __( 'View Slide' ),
		'search_items' => __( 'Search Slides' ),
		'not_found' =>  __( 'No Slides found' ),
		'not_found_in_trash' => __( 'No Slides found in Trash' ),
		'parent_item_colon' => ''
	);

	$args = array(
		'labels' => $labels,
		'public' => false,
		'publicly_queryable' => false,
		'exclude_from_search' => true,
		'show_ui' => true,
		'query_var' => true,
		'rewrite' => true,
		'capability_type' => 'post',
		'hierarchical' => false,
		'menu_position' => 10,
		'menu_icon' => get_template_directory_uri() . '/lib/admin/images/menu_icon-slide-16.png',
		'supports' => array( 'title', 'thumbnail', 'revisions' )
	);

	register_post_type( 'ct_slide' , $args );

	flush_rewrite_rules(false);

}
// End Register Post Type

// Create Custom Taxonomies
add_action( 'init', 'create_slide_taxonomies', 0 );

function create_slide_taxonomies() {

	// Slide Tags Taxonomy (Non-Hierarchical)
	$labels = array(
		'name' => _x( 'Slide Tags', 'taxonomy general name' ),
		'singular_name' => _x( 'Tag', 'taxonomy singular name' ),
		'search_items' =>  __( 'Search Tags' ),
		'popular_items' => __( 'Popular Tags' ),
		'all_items' => __( 'All Tags' ),
		'parent_item' => null,
		'parent_item_colon' => null,
		'edit_item' => __( 'Edit Tag' ),
		'update_item' => __( 'Update Tag' ),
		'add_new_item' => __( 'Add New Tag' ),
		'new_item_name' => __( 'New Tag Name' ),
		'separate_items_with_commas' => __( 'Separate Tags with commas' ),
		'add_or_remove_items' => __( 'Add or remove Tags' ),
		'choose_from_most_used' => __( 'Choose from the most used Tags' )
	);
	register_taxonomy( 'slide_tag', 'ct_slide', array(
		'hierarchical' => false,
		'labels' => $labels,
		'show_ui' => true,
		'query_var' => true,
		'rewrite' => array( 'slug' => 'slide_tag' ),
	));
	// End Slide Tags Taxonomy

}
// End Custom Taxonomies

// Submenu
add_action('admin_menu', 'sl_submenu');

function sl_submenu() {

	// Add to end of admin_menu action function
	global $submenu;
	$submenu['edit.php?post_type=ct_slide'][5][0] = __('All Slides');
	$post_type_object = get_post_type_object('ct_slide');
	$post_type_object->labels->name = "Slides";

}
// End Submenu

// Create Slide Options Box
add_action("admin_init", "sl_admin_init");

function sl_admin_init(){
    add_meta_box("sl_meta", "Slide Options", "sl_meta_options", "ct_slide", "normal", "core");
}

// Custom Field Keys
function sl_meta_options(){
	global $post;
	$custom = get_post_custom($post->ID);
	isset($custom["_ct_sl_tagline"][0]) ? $sl_tagline = $custom["_ct_sl_tagline"][0] : $sl_tagline = null;
	isset($custom["_ct_sl_linkurl"][0]) ? $sl_linkurl = $custom["_ct_sl_linkurl"][0] : $sl_linkurl = null;
	isset($custom["_ct_sl_disable_text"][0]) ? $sl_disable_text = $custom["_ct_sl_disable_text"][0] : $sl_disable_text = null;
	isset($custom["_ct_sl_notes"][0]) ? $sl_notes = $custom["_ct_sl_notes"][0] : $sl_notes = null;
// End Custom Field Keys

// Start HTML
?>

	<h2 class="meta_section"><?php _e('Featured Image', 'churchthemes'); ?></h2>

	<div class="meta_item first">
		<a title="Set Featured Image" href="media-upload.php?post_id=<?php echo $post->ID; ?>&amp;type=image&amp;TB_iframe=1&amp;width=640&amp;height=285" id="set-post-thumbnail" class="thickbox button rbutton"><?php _e('Set Featured Image', 'churchthemes'); ?></a>
		<br />
		<span><?php _e('To ensure the best image quality possible, please use a JPG image that is 924 x 345 pixels', 'churchthemes'); ?></span>
	</div>

	<hr class="meta_divider" />

	<h2 class="meta_section"><?php _e('General', 'churchthemes'); ?></h2>

	<div class="meta_item">
		<label for="_ct_sl_tagline"><?php _e('Tagline', 'churchthemes'); ?></label>
		<input type="text" name="_ct_sl_tagline" size="70" autocomplete="on" value="<?php echo esc_attr($sl_tagline); ?>">
		<span><?php _e('Tagline shown under the title on the slide (80 characters max)', 'churchthemes'); ?></span>
	</div>

	<div class="meta_item">
		<label for="_ct_sl_linkurl"><?php _e('Slide Link', 'churchthemes'); ?></label>
		<input type="text" name="_ct_sl_linkurl" size="70" autocomplete="on" placeholder="e.g. http://mychurch.org/some-page-with-more-info/" value="<?php echo esc_url($sl_linkurl); ?>">
		<span><?php _e('Where users are taken when the slide image is clicked', 'churchthemes'); ?></span>
	</div>

	<div class="meta_item">
		<label for="_ct_sl_disable_text"><?php _e('Disable Text', 'churchthemes'); ?></label>
		<input type="checkbox" name="_ct_sl_disable_text" class="ct_meta_checkbox" value="true" <?php if($sl_disable_text == true) echo 'checked="checked"'; ?>>
		<span><?php _e('Disables the Title/Tagline text and displays only the slide image', 'churchthemes'); ?></span>
	</div>

	<hr class="meta_divider" />

	<h2 class="meta_section"><?php _e('More', 'churchthemes'); ?></h2>

	<div class="meta_item">
		<label for="_ct_sl_notes">
			<?php _e('Admin Notes', 'churchthemes'); ?>
			<br /><br />
			<span class="label_note"><?php _e('Not Published', 'churchthemes'); ?></span>
		</label>
		<textarea type="text" name="_ct_sl_notes" cols="60" rows="8"><?php echo esc_textarea($sl_notes); ?></textarea>
	</div>

	<div class="meta_clear"></div>

<?php
// End HTML
}

// Save Custom Field Values
add_action('save_post', 'save_ct_sl_meta');

function save_ct_sl_meta(){

	global $post_id;

	if(isset($_POST['post_type']) && ($_POST['post_type'] == "ct_slide")):

		$sl_tagline = wp_filter_nohtml_kses( $_POST['_ct_sl_tagline'] );
		update_post_meta($post_id, '_ct_sl_tagline', $sl_tagline);

		$sl_linkurl = esc_url_raw( $_POST['_ct_sl_linkurl'] );
		update_post_meta($post_id, '_ct_sl_linkurl', $sl_linkurl);

		$sl_disable_text = isset( $_POST['_ct_sl_disable_text'] ) ? wp_filter_nohtml_kses( $_POST['_ct_sl_disable_text'] ) : null;
		update_post_meta($post_id, '_ct_sl_disable_text', $sl_disable_text);

		$sl_notes = wp_filter_nohtml_kses( $_POST['_ct_sl_notes'] );
		update_post_meta($post_id, '_ct_sl_notes', $sl_notes);

	endif;
}
// End Custom Field Values
// End Slide Options Box

// Custom Columns
function sl_register_columns($columns){
		$columns = array(
			'cb' => '<input type="checkbox" />',
			'title' => 'Title',
			'sl_tagline' => 'Tagline',
			'sl_tags' => 'Tags',
			'sl_image' => 'Featured Image'
		);
		return $columns;
}
add_filter('manage_edit-ct_slide_columns', 'sl_register_columns');

function sl_display_columns($column){
		global $post;
		$custom = get_post_custom();
		switch ($column)
		{
			case 'sl_tagline':
				$tagline = $custom['_ct_sl_tagline'][0];
				echo $tagline;
				break;
			case 'sl_tags':
				echo get_the_term_list($post->ID, 'slide_tag', '', ', ', '');
				break;
			case 'sl_image':
				echo get_the_post_thumbnail($post->ID, 'admin');
				break;
		}
}
add_action('manage_posts_custom_column', 'sl_display_columns');

// End Custom Columns

/* END SLIDE */
