<?php

class submenu_settings {

	public function __construct()
	{
		add_action('admin_menu', array($this, 'submenu_settings'));
		add_action( 'admin_init', array($this, 'my_settings_init'));
		/*add_action( 'admin_init', array( $this, 'sub_menu_page_init' ) );
    	add_action( 'admin_init', array( $this, 'media_selector_scripts' ) );*/ 

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

 		?>
		    <h1> <?php esc_html_e( 'Welcome to my custom settings menu.', 'my-plugin-textdomain' ); ?> </h1>
		    <form method="POST" action="options.php">
		    <?php
		    settings_fields( 'sample-page' );
		    do_settings_sections( 'sample-page' );
		    submit_button();
		    ?>
		    </form>
   		<?php               


                /*settings_fields( 'smashing_fields' );
                do_settings_sections( 'smashing_fields' );
                submit_button();
            
		/*$this->options = get_option( 'rushhour_projects_archive' );

	    wp_enqueue_media();

	    echo '<div class="wrap">';

	    printf( '<h1>%s</h1>', __('Job Options', 'rushhour' ) ); 

	    echo '<form method="post" action="options.php">';

	    settings_fields( 'projects_archive' );

	    do_settings_sections( 'projects-archive-page' );

	    submit_button();

	    echo '</form></div>';*/


	}



	public function my_settings_init() {

	    add_settings_section(
	        'sample_page_setting_section',
	        __( 'Custom settings', 'my-textdomain' ),
	        array($this,'my_setting_section_callback_function'),
	        'sample-page'
	    );

			add_settings_field(
			   'my_setting_field',
			   __( 'My custom setting field', 'my-textdomain' ),
			   array($this,'my_setting_markup'),
			   'sample-page',
			   'sample_page_setting_section'
			);

			register_setting( 'sample-page', 'my_setting_field' );
	}

	public function my_setting_section_callback_function() {
	    echo '<p>Add HR email to every jobs</p>';
	}

	public function my_setting_markup() {
	    ?>
	    <label for="my-input"><?php _e( 'HR-Email' ); ?></label>
	    <input type="email" id="my_setting_field" name="my_setting_field" value="<?php echo get_option( 'my_setting_field' ); ?>">
	    <?php
	}



			/**
	 * Register and add settings
	 */
	/*public function sub_menu_page_init()
	{
	    register_setting(
	        'projects_archive', // Option group
	        'rushhour_projects_archive', // Option name
	        array( $this, 'sanitize' ) // Sanitize
	        );

	    add_settings_section(
	        'header_settings_section', // ID
	        __('Header Settings', 'rushhour'), // Title
	        array( $this, 'print_section_info' ), // Callback
	        'projects-archive-page' // Page
	        );

	    add_settings_field(
	        'archive_description', // ID
	        __('Archive Description', 'rushhour'), // Title
	        array( $this, 'archive_description_callback' ), // Callback
	        'projects-archive-page', // Page
	        'header_settings_section' // Section
	        );

	    add_settings_field(
	        'image_attachment_id',
	        __('Header Background Image', 'rushhour'),
	        array( $this, 'header_bg_image_callback' ),
	        'projects-archive-page',
	        'header_settings_section'
	        );
	}

	/**
	 * Sanitize each setting field as needed
	 *
	 * @param array $input Contains all settings fields as array keys
	 */
	/*public function sanitize( $input )
	{
	    $new_input = array();

	    if( isset( $input['archive_description'] ) )
	        $new_input['archive_description'] = sanitize_text_field( $input['archive_description'] );

	    if( isset( $input['image_attachment_id'] ) )
	        $new_input['image_attachment_id'] = absint( $input['image_attachment_id'] );

	    return $new_input;
	}

	/**
	 * Print the Section text
	 */
	/*public function print_section_info()
	{
	    print 'Select options for the archive page header.';
	}

	/**
	 * Get the settings option array and print one of its values
	 */
	/*public function archive_description_callback()
	{
	    printf(
	        '<input type="text" id="archive_description" name="rushhour_projects_archive[archive_description]" value="%s" />',
	        isset( $this->options['archive_description'] ) ? esc_attr( $this->options['archive_description']) : ''
	        );
	}

	/**
	 * Get the settings option array and print one of its values
	 */
	/*public function header_bg_image_callback()
	{
	    $attachment_id = $this->options['image_attachment_id'];

	    // Image Preview
	    printf('<div class="image-preview-wrapper"><img id="image-preview" src="%s" ></div>', wp_get_attachment_url( $attachment_id ) );

	    // Image Upload Button
	    printf( '<input id="upload_image_button" type="button" class="button" value="%s" />',
	        __( 'Upload image', 'rushhour' ) );

	    // Hidden field containing the value of the image attachment id
	    printf( '<input type="hidden" name="rushhour_projects_archive[image_attachment_id]" id="image_attachment_id" value="%s">',
	        $attachment_id );
	}

	public function media_selector_scripts()
	{
	    $my_saved_attachment_post_id = get_option( 'media_selector_attachment_id', 0 );

	    wp_register_script( 'sub_menu_media_selector_scripts', get_template_directory_uri() . '/admin/js/media-selector.js', array('jquery'), false, true );

	    $selector_data = array(
	        'attachment_id' => get_option( 'media_selector_attachment_id', 0 )
	        );

	    wp_localize_script( 'sub_menu_media_selector_scripts', 'selector_data', $selector_data );

	    wp_enqueue_script( 'sub_menu_media_selector_scripts' );
	}*/



}
$submenu_settings_object = new submenu_settings();

?>