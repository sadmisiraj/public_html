<?php
if (!defined('ABSPATH')) {
    exit;
}

if (class_exists('BMP_Admin_Menus', false)) {
    return new BMP_Admin_Menus();
}

/**
 * BMP_Admin_Menus Class.
 */
class BMP_Admin_Menus
{

    public function __construct()
    {
        // Add menus.
        add_action('admin_menu', array($this, 'admin_menu'), 9);
        add_action('admin_menu', array($this, 'settings_menu'), 50);
    }


    public function admin_menu()
    {
        global $menu;

        if (current_user_can('manage_bmp')) {
            $menu[] = array('', 'read', 'separator-bmp', '', 'wp-menu-separator bmp');
        }
        $icon_url = BMP()->plugin_url() . '/image/mlm_tree.png';
        add_menu_page(__('Binary MLM Plan', 'binary-mlm-plan'), __('Binary MLM Plan', 'binary-mlm-plan'), 'manage_bmp', 'bmp-settings', null, $icon_url, '56.5');
        add_submenu_page('bmp-settings', __('Binary MLM Plan', 'binary-mlm-plan'), __('Binary MLM Plan', 'binary-mlm-plan'), 'manage_bmp', 'bmp-settings', null, null, '56.5');
    }

    public function settings_menu()
    {


        $settings_page = add_submenu_page('binary-mlm-plan', __('Binary MLM Plan settings', 'binary-mlm-plan'), __('Settings', 'binary-mlm-plan'), 'manage_bmp', 'bmp-settings', array($this, 'settings_page'));
        add_action('load-' . $settings_page, array($this, 'settings_page_init'));
        add_submenu_page('bmp-settings', __('User Reports', 'binary-mlm-plan'), __('User Reports', 'binary-mlm-plan'), 'manage_bmp', 'bmp-user-reports', array($this, 'bmp_user_reports'));
        add_submenu_page('bmp-settings', __('ePin Report', 'binary-mlm-plan'), __('ePin Reports', 'binary-mlm-plan'), 'manage_bmp', 'bmp-epin-reports', array($this, 'bmp_epin_reports'));
        add_submenu_page('bmp-settings', __('Payout Reports', 'binary-mlm-plan'), __('Payout Reports', 'binary-mlm-plan'), 'manage_bmp', 'bmp-payout-reports', array($this, 'bmp_payout_reports'));
        add_submenu_page('bmp-settings', __('Genealogy', 'binary-mlm-plan'), __('Genealogy', 'binary-mlm-plan'), 'manage_bmp', 'bmp-genealogy', array($this, 'bmp_genealogy'));
    }




    public function bmp_user_reports()
    {

        // BMP_Admin_Assets::bmp_scripts();
        $BMP_Admin_users_Reports = new BMP_Admin_users_Reports;
        $BMP_Admin_users_Reports->get_users_reports();
    }

    public function bmp_epin_reports()
    {

        // BMP_Admin_Assets::bmp_scripts();
        $BMP_Admin_epins_Reports = new BMP_Admin_ePin_Reports;
        $BMP_Admin_epins_Reports->get_epins_reports();
    }

    public function bmp_payout_reports()
    {

        // BMP_Admin_Assets::bmp_scripts();
        $BMP_Admin_payout_Reports = new BMP_Admin_payout_Reports;
        $BMP_Admin_payout_Reports->get_payout_reports();
    }

    public function bmp_genealogy()
    {

        BMP_Admin_Assets::admin_styles();
        BMP_Admin_Assets::admin_scripts();
        BMP_Admin_Assets::admin_genealogy_scripts();
        $BMP_Admin_genealogy = new Bmp_Admin_Genealogy;
        $BMP_Admin_genealogy->view_genealogy();
    }


    public function settings_page_init()
    {
        global $current_tab, $current_section;
        BMP_Admin_Assets::bmp_scripts();
        // Include settings pages.
        BMP_Admin_Settings::get_settings_pages();

        // Get current tab/section.
        $current_tab     = empty($_GET['tab']) ? 'general' : sanitize_title(wp_unslash($_GET['tab'])); // phpcs:ignore WordPress.Security.NonceVerification.Recommended
        $current_section = empty($_REQUEST['section']) ? '' : sanitize_title(wp_unslash($_REQUEST['section'])); // phpcs:ignore WordPress.Security.NonceVerification.Recommended

        // Save settings if data has been posted.

        if ('' !== $current_section && apply_filters("bmp_save_settings_{$current_tab}_{$current_section}", !empty($_POST))) { // phpcs:ignore WordPress.Security.NonceVerification.Recommended, WordPress.Security.NonceVerification.Missing
            BMP_Admin_Settings::save();
        } elseif ('' === $current_section && apply_filters("bmp_save_settings_{$current_tab}", !empty($_POST))) { // phpcs:ignore WordPress.Security.NonceVerification.Recommended, WordPress.Security.NonceVerification.Missing    
            BMP_Admin_Settings::save();
        }

        // Add any posted messages.
        if (isset($_GET['bmp_error']) && !empty($_GET['bmp_error'])) { // phpcs:ignore WordPress.Security.NonceVerification.Recommended
            BMP_Admin_Settings::add_error(sanitize_text_field(wp_unslash($_GET['bmp_error']))); // phpcs:ignore WordPress.Security.NonceVerification.Recommended
        }

        if (isset($_GET['bmp_message']) && !empty($_GET['bmp_message'])) { // phpcs:ignore WordPress.Security.NonceVerification.Recommended
            BMP_Admin_Settings::add_message(sanitize_text_field(wp_unslash($_GET['bmp_message']))); // phpcs:ignore WordPress.Security.NonceVerification.Recommended
        }
        do_action('bmp_settings_page_init');
    }

    public function settings_page()
    {
        BMP_Admin_Settings::output();
    }
}

return new BMP_Admin_Menus();
