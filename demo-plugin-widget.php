<?php
/*
 * Plugin name: Demo Plugin Widget
 * Plugin URI: http://website-in-a-weekend.net/plugins/demo-plugins/
 * Description: Demonstrating how to add a WordPress widget with a plugin.
 * Version: 0.1
 * Author: Dave Doolin
 * Author URI: http://website-in-a-weekend.net/
 */

if (!class_exists("demo_plugin_widget")) {

	class demo_plugin_widget extends WP_Widget {
			
		function demo_plugin_widget() {
			$widget_ops = array('classname' => 'demo_plugin_widget', 'description' => 'A Widget Demo' );
			$this->WP_Widget('demo_widget', 'Plugin Demo Widget', $widget_ops);
		}

		/* This is the code that gets displayed on the UI side,
		 * what readers see.
		 */
		function widget($args, $instance) {
			extract($args, EXTR_SKIP);
			echo $before_widget;
			$title = empty($instance['title']) ? '&nbsp;' : apply_filters('widget_title', $instance['title']);

			if (!empty($title)) { 
				echo $before_title . $title . $after_title; 
			}
			?>

<ul>
	<li>Some text here.</li>
	<li>More text.</li>
</ul>

<?php
            echo $after_widget;
		}

		function update($new_instance, $old_instance) {
			$instance = $old_instance;
			$instance['title'] = strip_tags($new_instance['title']);
			return $instance;
		}

		/* Back end, the interface shown in Appearance -> Widgets
		 * administration interface.
		 */
		function form($instance) {
			$instance = wp_parse_args( (array) $instance, array( 'title' => '', 'entry_title' => '', 'comments_title' => '' ) );
			$title = strip_tags($instance['title']);
			?>

<p>
<label for="<?php echo $this->get_field_id('title'); ?>">Title: 
    <input
	   class="widefat" id="<?php echo $this->get_field_id('title'); ?>"
	   name="<?php echo $this->get_field_name('title'); ?>" type="text"
	   value="<?php echo attribute_escape($title); ?>" 
	/>
</label>
</p>

			<?php
		}			
	}

	function demo_widget_init() {
		register_widget('demo_plugin_widget');
	}
	add_action('widgets_init', 'demo_widget_init');

}

$wpdpd = new demo_plugin_widget();

?>