<?php

/**
 * Collapsing Widgets
 *
 * This is a class handling the public-facing portions of the plugin.
 *
 * @package   Collapsing Widgets
 * @author    Slushman <chris@slushman.com>
 * @copyright Copyright (c) 2014, Slushman
 * @license   GPL-2.0+
 * @license   http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 * @link      http://slushman.com/plugins/slushman-collapsing-widgets
 */

// If this file is called directly, abort.
if ( !defined( 'WPINC' ) ) { die; }

if ( !class_exists( 'Collapsing_Widgets' ) ) {

	class Collapsing_Widgets {

/**
 * Holds the instance of this class.
 *
 * @access 	protected
 * @since  	0.1
 * @var    	object
 */
		protected static $instance = NULL;

/**
 * The internationalization domain
 *
 * @access 	private
 * @since 	0.1
 * @var 	string
 */
		protected $i18n = '';

/**
 * The name of the plugin
 *
 * @access 	protected
 * @since   0.1
 * @var     string
 */
		protected $name = '';

/**
 * The various sizes of pictures 
 *
 * @access 	protected
 * @since   0.1
 * @var     string
 */
		protected $sizes = array();

/**
 * Plugin version, used for cache-busting of style and script file references.
 *
 * @access 	protected
 * @since   0.1
 * @var     string
 */
		protected $version = '';

/**
 * Plugin constructor
 *
 * @access 	public
 * @since  	0.1
 * 
 * @return 	void
 */
		public function __construct() {

			$this->i18n 	= 'slushman-collapsing-widgets';
			$this->name 	= 'Collapsing Widgets';
			$this->version 	= '0.1';

			// Load plugin text domain
			add_action( 'init', 				array( $this, 'load_plugin_textdomain' ) );

			// Activate plugin when new blog is added
			add_action( 'wpmu_new_blog', 		array( $this, 'activate_new_site' ) );

			// Load public-facing style sheet and JavaScript.
			add_action( 'wp_enqueue_scripts', 	array( $this, 'enqueue_styles' ) );
			add_action( 'wp_enqueue_scripts', 	array( $this, 'enqueue_scripts' ) );

		} // End of __construct()



/* ==========================================================================
   Activation & Deactivation Methods
   ========================================================================== */

/**
 * Fired when the plugin is activated.
 *
 * @access 	public
 * @since 	0.1
 *
 * @param 	bool 		$network_wide		True if WPMU superadmin uses
 *                               			"Network Activate" action, false if
 *                               			WPMU is disabled or plugin is
 *                               			activated on an individual blog.
 *
 * @uses 	is_multisite()
 * @uses 	get_blog_ids()
 * @uses 	switch_to_blog()
 * @uses 	single_activate()
 *
 * @return 	void
 */
		public static function activate( $network_wide ) {

			if ( function_exists( 'is_multisite' ) && is_multisite() ) {

				if ( $network_wide  ) {

					// Get all blog ids
					$blog_ids = self::get_blog_ids();

					foreach ( $blog_ids as $blog_id ) {

						switch_to_blog( $blog_id );
						self::single_activate();
					
					} // End of foreach loop

					restore_current_blog();

				} else {

					self::single_activate();
				
				} // End of network check

			} else {
				
				self::single_activate();
			
			} // End of multisite check

		} // End of activate()

/**
 * Fired when the plugin is deactivated.
 *
 * @access 	public
 * @since 	0.1
 *
 * @param 	bool 		$network_wide 		True if WPMU superadmin uses
 *                                			"Network Deactivate" action, false if
 *                                			WPMU is disabled or plugin is
 *                                			deactivated on an individual blog.
 *
 * @uses 	is_multisite()
 * @uses 	get_blog_ids()
 * @uses 	switch_to_blog()
 * @uses 	single_deactivate()
 * @uses 	restore_current_blog()
 *
 * @return 	void
 */
		public static function deactivate( $network_wide ) {

			if ( function_exists( 'is_multisite' ) && is_multisite() ) {

				if ( $network_wide ) {

					// Get all blog ids
					$blog_ids = self::get_blog_ids();

					foreach ( $blog_ids as $blog_id ) {

						switch_to_blog( $blog_id );
						self::single_deactivate();

					} // End of foreach loop

					restore_current_blog();

				} else {
				
					self::single_deactivate();
				
				} // End of network check

			} else {
			
				self::single_deactivate();
			
			} // End of multisite check

		} // End of deactivate()

/**
 * Fired when a new site is activated with a WPMU environment.
 *
 * @access 	public
 * @since 	0.1
 *
 * @uses 	did_action()
 * @uses 	switch_to_blog()
 * @uses 	single_activate()
 * @uses 	restore_current_blog()
 *
 * @param    int    	$blog_id    	ID of the new blog.
 */
		public function activate_new_site( $blog_id ) {

			if ( 1 !== did_action( 'wpmu_new_blog' ) ) { return; }

			switch_to_blog( $blog_id );

			self::single_activate();
			
			restore_current_blog();

		} // End of activate_new_site()

/**
 * Get all blog ids of blogs in the current network that are:
 * - not archived
 * - not spam
 * - not deleted
 *
 * @access 	private
 * @since 	0.1
 *
 * @global 	$wpdb
 * 
 * @uses 	get_col()
 *
 * @return   array|false    The blog ids, false if no matches.
 */
		private static function get_blog_ids() {

			global $wpdb;

			// get an array of blog ids
			$sql = "SELECT blog_id FROM $wpdb->blogs
				WHERE archived = '0' AND spam = '0'
				AND deleted = '0'";

			return $wpdb->get_col( $sql );

		} // End of get_blog_ids()

/**
 * Fired for each blog when the plugin is activated.
 *
 * @access 	private
 * @since 	0.1
 */
		private static function single_activate() {

			// @TODO: Define activation functionality here

		} // End of single_activate()

/**
 * Fired for each blog when the plugin is deactivated.
 *
 * @access 	private
 * @since 	0.1
 */
		private static function single_deactivate() {

			// @TODO: Define deactivation functionality here

		} // End of single_deactivate()



/* ==========================================================================
   WP Plugin Methods
   ========================================================================== */

/**
 * Registers and enqueues the front-end style sheets
 *
 * @access 	public
 * @since 	0.1
 * 
 * @uses 	wp_enqueue_style()
 * @uses 	plugins_url()
 * 
 * @return 	void
 */		
		public function enqueue_styles() {

			wp_enqueue_style( $this->i18n . '-plugin-styles', plugins_url( 'css/public.css', dirname( __FILE__ ) ), array(), $this->version );

		} // End of enqueue_styles()

/**
 * Registers and enqueues the front-end scripts
 *
 * @access 	public
 * @since 	0.1
 * 
 * @uses 	wp_enqueue_script()
 * @uses 	plugins_url()
 * 
 * @return 	void
 */	
		public function enqueue_scripts() {
	
			wp_enqueue_script( $this->i18n .'-public-script', plugins_url( 'js/public.min.js', dirname( __FILE__ ) ), array( 'jquery' ), $this->version, TRUE );
			
		} // End of enqueue_scripts()

/**
 * Load the plugin text domain for translation.
 *
 * @access 	public
 * @since 	0.1
 *
 * @uses 	apply_filters()
 * @uses 	get_locale()
 * @uses 	load_textdomain()
 * @uses 	trailingslashit()
 * @uses 	load_plugin_textdomain()
 * @uses 	plugin_dir_path()
 *
 * @return 	void
 */
		public function load_plugin_textdomain() {

			$locale = apply_filters( 'plugin_locale', get_locale(), $this->i18n );

			load_textdomain( $this->i18n, trailingslashit( WP_LANG_DIR ) . $this->i18n . '/' . $this->i18n . '-' . $locale . '.mo' );
			load_plugin_textdomain( $this->i18n, FALSE, basename( plugin_dir_path( dirname( __FILE__ ) ) ) . '/languages/' );

		} // End of load_plugin_textdomain()



/* ==========================================================================
   Getter Methods
   ========================================================================== */

/**
 * Returns a count of the images on this post
 * 
 * @return 	int 	The count of images in the array
 */
		public function get_images_count( $images ) {

			return count( $images );

		} // End of get_images_count()

/**
 * Return an instance of this class.
 *
 * @access 	public
 * @since 	0.1
 *
 * @return 	object 		A single instance of this class.
 */
		public static function get_instance() {

			// If the single instance hasn't been set, set it now.
			if ( null == self::$instance ) {

				self::$instance = new self;
			
			}

			return self::$instance;
		
		} // End of get_instance()

/**
 * Returns the plugin slug.
 *
 * @access 	public
 * @since 	0.1
 *
 * @return 	string 		The plugin slug class variable
 */
		public function get_i18n() {

			return $this->i18n;

		} // End of get_i18n()

/**
 * Returns the plugin name.
 *
 * @access 	public
 * @since 	0.1
 *
 * @return 	string 		The plugin name class variable
 */
		public function get_name() {

			return $this->name;

		} // End of get_name()

/**
 * Returns current plugin version.
 *
 * @access 	public
 * @since 	0.1
 *
 * @return 	string 		The plugin version class variable
 */
		public function get_version() {

			return $this->version;

		} // End of get_version()



/* ==========================================================================
   Plugin Methods
   ========================================================================== */  






	} // End of class

} // End of class check

?>