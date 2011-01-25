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

add_action('admin_menu', 'thermometer_menu');

function thermometer_menu() {
	add_options_page('Thermometer Config', 'Progress Thermometer', 'manage_options', 'thermometer_menu', 'thermometer_menu_options');
}

function thermometer_menu_options() {
	if (!current_user_can('manage_options'))  {
		wp_die( __('You do not have sufficient permissions to access this page.') );
	}
?>

<div class="wrap">

<h2>Thermometer Config</h2>

	<?php if ($_POST['submit']) { ?>
<div class="updated"><p><strong>Settings saved (not really).</strong></p></div>
	<?php } ?>

<form name="thermometer_form" method="post" action="">

<p class="submit">
<input type="submit" name="submit" id="submit" class="button-primary" value="<?php esc_attr_e('Save Changes') ?>" />
</p>

</form>

</div>
<?php
}

function get_thermometer() {
	$current = 2;

	$values = array("Zoning variance","Close on building","Submit TTB application","Receive TTB license","Submit SLA application","Receive SLA license","Beer!");

	echo "<div id=\"thermometer\">\r\n";
	echo "<ul>\r\n";
	foreach ($values as $id=>$value) {
		echo "<li style=\"width:" . (1/count($values)*100) . "%\"";
		if ($id == $current) echo " class=\"last completed\"";
		else if ($id < $current) echo " class=\"completed\"";
		echo ">\r\n<div>&nbsp;</div>\r\n";
		echo $value . "</li>\r\n";
	}
	echo "</ul>\r\n";
	echo "</div>\r\n";
}
?>
