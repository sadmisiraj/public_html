<?php

if (!defined('ABSPATH')) {
    exit;
}

if (!class_exists('BMP_Admin_payout_Reports', false)) :

    class BMP_Admin_payout_Reports
    {

        public function get_payout_reports()
        {
            BMP_Admin_Assets::admin_styles();
            if (isset($_GET['payout_id']) && !empty($_GET['payout_id'])) { //phpcs:ignore WordPress.Security.NonceVerification.Recommended
                BMP_Admin_Assets::dataTableScript();
                include_once dirname(__FILE__) . '/class-bmp-admin-payout-detail.php';
            } else {
                $bmp_admin_payout_list = new bmp_admin_payout_list();
                $bmp_admin_payout_list->prepare_items(); ?>
                <div class='wrap'>
                    <div id="icon-users" class="icon32"></div>
                    <h2 class="bg-secondary text-white ps-2"><?php esc_html_e('Payout Reports', 'binary-mlm-plan'); ?></h2>
                    <?php $bmp_admin_payout_list->display();   ?>
                </div>
<?php
            }
        }
    }

endif;
