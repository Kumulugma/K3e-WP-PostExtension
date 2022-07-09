<?php

class UIClassPostExtensionAdmin extends UIClassPostExtension {

    public static function run() {

        add_action('admin_menu', 'postextension_menu');

        function postextension_menu() {

            add_submenu_page(
                    'options-general.php',
                    __('PostExtension', 'k3e'),
                    __('PostExtension', 'k3e'),
                    'manage_options',
                    'postextension',
                    'postextension_content'
            );

            /* Dostępne pozycje
              2 – Dashboard
              4 – Separator
              5 – Posts
              10 – Media
              15 – Links
              20 – Pages
              25 – Comments
              59 – Separator
              60 – Appearance
              65 – Plugins
              70 – Users
              75 – Tools
              80 – Settings
              99 – Separator
             */
        }

        UIClassPostExtensionAdmin::SaveSettings();

        function postextension_content() {
            include plugin_dir_path(__FILE__) . 'admin/templates/postextension.php';
        }

    }

    public static function SaveSettings() {
        if (isset($_POST['PostExtension']['salt'])) {
            $form = [];
            foreach ($_POST['PostExtension'] as $key => $PostExtensionFields) {
                if ($key != 'salt') {
                    $form[] = sanitize_text_field($PostExtensionFields);
                }
            }

            update_option(parent::OPTION_POSTEXTENSION, serialize($form));
            wp_redirect('options-general.php?page=' . $_GET['page']);
        }
    }
}
