<?php
if (!defined('ABSPATH')) {
    exit;
}
class BmpJoinNetwork
{
    public function joinNetwork()
    {
        global $current_user, $wpdb;
        $user_roles = $current_user->roles;

        if (!empty($current_user->ID)) {
            if (!in_array('bmp_user', $user_roles)) {
                $bmp_users = $wpdb->get_results($wpdb->prepare("SELECT * FROM {$wpdb->prefix}bmp_users where payment_status=%s", '1')); // phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery, WordPress.DB.DirectDatabaseQuery.NoCaching
?>
                <div class="container">
                    <div class="layer">
                        <div class="myloader"></div>
                    </div>
                    <div class="d-block m-auto">
                        <h4 class="text-center mt-3"><?php esc_html_e('Join Binary Mlm Plan', 'binary-mlm-plan'); ?></h4>
                        <form id="bmp_join_network_form" action="">
                            <?php wp_nonce_field('bmp_nonce_action', 'bmp_nonce'); ?>
                            <input type="hidden" name="action" value="bmp_join_network">
                            <div class="form-group mb-3">
                                <label for="joisponsor" class="form-label"><?php esc_html_e('SPONSER', 'binary-mlm-plan'); ?></label>
                                <select class="form-control " name="bmp_join_sponser" id="bmp_sponsor_id" required="">
                                    <option value="" disabled selected><?php esc_html_e('Select Sponser', 'binary-mlm-plan'); ?></option>
                                    <?php foreach ($bmp_users as $bmp_user) { ?>
                                        <option value="<?php echo esc_attr($bmp_user->user_id); ?>"><?php echo esc_html($bmp_user->user_name); ?></option>
                                    <?php } ?>
                                </select>
                            </div>

                            <div class="form-group mb-3">
                                <label for="joisponsor" class="form-label"><?php esc_html_e('LEG', 'binary-mlm-plan'); ?></label>
                                <select class="form-control " name="bmp_join_leg" id="bmp_position" required="">
                                    <option value="" disabled selected><?php esc_html_e('Select Leg', 'binary-mlm-plan'); ?></option>
                                    <option value="left"><?php esc_html_e('Left', 'binary-mlm-plan'); ?></option>
                                    <option value="right"><?php esc_html_e('Right', 'binary-mlm-plan'); ?></option>
                                </select>
                                <div class="bmp_position_message"></div>
                            </div>

                            <div class="form-group mb-3">
                                <label for="joiepin" class="form-label"><?php esc_html_e('Epin', 'binary-mlm-plan'); ?></label>
                                <input id="bmp_join_epin" name="bmp_join_epin" type="text" class="form-control " placeholder="<?php esc_html_e('Epin', 'binary-mlm-plan'); ?>" value="" required>
                                <div class="bmp_epin_join_message"></div>
                            </div>

                            <div class="row my-3">
                                <div class="col-md-12 col-md-offset-5">
                                    <button type="submit" class="button btn-primary d-block "><?php esc_html_e('Join', 'binary-mlm-plan'); ?></button>
                                </div>
                            </div>
                            <div id="bmp_user_success_message" style="text-align:center;color:green; margin-bottom:5px"></div>
                        </form>
                    </div>
                </div>
<?php
            } else {
                echo "<h4 style='text-align:center'>You are Already Mlm User </h4>";
            }
        } else {
            echo "<h4 style='text-align:center'> Please Login </h4>";
        }
    }
}
