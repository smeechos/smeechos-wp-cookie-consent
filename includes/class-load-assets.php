<?php

namespace Smeechos\WP_Cookie_Consent\Includes;


class Load_Assets
{
    /**
     * Load_Assets constructor.
     */
    public function __construct()
    {
        // Actions
        add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_frontend_styles' ) );
        add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_frontend_scripts' ) );
        add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_admin_styles' ) );
        add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_admin_scripts' ) );
    }

    /**
     * Enqueue styles for the front end of the plugin.
     */
    public function enqueue_frontend_styles() {
        wp_enqueue_style(
            'wpcookieconsent_frontend',
            WPCC_PLUGIN_URL . 'assets/css/public/dist/styles.min.css',
            [],
            '1.0.0'
        );
    }

    /**
     * Enqueue scripts for the front end of the plugin.
     */
    public function enqueue_frontend_scripts() {
        // Register the script
        wp_register_script(
            'wpcookieconsent_frontend',
            WPCC_PLUGIN_URL . 'assets/js/public/dist/scripts.min.js',
            [ 'jquery' ],
            '1.0.0'
        );

        // Localize the script with new data
        $content    = get_option( 'wpcookieconsent_content_settings' );
        $modal      = get_option( 'wpcookieconsent_modal_settings' );
        $cookies    = get_option( 'wpcookieconsent_cookie_settings' );

        $translation_array = [
            'choice'        => ($content['user_consent'] == '0') ? 'default' : 'consent',
            'dismiss'       => ($modal['dismiss_effect'] == '0') ? 'default' : 'fade',
            'num'           => $cookies['cookie_duration']['num'],
            'duration'      => $cookies['cookie_duration']['duration']
        ];
        wp_localize_script( 'wpcookieconsent_frontend', 'wp_cookie_consent_plugin', $translation_array );

        // Enqueued script with localized data.
        wp_enqueue_script( 'wpcookieconsent_frontend' );
    }

    /**
     * Enqueue styles for the admin of the plugin.
     */
    public function enqueue_admin_styles( $hook ) {
        if ( 'toplevel_page_wpcookieconsent' == $hook ) {
            wp_enqueue_style( 'wp-color-picker' );

            wp_enqueue_style(
                'wpcookieconsent_admin',
                WPCC_PLUGIN_URL . 'assets/css/admin/dist/styles.min.css',
                [],
                '1.0.0'
            );
        }
    }

    /**
     * Enqueue scripts for the admin of the plugin.
     */
    public function enqueue_admin_scripts( $hook ) {
        if ( 'toplevel_page_wpcookieconsent' == $hook ) {
            wp_enqueue_script(
                'wpcookieconsent_admin',
                WPCC_PLUGIN_URL . 'assets/js/admin/dist/scripts.min.js',
                [ 'jquery', 'wp-color-picker' ],
                '1.0.0',
                true
            );
        }
    }
}

new Load_Assets();