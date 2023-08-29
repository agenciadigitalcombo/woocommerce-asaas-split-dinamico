<?php
/*
Plugin Name: Split Asaas
Description: Vincula vendedor ao produto, sendo que no vendedor tem a regra de split.
Version: 1.0.0
Author: Split Dinamico
*/

require __DIR__ . "/includes/Asaas.php";
require __DIR__ . "/includes/custom-user-profile.php";
require __DIR__ . "/includes/create-account-asaas.php";
require __DIR__ . "/includes/taxa-entrega-plugin.php";
require __DIR__ . "/includes/product.php";
require __DIR__ . "/includes/makerSplit.php";

add_action('admin_enqueue_scripts', function () {
    wp_enqueue_script('split_dinamico_js', plugin_dir_url(__FILE__) . 'assets/js/main.js');
    wp_enqueue_style( 'split_dinamico_css', plugin_dir_url(__FILE__) . 'assets/css/style.css' );
});
