<?php

add_action('admin_menu', 'qig_admin_init');

function qig_admin_init() {
	add_options_page('Quick Image Gallery', 'Quick Image Gallery', 'manage_options', __FILE__, 'qig_settings');
	}
function qig_settings () {
	if( isset( $_POST['Submit'])) {
		$qig['images'] = $_POST['images'];
		$qig['gallery'] = $_POST['gallery'];
		$qig['select'] = $_POST['select'];
		$qig['caption'] = $_POST['caption'];
		update_option( 'qig', $qig);
		qig_admin_notice("The settings have been updated.");	
		}
	$qig = qig_get_stored_settings();
	$$qig['caption'] = "checked";
	$content = '
	<div class="wrap"><div id="icon-themes" class="icon32"><br /></div>
	<form method="post" action="">
	<h2>Quick Image Gallery</h2>
	<p>If you can read this it means plugin is installed, avtivated and already working on your site.</p>
	<p>Any clickable images in your posts and pages will open in a responsive floating box with buttons to scroll forwards and backwards.</p>
	<h2>Options</h2>
	<p><input style="margin:0; padding:0; border:none" type="checkbox" name="images" ' . $qig['images'] . ' value="checked"> Use the plugin on linked images in ALL posts and pages</p>
	<p><input style="margin:0; padding:0; border:none" type="checkbox" name="select" ' . $qig['select'] . ' value="checked"> Use the plugin with linked images on SELECTED posts and pages. Add the shortcode <code>[qig]</code> to those posts and pages where you want to use the plugin.</p>
	<p><input style="margin:0; padding:0; border:none" type="checkbox" name="gallery" ' . $qig['gallery'] . ' value="checked"> Use the plugin with wordpress galleries</p>
	<p>Image Captions: <input style="margin:0; padding:0; border:none" type="radio" name="caption" ' . $usetitle . ' Value ="usetitle"> Use image title <input style="margin:0; padding:0; border:none" type="radio" name="caption" ' . $usealt . ' Value ="usealt"> Use alternate text <input style="margin:0; padding:0; border:none" type="radio" name="caption" ' . $usenone . ' Value ="usenone"> No caption</p>
	<p><input type="submit" name="Submit" class="button-primary" style="color: #FFF;" value="Save Settings" /></p>
	</form>
	<p>If you come unstuck, email me at <a href="mailto:mail@quick-plugins.com">mail@quick-plugins.com</a></p>
	</div>';
	echo $content;
	}
function qig_admin_notice($message) {
	if (!empty( $message)) echo '<div class="updated"><p>'.$message.'</p></div>';
	}