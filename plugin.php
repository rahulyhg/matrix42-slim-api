<?php
/*
Plugin Name: Matrix42 Slim API
Plugin URI: https://marketplace.matrix42.com/slim/api/v1
Description: An API to work with the Marketplace Data
Author: Fabian Henzler
Version: 1.0.0
Author URI: http://matrix42.com
Text Domain: matrix42-slim-api
Domain Path: /language
*/

if (!defined('ABSPATH'))
    die();

require_once 'vendor/slim/slim/Slim/Slim.php';
require('classes/class-matrix42-api-v1-admin.php');

require('classes/class-matrix42-product.php');
require('classes/class-matrix42-subscription.php');
require('classes/class-matrix42-order.php');
require('classes/class-matrix42-customer.php');
require('classes/class-matrix42-attachment.php');
require('classes/class-matrix42-api-v1.php');

\Slim\Slim::registerAutoloader();
new matrix42\slim_api\Matrix42_API_v1_Admin();
new matrix42\slim_api\Matrix42_API_v1();



add_filter('rewrite_rules_array', function ($rules) {
    $new_rules = array(
        '(' . get_option('slim_base_path', 'slim/api/v1/') . ')' => 'index.php',
    );
    $rules = $new_rules + $rules;
    return $rules;
});

add_action('wp_loaded', function () {
    if (strstr($_SERVER['REQUEST_URI'], get_option('slim_base_path', 'slim/api/v1/'))) {
        $slim = new \Slim\Slim();

        do_action('get_products', $slim);
        do_action('get_product', $slim);
        do_action('get_subscriptions', $slim);
        do_action('get_subscription', $slim);
        do_action('get_orders', $slim);
        do_action('get_order', $slim);
        do_action('get_order_downloads', $slim);

        do_action('post_product_downloads', $slim);
        do_action('post_subscription_downloads', $slim);
        
        do_action('get_attachments', $slim);
        do_action('post_attachment', $slim);

        $slim->run();
        exit;
    }
});