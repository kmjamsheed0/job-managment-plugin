<?php
/*
Plugin Name: Job managment
Description: A  plugin to add jobs posts in wordpress functionality
Author: Jamsheed
Version: 0.1
Text Domain: jobs    
*/
class jobplugin {

	public function __construct()
	{
		//add_action('admin_menu', array($this, 'job_plugin_setup_menu'));
		add_action( 'init', array($this, 'job_plugin_setup_menu'),0);
		register_activation_hook(__FILE__, array($this, 'rewrite_flush'));

	} 
	public function job_plugin_setup_menu(){
	    //add_menu_page( 'Job Plugin Page', 'Job Managment', 'manage_options', 'job-plugin', array($this,'test_init') );
		$labels =  array(
			'name' => __('Jobs', 'Post type Genearal name','jobs'),
			'singular_name' => __('Job', 'Post type Singular name','jobs'),
			'menu_name' => __('Jobs', 'jobs'),
			'name_admin_bar' => __('Jobs', 'jobs'), 
			'archives' => __('Job Archives', 'jobs'),
			'attributes' => __('Job Attributes', 'jobs'),
			'parent_item_colon' => __('Parent Job', 'jobs'),
			'all_items' => __('All Jobs', 'jobs'),
			'add_new_item' => __('Add New Job', 'jobs'),
			'add_new' => __('Add New', 'jobs'),
			'new_item' => __('New Job', 'jobs'), 
			'edit_item' => __('Edit Job', 'jobs'),
			'update_item' => __('Update Job', 'jobs'),
			'view_item' => __('View Job', 'jobs'),
			'view_items' => __('View Jobs', 'jobs'),
			'search_items' => __('Search Jobs', 'jobs'),
			'not_found' => __('Not Found', 'jobs'),
			'not_found_in_trash' => __('Not Found in Trash', 'jobs'),
			'featured_image' => __('Featured Image', 'jobs'),
			'set_featured_image' => __('Set Featured Image', 'jobs'),
			'remove_featured_image' => __('Remove Featured Image', 'jobs'),
			'use_featured_image' => __('Use as Featured Image', 'jobs'),
			'insert_into_item' => __('Insert into Job', 'jobs'),
			'uploaded_to_this_item' => __('Uploaded to this job', 'jobs'),
			'items_list' => __('Job List', 'jobs'),
			'items_list_navigation' => __('Jobs list Navigation', 'jobs'),
			'filter_items_list' => __('Filter Jobs List', 'jobs'),

		);	

		$args = array(
			'label' => __('Job', 'jobs'),
			'description' => __('Job Description', 'jobs'),
			'labels' => $labels,
			'menu_icon' => 'dashicons-portfolio',
			'supports' => array('title','editor', 'thumbnail' , 'revisions' , 'author',),
			'taxonomies' => array('category','post_tag'),
			'public' => true,
			'show_ui' => true,
			'show_in_menu' => true,
			'menu_position' => 5,
			'show_in_admin_bar' => true,
			'show_in_nav_menus' => true,
			'can_export' => true,
			'has_archive' => true,
			'hierarchical' => false,
			'exclude_from_search' => false,
			'show_in_rest' => true,
			'publicly_queryable' => true,
			'capability_type' => 'post',
			'rewrite' => array('slug' => 'jobs'),

		);

		register_post_type('jobs', $args);



	}


	 
	public function rewrite_flush(){
	    $this->job_plugin_setup_menu();
	    flush_rewrite_rules();
		
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