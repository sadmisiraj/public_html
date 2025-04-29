<?php
if (!defined('ABSPATH')) {
    exit;
}
global $wpdb;
if (isset($_GET['payout_id']) && !empty($_GET['payout_id'])) { //phpcs:ignore WordPress.Security.NonceVerification.Recommended
    $payout_id = sanitize_text_field(wp_unslash($_GET['payout_id'])); //phpcs:ignore WordPress.Security.NonceVerification.Recommended
} else {
    $payout_id = 0;
}

if (isset($_GET['user_id']) && !empty($_GET['user_id'])) { //phpcs:ignore WordPress.Security.NonceVerification.Recommended
    $user_id = sanitize_text_field(wp_unslash($_GET['user_id'])); //phpcs:ignore WordPress.Security.NonceVerification.Recommended

} else {
    $user_id = 0;
}
?>
<div id="profile-page">
    <h1 class="wp-heading-inline"><?php esc_html_e('Payout Detail', 'binary-mlm-plan'); ?></h1>
    <?php
    do_action('bmp_admin_payout_detail');
    do_action('bmp_admin_bonus_details');
    ?>
</div>