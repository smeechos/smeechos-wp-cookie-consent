<?php

namespace Smeechos\WP_Cookie_Consent\Includes;

include 'settings/class-settings-parent.php';
include 'settings/class-content-settings.php';
include 'settings/class-modal-settings.php';
include 'settings/class-cookie-settings.php';

use Smeechos\WP_Cookie_Consent\Includes\Settings\Content_Settings as Content_Settings;
use Smeechos\WP_Cookie_Consent\Includes\Settings\Modal_Settings as Modal_Settings;
use Smeechos\WP_Cookie_Consent\Includes\Settings\Cookie_Settings as Cookie_Settings;

class Admin_Settings
{
    /**
     * Admin_Settings constructor.
     */
    public function __construct()
    {
        // Actions
        add_action( 'admin_menu', array( $this, 'settings_page' ) );
        add_action( 'admin_init', array( $this, 'add_settings' ) );

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

    /**
     * Setup new plugin settings.
     */
    public function add_settings() {
        $content_settings = new Content_Settings(
            'wpcookieconsent_content_settings',
            'wpcookieconsent_content_section',
            '',
            'section_display',
            'wpcookieconsent_content_settings'
        );
        $content_settings->add_fields();
        $content_settings->register_setting();

        $modal_settings = new Modal_Settings(
            'wpcookieconsent_modal_settings',
            'wpcookieconsent_modal_section',
            '',
            'section_display',
            'wpcookieconsent_modal_settings'
        );
        $modal_settings->add_fields();
        $modal_settings->register_setting();

        $cookie_settings = new Cookie_Settings(
            'wpcookieconsent_cookie_settings',
            'wpcookieconsent_cookie_section',
            '',
            'section_display',
            'wpcookieconsent_cookie_settings'
        );
        $cookie_settings->add_fields();
        $cookie_settings->register_setting();
    }
}

// Initialize Plugin
new Admin_Settings();