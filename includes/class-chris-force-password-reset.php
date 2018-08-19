<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       #
 * @since      1.0.0
 *
 * @package    fpr_Chris_Force_Password_Reset
 * @subpackage fpr_Chris_Force_Password_Reset/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    fpr_Chris_Force_Password_Reset
 * @subpackage fpr_Chris_Force_Password_Reset/includes
 * @author     ChristianNwachukwu <nwachukwu16@gmail.com>
 */
class fpr_Chris_Force_Password_Reset {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      fpr_Chris_Force_Password_Reset_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $plugin_name    The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {
		if ( defined( 'FPR_PLUGIN_NAME_VERSION' ) ) {
			$this->version = FPR_PLUGIN_NAME_VERSION;
		} else {
			$this->version = '1.0.0';
		}
		$this->plugin_name = 'chris-force-password-reset';

		$this->fpr_load_dependencies();
		$this->fpr_set_locale();
		$this->fpr_define_admin_hooks();
		$this->fpr_define_public_hooks();

	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - fpr_Chris_Force_Password_Reset_Loader. Orchestrates the hooks of the plugin.
	 * - fpr_Chris_Force_Password_Reset_i18n. Defines internationalization functionality.
	 * - fpr_Chris_Force_Password_Reset_Admin. Defines all hooks for the admin area.
	 * - fpr_Chris_Force_Password_Reset_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function fpr_load_dependencies() {

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-chris-force-password-reset-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-chris-force-password-reset-i18n.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-chris-force-password-reset-admin.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-chris-force-password-reset-public.php';

		$this->loader = new fpr_Chris_Force_Password_Reset_Loader();

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the fpr_Chris_Force_Password_Reset_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function fpr_set_locale() {

		$plugin_i18n = new fpr_Chris_Force_Password_Reset_i18n();

		$this->loader->fpr_add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function fpr_define_admin_hooks() {

		$plugin_admin = new fpr_Chris_Force_Password_Reset_Admin( $this->fpr_get_plugin_name(), $this->fpr_get_version() );

		$this->loader->fpr_add_action('admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		$this->loader->fpr_add_action('admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );
		$this->loader->fpr_add_action('profile_update', $plugin_admin, 'fpr_profile_update' );
		$this->loader->fpr_add_action('admin_menu', $plugin_admin, 'fpr_settings_page' );
		$this->loader->fpr_add_action('admin_init', $plugin_admin, 'options_update');
		$this->loader->fpr_add_action('admin_init', $plugin_admin, 'valid_password_reset');
		$this->loader->fpr_add_action('admin_notices', $plugin_admin, 'my_error_notice');
		$this->loader->fpr_add_action('password_reset', $plugin_admin, 'fpr_password_reset_called', 10, 2);

		$plugin_basename = plugin_basename( plugin_dir_path( __DIR__ ) . $this->plugin_name . '.php' );
		$this->loader->fpr_add_filter( 'plugin_action_links_' . $plugin_basename, $plugin_admin, 'add_action_links' );
 	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function fpr_define_public_hooks() {

		$plugin_public = new fpr_Chris_Force_Password_Reset_Public( $this->fpr_get_plugin_name(), $this->fpr_get_version() );

		$this->loader->fpr_add_action( 'wp_enqueue_scripts', $plugin_public, 'fpr_enqueue_styles' );
		$this->loader->fpr_add_action( 'wp_enqueue_scripts', $plugin_public, 'fpr_enqueue_scripts' );

	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function fpr_run_main() {
		$this->loader->fpr_run_loader();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function fpr_get_plugin_name() {
		return $this->plugin_name;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    fpr_Chris_Force_Password_Reset_Loader    Orchestrates the hooks of the plugin.
	 */
	public function fpr_get_loader() {
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function fpr_get_version() {
		return $this->version;
	}

}
