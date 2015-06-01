<?php
/**
 * Created by PhpStorm.
 * User: fabianhenzler
 * Date: 30/05/15
 * Time: 20:09
 */

namespace matrix42\slim_api;

use WP_Query;

class Matrix42_API_v1
{
    function __construct()
    {
        add_action('get_products', array($this, 'get_products'));
        add_action('get_subscriptions', array($this, 'get_subscriptions'));
    }

    function get_products($slim)
    {
        $context = $this;
        $slim->get('/slim/api/v1/products', function () use ($context) {

            /*
             * Get all posts of type product
             */
            $args = array(
                'post_type' => 'product',
                'posts_per_page' => -1
            );
            $query_results = new WP_Query($args);
            $query_posts = $query_results->get_posts();

            /*
             * create a new array of products out of the query results
             */
            $results = Matrix42_Product::get_products($query_posts);

            /*
             * return the result as json
             */
            echo json_encode($results);
        });
    }

    function get_subscriptions($slim)
    {
        $context = $this;
        $slim->get('/slim/api/v1/subscriptions', function () use ($context) {

            /*
             * Get all posts of type product
             */
            $args = array(
                'post_type' => 'product',
                'posts_per_page' => -1
            );
            $query_results = new WP_Query($args);
            $query_posts = $query_results->get_posts();

            /*
             * create a new array of products out of the query results
             */
            $results = Matrix42_Subscription::get_subscriptions($query_posts);

            /*
             * return the result as json
             */
            echo json_encode($results);
        });
    }
}


