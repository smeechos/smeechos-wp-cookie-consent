<div class="wrap">
    <h1><?php esc_html_e( get_admin_page_title() ); ?></h1>

    <form method="post" action="options.php">
        <?php
            settings_fields( 'wpcookieconsent_settings' );
            do_settings_sections( 'wpcookieconsent' );
            submit_button();
        ?>
    </form>
</div>