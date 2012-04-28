<?php
/*
Plugin Name: Progress Thermometer
Plugin URI: http://blog.danconley.net/progress-thermometer-wordpress-plugin
Description: Displays a horizontal "thermometer" with a task's progress
Version: 1.0.5.2.3
Author: Dan Conley
Author URI: http://www.danconley.net
License: Kopyleft
*/

function include_thermometer_css() {
	echo "<link rel=\"stylesheet\" type=\"text/css\" media=\"all\" href=\"" . plugins_url() . "/thermometer/thermometer.css\" />";
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
		$options = get_option("progress_thermometer");
		$current = $options['current'];
		$values = explode("\r",$options['steps']);

		echo $before_widget;

		echo "<div id=\"thermometer\">\r\n";
		/* If you want a dancing baby upon completion 
		   (and who wouldn't?), uncomment the next line.
		   It'd be nice if you hosted the image, too */
		//if ($current == count($values)-1) echo "<img src=\"http://www.communitybeerworks.com/files/2012/02/dancingbaby.gif\" style=\"position:absolute;left:400px; top:-5px\" />";
		echo "<ol>\r\n";
		$width = round((1/count($values)*100),1);
		if ($width*count($values) > 100) $width = $width - .1;
		foreach ($values as $id=>$value) {
			echo "<li style=\"width:" . $width . "%\"";
			if ($id == $current) echo " class=\"last completed\"";
			else if ($id < $current) echo " class=\"completed\"";
			echo ">\r\n<span>&nbsp;</span>\r\n";
			echo ($id == $current) ? "<strong>" . $value . "</strong>" : $value;
			echo "</li>\r\n";
		}
		echo "</ol>\r\n";

		// I admit I don't entirely know why this works.
		// If there are 1-5 or 8 values it will look different than otherwise
		if ($width*count($values) != 100) echo "<div style=\"width:" . (100-$width*count($values)) . "%\">&nbsp;</div>";
		else echo "<div class=\"clearfix\">&nbsp;</div>\r\n";
		echo "</div>\r\n";
		echo $after_widget;
	}

	// go elsewhere
	function form($instance) {
		echo "<p>To configure, use the <a href=\"options-general.php?page=thermometer_menu\">settings panel</a>.</p>\r\n";
	}
}
?>
