<?php

namespace Smeechos\WP_Cookie_Consent\Includes\Settings;

class Content_Settings extends Settings_Parent
{
    /**
     * Adds the array of fields to the content section of the plugin.
     */
    public function add_fields()
    {
        $fields = [
            [
                'id' => 'wpcookieconsent_heading_display',
                'title' => 'Heading Text Display',
                'callback' => 'radio_display',
                'page' => $this->get_page_name(),
                'section' => $this->get_setting_id(),
                'args' => [
                    'option'    => 'heading_display',
                    'radio_1'   => 'Hidden',
                    'radio_2'   => 'Shown'
                ]
            ],
            [
                'id' => 'wpcookieconsent_heading_text',
                'title' => 'Heading Text',
                'callback' => 'text_display',
                'page' => $this->get_page_name(),
                'section' => $this->get_setting_id(),
                'args' => [
                    'option'    => 'heading_text'
                ]
            ],
            [
                'id' => 'wpcookieconsent_body_text',
                'title' => 'Body Text',
                'callback' => 'textarea_display',
                'page' => $this->get_page_name(),
                'section' => $this->get_setting_id(),
                'args' => [
                    'option'    => 'body_text'
                ]
            ],
            [
                'id' => 'wpcookieconsent_text_color',
                'title' => 'Text Color',
                'callback' => 'color_display',
                'page' => $this->get_page_name(),
                'section' => $this->get_setting_id(),
                'args' => [
                    'option'    => 'text_color'
                ]
            ],
            [
                'id' => 'wpcookieconsent_user_consent',
                'title' => 'User Consent Settings',
                'callback' => 'radio_display',
                'page' => $this->get_page_name(),
                'section' => $this->get_setting_id(),
                'args' => [
                    'option'    => 'user_consent',
                    'radio_1'   => 'Default',
                    'radio_2'   => 'Choice',
                    'description'   => __( 'Default will display an x at the top right of the modal.', 'wpcookieconsent' )
                ]
            ],
            [
                'id' => 'wpcookieconsent_accept_button_options',
                'title' => 'Accept Button Options',
                'callback' => 'button_display',
                'page' => $this->get_page_name(),
                'section' => $this->get_setting_id(),
                'args' => [
                    'option'    => 'accept_button'
                ]
            ],
            [
                'id' => 'wpcookieconsent_decline_button_options',
                'title' => 'Decline Button Options',
                'callback' => 'button_display',
                'page' => $this->get_page_name(),
                'section' => $this->get_setting_id(),
                'args' => [
                    'option'    => 'decline_button'
                ]
            ],
        ];

        foreach( $fields as $field ) {
            $this->add_field(
                $field['id'],
                $field['title'],
                $field['callback'],
                $field['page'],
                $field['section'],
                $field['args']
            );
        }
    }
}