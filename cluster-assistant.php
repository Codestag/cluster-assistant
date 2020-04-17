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
	 * Crux Assistant.
	 *
	 * @since 1.0
	 */
	class Cluster_Assistant {

		/**
		 * Class instance.
		 *
		 * @since 1.0
		 */
		private static $instance;

		/**
		 * Register method to crate a new instance.
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
		 * Init method.
		 *
		 * @since 1.0
		 */
		public function init() {
			add_action( 'enqueue_assets', 'plugin_assets' );
		}

		/**
		 * Defines constants.
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
		 * Imethod to define a constant.
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
		 * Includes plugin files.
		 *
		 * @since 1.0
		 */
		public function includes() {
			// Widgets.
			require_once CA_PLUGIN_PATH . 'includes/class-widgetized-pages.php';
			require_once CA_PLUGIN_PATH . 'includes/widgets/widget-clients.php';
			require_once CA_PLUGIN_PATH . 'includes/widgets/widget-latest-post.php';
			require_once CA_PLUGIN_PATH . 'includes/widgets/widget-portfolio.php';
			require_once CA_PLUGIN_PATH . 'includes/widgets/widget-services.php';
			require_once CA_PLUGIN_PATH . 'includes/widgets/widget-services-section.php';
			require_once CA_PLUGIN_PATH . 'includes/widgets/widget-static-content.php';
			require_once CA_PLUGIN_PATH . 'includes/widgets/widget-featured-portfolio.php';

			// Shortcodes.
			require_once CA_PLUGIN_PATH . 'includes/shortcodes/theme-shortcodes.php';
			require_once CA_PLUGIN_PATH . 'includes/shortcodes/contact-form.php';

			// Metaboxes.
			require_once CA_PLUGIN_PATH . 'includes/meta/stag-admin-metaboxes.php';
			if ( false === get_theme_mod( 'general_disable_seo_settings', false ) ) {
				require_once CA_PLUGIN_PATH . 'includes/meta/seo-meta.php';
			}
			require_once CA_PLUGIN_PATH . 'includes/meta/portfolio-meta.php';
			require_once CA_PLUGIN_PATH . 'includes/meta/page-meta.php';
			require_once CA_PLUGIN_PATH . 'includes/meta/post-meta.php';

		}
	}
endif;


/**
 * Invokes Cluster_Assistant Class.
 *
 * @since 1.0
 */
function cluster_assistant() {
	return Cluster_Assistant::register();
}

/**
 * Activation notice.
 *
 * @since 1.0
 */
function cluster_assistant_activation_notice() {
	echo '<div class="error"><p>';
	echo esc_html__( 'Cluster Assistant requires Cluster WordPress Theme to be installed and activated.', 'cluster-assistant' );
	echo '</p></div>';
}

/**
 * Assistant activation check.
 *
 * @since 1.0
 */
function cluster_assistant_activation_check() {
	$theme = wp_get_theme(); // gets the current theme
	if ( 'Cluster' === $theme->name || 'Cluster' === $theme->parent_theme ) {
		if ( function_exists( 'is_multisite' ) && is_multisite() ) {
			add_action( 'after_setup_theme', 'cluster_assistant' );
		} else {
			cluster_assistant();
		}
	} else {
		if ( ! function_exists( 'deactivate_plugins' ) ) {
			require_once ABSPATH . 'wp-admin/includes/plugin.php';
		}
		deactivate_plugins( plugin_basename( __FILE__ ) );
		add_action( 'admin_notices', 'cluster_assistant_activation_notice' );
	}
}

// Plugin loads.
cluster_assistant_activation_check();
