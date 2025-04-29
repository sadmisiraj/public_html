<?php
global $wpdb;
$setting = get_option('bmp_manage_payout');
?>
<div class="card w-100 p-0 mw-100">
    <div class="card-header">
        <?php esc_html_e('Payout Settings', 'binary-mlm-plan'); ?>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-6 ">
                <div class="form-group mb-3">
                    <label for="bmp_referral_commission_amount" class="form-label"><?php esc_html_e('Direct Referral Commission', 'binary-mlm-plan'); ?></label>
                    <input name="bmp_referral_commission_amount" class="form-control" id="bmp_referral_commission_amount" type="text" style="" value="<?php echo (isset($setting['bmp_referral_commission_amount']) && is_numeric($setting['bmp_referral_commission_amount'])) ? esc_attr($setting['bmp_referral_commission_amount']) : ''; ?>" class="regular-text" placeholder="<?php esc_html_e('Referral Commission Amount', 'binary-mlm-plan'); ?>" required>
                    <small id="bmp_referral_commission_amount_help" class="form-text text-muted"></small>
                </div>
            </div>
            <div class="col-md-6 ">
                <div class="form-group mb-3">
                    <label for="bmp_referral_commission_type" class="form-label"><?php esc_html_e('Direct Referral Commission Type', 'binary-mlm-plan'); ?></label>
                    <select name="bmp_referral_commission_type" class="form-control" id="bmp_referral_commission_type" type="text" value="1" required>
                        <option value="fixed" <?php echo (isset($setting['bmp_referral_commission_type']) && $setting['bmp_referral_commission_type'] == 'fixed') ? 'selected' : ''; ?>><?php esc_html_e('Fixed', 'binary-mlm-plan'); ?></option>
                        <option value="percentage" <?php echo (isset($setting['bmp_referral_commission_type']) && $setting['bmp_referral_commission_type'] == 'percentage') ? 'selected' : ''; ?>><?php esc_html_e('Percentage', 'binary-mlm-plan'); ?></option>
                    </select>
                    <small id="bmp_referral_commission_type_help" class="form-text text-muted"></small>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 ">
                <div class="form-group mb-3">
                    <label for="bmp_service_charge_amount" class="form-label"><?php esc_html_e('Service Charge (If any)', 'binary-mlm-plan'); ?></label>
                    <input name="bmp_service_charge_amount" class="form-control" id="bmp_service_charge_amount" type="text" style="" value="<?php echo (isset($setting['bmp_service_charge_amount']) && is_numeric($setting['bmp_service_charge_amount'])) ? esc_attr($setting['bmp_service_charge_amount']) : ''; ?>" class="regular-text" placeholder="<?php esc_html_e('Bmp Service Charge Amount', 'binary-mlm-plan'); ?>" required>
                    <small id="bmp_service_charge_amount_help" class="form-text text-muted"></small>
                </div>
            </div>
            <div class="col-md-6 ">
                <div class="form-group mb-3">
                    <label for="bmp_service_charge_type" class="form-label"><?php esc_html_e('Direct Referral Commission Type', 'binary-mlm-plan'); ?></label>
                    <select name="bmp_service_charge_type" class="form-control" id="bmp_service_charge_type" type="text" value="1" required>
                        <option value="fixed" <?php echo (isset($setting['bmp_service_charge_type']) && $setting['bmp_service_charge_type'] == 'fixed') ? 'selected' : ''; ?>><?php esc_html_e('Fixed', 'binary-mlm-plan'); ?></option>
                        <option value="percentage" <?php echo (isset($setting['bmp_service_charge_type']) && $setting['bmp_service_charge_type'] == 'percentage') ? 'selected' : ''; ?>><?php esc_html_e('Percentage', 'binary-mlm-plan'); ?></option>
                    </select>
                    <small id="bmp_service_charge_type_help" class="form-text text-muted"></small>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 ">
                <div class="form-group mb-3">
                    <label for="bmp_tds" class="form-label"><?php esc_html_e('Tax Deduction', 'binary-mlm-plan'); ?></label>
                    <input name="bmp_tds" id="bmp_tds" class="form-control" type="text" style="" value="<?php echo (isset($setting['bmp_tds']) && is_numeric($setting['bmp_tds'])) ? esc_attr($setting['bmp_tds']) : ''; ?>" class="regular-text" placeholder="<?php esc_html_e('Bmp Tds', 'binary-mlm-plan'); ?>" required>
                    <small id="bmp_tds_help" class="form-text text-muted"></small>
                </div>
            </div>
            <div class="col-md-6 ">
                <div class="form-group mb-3">
                    <label for="bmp_service_charge_type" class="form-label"><?php esc_html_e('Direct Referral Commission Type', 'binary-mlm-plan'); ?></label>
                    <select name="bmp_service_charge_type" class="form-control" id="bmp_service_charge_type" type="text" style="" value="1" class="" required>
                        <option value="fixed" <?php echo (isset($setting['bmp_service_charge_type']) && $setting['bmp_service_charge_type'] == 'fixed') ? 'selected' : ''; ?>><?php esc_html_e('Fixed', 'binary-mlm-plan'); ?></option>
                        <option value="percentage" <?php echo (isset($setting['bmp_service_charge_type']) && $setting['bmp_service_charge_type'] == 'percentage') ? 'selected' : ''; ?>><?php esc_html_e('Percentage', 'binary-mlm-plan'); ?></option>
                    </select>
                    <small id="bmp_service_charge_type_help" class="form-text text-muted"></small>
                </div>
            </div>
        </div>
        <div class="col-md-12 float-left">
            <div class="form-group mb-3">
                <label for="bmp_cap_limit_amount" class="form-label"><?php esc_html_e('Bmp Cap Limit Amount', 'binary-mlm-plan'); ?></label>
                <input name="bmp_cap_limit_amount" class="form-control" id="bmp_cap_limit_amount" type="text" style="" value="<?php echo (isset($setting['bmp_cap_limit_amount']) && is_numeric($setting['bmp_cap_limit_amount'])) ? esc_attr($setting['bmp_cap_limit_amount']) : ''; ?>" class="regular-text" placeholder="<?php esc_html_e('Bmp Cap Limit Amount', 'binary-mlm-plan'); ?>" required>
                <small id="bmp_cap_limit_amount_help" class="form-text text-muted"></small>
            </div>
        </div>
    </div>
</div>