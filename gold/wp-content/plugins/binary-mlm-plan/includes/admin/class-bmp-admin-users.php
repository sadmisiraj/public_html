<?php

/**
 * 
 *
 * @package  
 * @version  3.4.0
 */

if (!defined('ABSPATH')) {
    exit;
}

if (!class_exists('BMP_Admin_users_Reports', false)) :

    class BMP_Admin_users_Reports
    {
        public function get_users_reports()
        {
            BMP_Admin_Assets::admin_styles();
            $bmp_admin_users_list = new bmp_admin_users_list();
            if (isset($_GET['user_id']) && !empty($_GET['user_id'])) { //phpcs:ignore WordPress.Security.NonceVerification.Recommended
                BMP_Admin_Assets::dataTableScript();
                include_once dirname(__FILE__) . '/class-bmp-admin-user-detail.php';
            } else {
                $bmp_admin_users_list->prepare_items(); ?>
                <div class='wrap'>
                    <div id="icon-users" class="icon32"></div>
                    <h2 class="bg-secondary text-white ps-2"><?php esc_html_e('MLM Users reports', 'binary-mlm-plan'); ?></h2>
                    <?php $bmp_admin_users_list->display(); ?>
                </div>
<?php
            }
        }
    }
endif;
