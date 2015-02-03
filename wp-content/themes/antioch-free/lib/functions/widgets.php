<?php

/*
Widget Name: List Posts Widget
Description: Display a list of posts. Supports multiple usage.
Author: ChurchThemes
Author URI: http://churchthemes.net
*/

add_action('init', 'churchthemes_post_list_widget');
function churchthemes_post_list_widget() {

	$prefix = 'churchthemes-post-list'; // $id prefix
	$name = __('List Posts');
	$widget_ops = array('classname' => 'churchthemes_post_list', 'description' => __('Display a list of posts that match a certain criteria and order them however you like. Supports multiple usage.'));
	$control_ops = array('width' => 200, 'height' => 200, 'id_base' => $prefix);

	$options = get_option('churchthemes_post_list');
	if(isset($options[0])) unset($options[0]);

	if(!empty($options)){
		foreach(array_keys($options) as $widget_number){
			wp_register_sidebar_widget($prefix.'-'.$widget_number, $name, 'churchthemes_post_list', $widget_ops, array( 'number' => $widget_number ));
			wp_register_widget_control($prefix.'-'.$widget_number, $name, 'churchthemes_post_list_control', $control_ops, array( 'number' => $widget_number ));
		}
	} else{
		$options = array();
		$widget_number = 1;
		wp_register_sidebar_widget($prefix.'-'.$widget_number, $name, 'churchthemes_post_list', $widget_ops, array( 'number' => $widget_number ));
		wp_register_widget_control($prefix.'-'.$widget_number, $name, 'churchthemes_post_list_control', $control_ops, array( 'number' => $widget_number ));
	}
}

function churchthemes_post_list($args, $vars = array()) {
    extract($args);
    $widget_number = (int)str_replace('churchthemes-post-list-', '', @$widget_id);
    $options = get_option('churchthemes_post_list');
    if(!empty($options[$widget_number])){
    	$vars = $options[$widget_number];
    }
    // widget open tags
		echo $before_widget;

		// print content and widget end tags
		$title = stripslashes($vars['title']);
		$num = $vars['num'];
		if(empty($num)) $num = 3;
		$order_by = $vars['order_by'];
		$the_order = $vars['the_order'];
		$show_image = $vars['show_image'];
		$show_date = $vars['show_date'];
		$show_author = $vars['show_author'];
		$post_author = $vars['post_author'];
		$post_cat = $vars['post_cat'];
		$post_tag = $vars['post_tag'];
		if($post_tag == 0):
			$post_tag = null;
		elseif($post_tag):
			$the_tag = get_term_by('id', $post_tag, 'post_tag');
			$post_tag = $the_tag->slug;
		endif;

		global $post;

if($order_by == 'meta_value_num'):
		$args=array(
			'post_type' => 'post',
			'post_status' => 'publish',
			'paged' => true,
			'p' => $id,
			'posts_per_page' => $num,
			'author' => $post_author,
			'cat' => $post_cat,
			'tag' => $post_tag,
			'meta_key' => 'Views',
			'orderby' => $order_by,
			'order' => $the_order,
		);
else:
		$args=array(
			'post_type' => 'post',
			'post_status' => 'publish',
			'paged' => true,
			'p' => $id,
			'posts_per_page' => $num,
			'author' => $post_author,
			'cat' => $post_cat,
			'tag' => $post_tag,
			'orderby' => $order_by,
			'order' => $the_order,
		);
endif;

		$query = null;
		$query = new WP_Query($args);

		if($title):
			echo $before_title . $title . $after_title;
			echo "<ul class=\"list_widget\">\n";
			$i = 0;
			if( $query->have_posts() ) : while ($query->have_posts()) : $query->the_post(); $i++;

				$the_title = strip_tags(get_the_title());
				$the_author = strip_tags(get_the_author());
				$the_thumb = get_thumbnail($post->ID,'80','80');

				if($query->post_count == 1):
					echo "<li class=\"first last\">\n";
				elseif($i == 1):
					echo "<li class=\"first\">\n";
				elseif($i == $query->post_count):
					echo "<li class=\"last\">\n";
				else:
					echo "<li>\n";
				endif;
					echo "<a href=\"".get_permalink()."\">";
				if($show_image == 'true' && !empty($the_thumb)):
					echo "<img src=\"".$the_thumb."\" alt=\"".$the_title."\">\n";
				endif;
				if($show_date == 'true' && ($show_image == 'false' || empty($the_thumb))):
					echo "<p class=\"left\">".get_the_date()."</p>";
				elseif($show_date == 'true' && $show_image == 'true'):
					echo "<p>".get_the_date()."</p>";
				endif;
				if($show_image == 'false' || empty($the_thumb)):
					echo "<h5 class=\"left\">".$the_title."</h5>\n";
				else:
					echo "<h5>".$the_title."</h5>\n";
				endif;
				if($show_author == 'true' && ($show_image == 'false' || empty($the_thumb))):
					echo "<p class=\"left notranslate\">".$the_author."</p>";
				elseif($show_author == 'true' && $show_image == 'true'):
					echo "<p class=\"notranslate\">".$the_author."</p>";
				endif;
				echo "</a>\n";
				echo "<div class=\"clear\"></div>\n";
				echo "</li>\n";
			endwhile; wp_reset_query();
			else:
				echo "<li><p class=\"left noresults\">Sorry, no posts found.</p></li>";
			endif;
				echo "</ul>\n";
				echo $after_widget;
		endif;
}

function churchthemes_post_list_control($args) {

	$prefix = 'churchthemes-post-list'; // $id prefix

	$options = get_option('churchthemes_post_list');
	if(empty($options)) $options = array();
	if(isset($options[0])) unset($options[0]);

	// update options array
	if(!empty($_POST[$prefix]) && is_array($_POST)){
		foreach($_POST[$prefix] as $widget_number => $values){
			if(empty($values) && isset($options[$widget_number])) // user clicked cancel
				continue;

			if(!isset($options[$widget_number]) && $args['number'] == -1){
				$args['number'] = $widget_number;
				$options['last_number'] = $widget_number;
			}
			$options[$widget_number] = $values;
		}

		// update number
		if($args['number'] == -1 && !empty($options['last_number'])){
			$args['number'] = $options['last_number'];
		}

		// clear unused options and update options in DB. return actual options array
		$options = churchthemes_post_list_update($prefix, $options, $_POST[$prefix], $_POST['sidebar'], 'churchthemes_post_list');
	}

	// $number - is dynamic number for multi widget, gived by WP
	// by default $number = -1 (if no widgets activated). In this case we should use %i% for inputs
	//   to allow WP generate number automatically
	$number = ($args['number'] == -1)? '%i%' : $args['number'];

	// now we can output control
	$opts = @$options[$number];

	$title = @$opts['title'];
	$num = @$opts['num'];
	$order_by = @$opts['order_by'];
	$the_order = @$opts['the_order'];
	$show_image = @$opts['show_image'];
	$show_date = @$opts['show_date'];
	$show_author = @$opts['show_author'];
	$post_author = @$opts['post_author'];
	$post_cat = @$opts['post_cat'];
	$post_tag = @$opts['post_tag'];

	?>
	<p>
		<label for="<?php echo $prefix; ?>[<?php echo $number; ?>][title]"><?php _e('Title', 'churchthemes'); ?> *</label>
		<br />
		<input type="text" name="<?php echo $prefix; ?>[<?php echo $number; ?>][title]" value="<?php echo stripslashes($title); ?>" class="widefat<?php if(empty($title)): echo ' error'; endif; ?>" />
	</p>
	<p>
		<label for="<?php echo $prefix; ?>[<?php echo $number; ?>][order_by]"><?php _e('Order By', 'churchthemes'); ?></label>
		<br />
		<select name="<?php echo $prefix; ?>[<?php echo $number; ?>][order_by]">
			<option value="date"<?php if($order_by == 'date'): echo ' selected="selected"'; endif; ?>><?php _e('Post Date', 'churchthemes'); ?></option>
			<option value="title"<?php if($order_by == 'title'): echo ' selected="selected"'; endif; ?>><?php _e('Title', 'churchthemes'); ?></option>
			<option value="modified"<?php if($order_by == 'modified'): echo ' selected="selected"'; endif; ?>><?php _e('Date Modified', 'churchthemes'); ?></option>
			<option value="menu_order"<?php if($order_by == 'menu_order'): echo ' selected="selected"'; endif; ?>><?php _e('Menu Order', 'churchthemes'); ?></option>
			<option value="id"<?php if($order_by == 'id'): echo ' selected="selected"'; endif; ?>><?php _e('Post ID', 'churchthemes'); ?></option>
			<option value="rand"<?php if($order_by == 'rand'): echo ' selected="selected"'; endif; ?>><?php _e('Random', 'churchthemes'); ?></option>
			<option value="meta_value_num"<?php if($order_by == 'meta_value_num'): echo ' selected="selected"'; endif; ?>><?php _e('View Count', 'churchthemes'); ?></option>
		</select>
	</p>
	<p>
		<label for="<?php echo $prefix; ?>[<?php echo $number; ?>][the_order]"><?php _e('Order', 'churchthemes'); ?></label>
		<br />
		<select name="<?php echo $prefix; ?>[<?php echo $number; ?>][the_order]">
			<option value="DESC"<?php if($the_order == 'DESC'): echo ' selected="selected"'; endif; ?>><?php _e('Descending', 'churchthemes'); ?></option>
			<option value="ASC"<?php if($the_order == 'ASC'): echo ' selected="selected"'; endif; ?>><?php _e('Ascending', 'churchthemes'); ?></option>
		</select>
	</p>
	<p>
		<label for="<?php echo $prefix; ?>[<?php echo $number; ?>][show_image]"><?php _e('Thumbnail Image', 'churchthemes'); ?></label>
		<br />
		<select name="<?php echo $prefix; ?>[<?php echo $number; ?>][show_image]">
			<option value="true"<?php if($show_image == 'true'): echo ' selected="selected"'; endif; ?>><?php _e('Show', 'churchthemes'); ?></option>
			<option value="false"<?php if($show_image == 'false'): echo ' selected="selected"'; endif; ?>><?php _e('Hide', 'churchthemes'); ?></option>
		</select>
	</p>
	<p>
		<label for="<?php echo $prefix; ?>[<?php echo $number; ?>][show_date]"><?php _e('Date', 'churchthemes'); ?></label>
		<br />
		<select name="<?php echo $prefix; ?>[<?php echo $number; ?>][show_date]">
			<option value="true"<?php if($show_date == 'true'): echo ' selected="selected"'; endif; ?>><?php _e('Show', 'churchthemes'); ?></option>
			<option value="false"<?php if($show_date == 'false'): echo ' selected="selected"'; endif; ?>><?php _e('Hide', 'churchthemes'); ?></option>
		</select>
	</p>
	<p>
		<label for="<?php echo $prefix; ?>[<?php echo $number; ?>][show_author]"><?php _e('Author', 'churchthemes'); ?></label>
		<br />
		<select name="<?php echo $prefix; ?>[<?php echo $number; ?>][show_author]">
			<option value="true"<?php if($show_author == 'true'): echo ' selected="selected"'; endif; ?>><?php _e('Show', 'churchthemes'); ?></option>
			<option value="false"<?php if($show_author == 'false'): echo ' selected="selected"'; endif; ?>><?php _e('Hide', 'churchthemes'); ?></option>
		</select>
	</p>
	<p>
		<label for="<?php echo $prefix; ?>[<?php echo $number; ?>]"><?php _e('Display', 'churchthemes'); ?></label>
		<br />
		<?php wp_dropdown_users('show_option_all=All Authors&selected='.$post_author.'&show_count=1&orderby=display_name&who=authors&name='.$prefix.'['.$number.'][post_author]'); ?>
	</p>
	<p>
		<?php wp_dropdown_categories('show_option_all=All Categories&selected='.$post_cat.'&show_count=1&hierarchical=1&hide_empty=0&orderby=title&name='.$prefix.'['.$number.'][post_cat]'); ?>
	</p>
	<p>
		<?php wp_dropdown_categories('show_option_all=All Tags&selected='.$post_tag.'&show_count=1&hierarchical=0&hide_empty=0&orderby=title&name='.$prefix.'['.$number.'][post_tag]&taxonomy=post_tag'); ?>
	</p>
	<p>
		<label for="<?php echo $prefix; ?>[<?php echo $number; ?>][num]"><?php _e('Number of Posts', 'churchthemes'); ?></label>
		<br />
		<input type="text" name="<?php echo $prefix; ?>[<?php echo $number; ?>][num]" size="2" placeholder="3" value="<?php echo stripslashes($num); ?>" />
		<br />
		<small><em><?php _e('Enter -1 to display unlimited results', 'churchthemes'); ?></em></small>
	</p>
	<?php
}

// helper function can be defined in another plugin
if(!function_exists('churchthemes_post_list_update')){
	function churchthemes_post_list_update($id_prefix, $options, $post, $sidebar, $option_name = ''){
		global $wp_registered_widgets;
		static $updated = false;

		// get active sidebar
		$sidebars_widgets = wp_get_sidebars_widgets();
		if ( isset($sidebars_widgets[$sidebar]) )
			$this_sidebar =& $sidebars_widgets[$sidebar];
		else
			$this_sidebar = array();

		// search unused options
		foreach ( $this_sidebar as $_widget_id ) {
			if(preg_match('/'.$id_prefix.'-([0-9]+)/i', $_widget_id, $match)){
				$widget_number = $match[1];

				// $_POST['widget-id'] contain current widgets set for current sidebar
				// $this_sidebar is not updated yet, so we can determine which was deleted
				if(!in_array($match[0], $_POST['widget-id'])){
					unset($options[$widget_number]);
				}
			}
		}

		// update database
		if(!empty($option_name)){
			update_option($option_name, $options);
			$updated = true;
		}

		// return updated array
		return $options;
	}
}
