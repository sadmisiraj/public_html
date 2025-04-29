<?php
if (!defined('ABSPATH')) {
    exit;
}

class BmpRegistration
{

    function getRegistrationForm()
    {
        global $wpdb, $current_user;
        $bmp_users = $wpdb->get_results($wpdb->prepare("SELECT * FROM {$wpdb->prefix}bmp_users WHERE payment_status=%s", '1')); // phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery, WordPress.DB.DirectDatabaseQuery.NoCaching
        if (is_user_logged_in()) {
            $sponsor_id = esc_attr($current_user->ID);
        } else {
            $sponsor_id = '';
        }
        if (isset($_REQUEST['position']) && !empty($_REQUEST['position'])) { // phpcs:ignore WordPress.Security.NonceVerification.Recommended
            $position = esc_attr(sanitize_text_field(wp_unslash($_REQUEST['position']))); // phpcs:ignore WordPress.Security.NonceVerification.Recommended
            $position_diabled = "disabled";
        } else {
            $position = '';
            $position_diabled = "";
        }
        if (isset($_GET['k']) && !empty($_GET['k'])) { // phpcs:ignore WordPress.Security.NonceVerification.Recommended
            $parent_key = esc_attr(sanitize_text_field(wp_unslash($_GET['k']))); // phpcs:ignore WordPress.Security.NonceVerification.Recommended
        } else {
            $parent_key = '';
        }
        if (!empty($sponsor_id)) {
            $selected = 'selected';
            $disabled = 'disabled';
        } else {
            $selected = '';
            $disabled = '';
        }


?>
        <div class="container-fluid">
            <div class="layer">
                <div class="myloader"></div>
            </div>
            <div class="col-md-12">
                <h3 class="register-heading"><?php esc_html_e('Apply For Binary MLM Plan', 'binary-mlm-plan'); ?></h3>
                <div class="row">
                    <div class="text-center" id="bmp_user_success_message"></div>
                    <form id="bmp_register_form" name="bmp_register_form" action="" method="POST">
                        <?php wp_nonce_field('bmp_nonce_action', 'bmp_nonce'); ?>
                        <input type="hidden" name="action" value="bmp_user_register">
                        <input type="hidden" name="parent_key" value="<?php echo esc_html($parent_key); ?>">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <input id="bmp_username" name="bmp_username" type="text" class="form-control" placeholder="<?php esc_html_e('User Name *', 'binary-mlm-plan'); ?>" value="" required>
                                    <div class="bmp_username_message"></div>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <input id="bmp_email" name="bmp_email" type="email" class="form-control" placeholder="<?php esc_html_e('Your Email *', 'binary-mlm-plan'); ?>" value="" required>
                                    <div class="bmp_email_message"></div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <input id="bmp_first_name" name="bmp_first_name" type="text" class="form-control" placeholder="<?php esc_html_e('First Name *', 'binary-mlm-plan'); ?>" value="" required>
                                    <div class="bmp_first_name_message"></div>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <input id="bmp_last_name" name="bmp_last_name" type="text" class="form-control" placeholder="<?php esc_html_e('Last Name *', 'binary-mlm-plan'); ?>" value="" required>
                                    <div class="bmp_last_name_message"></div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <input id="bmp_password" name="bmp_password" type="password" class="form-control" placeholder="<?php esc_html_e('Password *', 'binary-mlm-plan'); ?>" value="" required>
                                    <div class="bmp_password_message"></div>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <input id="bmp_confirm_password" name="bmp_confirm_password" type="password" class="form-control" placeholder="<?php esc_html_e('Confirm Password *', 'binary-mlm-plan'); ?>" value="" required>
                                    <div class="bmp_confirm_password_message"></div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <input id="bmp_phone" name="bmp_phone" type="text" minlength="10" maxlength="10" class="form-control" placeholder="<?php esc_html_e('Your Phone *', 'binary-mlm-plan'); ?>" value="" required>
                                    <div class="bmp_phone_message"></div>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <?php
                                    if ($disabled) {

                                    ?>
                                        <select id="bmp_sponsor_id" name="bmp_sponsor_id" class="form-control" required <?php echo esc_attr($disabled); ?>>
                                            <option value=""><?php esc_html_e('Please select your Sponsor', 'binary-mlm-plan'); ?></option>
                                            <?php foreach ($bmp_users as $bmp_user) { ?>
                                                <option value="<?php echo esc_attr($bmp_user->user_id); ?>" <?php echo ($sponsor_id == $bmp_user->user_id) ? esc_attr($selected) : ''; ?>><?php echo esc_html($bmp_user->user_name); ?></option>
                                            <?php } ?>

                                        </select>
                                        <input type="hidden" name="bmp_sponsor_id" value="<?php echo esc_attr($sponsor_id); ?>">
                                    <?php } else { ?>
                                        <select id="bmp_sponsor_id" name="bmp_sponsor_id" class="form-control" required>
                                            <option value=""><?php esc_html_e('Please select your Sponsor', 'binary-mlm-plan'); ?></option>
                                            <?php foreach ($bmp_users as $bmp_user) { ?>
                                                <option value="<?php echo esc_attr($bmp_user->user_id); ?>" <?php echo ($sponsor_id == $bmp_user->user_id) ? esc_attr($selected) : ''; ?>><?php echo esc_html($bmp_user->user_name); ?></option>
                                            <?php } ?>

                                        </select>
                                    <?php } ?>
                                    <div class="bmp_sponsor_message"></div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <?php if ($position_diabled) { ?>
                                        <select name="bmp_position" id="bmp_position" class="form-control" required <?php echo esc_attr($position_diabled); ?>>
                                            <option value=""><?php esc_html_e('Select Position', 'binary-mlm-plan'); ?></option>
                                            <option value="left" <?php echo ($position == 'left') ? esc_attr($selected) : ''; ?>><?php esc_html_e('Left', 'binary-mlm-plan'); ?></option>
                                            <option value="right" <?php echo ($position == 'right') ? esc_attr($selected) : ''; ?>><?php esc_html_e('Right', 'binary-mlm-plan'); ?></option>
                                        </select>
                                        <input type="hidden" name="bmp_position" value="<?php echo esc_attr($position); ?>">
                                    <?php } else {
                                    ?>
                                        <select name="bmp_position" id="bmp_position" class="form-control" required>
                                            <option value=""><?php esc_html_e('Select Position', 'binary-mlm-plan'); ?></option>
                                            <option value="left" <?php echo ($position == 'left') ? esc_attr($selected) : ''; ?>><?php esc_html_e('Left', 'binary-mlm-plan'); ?></option>
                                            <option value="right" <?php echo ($position == 'right') ? esc_attr($selected) : ''; ?>><?php esc_html_e('Right', 'binary-mlm-plan'); ?></option>
                                        </select>
                                    <?php
                                    } ?>
                                    <div class="bmp_position_message"></div>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <input id="bmp_epin" name="bmp_epin" type="text" class="form-control" placeholder="<?php esc_html_e('Epin Optional', 'binary-mlm-plan'); ?>" value="">

                                    <div class="bmp_epin_message"></div>
                                </div>
                            </div>

                        </div>
                        <div class="col-md-12 text-center">
                            <input type="submit" class="btn button btn-primary" value="Register" />
                        </div>
                    </form>
                    <span>
                        <?php esc_html_e('Already have an account? ', 'binary-mlm-plan'); ?>
                        <a href="<?php bloginfo('url'); ?>/wp-login.php" class="text-success"><?php esc_html_e('here', 'binary-mlm-plan'); ?></a>
                    </span>
                </div>
            </div>
        </div>
<?php

    }
}
