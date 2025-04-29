<?php
global $wpdb;
$row_num = 0;
$gen = new BMP_Settings_General();
$epin_length = $gen->getepinlength();

?>
<div class="card w-100 p-0 mw-100">
    <div class="card-header">
        <?php esc_html_e('ePin Settings', 'binary-mlm-plan'); ?>
    </div>
    <div class="card-body">
        <div class="form-group mb-3">
            <label for="bmp_epin_name" class="form-label"><?php esc_html_e('ePin Name', 'binary-mlm-plan'); ?></label>
            <input type="text" class="form-control" name="bmp_epin_name" placeholder="<?php esc_html_e('ePin name', 'binary-mlm-plan'); ?>" id="bmp_epin_name">
        </div>
        <div class="form-group mb-3">
            <label for="bmp_epin_type" class="form-label"><?php esc_html_e('ePin Type', 'binary-mlm-plan'); ?></label>
            <select name="bmp_epin_type" id="bmp_epin_type" class="form-control" required>
                <option value=""><?php esc_html_e('Select ePin Type', 'binary-mlm-plan'); ?></option>
                <option value="regular"><?php esc_html_e('Regular', 'binary-mlm-plan'); ?></option>
                <option value="free"><?php esc_html_e('Free', 'binary-mlm-plan'); ?></option>
            </select>
        </div>
        <div class="form-group mb-3">
            <label for="bmp_epin_number" class="form-label"><?php esc_html_e('Number Of ePins', 'binary-mlm-plan'); ?></label>
            <input name="bmp_epin_number" type="text" id="bmp_epin_number" class="form-control" placeholder="<?php esc_html_e('number of ePins', 'binary-mlm-plan'); ?>" required>
        </div>
        <div class="form-group mb-3">
            <label for="bmp_epin_length" class="form-label"><?php esc_html_e('ePin length', 'binary-mlm-plan'); ?></label>
            <select name="bmp_epin_length" id="bmp_epin_length" class="form-control" required>
                <option value=""><?php esc_html_e('Select ePin Length', 'binary-mlm-plan'); ?></option>
                <?php foreach ($epin_length as $key => $value) { ?>
                    <option value="<?php echo esc_attr($key); ?>"><?php echo esc_attr($value); ?></option>
                <?php } ?>
            </select>
        </div>
        <div class="form-group mb-3">
            <label for="bmp_epin_price" class="form-label"><?php esc_html_e('ePin Price', 'binary-mlm-plan'); ?></label>
            <input name="bmp_epin_price" id="bmp_epin_price" type="text" placeholder="<?php esc_html_e('ePin price', 'binary-mlm-plan'); ?>" class="form-control" required>
        </div>
    </div>
</div>