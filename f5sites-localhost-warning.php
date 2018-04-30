<?php
/* 
Plugin Name: F5 Sites | Localhost Warning
Plugin URI: https://www.f5sites.com/software/wordpress/f5sites-localhost-warning
Description: Tired of not knowing when you are on development server?
Author: Francisco Matelli Matulovic
Author URI: www.franciscomat.com
Version: 0.1
Tags: localhost, maintance
*/

add_action("wp_footer", "f5_warn");
add_action("admin_footer", "f5_warn");

function f5_warn () {
	if(get_option("host1name")) {
		if(gethostname()==get_option("host1name")) {
			echo get_option("host1html");
		} elseif(gethostname()==get_option("host2name")) {
			echo get_option("host2html");
		} elseif(gethostname()==get_option("host3name")) {
			echo get_option("host3html");
		}
	} else {
		//Uncomment line above to create default conf without need to configure wp-admin
		if(gethostname()=="note-itautec" || gethostname()=="note-samsung") {
			echo '<div style="background:#B33;position:fixed;top:0px;z-index:99999999;width:14%;left:43%;color:#FFF;font-weight:600;font-size:8px;text-align:center;">DEV SERVER</div>'; 
			#echo '<div style="background:#B33;position:fixed;top:0px;z-index:99999999;width:25%;left:20%;color:#FFF;font-weight:600;font-size:8px;text-align:center;">localhost - development server (hostname: note-itautec)</div>'; 
		}
	}
}

add_filter( 'plugin_action_links', 'f5_warn_plugin_link', 10, 2 );

function f5_warn_plugin_link ( $links, $file ) {
    if ( $file == plugin_basename(dirname(__FILE__) . '/localhost_warn.php') ) 
    {
        /*
         * Insert the link at the beginning
         */
        $in = '<a href="options-general.php?page=localhost-warn%2Flocalhost_warn.php">' . __('Settings','mtt') . '</a>';
        array_unshift($links, $in);

        /*
         * Insert at the end
         */
        // $links[] = '<a href="options-general.php?page=many-tips-together">'.__('Settings','mtt').'</a>';
    }
    return $links;
}

add_action('admin_menu', 'f5_warn_create_menu');

function f5_warn_create_menu() {
	//create new top-level menu
	add_submenu_page('options-general.php', 'Localhost Warn!', 'Localhost Warn!', 'administrator', __FILE__, 'f5_warn_settings' , plugins_url('/images/icon.png', __FILE__) );

	//call register settings function
	add_action( 'admin_init', 'f5_warn_register_plugin_settings' );
}


function f5_warn_register_plugin_settings() {
	//register our settings
	register_setting( 'f5-warn-settings-host', 'host1name' );
	register_setting( 'f5-warn-settings-host', 'host1html' );
	register_setting( 'f5-warn-settings-host', 'host2name' );
	register_setting( 'f5-warn-settings-host', 'host2html' );
	register_setting( 'f5-warn-settings-host', 'host3name' );
	register_setting( 'f5-warn-settings-host', 'host3html' );
}


function f5_warn_settings() {
	echo '<h1>Localhost Warn!</h1>';
	echo '<p>Provided by <a href="f5sites.com/localhost-warn">f5sites.com</a></p>';
	echo '<p>Current server hostname: <strong>'.gethostname().'</strong></p>';
	echo '<div class="wrap">';
	
	echo '<form method="post" action="options.php">';
	settings_fields( 'f5-warn-settings-host' );
	do_settings_sections( 'f5-warn-settings-host' );
	echo '<table class="form-table">
		<tr valign="top">
			<th scope="row">Host 1 name:</th>
			<td><input type="text" name="host1name" value="'.esc_attr( get_option('host1name') ).'" /></td>
			</tr>
			 
			<tr valign="top">
			<th scope="row">Host 1 html warn:</th>
			<td><textarea name="host1html" rows="8">'.esc_attr( get_option('host1html') ).'</textarea></td>
			<td valign="top"><p>Suggested:<br /><small>'.nl2br(htmlentities('
<div style="background:#B33;
position:fixed;
top:0px;
z-index:99999999;
width:25%;
left:20%;
color:#FFF;
font-weight:600;
font-size:8px;
text-align:center;">
localhost - development server (hostname: '.gethostname().')
</div>')).'</small></p>
			</td>
		</tr>
		
		<tr valign="top">
			<th scope="row">Host 2 name:</th>
			<td><input type="text" name="host2name" value="'.esc_attr( get_option('host2name') ).'" /></td>
			</tr>
			 
			<tr valign="top">
			<th scope="row">Host 2 html warn:</th>
			<td><textarea name="host2html" rows="8">'.esc_attr( get_option('host2html') ).'</textarea></td>
		</tr>

		<tr valign="top">
			<th scope="row">Host 3 name:</th>
			<td><input type="text" name="host3name" value="'.esc_attr( get_option('host3name') ).'" /></td>
			</tr>
			 
			<tr valign="top">
			<th scope="row">Host 3 html warn:</th>
			<td><textarea name="host3html" rows="8">'.esc_attr( get_option('host3html') ).'</textarea></td>
		</tr>

	    </table>';
	submit_button();
	echo '</form></div>';
	//echo '<input type="text" name="hostname_to_warn_submitted">'.get_option("hostname_to_warn").'</input>';
}

?>
