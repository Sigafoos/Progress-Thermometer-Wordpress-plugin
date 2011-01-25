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

function get_thermometer() {
?>
<div id="thermometer">Hello</div>
<?php
}
?>
