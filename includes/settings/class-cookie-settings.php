<?php

namespace Smeechos\WP_Cookie_Consent\Includes\Settings;


class Cookie_Settings extends Settings_Parent
{
    private $page = 'wpcookieconsent_cookie_settings', $section = 'wpcookieconsent_cookie_section';

    /**
     * Adds the array of fields to the content section of the plugin.
     */
    public function add_fields()
    {
        $fields = [
            [
                'id' => 'wpcookieconsent_cookie_duration',
                'title' => 'Cookie Duration',
                'callback' => 'cookie_duration_display',
                'page' => $this->get_page_name(),
                'section' => $this->get_setting_id(),
                'args' => [
                    'option'        => 'cookie_duration',
                    'selects'       => [
                        'seconds'   => 'Seconds',
                        'minutes'   => 'Minutes',
                        'hours'     => 'Hours',
                        'days'      => 'Days'
                    ]
                ]
            ]
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