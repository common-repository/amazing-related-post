<?php
/*
Plugin Name: Amazing Related Post
Plugin URI: http://wordpress.org/plugins/amazing-related-post/
Description: The plugin displays the posts related to a specific post by category or post type.
Author: Khalil Alsous
Version: 1.0
Text Domain: RPKH_domain
Author URI: https://www.facebook.com/people/%D8%AE%D9%84%D9%8A%D9%84-%D8%A7%D9%84%D8%B5%D9%88%D8%B5/100007033636067/
*/

if (!defined('ABSPATH')) {
    exit;
}

define('RPKH_dir_path', plugin_dir_path(__FILE__));
include(RPKH_dir_path . 'content/setting.php');

// translation domain
if (!function_exists('RPKH_load_textdomain')) {
    add_action('init', 'RPKH_load_textdomain');
    function RPKH_load_textdomain()
    {
        load_plugin_textdomain('RPKH_domain', false, dirname(plugin_basename(__FILE__)) . '/lang');
    }
}

// links
if (!function_exists('RPKH_my_links')) {
    add_action('wp_enqueue_scripts', 'RPKH_my_links');
    function RPKH_my_links()
    {
        wp_enqueue_style('main-style', plugin_dir_url(__FILE__) . '/css/main.css');
        wp_enqueue_style('font-Amazing-style', plugin_dir_url(__FILE__) . '/css/all.min.css');
    }
}


include(RPKH_dir_path . 'content/html-content.php');
