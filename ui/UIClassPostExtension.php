<?php

class UIClassPostExtension {

    const POST_TAXONOMIES = [
        'category',
        'post_tag'
    ];
    const OPTION_POSTEXTENSION = '_k3e_postextension';

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
