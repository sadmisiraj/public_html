<?php

if (!defined('ABSPATH')) {
    exit;
}

if (!class_exists('BMP_Admin_ePin_Reports', false)) :

    class BMP_Admin_ePin_Reports
    {

        public function get_epins_reports()
        {

            BMP_Admin_Assets::admin_styles();
            $bmp_admin_epin_list = new bmp_admin_epin_list();
            $bmp_admin_epin_list->prepare_items(); ?>
            <div class='wrap'>
                <div id="icon-users" class="icon32"></div>
                <h4 class="bg-secondary p-2 text-white "><?php esc_html_e('ePin Reports', 'binary-mlm-plan'); ?></h4>
                <?php
                $bmp_admin_epin_list->display();
                ?>
            </div>
<?php
        }
    }
endif;
