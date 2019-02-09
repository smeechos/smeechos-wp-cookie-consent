<?php

namespace Smeechos\WP_Cookie_Consent;

class Admin_Settings
{

    /**
     * Admin_Settings constructor.
     */
    public function __construct()
    {
        add_action( 'admin_menu', array( $this, 'settings_page' ) );
    }

    public function settings_page() {
        add_menu_page(
            'WP Cookie Consent',
            'WP Cookie Consent',
            'manage_options',
            'wpcookieconsent',
            array( $this, 'settings_page_markup' ),
            'dashicons-megaphone',
            100
        );
    }

    public function settings_page_markup() {
        include( WPCC_PLUGIN_ROOT_DIR . 'templates/admin-settings.php' );
    }

}

new Admin_Settings();