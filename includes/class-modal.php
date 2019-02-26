<?php

namespace Smeechos\WP_Cookie_Consent\Includes;

class Modal
{
    private $content, $modal;

    /**
     * Modal constructor.
     */
    public function __construct()
    {
        $this->content = get_option( 'wpcookieconsent_content_settings' );
        $this->modal = get_option( 'wpcookieconsent_modal_settings' );

        // Actions
        add_action( 'wp_footer', array( $this, 'display_modal') );
    }

    /**
     * Display the modal.
     */
    public function display_modal() {

        $user_default_consent = isset($this->content['user_consent']) === false || ( isset($this->content['user_consent']) && $this->content['user_consent'] == '0' );

        $html =     '<div id="wp-cookie-consent-banner">';

        if ( $user_default_consent ) {
            $class = 'wp-cookie-consent-full-width';
        } else {
            $class = 'wp-cookie-consent-flex-width';
        }
        $html .= '<div id="wp-cookie-consent-body" class="' . $class . '">';

        if ( isset($this->content['heading_text']) && $this->content['heading_display'] == 1 ) {
            $html .= '<h4>' . $this->content['heading_text'] . '</h4>';
        }

        if ( isset($this->content['body_text']) ) {
            $html .= $this->content['body_text'];
        }

        $html .= '</div>';

        if ( $user_default_consent ) {
            $html .= '<div id="wp-cookie-consent-close"><a href="#">&#10005;</a></div>';
        } else {
            if ( isset($this->content['accept_button']['text']) && isset($this->content['decline_button']['text']) ) {
                $html .= '<div id="wp-cookie-consent-buttons">
                        <button id="wp-cookie-consent-accept" type="button">' . $this->content['accept_button']['text'] . '</button>
                        <button id="wp-cookie-consent-decline" type="button">' . $this->content['decline_button']['text'] . '</button>
                      </div>';
            }
        }

        $html .=    '</div>';

        echo $html;

        $this->display_styles();
    }

    /**
     * Output embedded stylesheet from admin selections.
     */
    public function display_styles()
    {
        $style = '
        <style>
        #wp-cookie-consent-banner {
            background-color: ' . $this->modal['background_color'] .';
            color: ' . $this->content['text_color'] .';
        }
        
        #wp-cookie-consent-accept {
            background-color: ' . $this->content['accept_button']['back_color'] . ';
            color: ' . $this->content['accept_button']['text_color'] . ';
        }
        
        #wp-cookie-consent-accept:hover,
        #wp-cookie-consent-accept:focus {
            background-color: ' . $this->content['accept_button']['hover_back'] . ';
            color: ' . $this->content['accept_button']['hover_text'] . ';
        }
        
        #wp-cookie-consent-decline {
            background-color: ' . $this->content['decline_button']['back_color'] . ';
            color: ' . $this->content['decline_button']['text_color'] . ';
        }
        
        #wp-cookie-consent-decline:hover,
        #wp-cookie-consent-decline:focus {
            background-color: ' . $this->content['decline_button']['hover_back'] . ';
            color: ' . $this->content['decline_button']['hover_text'] . ';
        }
        
        #wp-cookie-consent-close a {
            color: ' . $this->content['close_button_color'] . ';
        }
        
        #wp-cookie-consent-close a:hover,
        #wp-cookie-consent-close a:focus {
            color: ' . $this->content['close_button_hover'] . ';
        }';

        if ( $this->modal['background_opacity'] == '1' ) {
            $style .= '
            #wp-cookie-consent-banner {
                opacity: 0.9;
            }
            ';
        }

        $style .= '</style>';

        echo $style;
    }
}

new Modal();