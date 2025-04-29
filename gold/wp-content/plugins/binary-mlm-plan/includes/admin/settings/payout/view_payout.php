<?php
if (!defined('ABSPATH')) {
    exit;
}
$dataarray = [];

if (isset($_POST['bmp_nonce']) && wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['bmp_nonce'])), 'bmp_nonce_action') && !empty($_POST)) {
    $dataarray = bmp_run_payout_functions();
} else {
    $dataarray = bmp_run_payout_display_functions();
}
BMP_Admin_Assets::dataTableScript();
?>
<h4 class="text-center bg-secondary text-white p-2"><?php esc_html_e('Payout Run', 'binary-mlm-plan'); ?></h4>
<div class="card w-100 p-0 mw-100">
    <div class="card-header">
        <?php esc_html_e('Payout Run', 'binary-mlm-plan'); ?>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table-bordered table ml-1  table-striped" id="runPayouts">
                <thead class="text-center table-dark">
                    <tr>
                        <th>#</th>
                        <th><?php esc_html_e('User Name', 'binary-mlm-plan'); ?></th>
                        <th><?php esc_html_e('Direct Refferal Commission', 'binary-mlm-plan'); ?></th>
                        <th><?php esc_html_e('Total Amount', 'binary-mlm-plan'); ?></th>
                        <th><?php esc_html_e('Cap Limit', 'binary-mlm-plan'); ?></th>
                        <th><?php esc_html_e('Tax', 'binary-mlm-plan'); ?></th>
                        <th><?php esc_html_e('Service Charge', 'binary-mlm-plan'); ?></th>
                        <th><?php esc_html_e('Net Amount', 'binary-mlm-plan'); ?></th>
                    </tr>
                </thead>
                <tbody class="text-center">
                    <?php
                    if (!empty($dataarray) || $dataarray != null) {
                        foreach ($dataarray as $key => $row) { ?>
                            <tr>
                                <td><?php echo esc_html(++$key); ?></td>
                                <td><?php echo esc_html($row['username']); ?></td>
                                <td><?php echo esc_attr(bmpPrice($row['direct_refferal_commission'])); ?></td>
                                <td><?php echo esc_attr(bmpPrice($row['total_amount'])); ?></td>
                                <td><?php echo esc_attr(bmpPrice($row['cap_limit'])); ?></td>
                                <td><?php echo esc_attr(bmpPrice($row['tax'])); ?></td>
                                <td><?php echo esc_attr(bmpPrice($row['service_charge'])); ?></td>
                                <td><?php echo esc_attr(bmpPrice($row['net_amount'])); ?></td>
                            </tr>
                    <?php
                        }
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>