<?php

// For breadcrumbs and URLs
function tnatheme_globals() {
    global $pre_path;
    global $pre_crumbs;
    $headers = apache_request_headers();
    if ( isset($_SERVER['HTTP_X_NGINX_PROXY']) && isset($headers['X_HOST_TYPE']) && $headers['X_HOST_TYPE'] == 'public' ) {
        $pre_crumbs = array(
            'About us' => '/about/'
        );
        $pre_path = '/about';
    } elseif (substr($_SERVER['REMOTE_ADDR'], 0, 3) === '10.') {
        $pre_path = '';
        $pre_crumbs = array(
            'About us' => '/'
        );
    } else {
        $pre_crumbs = array(
            'About us' => '/about/'
        );
        $pre_path = '/about';
    }
}
// If web development machine
if ( $_SERVER['SERVER_ADDR'] !== $_SERVER['REMOTE_ADDR'] ) {
        tnatheme_globals();
    } else {
        $pre_path = '';
        $pre_crumbs = array(
            'About' => '/'
    );
}

// Dequeue parent styles for re-enqueuing in the correct order
function dequeue_parent_style() {
    wp_dequeue_style('tna-styles');
    wp_deregister_style('tna-styles');
}
add_action( 'wp_enqueue_scripts', 'dequeue_parent_style', 9999 );
add_action( 'wp_head', 'dequeue_parent_style', 9999 );

// Enqueue styles in correct order
function tna_child_styles() {
    wp_register_style( 'tna-parent-styles', get_template_directory_uri() . '/css/base-sass.min.css', array(), EDD_VERSION, 'all' );
    wp_register_style( 'tna-child-styles', get_stylesheet_directory_uri() . '/style.css', array(), '0.1', 'all' );
    wp_enqueue_style( 'tna-parent-styles' );
    wp_enqueue_style( 'tna-child-styles' );
}
add_action( 'wp_enqueue_scripts', 'tna_child_styles' );