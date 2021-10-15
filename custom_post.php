<?php


class custom_post {

	public function __construct()
	{
		add_action( 'init', array($this, 'job_plugin_setup_menu'),0);
		register_activation_hook(__FILE__, array($this, 'rewrite_flush'));
		add_shortcode( 'jobs-list', array($this, 'shortcode_display_jobs')); 

	} 

	public function job_plugin_setup_menu(){
	
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


	// >> Create Shortcode to list Jobs
  
	public function shortcode_display_jobs() {
	    $args = array(
	                    'post_type'      => 'jobs',
	                    'posts_per_page' => '5',
	                    'publish_status' => 'published',
	                 );
	  
	    $query = new WP_Query($args);
	  
	    if($query->have_posts()) :
	    	$result = "";
	  
	        while($query->have_posts()) :
	  
	            $query->the_post() ;
	            global $post;
				$data = get_post_meta($post -> ID, 'meta-box-text', true);
				$check = get_post_meta($post -> ID, 'meta-box-checkbox', true);
	            $flag = get_option('checkbox_field');
	            $link = get_permalink();
	            $color = get_option('selection_field');			
				
	            if ($flag == "true") 
	            {         
			        $result .= '<div class="job-item" style="width: 100%; margin:0 auto; clear: both; margin-bottom: 20px; overflow: auto; border-bottom: #eee thin solid; padding-bottom: 20px;">';
			        $result .= '<div class="job" style="width: 160px;float: left;margin-right: 25px; ">' . get_the_post_thumbnail() . '</div>';
			        $result .= '<div class="job-title" style="font-size: 30px; padding-bottom: 20px; "><a style="color:'.$color.';" href="'.$link.'">' . get_the_title() . '</a></div>';
			        $result .= '<div>Qualification: '.$data.'</div>';
			        $result .= '<div>Job Type- '.$check.' time</div>';
			        $result .= '<div class="job-desc">' . get_the_content() . '</div>';
			        $result .= '<div class="hr-mail">Send your CV to: ' . get_option( 'my_setting_field' ) . '</div>';
			        $result .= '<div class="address" style="text-align:center;">' . get_option( 'address' ) . '</div>';  
			        $result .= '</div><br>';
			    }
			    elseif ($flag == "") {
			    	$result .= '<div class="job-item" style="width: 100%; margin:0 auto; clear: both; margin-bottom: 20px; overflow: auto; border-bottom: #eee thin solid; padding-bottom: 20px;">';
			        $result .= '<div class="job" style="width: 160px;float: left;margin-right: 25px; ">' . get_the_post_thumbnail() . '</div>';
			        $result .= '<div class="job-title" style="font-size: 30px; padding-bottom: 20px;"><a href="'.$link.'">' . get_the_title() . '</a></div>';
			        $result .= '<div>Qualification: '.$data.'</div>';
			        $result .= '<div>Job Type- '.$check.' time</div>';
			        $result .= '<div class="job-desc">' . get_the_content() . '</div>';
			        $result .= '<div class="hr-mail">Send your CV to: ' . get_option( 'my_setting_field' ) . '</div>'; 
			        $result .= '</div><br>';
			    }

			    	
	  
	        endwhile;
	  
	        wp_reset_postdata();
	  
	    endif;    
	  
	    return $result;            
	}


	



}
$custompost_object = new custom_post();

?>