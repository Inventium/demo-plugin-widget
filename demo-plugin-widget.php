<?php
/*
 * Plugin name: Demo Plugin Widget
 * Plugin URI: http://website-in-a-weekend.net/plugins/demo-plugins/
 * Description: Demonstrating how to add a WordPress widget with a plugin.
 * Version: 0.1
 * Author: Dave Doolin
 * Author URI: http://website-in-a-weekend.net/
 */

// Codex: http://codex.wordpress.org/Widgets_API#Developing_Widgets
if (!class_exists("demo_plugin_widget")) {

  class demo_plugin_widget extends WP_Widget {
      
    var $css_class = 'demo_plugin_widget_class';
    var $description = 'A minimal WordPress widget defined using a short, simple plugin';
    var $base_id = 'demo_widget';
    var $name = 'Plugin Demo Widget';
    var $default_title = 'Cool demo widget plugin';
    var $default_demotext = 'Some default demo text for just for fun.';

    function demo_plugin_widget() {
      $widget_ops = array('classname' => $this->css_class, 
                          'description' => $this->description);
      $this->WP_Widget($this->base_id, $this->name, $widget_ops);
    }

    /* This is the code that gets displayed on the UI side,
     * what readers see.
     */
    function widget($args, $instance) {
      extract($args, EXTR_SKIP);
      echo $before_widget;
      $title = (empty($instance['title'])) ? $this->default_title : apply_filters('widget_title', $instance['title']); 
      $demotext = (empty($instance['demotext'])) ? $this->default_demotext : $instance['demotext']; 
      echo $before_title . $title . $after_title; 
?>
<ul>
  <li><?php echo $demotext ?></li>
  <li>More text.</li>
</ul>
<?php
      echo $after_widget;
    }

    function update($new_instance, $old_instance) {
      $instance = $old_instance;
      $instance['title'] = strip_tags($new_instance['title']);
      $instance['demotext'] = strip_tags($new_instance['demotext']);
      return $instance;
    }

    /* Back end, the interface shown in Appearance -> Widgets
     * administration interface.
     */
    function form($instance) {
      $instance = wp_parse_args( (array) $instance, array( 'title' => '', 'entry_title' => '', 'comments_title' => '', 'demotext' => '' ) );
      $title    = strip_tags($instance['title']);
      $demotext = strip_tags($instance['demotext']);
      ?>

<p>
<label for="<?php echo $this->get_field_id('title'); ?>">Title: 
    <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>"
     name="<?php echo $this->get_field_name('title'); ?>" type="text"
     value="<?php echo esc_attr($title); ?>" />
</label>
<label for="<?php echo $this->get_field_id('demotext'); ?>">Demo text: 
    <input class="widefat" id="<?php echo $this->get_field_id('demotext'); ?>"
     name="<?php echo $this->get_field_name('demotext'); ?>" type="text"
     value="<?php echo esc_attr($demotext); ?>" />
</label>
</p>

      <?php
    }      
  }

  function demo_widget_init() {
    // http://codex.wordpress.org/Function_Reference/register_widget
    register_widget('demo_plugin_widget');
  }
  add_action('widgets_init', 'demo_widget_init');

}

// Uncomment this for standalone widget testing... 
$wpdpd = new demo_plugin_widget();

?>
