<?php
/**
 * Plugin Name: Cluster Assistant
 * Plugin URI: https://github.com/Codestag/cluster-assistant
 * Description: A plugin to assist Cluster theme in adding widgets.
 * Author: Codestag
 * Author URI: https://codestag.com
 * Version: 1.0
 * Text Domain: cluster-assistant
 * License: GPL2+
 * License URI: https://www.gnu.org/licenses/gpl-2.0.txt
 *
 * @package Cluster
 */


// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Cluster_Assistant' ) ) :
	/**
	 *
	 * @since 1.0
	 */
	class Cluster_Assistant {

		/**
		 *
		 * @since 1.0
		 */
		private static $instance;

		/**
		 *
		 * @since 1.0
		 */
		public static function register() {
			if ( ! isset( self::$instance ) && ! ( self::$instance instanceof Cluster_Assistant ) ) {
				self::$instance = new Cluster_Assistant();
				self::$instance->init();
				self::$instance->define_constants();
				self::$instance->includes();
			}
		}

		/**
		 *
		 * @since 1.0
		 */
		public function init() {
			add_action( 'enqueue_assets', 'plugin_assets' );
		}

		/**
		 *
		 * @since 1.0
		 */
		public function define_constants() {
			$this->define( 'CA_VERSION', '1.0' );
			$this->define( 'CA_DEBUG', true );
			$this->define( 'CA_PLUGIN_PATH', plugin_dir_path( __FILE__ ) );
			$this->define( 'CA_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
		}

		/**
		 *
		 * @param string $name
		 * @param string $value
		 * @since 1.0
		 */
		private function define( $name, $value ) {
			if ( ! defined( $name ) ) {
				define( $name, $value );
			}
		}

		/**
		 *
		 * @since 1.0
		 */
		public function includes() {
			require_once CA_PLUGIN_PATH . 'includes/widgets/widget-clients.php';
			require_once CA_PLUGIN_PATH . 'includes/widgets/widget-latest-post.php';
			require_once CA_PLUGIN_PATH . 'includes/widgets/widget-portfolio.php';
			require_once CA_PLUGIN_PATH . 'includes/widgets/widget-services.php';
			require_once CA_PLUGIN_PATH . 'includes/widgets/widget-services-section.php';
			require_once CA_PLUGIN_PATH . 'includes/widgets/widget-static-content.php';
			require_once CA_PLUGIN_PATH . 'includes/widgets/widget-featured-portfolio.php';

			require_once CA_PLUGIN_PATH . 'includes/updater/updater.php';
		}
	}
endif;


/**
 *
 * @since 1.0
 */
function cluster_assistant() {
	return Cluster_Assistant::register();
}

/**
 *
 * @since 1.0
 */
function cluster_assistant_activation_notice() {
	echo '<div class="error"><p>';
	echo esc_html__( 'Cluster Assistant requires Cluster WordPress Theme to be installed and activated.', 'cluster-assistant' );
	echo '</p></div>';
}

/**
 *
 *
 * @since 1.0
 */
function cluster_assistant_activation_check() {
	$theme = wp_get_theme(); // gets the current theme
	if ( 'Cluster' == $theme->name || 'Cluster' == $theme->parent_theme ) {
		if ( function_exists( 'is_multisite' ) && is_multisite() ) {
			add_action( 'after_setup_theme', 'cluster_assistant' );
		} else {
			cluster_assistant();
		}
	} else {
		deactivate_plugins( plugin_basename( __FILE__ ) );
		add_action( 'admin_notices', 'cluster_assistant_activation_notice' );
	}
}

// Plugin loads.
cluster_assistant_activation_check();
