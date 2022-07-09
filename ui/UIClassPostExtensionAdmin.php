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

            add_submenu_page(
                    'edit.php',
                    __('PDF', 'k3e'),
                    __('PDF', 'k3e'),
                    'manage_options',
                    'post_pdf',
                    'post_pdf_content'
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
        UIClassPostExtensionAdmin::GeneratePDF();

        function postextension_content() {
            include plugin_dir_path(__FILE__) . 'admin/templates/postextension.php';
        }

        function post_pdf_content() {

            include plugin_dir_path(__FILE__) . 'admin/templates/pdf.php';
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

    public static function GeneratePDF() {
        if (isset($_POST['PostExtension']['PDF'])) {
            $document = [];
            $args = array(
                'post_type' => 'post',
                'order' => 'ASC',
                'orderby' => 'title',
                'posts_per_page' => -1
            );

            $species = new WP_Query($args);
            if ($species->have_posts()) {
                $i = 1;
                while ($species->have_posts()) : $species->the_post();
                    $document[$i]['i'] = $i;
                    $document[$i]['name'] = get_the_title();
                    $post_images = explode(",", unserialize(get_post_meta(get_the_ID(), "post_files", true)));
                    $j = 0;
                    foreach ($post_images as $image) {
                        if ($image != "") {
                            $j++;
                        }
                    }
                    $document[$i]['images'] = $j;
                    $document[$i]['thumbnail'] = has_post_thumbnail(get_the_ID());
                    $i++;
                endwhile;
            }

            update_option(UIClassPostExtension::OPTION_POSTEXTENSION_DOCUMENT_CONTENT, $document);

            include plugin_dir_path(__FILE__) . 'admin/templates/documents/document_pdf.php';

            wp_redirect('admin.php?page=' . $_GET['page']);
        }
    }

}
