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
		add_action('admin_menu', array($this, 'submenu_settings'));
		add_action( 'init', array($this, 'job_plugin_setup_menu'),0);
		register_activation_hook(__FILE__, array($this, 'rewrite_flush'));
		add_action('add_meta_boxes', array($this, 'add_custom_meta_box'));
		add_action('save_post', array($this, 'save_custom_meta_box'),10,3);
		add_action( 'the_content', array($this,'meta_message' ));
		add_shortcode( 'jobs-list', array($this, 'shortcode_display_jobs')); 

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


public function custom_meta_box_markup($object)
{
    wp_nonce_field(basename(__FILE__), "meta-box-nonce");

    ?>
        <div>
            <label for="meta-box-text">Basic Qualification:</label>
            <input name="meta-box-text" placeholder="candidate qualification" type="text" value="<?php echo get_post_meta($object->ID, "meta-box-text", true);?>"><br><br>
        	<fieldset style='background-color: #eeeeee;'>
	            <legend style='background-color: gray;color: white; padding: 5px 10px;'>Job Type-</legend>
	            <label for="full" >Full Time : </label>
	            <input id="full" name="meta-box-checkbox" type="radio" value="full"><br>
	            <label for="part">Part Time : </label>
	            <input id="part" name="meta-box-checkbox" type="radio" value="part">
        	</fieldset>
        </div>
    <?php  
}

public function save_custom_meta_box($post_id, $post, $update)
{
    if (!isset($_POST["meta-box-nonce"]) || !wp_verify_nonce($_POST["meta-box-nonce"], basename(__FILE__)))
        return $post_id;

    if(!current_user_can("edit_post", $post_id))
        return $post_id;

    if(defined("DOING_AUTOSAVE") && DOING_AUTOSAVE)
        return $post_id;

    $slug = "jobs";
    if($slug != $post->post_type)
        return $post_id;

    $meta_box_text_value = "";
    $meta_box_checkbox_value = "";

    if(isset($_POST["meta-box-text"]))
    {
        $meta_box_text_value = sanitize_text_field($_POST["meta-box-text"]);
    }   
    update_post_meta($post_id, "meta-box-text", $meta_box_text_value);

    if(isset($_POST["meta-box-checkbox"]))
    {
        $meta_box_checkbox_value = $_POST["meta-box-checkbox"];
    }   
    update_post_meta($post_id, "meta-box-checkbox", $meta_box_checkbox_value);
  
}


public function meta_message( $pst ) {
	global $post;
	$data = get_post_meta($post -> ID, 'meta-box-text', true);
	$check = get_post_meta($post -> ID, 'meta-box-checkbox', true);
	if (!empty($data) && $check=='full' ) {
			$custom_message = "<div style='font-weight:lighter;text-align:center'><p> Qualification: ";
			$custom_message .= $data;
			$custom_message .= "<br> Full Time Job</p></div>";
			$pst = $pst.$custom_message;
		}
	else if (!empty($data) && $check=='part'){
			$custom_message = "<div style='font-weight:lighter;text-align:center'><p> Qualification: ";
			$custom_message .= $data;
			$custom_message .= "<br> Part Time Job</p></div>";
			$pst = $pst.$custom_message;
	}

		return $pst;
	}




public function add_custom_meta_box()
{
    add_meta_box("demo-meta-box", "Custom Meta Box", array($this, "custom_meta_box_markup"), "jobs", "side", "high", null);
}

public function submenu_settings(){

	add_submenu_page(
		'edit.php?post_type=jobs',
		'Jobs Settings',
		'Jobs Settings',
		'manage_options',
		'job_settings',
		array($this, 'settings_render')
	);
}

public function settings_render(){
	echo '<h2> Jobs Settings </h2>';
}



// >> Create Shortcode to Display Jobs Post Types
  
public function shortcode_display_jobs(){
  
    $args = array(
                    'post_type'      => 'jobs',
                    'posts_per_page' => '5',
                    'publish_status' => 'published',
                 );
  
    $query = new WP_Query($args);
  
    if($query->have_posts()) :
  
        while($query->have_posts()) :
  
            $query->the_post() ;
            global $post;
			$data = get_post_meta($post -> ID, 'meta-box-text', true);
			$check = get_post_meta($post -> ID, 'meta-box-checkbox', true);
                      
	        $result .= '<div class="job-item" style="width: 100%; margin:0 auto; clear: both; margin-bottom: 20px; overflow: auto; border-bottom: #eee thin solid; padding-bottom: 20px;">';
	        $result .= '<div class="job" style="width: 160px;float: left;margin-right: 25px; ">' . get_the_post_thumbnail() . '</div>';
	        $result .= '<div class="job-title" style="font-size: 30px; padding-bottom: 20px;">' . get_the_title() . '</div>';
	        $result .= '<div>Qualification: '.$data.'</div>';
	        $result .= '<div>Job Type- '.$check.' time</div>';
	        $result .= '<div class="job-desc">' . get_the_content() . '</div>'; 
	        $result .= '</div><br>';
  
        endwhile;
  
        wp_reset_postdata();
  
    endif;    
  
    return $result;            
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