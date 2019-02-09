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
    }

    /**
     * Enqueue styles for the front end of the plugin.
     */
    public function enqueue_frontend_styles() {
        wp_enqueue_style(
            'wpcookieconsent-frontend',
            WPCC_PLUGIN_URL . 'assets/css/dist/styles.min.css',
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
            WPCC_PLUGIN_URL . 'assets/js/dist/scripts.min.css',
            [ 'jquery' ],
            '1.0.0'
        );
    }
}

new Load_Assets();