<?php

if (!defined('ABSPATH')) {
    exit;
}
add_shortcode('bmp_register', function () {
    do_action('bmp_frontend_script');
    ob_start();
    $bmp_register = new BmpRegistration();
    $bmp_register->getRegistrationForm();
    return ob_get_clean();
});
add_shortcode('join_network', function () {
    do_action('bmp_frontend_script');
    ob_start();
    $joinNetwork = new BmpJoinNetwork();
    $joinNetwork->joinNetwork();
    return ob_get_clean();
});
add_shortcode('bmp_genealogy', function () {
    ob_start();
    do_action('bmp_frontend_script');
    bmp_genealogy_scripts();
    $genealogy = new BmpGenealogy();
    $genealogy->view_genealogy();
    return ob_get_clean();
});
add_shortcode('bmp_account_detail', function () {
    do_action('bmp_frontend_script');
    bmp_dataTable();
    ob_start();
    $userDEtails = new BmpAccountDetials();
    $userDEtails->getUserDetails();
    return ob_get_clean();
});
