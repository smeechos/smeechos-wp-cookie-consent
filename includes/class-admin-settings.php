<?php

namespace Smeechos\WP_Cookie_Consent\Includes;

class Admin_Settings
{
    private $options;

    /**
     * Admin_Settings constructor.
     */
    public function __construct()
    {
        // Actions
        add_action( 'admin_menu', array( $this, 'settings_page' ) );
//        add_action( 'admin_init', array( $this, 'add_options') );
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
     * Adds to the options table for our plugin.
     */
    public function add_options() {
        if ( !get_option( 'wpcookieconsent_option' ) ) {
            add_option( 'wpcookieconsent_option', 'WP Cookie Consent Options' );
        }
    }

    public function add_settings() {
        if ( !get_option( 'wpcookieconsent_settings' ) ) {
            add_option( 'wpcookieconsent_settings' );
        }

        $this->options = get_option( 'wpcookieconsent_settings' );

        $sections = [
            'content_section' => 'Content Settings',
            'modal_section' => 'Modal Settings'
        ];

        foreach ( $sections as $key => $value ) {
            add_settings_section(
                'wpcookieconsent_' . $key,
                __( $value, 'wpcookieconsent'),
                array( $this, 'wpcookieconsent_' . $key . '_display' ),
                'wpcookieconsent'
            );
        }

        $content_fields = [
            'content_heading'           => 'Display Heading Text',
            'content_heading_text'      => 'Heading Text',
            'content_body'              => 'Body Text',
            'content_text_color'        => 'Content Text Color',
            'modal_dismiss'             => 'Modal Dismiss Setting',
            'modal_accept_button_text'  => 'Accept Button Text',
            'modal_decline_button_text' => 'Decline Button Text',
            'modal_button_text_color'   => 'Button Text Color',
            'modal_button_color'        => 'Button Color',
            'modal_dismiss_effect'      => 'Dismiss Effect',
            'modal_background_color'    => 'Modal Background Color'
        ];

        foreach ( $content_fields as $key => $value) {
            // Gets the section based off of the field prefix
            $type = explode('_', $key);

            add_settings_field(
                'wpcookieconsent_' . $key,
                __( $value, 'wpcookieconsent' ),
                array( $this, 'wpcookieconsent_' . $key . '_display' ),
                'wpcookieconsent',
                'wpcookieconsent_' . $type[0] . '_section'
            );
        }

        register_setting(
            'wpcookieconsent_settings',
            'wpcookieconsent_settings'
        );
    }

    public function wpcookieconsent_content_section_display() {
//        esc_html_e( 'Options for the content of the notice.', 'wpcookieconsent' );
    }

    public function wpcookieconsent_modal_section_display() {
//        esc_html_e( 'Options for the modal.', 'wpcookieconsent' );
    }

    public function wpcookieconsent_content_heading_display() {
        $heading_display = '0';

        if ( isset( $this->options['heading_display'] ) ) {
            $heading_display = esc_html( $this->options['heading_display'] );
        }

        $hide = ( $heading_display === '0' ) ? 'checked' : '';
        $show = ( $heading_display === '1' ) ? 'checked' : '';

        echo '<label>
            <input type="radio" name="wpcookieconsent_settings[heading_display]" value="0" ' . $hide . '>
            <span>Hide</span>
        </label><br>
        <label>
            <input type="radio" name="wpcookieconsent_settings[heading_display]" value="1" ' . $show . '>
            <span>Show</span>
        </label><br>
        ';
    }

    public function wpcookieconsent_content_heading_text_display() {
        $heading_text = '';

        if ( isset( $this->options['heading_text'] ) ) {
            $heading_text = esc_html( $this->options['heading_text'] );
        }

        echo '<input class="regular-text" type="text" name="wpcookieconsent_settings[heading_text]" value="' . $heading_text  .'">';
    }

    public function wpcookieconsent_content_body_display() {
        $body = '';

        if ( isset( $this->options['body'] ) ) {
            $body = wp_kses( $this->options['body'], $this->wpcookieconsent_get_allowed_html() );
        }

        echo '<textarea name="wpcookieconsent_settings[body]" cols="80" rows="10">' . $body . '</textarea><br>';
    }

    public function wpcookieconsent_content_text_color_display() {
        $color = '#dfe6e9';

        if ( isset( $this->options['content_text_color'] ) ) {
            $color = esc_html( $this->options['content_text_color'] );
        }

        echo '<input type="text" name="wpcookieconsent_settings[content_text_color]" value="' . $color . '" class="color-field" >';
    }

    public function wpcookieconsent_modal_dismiss_display() {
        $dismiss = '0';

        if ( isset( $this->options['modal_dismiss'] ) ) {
            $dismiss = esc_html( $this->options['modal_dismiss'] );
        }

        $default = ( $dismiss === '0' ) ? 'checked' : '';
        $button = ( $dismiss === '1' ) ? 'checked' : '';

        echo '<label>
            <input type="radio" name="wpcookieconsent_settings[modal_dismiss]" value="0" ' . $default . '>
            <span>Default</span>
        </label><br>
        <label>
            <input type="radio" name="wpcookieconsent_settings[modal_dismiss]" value="1" ' . $button . '>
            <span>Button</span>
        </label><br>
        <span class="description">' . __( 'Default will display an x at the top right of the modal.', 'wpcookieconsent' ) . '</span><br>
        ';
    }

    public function wpcookieconsent_modal_accept_button_text_display() {
        $button_text = '';

        if ( isset( $this->options['accept_button_text'] ) ) {
            $button_text = esc_html( $this->options['accept_button_text'] );
        }

        echo '<input class="regular-text" type="text" name="wpcookieconsent_settings[accept_button_text]" value="' . $button_text  .'">';
    }

    public function wpcookieconsent_modal_decline_button_text_display() {
        $button_text = '';

        if ( isset( $this->options['decline_button_text'] ) ) {
            $button_text = esc_html( $this->options['decline_button_text'] );
        }

        echo '<input class="regular-text" type="text" name="wpcookieconsent_settings[decline_button_text]" value="' . $button_text  .'">';
    }

    public function wpcookieconsent_modal_button_text_color_display() {
        $color = '#dfe6e9';

        if ( isset( $this->options['button_text_color'] ) ) {
            $color = esc_html( $this->options['button_text_color'] );
        }

        echo '<input type="text" name="wpcookieconsent_settings[button_text_color]" value="' . $color . '" class="color-field" >';
    }

    public function wpcookieconsent_modal_button_color_display() {
        $color = '#2c3e50';

        if ( isset( $this->options['button_color'] ) ) {
            $color = esc_html( $this->options['button_color'] );
        }

        echo '<input type="text" name="wpcookieconsent_settings[button_color]" value="' . $color . '" class="color-field" >';
    }

    public function wpcookieconsent_modal_dismiss_effect_display() {
        $dismiss_effect = '0';

        if ( isset( $this->options['dismiss_effect'] ) ) {
            $dismiss_effect = esc_html( $this->options['dismiss_effect'] );
        }

        $default = ( $dismiss_effect === '0' ) ? 'checked' : '';
        $button = ( $dismiss_effect === '1' ) ? 'checked' : '';

        echo '<label>
            <input type="radio" name="wpcookieconsent_settings[dismiss_effect]" value="0" ' . $default . '>
            <span>Default</span>
        </label><br>
        <label>
            <input type="radio" name="wpcookieconsent_settings[dismiss_effect]" value="1" ' . $button . '>
            <span>Fade</span>
        </label><br>
        <span class="description">' . __( 'Default will simply hide the modal upon closing.', 'wpcookieconsent' ) . '</span><br>
        ';
    }

    public function wpcookieconsent_modal_background_color_display() {
        $color = '#34495e';

        if ( isset( $this->options['background_color'] ) ) {
            $color = esc_html( $this->options['background_color'] );
        }

        echo '<input type="text" name="wpcookieconsent_settings[background_color]" value="' . $color . '" class="color-field" >';
    }

    private function wpcookieconsent_get_allowed_html() {
        $allowed_tags = array(
            'a' => array(
                'class' => array(),
                'href'  => array(),
                'rel'   => array(),
                'title' => array(),
            ),
            'abbr' => array(
                'title' => array(),
            ),
            'b' => array(),
            'blockquote' => array(
                'cite'  => array(),
            ),
            'cite' => array(
                'title' => array(),
            ),
            'code' => array(),
            'del' => array(
                'datetime' => array(),
                'title' => array(),
            ),
            'dd' => array(),
            'div' => array(
                'class' => array(),
                'title' => array(),
                'style' => array(),
            ),
            'dl' => array(),
            'dt' => array(),
            'em' => array(),
            'h1' => array(),
            'h2' => array(),
            'h3' => array(),
            'h4' => array(),
            'h5' => array(),
            'h6' => array(),
            'i' => array(),
            'img' => array(
                'alt'    => array(),
                'class'  => array(),
                'height' => array(),
                'src'    => array(),
                'width'  => array(),
            ),
            'li' => array(
                'class' => array(),
            ),
            'ol' => array(
                'class' => array(),
            ),
            'p' => array(
                'class' => array(),
            ),
            'q' => array(
                'cite' => array(),
                'title' => array(),
            ),
            'span' => array(
                'class' => array(),
                'title' => array(),
                'style' => array(),
            ),
            'strike' => array(),
            'strong' => array(),
            'ul' => array(
                'class' => array(),
            ),
        );

        return $allowed_tags;
    }


}

// Initialize Plugin
new Admin_Settings();