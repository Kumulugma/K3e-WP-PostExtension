<?php

class UIClassPostExtension {

    const POST_TAXONOMIES = [
        'category',
        'post_tag'
    ];
    const OPTION_POSTEXTENSION = '_k3e_postextension';
    const OPTION_POSTEXTENSION_DOCUMENT_CONTENT = '_k3e_posts_pdf';
    const OPTION_POSTEXTENSION_DOCUMENT = '_k3e_postextension_document';

    public static function init() {
        //Usuwamy taksonomię
        $taxonomies = unserialize(get_option(UIClassPostExtension::OPTION_POSTEXTENSION));

        foreach ($taxonomies as $tax) {
            register_taxonomy($tax, array());
        }
    }

    public static function run() {
        
    }

}
