<?php
/**
 * Modify Woocommerce myaccount to add saucal Tab
 *
 * @package  wp_saucal_gtompeas
 * @version  1.0.0
 */

function add_saucal_tompeas_endpoint()
{
    add_rewrite_endpoint('saucal_tompeas', EP_ROOT | EP_PAGES);
    flush_rewrite_rules();
}

add_action('init', 'add_saucal_tompeas_endpoint');

function saucal_tompeas_query_vars($vars)
{
    $vars[] = 'saucal_tompeas';
    return $vars;
}

add_filter('query_vars', 'saucal_tompeas_query_vars', 0);

function add_saucal_tompeas_link_my_account($items)
{
    $items['saucal_tompeas'] = 'Saucal';
    return $items;
}

add_filter('woocommerce_account_menu_items', 'add_saucal_tompeas_link_my_account');


add_action('woocommerce_account_saucal_tompeas_endpoint', 'saucal_tompeas1');

function saucal_tompeas1()
{
    echo '<h3>Saucal Test Tompeas</h3>';
}