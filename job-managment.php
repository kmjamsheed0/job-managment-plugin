<?php
/*
Plugin Name: Job managment
Description: A  plugin to add jobs posts in wordpress functionality
Author: Jamsheed
Version: 0.1
Text Domain: jobs    
*/

include("custom_post.php");
include("custom_metaboxes.php");
include("submenu_settings.php");


/*if (!function_exists('write_log')) {
	public	function write_log ( $log )  {
		if ( true === WP_DEBUG ) {
			if ( is_array( $log ) || is_object( $log ) ) {
				error_log( print_r( $log, true ) );
			} else {
				error_log( $log );
			}
		}
	}
}*/

/*add_action( 'all', 'th_show_all_hooks' );
	
function th_show_all_hooks( $tag ) {
	if(!(is_admin())){ // Display Hooks in front end pages only
		$debug_tags = array();
		global $debug_tags;
		if ( in_array( $tag, $debug_tags ) ) {
			return;
		}
		echo "<pre>" . $tag . "</pre>";
		$debug_tags[] = $tag;
	}
}*/



 
?>