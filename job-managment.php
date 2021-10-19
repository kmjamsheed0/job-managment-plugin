<?php
/**
Plugin Name: Job managment
Description: A  plugin to add jobs posts in wordpress functionality
Author: Jamsheed
Version: 0.1
Text Domain: jobs    
*/
if ( ! defined( 'ABSPATH' ) ) {
        exit(); // Exit if accessed directly
}
include("custom_post.php");
include("custom_metaboxes.php");
include("submenu_settings.php");
include("applicant.php");
/**
 * Class for add applicant data to custom post applicant
 */
if ( ! class_exists( 'ApplicantData' ) ) {
  class ApplicantData {
    public function __construct() {
      add_action("wp_ajax_set_form", array($this, "set_form") );
      add_action("wp_ajax_nopriv_set_form", array($this, "set_form") );
      add_action( 'init', array($this,'script_enqueuer' ) );
    }
    public function set_form() {
      $name = sanitize_text_field($_POST['name']);
      $email = sanitize_email($_POST['email']);
      $message = sanitize_textarea_field($_POST['message']);
      $title = sanitize_text_field($_POST['jobname']);
      //To Save The Message In Custom Post Type
      $new_post = array(
       'post_title'    => $name,
       'post_content'  => $message."<br><br>Email : ".$email."<br>Applied For ".$title,
       'post_status'   => 'draft',           // Choose: publish, preview, future, draft, etc.
       'post_type' => 'applicant'  //'post',page' or use a custom post type if you want to
        );
      $pid = wp_insert_post($new_post);
      if ( empty( $email ) OR ! $email )
       {
           delete_post_meta( $pid,  'meta_email');
       }
      elseif( ! get_post_meta( $pid, 'meta_email' ) )
       {
           add_post_meta( $pid, 'meta_email', $email );
       }
       else
       {
           update_post_meta( $pid, 'meta_email', $email );
       }  
    }
    public function script_enqueuer() {
       // Register the JS file with a unique handle, file location, and an array of dependencies
       wp_register_script( "script", plugin_dir_url(__FILE__).'script.js', array('jquery') );
       // localize the script to your domain name, so that you can reference the url to admin-ajax.php file easily
       wp_localize_script( 'script', 'myAjax', array( 'ajaxurl' => admin_url( 'admin-ajax.php' )));         
       // enqueue jQuery library and the script you registered above
       wp_enqueue_script( 'jquery' );
       wp_enqueue_script( 'script' );
    }
  }  
  $objectApplicantData = new ApplicantData();
}
else {
    exit();
}
?>