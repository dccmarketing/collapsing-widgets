<?php
/**
 * Collapsing Widgets: Collapse widgets by clicking the widget title.
 *
 * @package   Collapsing Widgets
 * @author    Slushman <chris@slushman.com>
 * @copyright Copyright (c) 2014, Slushman
 * @license   GPL-2.0+
 * @license   http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 * @link      http://slushman.com/plugins/collapsing-widgets
 * @version   0.1
 * 
 * @wordpress-plugin
 * Plugin Name: 		Collapsing Widgets
 * Plugin URI: 			http://slushman.com/plugins/collapsing-widgets
 * Description: 		Collapse widgets by clicking the widget title.
 * Version: 			0.1
 * Author: 				Slushman
 * Author URI: 			http://www.slushman.com
 * Text Domain:			slushman-collapsing-widgets
 * Domain Path:			/languages
 * Github Plugin URI: 	https://github.com/slushman/collapsing-widgets
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) { die; }

/*----------------------------------------------------------------------------*
 * Public-Facing Functionality
 *----------------------------------------------------------------------------*/

/**
 * Includes the plugin class file
 */
require_once( plugin_dir_path( __FILE__ ) . 'classes/class-collapsing-widgets.php' );



/**
 * Register hooks that are fired when the plugin is activated or deactivated.
 * When the plugin is deleted, the uninstall.php file is loaded.
 */
register_activation_hook( __FILE__, array( 'Collapsing_Widgets', 'activate' ) );
register_deactivation_hook( __FILE__, array( 'Collapsing_Widgets', 'deactivate' ) );

/**
 * Loads the plugin instance when plugins are loaded
 */
add_action( 'plugins_loaded', array( 'Collapsing_Widgets', 'get_instance' ) );


/**
 * Create a global variable for accessing the plugin options
 */
//$slushman_scw_settings = get_option( 'slushman_scw_settings' );



/*----------------------------------------------------------------------------*
 * Dashboard and Administrative Functionality
 *----------------------------------------------------------------------------*/

/**
 * Includes the admin file and loads the instance of it when the plugins are loaded.
 */
/*if ( is_admin() && ( ! defined( 'DOING_AJAX' ) || ! DOING_AJAX ) ) {

	require_once( plugin_dir_path( __FILE__ ) . 'classes/class-admin-scw.php' );

	add_action( 'plugins_loaded', array( 'Collapsing_Widgets_Admin', 'get_instance' ) );

} // End of admin check*/

?>