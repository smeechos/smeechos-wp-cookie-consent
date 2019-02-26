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
            'wpcookieconsent-frontend',
            WPCC_PLUGIN_URL . 'assets/css/public/dist/styles.min.css',
            [],
            '1.0.0'
        );
    }

    /**
     * Enqueue scripts for the front end of the plugin.
     */
    public function enqueue_frontend_scripts() {
        wp_enqueue_script(
            'wpcookieconsent-frontend',
            WPCC_PLUGIN_URL . 'assets/js/public/dist/scripts.min.css',
            [ 'jquery' ],
            '1.0.0'
        );
    }

    /**
     * Enqueue styles for the admin of the plugin.
     */
    public function enqueue_admin_styles( $hook ) {
        if ( 'toplevel_page_wpcookieconsent' == $hook ) {
            wp_enqueue_style( 'wp-color-picker' );

            wp_enqueue_style(
                'wpcookieconsent-admin',
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
                'wpcookieconsent-admin',
                WPCC_PLUGIN_URL . 'assets/js/admin/dist/scripts.min.js',
                [ 'jquery', 'wp-color-picker' ],
                '1.0.0',
                true
            );
        }
    }
}

new Load_Assets();