<?php

/*
  Plugin name: K3e - PostExtension
  Plugin URI:
  Description: Usunięcie niepotrzebnych taksonomii oraz lista PDF z aktualnymi wpisami.
  Author: K3e
  Author URI: https://www.k3e.pl/
  Text Domain:
  Domain Path:
  Version: 0.0.1a
 */
require_once(plugin_dir_path(__FILE__) . '/vendor/autoload.php');
            
add_action('init', 'k3e_postextension_plugin_init');

function k3e_postextension_plugin_init() {
    do_action('k3e_postextension_plugin_init');
    require_once 'ui/UIClassPostExtension.php';
    require_once 'ui/UIClassPostExtensionAdmin.php';
    require_once 'ui/UIClassPostExtensionFront.php';
    require_once 'ui/UIFunctions.php';

    UIClassPostExtension::init();
    
    if (is_admin()) {
        UIClassPostExtensionAdmin::run();
    } else {
        UIClassPostExtensionFront::run();
    }
}

function k3e_postextension_plugin_activate() {
    
}

register_activation_hook(__FILE__, 'k3e_postextension_plugin_activate');

function k3e_postextension_plugin_deactivate() {
    
}

register_deactivation_hook(__FILE__, 'k3e_postextension_plugin_deactivate');
