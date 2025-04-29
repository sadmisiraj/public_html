<?php
global $wpdb;
$setting = get_option('bmp_manage_eligibility'); ?>
<div class="card w-100 p-0 mw-100">
    <div class="card-header">
        <?php esc_html_e('Eligibility Settings', 'binary-mlm-plan'); ?>
    </div>
    <div class="card-body">
        <div class="mb-3">
            <label for="bmp_referral" class="form-label"><?php esc_html_e('Direct Paid Referral(s)', 'binary-mlm-plan'); ?></label>
            <input name="bmp_referral" id="bmp_referral" type="text" class="form-control" value="<?php echo (isset($setting['bmp_referral']) && is_numeric($setting['bmp_referral'])) ? esc_attr($setting['bmp_referral']) : ''; ?>" placeholder="<?php esc_html_e('Initial Pair', 'binary-mlm-plan'); ?>" required class="regular-text">
            <small id="bmp_referral_help" class="form-text text-muted"></small>
        </div>
        <div class="mb-3">
            <label for="bmp_referral_left" class="form-label"><?php esc_html_e('Left Leg Referral(s)', 'binary-mlm-plan'); ?></label>
            <input name="bmp_referral_left" id="bmp_referral_left" class="form-control" type="text" value="<?php echo (isset($setting['bmp_referral_left']) && is_numeric($setting['bmp_referral_left'])) ? esc_attr($setting['bmp_referral_left']) : ''; ?>" placeholder="<?php esc_html_e('Referral Left', 'binary-mlm-plan'); ?>" required class="regular-text">
            <small id="bmp_referral_left_help" class="form-text text-muted"></small>
        </div>
        <div class="mb-3">
            <label for="bmp_referral_right" class="form-label"><?php esc_html_e('Right Leg Referral(s)', 'binary-mlm-plan'); ?></label>
            <input name="bmp_referral_right" id="bmp_referral_right" class="form-control" type="text" value="<?php echo (isset($setting['bmp_referral_right']) && is_numeric($setting['bmp_referral_right'])) ? esc_attr($setting['bmp_referral_right']) : ''; ?>" placeholder="<?php esc_html_e('Referral Right', 'binary-mlm-plan'); ?>" required class="regular-text"></td>
            <small id="bmp_referral_right_help" class="form-text text-muted"></small>
        </div>
    </div>
</div>