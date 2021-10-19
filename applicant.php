<?php
if ( ! defined( 'ABSPATH' ) ) {
        exit(); // Exit if accessed directly
    }
if ( ! class_exists( 'Applicant' ) ) {
  class Applicant {
    public function __construct()
      {
        add_action( 'init', array($this, 'applicant_post'));
      } 
    public function applicant_post() {
      $labels = array(
        'name'                     => _x( 'Applicants ', 'post type general name' ),
        'singular_name'        => _x( 'Applicant ', 'post type singular name' ),
        'add_new'                 => _x( 'Add New', 'applicant' ),
        'add_new_item'          => __( 'Add New Applicant ' ),
        'edit_item'               => __( 'Edit Applicant' ),
        'new_item'                => __( 'New Applicant' ),
        'all_items'               => __( 'All Applicant' ),
        'view_item'               => __( 'View Applicant' ),
        'search_items'           => __( 'Search Applicant' ),
        'not_found'               => __( 'Not found' ),
        'not_found_in_trash'  => __( 'Not found in the Trash' ), 
        'parent_item_colon'   => '',
        'menu_name'               => 'Applicant'
      );
    //register post type
      $args = array(
        'labels'                 => $labels,
        'description'          => 'Applicant description',
        'public'                 => true,
        'menu_position'       => 5,
        'supports'              => array( 'title', 'editor', 'thumbnail', 'excerpt', 'comments' ),
        'has_archive'         => true,
      );
      register_post_type( 'applicant', $args ); 

    // register taxonomy 
      register_taxonomy('applicant_category', 'applicant',array('hierarchical' => true, 'label' => 'Category', 'query_var' => true, 'rewrite' => array( 'slug' => 'applicant-category' )));
    }
  }
  $applicant_object = new Applicant();
}
else {
    exit();
}  
?>

