<?php
/*
Plugin Name: Progress Thermometer
Plugin URI: http://blog.danconley.net
Description: Displays a horizontal 'thermometer' with a task's progress
Version: 0.23
Author: Dan Conley
Author URI: http://www.danconley.net
License: Kopyleft
*/

function include_thermometer_css() {
	echo "<link rel=\"stylesheet\" type=\"text/css\" media=\"all\" href=\"" . WP_PLUGIN_URL . "/thermometer/thermometer.css\" />";
}

add_action('wp_head', 'include_thermometer_css');

// the admin panel stuff is found here
require('thermometer_admin.php');

// make it a widget
function register_thermometer() {
	register_widget("Progress_Thermometer");
}

add_action("widgets_init","register_thermometer");

class Progress_Thermometer extends WP_Widget {

	function Progress_Thermometer() {
		$widget_ops = array('classname'=>'thermometer','description' => 'Displays a progress bar');
		$control_ops = array( 'width' => 300, 'height' => 350, 'id_base' => 'progress-thermometer' );

		$this->WP_Widget('progress-thermometer','Progress Thermometer',$widget_ops,$control_ops);
	}

	// sweater, shoes, shirt
	function widget($args, $instance) {
		extract($args);

		$title = apply_filters('widget_title',$instance['title']);
		$current = 2; //$instance['current'];

		$values = array("Zoning variance","Close on building","Submit TTB application","Receive TTB license","Submit SLA application","Receive SLA license","Beer!");//explode("	",$instance['values']);

		echo $before_widget;

		echo "<div id=\"thermometer\">\r\n";
		echo "<ol>\r\n";
		foreach ($values as $id=>$value) {
			echo "<li style=\"width:" . (1/count($values)*100) . "%\"";
			if ($id == $current) echo " class=\"last completed\"";
			else if ($id < $current) echo " class=\"completed\"";
			echo ">\r\n<span>&nbsp;</span>\r\n";
			echo ($id == $current) ? "<strong>" . $value . "</strong>" : $value;
			echo "</li>\r\n";
		}
		echo "</ol>\r\n";
		echo "<span class=\"clear:both\">&nbsp;</span>\r\n";
		echo "</div>\r\n";

		echo $after_widget;
	}

	// go elsewhere
	function form($instance) {
		echo "<p>To configure, use the settings panel.</p>\r\n";
	}
}
?>
