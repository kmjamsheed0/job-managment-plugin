<?php
if ( ! defined( 'ABSPATH' ) ) {
        exit(); // Exit if accessed directly
}

if ( ! class_exists( 'SubmenuSettings' ) ) {
	class SubmenuSettings {
		public function __construct() {
			add_action('admin_menu', array($this, 'submenu_settings'));
			add_action( 'admin_init', array($this, 'my_settings_init'));	
		} 
		public function submenu_settings() {
			add_submenu_page(
				'edit.php?post_type=jobs',
				'Jobs Settings',
				'Jobs Settings',
				'manage_options',
				'job_settings',
				array($this, 'settings_render')
			);
		}
		public function settings_render() {
			echo '<h2><center> Jobs Settings </center></h2>';
	 		?>
			    <h1> <?php esc_html_e( 'You can manage your jobs settings here.'); ?> </h1>
			    <form method="POST" action="options.php">
			    <?php
			    settings_fields( 'job_settings' );
			    do_settings_sections( 'job_settings' );
			    submit_button();
			    ?>
			    </form>
	   		<?php             
		}
		public function my_settings_init() {
		    add_settings_section(
		        'sample_page_setting_section',
		        __( 'Custom settings', 'my-textdomain' ),
		        array($this,'my_setting_section_callback_function'),
		        'job_settings'
		    );
				add_settings_field(
				   'my_setting_field',
				   __( 'Add HR Email Field', 'my-textdomain' ),
				   array($this,'my_setting_markup'),
				   'job_settings',
				   'sample_page_setting_section'
				);
				add_settings_field(
				   'address',
				   __( 'Add Company Address Field', 'my-textdomain' ),
				   array($this,'address_markup'),
				   'job_settings',
				   'sample_page_setting_section'
				);
				add_settings_field(
				   'checkbox_field',
				   __( 'Show Address in front end', 'my-textdomain' ),
				   array($this,'checkbox_markup'),
				   'job_settings',
				   'sample_page_setting_section'
				);
				add_settings_field(
				   'selection_field',
				   __( 'Select the title color', 'my-textdomain' ),
				   array($this,'selection_markup'),
				   'job_settings',
				   'sample_page_setting_section'
				);
				register_setting( 'job_settings', 'my_setting_field' );
				register_setting( 'job_settings', 'address' );
				register_setting( 'job_settings', 'checkbox_field' );
				register_setting( 'job_settings', 'selection_field' );
		}
		public function my_setting_section_callback_function() {
		    echo '<p>This Settings Section can add  email to every job post and also can add company address</p>';
		}
		public function my_setting_markup() {
		    ?>
		    <label for="my-input"><?php _e( 'Email: ' ); ?></label>
		    <input type="email" id="my_setting_field" name="my_setting_field" value="<?php echo get_option( 'my_setting_field' ); ?>"><br><br>
		    <?php
		}
		public function address_markup() {    
		    ?>
	  		Write Company Address Here: <br>
	  		<textarea rows="5" cols="50" name="address"><?php echo get_option( 'address' ); ?>
	  		</textarea>
		    <?php
		}
		public function checkbox_markup() {
		    $flag = get_option('checkbox_field');
		    if($flag == "") {
	            ?>
	                <input name="checkbox_field" type="checkbox" value="true">
	            <?php
	        }
            else if($flag == "true") {
	            ?>  
	                <input name="checkbox_field" type="checkbox" value="true" checked>
	            <?php
            }
		}
		public function selection_markup() {
		    ?>
		    <label for="color">Choose a color:</label>
			<select name="selection_field" id="color">
				<option value="#000000" selected>BLACK</option>
				<option value="#FF0000">RED</option>
				<option value="#FFFF00">YELLOW</option>
				<option value="#4B0082">INDIGO</option>
				<option value="#008000">GREEN</option>
			</select>
		    <?php
		}
	}
	$submenu_settings_object = new SubmenuSettings();
}
else {
    exit();
}  	
?>