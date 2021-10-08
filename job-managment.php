<?php
/*
Plugin Name: Job managment
Description: A  plugin to add jobs posts in wordpress functionality
Author: Jamsheed
Version: 0.1
*/
class jobplugin {

	public function __construct()
	{
		add_action('admin_menu', array($this, 'job_plugin_setup_menu'));
		//add_action( 'init', array($this, 'test_init'));

	} 
	public function job_plugin_setup_menu(){
	    add_menu_page( 'Job Plugin Page', 'Job Managment', 'manage_options', 'job-plugin', array($this,'test_init') );
	}
	 
	public function test_init(){
	    echo "<h1>Hello World!</h1>";
	    $abc="checking";
	    $this->write_log("asdd".$abc);


	}
	//if (!function_exists('write_log')) {
	public	function write_log ( $log )  {
		if ( true === WP_DEBUG ) {
			if ( is_array( $log ) || is_object( $log ) ) {
				error_log( print_r( $log, true ) );
			} else {
				error_log( $log );
			}
		}
	}
//}

}
$jobplugin_object = new jobplugin();
 
?>