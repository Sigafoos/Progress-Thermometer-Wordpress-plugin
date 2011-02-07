<?php
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
<?php settings_fields("progress_thermometer"); ?>
<table class="form-table">
<tr valign="top">
<th scope="row">Add options (one per line)</th>
<td><textarea name="options" id="options" rows="10" cols="50"></textarea></td>
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
