<?php
add_action('admin_menu', 'thermometer_menu');
add_action('admin_init','thermometer_settings_init');

function thermometer_settings_init() {
	register_setting('progress_thermometer','milestones');
//	register_setting('progress_thermometer','current');
}

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

        <?php if ($_POST['submit']) { 
		$options['steps'] = $_POST['steps'];
		$options['current'] = (is_numeric($_POST['current'])) ? $_POST['current'] : "0";
		update_option("progress_thermometer",$options);
	?>
<div class="updated"><p><strong>Settings saved!</strong></p></div>
        <?php } ?>

<form name="thermometer_form" method="post" action="">
<?php settings_fields("progress_thermometer"); ?>
<?php $options = get_option("progress_thermometer"); ?>
<table class="form-table">
<tr valign="top">
<th scope="row">Add steps (one per line)</th>
<td><textarea name="steps" id="steps" rows="10" cols="50"><?php echo $options['steps']; ?></textarea></td>
</tr>
<tr valign="top">
<th scope="row">Current step</th>
<td><select name="current" id="current">
<?php 
foreach (explode("\r",$options['steps']) as $id=>$step) {
	echo "<option value=\"" . $id . "\"";
	if ($id == $options['current']) echo " selected=\"selected\"";
	echo ">" . $step . "</option>\r\n";
}
?>
</td>
</tr>
</table>
<p class="submit">
<input type="submit" name="submit" id="submit" class="button-primary" value="<?php esc_attr_e('Save Changes') ?>" />
</p>

</form>

</div>
<?php
}
?>
