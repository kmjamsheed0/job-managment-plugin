<?php

class custom_metaboxes {

	public function __construct()
	{
		add_action('add_meta_boxes', array($this, 'add_custom_meta_box'));
		add_action('save_post', array($this, 'save_custom_meta_box'),10,3);
		add_filter( 'the_content', array($this,'meta_message' )); 

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
        	<label for="expire_date">Expire On:</label>
  			<input type="date" id="expire_date" name="expire_date">
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
	    $expire_date = "";

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

	    if(isset($_POST["expire_date"]))
	    {
	        $expire_date = $_POST["expire_date"];
	    }   
	    update_post_meta($post_id, "expire_date", $expire_date);
  
	}


	public function meta_message( $pst) {

		if ( ! is_single() ) {
        return $pst;
    	}	
		global $post;
		$data = get_post_meta($post -> ID, 'meta-box-text', true);
		$check = get_post_meta($post -> ID, 'meta-box-checkbox', true);
		$date = get_post_meta($post -> ID, 'expire_date', true);
		if (!empty($data) && $check=='full' ) {
				$custom_message = "<div style='font-weight:lighter;text-align:center'><p> Qualification: ";
				$custom_message .= $data;
				$custom_message .= "<br> Full Time Job<br>";
				$custom_message .= "<br> Expire On: ".$date."</p></div>";
				$pst = $pst.$custom_message;
			}
		else if (!empty($data) && $check=='part'){
				$custom_message = "<div style='font-weight:lighter;text-align:center'><p> Qualification: ";
				$custom_message .= $data;
				$custom_message .= "<br> Part Time Job<br>";
				$custom_message .= "<br> Expire On: ".$date."</p></div>";
				$pst = $pst.$custom_message;
		}

					$likes = get_post_meta($post-> ID, "likes", true);
					$likes = ($likes == "") ? 0 : $likes;
			

					

				// Linking to the admin-ajax.php file. Nonce check included for extra security. Note the "user_like" class for JS enabled clients.
				
					$nonce = wp_create_nonce("my_user_like_nonce");
					$links = admin_url('admin-ajax.php?action=my_user_like&post_id='.$post-> ID.'&nonce='.$nonce);

					$pst .= '<button id="Mybtn" onclick="get()">Apply for Job</button><br><br>
							<form id="data_form" action="" class="ajax" hidden >	
  							<label><b>Name</b></label>
          					<input type="text" placeholder="Enter Your Name" name="name" required class="name">
							<label><b>Email</b></label>
							<input type="email" placeholder="Enter your Email" name="email" required class="email">
							<br><label><b>Skills</b></label>
							<textarea rows="3" cols="5" placeholder="Your Skills" name="message" required class="message" ></textarea><hr>
            				<div id="msg"></div>
							<input type = "submit" class="submitbtn" value="Submit">
							<div class="success_msg" style="display: none">Your Application sent!<br></div>
							</form>';	
					//$pst .= '<button><a class="user_like" data-nonce="' . $nonce . '" data-post_id="' . $post-> ID . '" href="' . $links . '">Apply for this </a></button><br>';
					$pst.= '<div><span class="preview">'.$likes.' Applied</span><br></div>';


			return $pst;
	}


}
$custom_metaboxes_object = new custom_metaboxes();


?>