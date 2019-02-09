<?php

namespace Smeechos\WP_Cookie_Consent\Includes;

class Admin_Settings
{

    /**
     * Admin_Settings constructor.
     */
    public function __construct()
    {
        // Actions
        add_action( 'admin_menu', array( $this, 'settings_page' ) );

        // Filters
        add_filter( 'plugin_action_links_' . WPCC_PLUGIN_BASE_NAME, array( $this, 'add_settings_link' ) );
    }

    /**
     * Adds a link to this plugin's settings page on the plugins overview page.
     *
     * @param array $links The current list of links on the plugins overview page.
     * @return mixed The links to show on the plugins overview page.
     */
    public function add_settings_link( $links ) {
        $addtional_links = array(
            '<a href="admin.php?page=wpcookieconsent">' . __('Settings', 'wpcookieconsent') . '</a>',
        );
        return array_merge( $links, $addtional_links );
    }

    /**
     * Adds menu item to the dashboard.
     */
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

    /**
     * Includes the markup for the settings page.
     */
    public function settings_page_markup() {
        include( WPCC_PLUGIN_ROOT_DIR . 'templates/admin-settings.php' );
    }

}

// Initialize Plugin
new Admin_Settings();