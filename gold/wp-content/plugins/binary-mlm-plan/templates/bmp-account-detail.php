<?php
if (!defined('ABSPATH')) {
    exit;
}
class BmpAccountDetials
{
    public function getUserDetails()
    {
        do_action('bmp_user_check_validate');
        if (isset($_GET['payout-id']) && !empty($_GET['payout-id'])) {  //phpcs:ignore WordPress.Security.NonceVerification.Recommended
            $payout_id =  sanitize_text_field(wp_unslash($_GET['payout-id'])); //phpcs:ignore WordPress.Security.NonceVerification.Recommended            
            do_action('bmp_user_payout_detail', $payout_id);
        } else {
            do_action('bmp_user_account_detail');
            do_action('bmp_user_payout_list');
            do_action('bmp_user_downlines_list');
        }
    }
}
