<?php

class custom_metaboxes {

	public function __construct()
	{
		add_action('add_meta_boxes', array($this, 'add_custom_meta_box'));
		add_action('save_post', array($this, 'save_custom_meta_box'),10,3);
		add_action( 'the_content', array($this,'meta_message' )); 

	} 
	
	public function add_custom_meta_box()
	{
    	add_meta_box("demo-meta-box", "Custom Meta Box", array($this, "custom_meta_box_markup"), "jobs", "side", "high", null);
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


}
$custom_metaboxes_object = new custom_metaboxes();


?>