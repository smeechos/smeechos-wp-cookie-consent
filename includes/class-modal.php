<?php

namespace Smeechos\WP_Cookie_Consent\Includes;

class Modal
{
    private $options;

    public function __construct()
    {
        // Actions
        add_action( 'wp_footer', array( $this, 'display_modal') );
    }

    public function display_modal() {
        $this->options = get_option( 'wpcookieconsent_settings' );

        $html =     '<div id="wp-cookie-consent-banner">';

        if ( $this->options['heading_display'] == 1 && isset($this->options['heading_text'])) {
            $html .= '<h4>' . $this->options['heading_text'] . '</h4>';
        }

        if ( isset($this->options['body']) ) {
            $html .= '<div id="wp-cookie-consent-body">' . $this->options['body'] . '</div>';
        }

        if ( isset($this->options['accept_button_text']) && isset($this->options['decline_button_text']) ) {
            $html .= '<div id="wp-cookie-consent-buttons">
                        <button type="button">' . $this->options['accept_button_text'] . '</button>
                        <button type="button">' . $this->options['decline_button_text'] . '</button>
                      </div>';
        }

        $html .=    '</div>';

        echo $html;
    }
}

new Modal();