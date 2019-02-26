<?php

namespace Smeechos\WP_Cookie_Consent\Includes\Settings;

class Settings_Parent
{
    private $option, $id, $title, $callback, $page, $options;

    /**
     * Settings_Parent constructor.
     *
     * @param string $option The name of the option.
     * @param string $id ID used to identify this section and with which to register options.
     * @param string $title Title of the section.
     * @param string $callback Function that fills the section with the desired content.
     * @param string $page The menu page on which to display this section.
     */
    public function __construct( $option, $id, $title, $callback, $page )
    {
        $this->option = $option;
        $this->id = $id;
        $this->title = $title;
        $this->callback = $callback;
        $this->page = $page;

        $this->add_option();
        $this->add_section();
    }

    /**
     * Returns the setting ID.
     *
     * @return string ID of setting.
     */
    public function get_setting_id()
    {
        return $this->id;
    }

    /**
     * Returns the page name.
     *
     * @return string Page name.
     */
    public function get_page_name()
    {
        return $this->page;
    }

    /**
     * Adds the option to the options table.
     */
    public function add_option()
    {
        if ( !get_option( $this->option ) ) {
            add_option( $this->option );
        }

        $this->options = get_option( $this->option );
    }

    /**
     * Adds a section for the plugin.
     */
    public function add_section()
    {
        add_settings_section(
            $this->id,
            __( $this->title, 'wpcookieconsent' ),
            array( $this, $this->callback ),
            $this->page
        );
    }

    /**
     * The HTML to be displayed for a section.
     */
    public function section_display()
    {
        if ( $this->option === 'wpcookieconsent_cookie_settings' ) {
            $html = '<div class="notice notice-info">
	                    <p>
	                    ' . __('Cookies will only be used if the <strong>User Consent Settings</strong> is set to <strong>Choice</strong>, 
                            within the <strong>Content Settings</strong> tab.', 'wpcookieconsent') . '		
	                    </p>
	                    <p>
	                    Depending on the user\'s choice, the cookie <strong>wp_user_cookie_consent</strong> will be set to one of the following values:<br />	                  
	                    - If user accepts, value will be true.<br />
	                    - If user declines, value will be false.<br />
	                    The cookie will last as long as the specified duration below.
                        </p>
            </div>';

            echo $html;
        }
    }

    /**
     * Register a setting and its data.
     */
    public function register_setting()
    {
        register_setting(
            $this->option,
            $this->option
        );
    }

    /**
     * Register a settings field to a settings page and section.
     *
     * @param string $id ID of the field.
     * @param string $title Title of the field.
     * @param string $callback Function that fills the field with the desired inputs as part of the larger form.
     * @param string $page The menu page on which to display this field.
     * @param string $section The section of the settings page in which to show the box.
     * @param array $args Additional arguments that are passed to the $callback function.
     */
    public function add_field( $id, $title, $callback, $page, $section, $args )
    {
        add_settings_field(
            $id,
            __( $title, 'wpcookieconsent' ),
            array( $this, $callback ),
            $page,
            $section,
            $args
        );
    }

    /**
     * Displays a text input for a field.
     *
     * @param array $args Arguments for the specific field.
     */
    public function text_display( $args ) {
        $text = '';

        if ( isset( $this->options[ $args['option'] ] ) ) {
            $text = esc_html( $this->options[ $args['option'] ] );
        }

        echo '<input class="regular-text" type="text" name="' . $this->option . '[' . $args['option'] . ']" value="' . $text  .'">';
    }

    /**
     * Displays a textarea input for a field.
     *
     * @param array $args Arguments for the specific field.
     */
    public function textarea_display( $args ) {
        $body = '';

        if ( isset( $this->options[ $args['option'] ] ) ) {
            $body = wp_kses( $this->options[ $args['option'] ], $this->get_allowed_html() );
        }

        echo '<textarea name="' . $this->option . '[' . $args['option'] . ']" cols="80" rows="10">' . $body . '</textarea><br>';
    }

    /**
     * Displays a color input for a field.
     *
     * @param array $args Arguments for the specific field.
     */
    public function color_display( $args ) {
        $color = '';

        if ( isset( $this->options[ $args['option'] ] ) ) {
            $color = esc_html( $this->options[ $args['option'] ] );
        }

        echo '<input type="text" name="' . $this->option . '[' . $args['option'] . ']" value="' . $color . '" class="color-field" >';
    }

    /**
     * Displays radio buttons for a field.
     *
     * @param array $args Arguments for the specific field.
     */
    public function radio_display( $args ) {
        $input = '0';

        if ( isset( $this->options[ $args['option'] ] ) ) {
            $input = esc_html( $this->options[ $args['option'] ] );
        }

        $option_1 = ( $input === '0' ) ? 'checked' : '';
        $option_2 = ( $input === '1' ) ? 'checked' : '';

        $html = '<label>
            <input type="radio" name="' . $this->option . '[' . $args['option'] . ']" value="0" ' . $option_1 . '>
            <span>' . $args['radio_1'] . '</span>
        </label><br />
        <label>
            <input type="radio" name="' . $this->option . '[' . $args['option'] . ']" value="1" ' . $option_2 . '>
            <span>' . $args['radio_2'] . '</span>
        </label><br />
        ';

        $html .= isset($args['description']) ? '<span class="description">' . $args['description'] . '</span>' : '';

        echo $html;
    }

    /**
     * Displays the inputs for our button fields.
     *
     * @param array $args Arguments for the specific field.
     */
    public function button_display( $args ) {
        $text = '';
        $back = '#2c3e50';
        $color = '#fff';
        $hover_back = '#fff';
        $hover_text = '#2c3e50';

        if ( isset( $this->options[ $args['option'] ]['text'] ) ) {
            $text = esc_html( $this->options[ $args['option'] ]['text'] );
        }

        if ( isset( $this->options[ $args['option'] ]['back-color'] ) ) {
            $back = esc_html( $this->options[ $args['option'] ]['back-color'] );
        }

        if ( isset( $this->options[ $args['option'] ]['text-color'] ) ) {
            $color = esc_html( $this->options[ $args['option'] ]['text-color'] );
        }

        if ( isset( $this->options[ $args['option'] ]['hover-back'] ) ) {
            $hover_back = esc_html( $this->options[ $args['option'] ]['hover-back'] );
        }

        if ( isset( $this->options[ $args['option'] ]['hover-text'] ) ) {
            $hover_text = esc_html( $this->options[ $args['option'] ]['hover-text'] );
        }

        $html = '<label>Button Text:</label><br /><input class="regular-text" type="text" name="' . $this->option . '[' . $args['option'] .'][text]" value="' . $text . '"><br /><br />';
        $html .= '<label>Background Color:</label><br /><input type="text" name="' . $this->option . '[' . $args['option'] .'][back-color]" class="color-field" value="' . $back . '"><br />';
        $html .= '<label>Text Color:</label><br /><input type="text" name="' . $this->option . '[' . $args['option'] .'][text-color]" class="color-field" value="' . $color . '"><br />';
        $html .= '<label>Hover Background Color:</label><br /><input type="text" name="' . $this->option . '[' . $args['option'] .'][hover-back]" class="color-field" value="' . $hover_back . '"><br />';
        $html .= '<label>Hover Text Color:</label><br /><input type="text" name="' . $this->option . '[' . $args['option'] .'][hover-text]" class="color-field" value="' . $hover_text . '"><br />';

        echo $html;
    }

    public function cookie_duration_display( $args )
    {
        $num = 1;
        $duration = 'days';

        if ( isset( $this->options[ $args['option'] ]['num'] ) ) {
            $num = esc_html( $this->options[ $args['option'] ]['num'] );
        }

        if ( isset( $this->options[ $args['option'] ]['duration'] ) ) {
            $duration = esc_html( $this->options[ $args['option'] ]['duration'] );
        }

        $html = '<input class="small-text" type="number" name="' . $this->option . '[' . $args['option'] .'][num]" value="' . $num . '">';
        $html .= '<select name="' . $this->option . '[' . $args['option'] .'][duration]">';
        foreach ( $args['selects'] as $key => $value ) {
            if ( $duration === $key ) {
                $selected = 'selected="selected"';
            } else {
                $selected = '';
            }
            $html .= '<option value="' . $key . '"' . $selected . '>' . $value . '</option>';
        }
        $html .= '</select>';

        echo $html;
    }

    /**
     * Returns all the tags that are allowed.
     *
     * @return array The allowed HTML tags.
     */
    private function get_allowed_html() {
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