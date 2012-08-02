<?php

defined('DS') or define('DS', DIRECTORY_SEPARATOR);

require_once 'KayakoAPILibrary' . DS . 'kyIncludes.php';
require_once 'KayakoApi.php';

final class KayakoWP {

	private $settings = array();

	public static $configured = FALSE;

	private $kayakoAPI = null;


	public function __construct() {

		//Calling Hooks
		add_action('admin_menu', array($this,'kayako_admin_actions'));
		add_action('admin_print_styles', array($this, '_admin_print_styles'));

		if($settings = get_option('kayako_settings')) {
			$this->settings = get_option('kayako_settings');
			$this->kayakoAPI = new KayakoApi($settings['kayako_url'], $settings['kayako_api'], $settings['kayako_secret']);
		}

		//$this->createTicket();

		//echo 'K4W initialized successfully';
	}

	/**
	 * Sets/Updates the Kayko settings
	 * @param type $data
	 * @return boolean
	 */
	public function saveSettings($data) {
		if(!is_array($data))
			return false;

		if(array_key_exists('kayako_url', $data))
			$this->settings['kayako_url'] = $data['kayako_url'];

		if(array_key_exists('kayako_key', $data))
			$this->settings['kayako_key'] = $data['kayako_key'];

		if(array_key_exists('kayako_secret', $data))
			$this->settings['kayako_secret'] = $data['kayako_secret'];

		if(array_key_exists('kayako_tag', $data))
			$this->settings['kayako_tag'] = $data['kayako_tag'];

		if(get_option('kayako_settings') !== FALSE) {
			return update_option('kayako_settings', $this->settings);
		}
		return add_option('kayako_settings', $this->settings);
	}

	/**
	 * Fetch the current Kayako settings
	 * @return mixed An asociative array of settings
	 */
	public function getSettings() {
		return $this->settings = get_option('kayako_settings');
	}

	public function kayako_admin_actions() {
		add_menu_page('Kayako for Wordpress', 'Kayako', 'administrator', 'kayako/settings.php', '', plugins_url('kayako/images/favicon.ico'), 99);
		add_submenu_page( 'kayako/settings.php', 'Kayako Settings', 'Helpdesk Settings', 'administrator', 'kayako/settings.php', '' );
		add_submenu_page( 'kayako/settings.php', 'Kayako Settings', 'Dropbox Settings', 'administrator', 'kayako/dropbox.php', '' );
	}

	public function _admin_print_styles() {
		// Admin Scripts
		wp_enqueue_style( 'kayako-admin', plugins_url( '/css/admin.css', __FILE__ ) );
	}

	// Create the function to output the contents of our Dashboard Widget

	public function kayako_dashboard_widget_function() {
		// Display whatever it is you want to show
		echo 'Wordpress meets Kayako . . .  & they both live happily ever after<br/>';
	}

	public function kayako_render_tag() {
		$tag = get_option('kayako_tag');
		echo stripslashes($tag);
	}





	public function dropbox_form() {
	}



	public function example_add_dashboard_widgets() {
		wp_add_dashboard_widget('kayako_dashboard', 'Kayako for Wordpress', 'kayako_dashboard_widget_function');
	}

	public function my_action_javascript() {
	?>
			<script type='text/javascript'>
				jQuery(function(){
					data = {
						action: 'my_action',
						whatever: 1234
					};

					jQuery.post(ajaxurl, data, function(response){
						alert('Response from server ' + response);
					});
				});


			</script>
	<?php
	}

	public function my_action_callback()
	{
		echo 'response';
	}

	public function setup() {
		//Hook into the 'wp_dashboard_setup' action to register our other functions
		//add_action('admin_head', 'my_action_javascript');
		//add_action('wp_ajax_my_action', 'my_action_callback');
		add_action('wp_dashboard_setup', 'example_add_dashboard_widgets' );
		add_action('admin_menu', 'kayako_admin_actions');
		add_action('wp_footer', 'kayako_render_tag');
		add_action( 'admin_print_styles', '_admin_print_styles' );
	}

	public function createTicket() {
		$data = array(
			'subject'			=>	'Created from Wordpress',
			'fullname'			=>	'Test User',
			'email'				=>	'test@kayako.com',
			'contents'			=>	'Some Dummy Texts . . .  . some more and some more',
			'departmentid'		=>	2,
			'ticketpriorityid'	=>	1,
			'tickettypeid'		=>	1,
			'staffid'			=>	1
		);

		return $this->kayakoAPI->createTicket($data);
	}
}