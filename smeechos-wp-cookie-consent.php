<?php
/**
 * Plugin Name: WP Cookie Consent
 * Plugin URI:  https://github.com/smeechos/smeechos-wp-cookie-consent
 * Description: Simple GDPR cookie consent for WordPress!
 * Version:     1.0.0
 * Author:      Smeechos
 * Author URI:  https://github.com/smeechos/
 * Contributors: smeechos
 * License:     GPL3
 * License URI: https://www.gnu.org/licenses/gpl-3.0.en.html
 * Text Domain: wpcookieconsent
 * Domain Path: /languages
 */

namespace Smeechos\WP_Cookie_Consent;

class WP_Cookie_Consent {

    public function  __construct()
    {
        // If this file is called directly, abort.
        if ( ! defined( 'WPINC' ) ) {
            die;
        }

        if ( !defined( 'WPCC_PLUGIN_ROOT_DIR' ) ) {
            define( 'WPCC_PLUGIN_ROOT_DIR', plugin_dir_path(__FILE__) );
        }

        if ( !defined( 'WPCC_PLUGIN_BASE_NAME' ) ) {
            define( 'WPCC_PLUGIN_BASE_NAME', plugin_basename(__FILE__) );
        }

        if ( !defined( 'WPCC_PLUGIN_URL' ) ) {
            define( 'WPCC_PLUGIN_URL', plugin_dir_url(__FILE__) );
        }

        // Includes
        include( WPCC_PLUGIN_ROOT_DIR . 'includes/class-admin-settings.php' );
        include( WPCC_PLUGIN_ROOT_DIR . 'includes/class-load-assets.php' );
        include( WPCC_PLUGIN_ROOT_DIR . 'includes/class-modal.php' );
    }

}

new WP_Cookie_Consent();