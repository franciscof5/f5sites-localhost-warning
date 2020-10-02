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
$local_host_name = file("/etc/hostname");
$dev_host_name  = "fnetwork_wordpress";
$show_localhost_warn = strpos($local_host_name[0], $dev_host_name);
#if($lines_array[0]=="fnetwork_wordpress" || $lines_array[0]=="fnetwork_wordpress ") {
if(is_numeric($show_localhost_warn)) {
	add_action("wp_footer", "f5_warn");
	add_action("admin_footer", "f5_warn");
}

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
		echo '<div style="background:#B33;position:fixed;top:0px;z-index:99999999;width:14%;left:43%;color:#FFF;font-weight:600;font-size:8px;text-align:center;">'.gethostname().'</div>'; 
	}
}
