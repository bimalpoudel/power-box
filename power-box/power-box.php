<?php
/**
 * Plugin Name: Power Box
 * Plugin URI: http://bimal.org.np/
 * Description: Puts almost anything in Widget Boxes. After activation <a href="widgets.php">Appearance &gt; Widgets</a>, add blocks.
 * Author: Bimal Poudel
 * Author URI: http://bimal.org.np/
 * Version: 1.0.0
 * License: GPL3
*/

class power_box extends WP_Widget
{
	/**
	 * Each of these default values should be setup within Widget Interface
	 */
	private $power_title = 'One Liners';
	private $power_url = 'http://bimal.org.np/micro-services/one-liners.php';
	private $attribution_name = 'bimal.org.np';
	private $attribution_url = 'http://bimal.org.np/';

	public function __construct() {
		parent::__construct(false, 'Power Box', array('description' => 'Displays almost any tiny contents.'));
		add_action('widgets_init', array($this, 'register'));
	}

	public function form($instance)
	{
		$instance['power_title'] = !empty($instance['power_title'])?esc_attr($instance['power_title']):'';
		$instance['power_url'] = !empty($instance['power_url'])?esc_attr($instance['power_url']):'';
		$instance['attribution_name'] = !empty($instance['attribution_name'])?esc_attr($instance['attribution_name']):'';
		$instance['attribution_url'] = !empty($instance['attribution_url'])?esc_attr($instance['attribution_url']):'';
		?>
		
		<h4>Please fill up the all fields below.</h4>

		<p>
		<label for="<?php echo $this->get_field_id('power_title'); ?>">Box's Heading:</label>
		<input class="widefat" id="<?php echo $this->get_field_id('power_title'); ?>" name="<?php echo $this->get_field_name('power_title'); ?>" type="text" value="<?php echo $instance['power_title']; ?>" placeholder="<?php echo $this->power_title; ?>" />
		</p>

		<p>
		<label for="<?php echo $this->get_field_id('power_url'); ?>">Content URL (Main Source):</label>
		<input class="widefat" id="<?php echo $this->get_field_id('power_url'); ?>" name="<?php echo $this->get_field_name('power_url'); ?>" type="text" value="<?php echo $instance['power_url']; ?>" placeholder="<?php echo $this->power_url; ?>" />
		</p>

		<p>
		<label for="<?php echo $this->get_field_id('attribution_name'); ?>">Attribution Name (optional):</label>
		<input class="widefat" id="<?php echo $this->get_field_id('attribution_name'); ?>" name="<?php echo $this->get_field_name('attribution_name'); ?>" type="text" value="<?php echo $instance['attribution_name']; ?>" placeholder="<?php echo $this->attribution_name; ?>" />
		</p>
		
		<p>
		<label for="<?php echo $this->get_field_id('attribution_url'); ?>">Attribution URL (optional):</label>
		<input class="widefat" id="<?php echo $this->get_field_id('attribution_url'); ?>" name="<?php echo $this->get_field_name('attribution_url'); ?>" type="text" value="<?php echo $instance['attribution_url']; ?>" placeholder="<?php echo $this->attribution_url; ?>" />
		</p>

		<h4>Help</h4>
		<ul>
			<li><strong>Box's Heading</strong>: Widget Box's Title</li>
			<li><strong>Content URL</strong>: The actual remote tiny content, <a href="http://bimal.org.np/micro-services/one-liners.php">copy example</a></li>
			<li><strong>Attribution Name</strong>: Link back text</li>
			<li><strong>Attribution URL</strong>: URL to go there</li>
		</ul>
		<?php
	}

	public function update($new_instance, $old_instance) {
		$instance = $old_instance;
		$instance['power_title'] = strip_tags($new_instance['power_title']);
		$instance['power_url'] = strip_tags($new_instance['power_url']);
		$instance['attribution_name'] = strip_tags($new_instance['attribution_name']);
		$instance['attribution_url'] = strip_tags($new_instance['attribution_url']);
		return $instance;
	}

	public function widget($args, $instance)
	{
		if(empty($instance['power_url'])) return false;

		#print_r(func_get_args());
		echo $args['before_widget'];
		echo '<div class="widget-text power_box">';
			#$power_title = apply_filters('widget_power_title', $instance['power_title']);
			echo "<h3>{$instance['power_title']}</h3>";
			
			/**
			 * The actual remote content; should be valid to process
			 */
			$quote = wp_remote_fopen($instance['power_url']);
			echo $quote;
			
			if($instance['attribution_name'] && $instance['attribution_url'])
			{
				echo "<div class='power_box_attribution'><a href='{$instance['attribution_url']}'>{$instance['attribution_name']}</a></div>";
			}
		echo '</div>';
		echo $args['after_widget'];

	}
	
	public function register()
	{
		register_widget(__CLASS__);
	}
}

new power_box;
