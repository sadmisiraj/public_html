<?php
global $wpdb;

$currencies = $this->getCurrency();
$settings = get_option('bmp_manage_general');
?>
<div class="card w-100 p-0 mw-100">
    <div class="card-header">
        <?php esc_html_e('General Settings', 'binary-mlm-plan'); ?>
    </div>
    <div class="card-body">
        <h5 class="card-title"><?php esc_html_e('Select Currency', 'binary-mlm-plan'); ?></h5>
        <div class="col-md-12">
            <div class="form-group mb-3">
                <label for="bmp_currency" class="label-contol"></label>
                <select name="bmp_currency" class="form-control" id="bmp_currency" required="" placeholder="" required="">
                    <?php foreach ($currencies as $key => $value) { ?>
                        <option value="<?php echo esc_attr($key); ?>" <?php echo (!empty($settings['bmp_currency']) && $settings['bmp_currency'] == $key) ? 'selected' : ''; ?>><?php echo esc_attr($value); ?></option>
                    <?php } ?>
                </select>
                <small id="bmp_currencyHelp" class="form-text text-muted"><?php esc_html_e('Select your currency which will you use.', 'binary-mlm-plan'); ?></small>
            </div>
        </div>
    </div>
</div>