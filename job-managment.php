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
include("applicant.php");

add_action("wp_ajax_set_form", "set_form");
add_action("wp_ajax_nopriv_set_form", "set_form");


// define the function to be fired for logged in users
/*function my_user_like() {
   
   // nonce check for an extra layer of security, the function will exit if it fails
   if ( !wp_verify_nonce( $_REQUEST['nonce'], "my_user_like_nonce")) {
      exit("Woof Woof Woof");
   }   
   
   // fetch like_count for a post, set it to 0 if it's empty, increment by 1 when a click is registered 
   $like_count = get_post_meta($_REQUEST["post_id"], "likes", true);
   $like_count = ($like_count == ’) ? 0 : $like_count;
   $new_like_count = $like_count + 1;
   
   // Update the value of 'likes' meta key for the specified post, creates new meta data for the post if none exists
   $like = update_post_meta($_REQUEST["post_id"], "likes", $new_like_count);
  

   
   // If above action fails, result type is set to 'error' and like_count set to old value, if success, updated to new_like_count  
   if($like === false) {
      $results['type'] = "error";
      $results['like_count'] = $like_count;
   }
   else {
      $results['type'] = "success";
      /*$html = '<div><br><form >
  				<label for="fname">First name:</label><br>
  				<input type="text" id="fname" name="fname"><br>
  				<label for="phone">Phone:</label><br>
  				<input type="tel" id="phone" name="phone" ><br><br>
  				<input type="submit" id="mySubmit" value="Submit" onclick="myFunction">
				</form> </div> ';*/
  /*    $results['like_count'] = $new_like_count;
   }
   
   // Check if action was fired via Ajax call. If yes, JS code will be triggered, else the user is redirected to the post page
   if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
      $results = json_encode($results);
      echo $results;
   }
   else {
      header("Location: ".$_SERVER["HTTP_REFERER"]);
   }

   // don't forget to end your scripts with a die() function - very important
   die();
}*/

function set_form(){
  $name = $_POST['name'];
  $email = $_POST['email'];
  $message = $_POST['message'];
  //die();
//To Save The Message In Custom Post Type
$new_post = array(
   'post_title'    => $name,
   'post_content'  => $message,
   'post_status'   => 'draft',           // Choose: publish, preview, future, draft, etc.
   'post_type' => 'applicant'  //'post',page' or use a custom post type if you want to
    );
$pid = wp_insert_post($new_post);

  if( ! get_post_meta( $pid, 'meta_email' ) )
   {
       add_post_meta( $pid, 'meta_email', $email );
   }
   else
   {
       update_post_meta( $pid, 'meta_email', $email );
   }
  
}



// used here only for enabling syntax highlighting. Leave this out if it's already included in your plugin file.

// Fires after WordPress has finished loading, but before any headers are sent.
add_action( 'init', 'script_enqueuer' );

function script_enqueuer() {
   
   // Register the JS file with a unique handle, file location, and an array of dependencies
   wp_register_script( "liker_script", plugin_dir_url(__FILE__).'liker_script.js', array('jquery') );
   
   // localize the script to your domain name, so that you can reference the url to admin-ajax.php file easily
   wp_localize_script( 'liker_script', 'myAjax', array( 'ajaxurl' => admin_url( 'admin-ajax.php' )));        
   
   // enqueue jQuery library and the script you registered above
   wp_enqueue_script( 'jquery' );
   wp_enqueue_script( 'liker_script' );
}

	function write_log ( $log )  {
		if ( true === WP_DEBUG ) {
			if ( is_array( $log ) || is_object( $log ) ) {
				error_log( print_r( $log, true ) );
			} else {
				error_log( $log );
			}
		}
	}
 
?>